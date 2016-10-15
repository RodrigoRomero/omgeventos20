<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
/**
 * @author Rodrigo Romero
 * @version 1.0.0
 *
 */
class account_mod extends RR_Model {
    private $payment_enabled;
    private $cupons_enabled;
    private $evento_name;
    public function __construct() {
        parent::__construct();
        $this->load->model('eventos_mod','Evento');
        $this->load->model('email_mod','Email');
        $this->load->model('cupons_mod','Cupons');
        $this->load->model('payments_mod','MP');
        $this->_setConfig();
    }
    private function _setConfig(){
        $evento = $this->Evento->getEvento();
        $this->payment_enabled = $evento->payments_enabled;
        $this->evento_name = $evento->nombre;
        $this->cupons_enabled = $evento->cupons_enabled;
    }

    public function getAccountBySalt(){
        return $this->db->get_where('acreditados',array('salt'=>$this->session->userdata('cart_salt')))->row();
    }

    public function doCreateAccount(){
        if($this->payment_enabled){
            return $this->_do_registro_payment();
         } else {
            return $this->_do_registro_regular();
         }
    }

    public function _do_registro_regular(){

        $success = 'false';
        $config = array();
        $config[1] = array('field'=>'nombre', 'label'=>'Nombre', 'rules'=>'trim|required|xss_clean');
        $config[2] = array('field'=>'apellido', 'label'=>'Apellido', 'rules'=>'trim|required|xss_clean');
        $config[3] = array('field'=>'empresa', 'label'=>'Empresa', 'rules'=>'trim|required|xss_clean');
        #$config[4] = array('field'=>'edad', 'label'=>'Edad', 'rules'=>'trim|required|xss_clean');
        #$config[5] = array('field'=>'dni', 'label'=>'DNI', 'rules'=>'trim|required|xss_clean');
        $config[6] = array('field'=>'cargo', 'label'=>'Cargo', 'rules'=>'trim|required|xss_clean');
        $config[7] = array('field'=>'email', 'label'=>'Email', 'rules'=>'trim|required|xss_clean|valid_email');
        $config[8] = array('field'=>'telefono', 'label'=>'Telefono', 'rules'=>'trim|required|xss_clean');
         $config[9] = array('field'=>'area', 'label'=>'Área de Trabajo', 'rules'=>'trim|required|xss_clean');

        #EXTRAS json_cantidad_empleados
        $config[100] = array('field'=>'json_cantidad_empleados', 'label'=>'Cantidad de Empleados', 'rules'=>'trim|required|xss_clean');
        $config[101] = array('field'=>'json_tipo_asistente', 'label'=>'Tipo de Asistentes', 'rules'=>'trim|required|xss_clean');

        $this->form_validation->set_rules($config);
        if($this->form_validation->run()==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alerts',array('texto'=>validation_errors(), 'title'=>'Formulario de Contacto', 'class_type'=>'error'));
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
        } else {
            #VERIFICO QUE EL USUARIO NO ESTE REGISTRADO
            try {
                $this->db->select('a.id, a.nombre, a.apellido, a.email, a.status', false)
                         ->from('acreditados a')
                         ->where('a.email', filter_input(INPUT_POST,'email'))
                         ->where('a.evento_id', $this->evento_id);
                $user = $this->db->get()->row();
                if(count($user)>0){
                    #VERIFICO QUE EL USUARIO ESTE ACTIVO Y QUE NO SE HAYA REGISTRADO PAGO
                    switch($user->status){
                        case 1:
                        case 0:
                        default:
                            #ARMAR DEFAULT PARA USUARIO REGISTRADO PERO NO APROBADO
                            throw new Exception('El email ingresado, ya se encuentra registrado', 200);
                            break;
                    }
                }



                #DEFINO NEWSLETTER
                $newsletter = 0;
                #VEO SI DONA LA ENTRADA
                $no_asistire = 0;
                if(filter_input(INPUT_POST,'no_asistente')){
                    $no_asistire = 1;
                }

                #VEO SI ES DONANTE MENSUAL
                $donante_mensual = 0;
                if(filter_input(INPUT_POST,'donante_mensual')){
                    $donante_mensual = 1;
                }

                $pattern = "/^json_.*/i";
                $extras = array();
                foreach($_POST as $k=>$v){

                     if(preg_match($pattern, $k, $matches)){
                        $newk = str_replace('json_','',$k);
                        $extras[$newk] = $v;
                     }
                }

                $tipo_usuario = 0;

                $values = array ('evento_id'       => $this->evento_id,
                                 'empresa'         => filter_input(INPUT_POST,'empresa'),
                                 'cargo'           => filter_input(INPUT_POST,'cargo'),
                                 'area_empresa'    => filter_input(INPUT_POST,'area'),
                                 'nombre'          => filter_input(INPUT_POST,'nombre'),
                                 'apellido'        => filter_input(INPUT_POST,'apellido'),
                                 'dni'             => filter_input(INPUT_POST,'dni'),
                                 'edad'            => filter_input(INPUT_POST,'edad'),
                                 'email'           => filter_input(INPUT_POST,'email'),
                                 'telefono'        => filter_input(INPUT_POST,'telefono'),
                                 'conocio'         => filter_input(INPUT_POST,'conocio'),
                                 'tipo_usuario'    => $tipo_usuario,
                                 'newsletter'      => $newsletter,
                                 'fbId'            => filter_input(INPUT_POST,'fbId'),
                                 'donante_mensual' => $donante_mensual,
                                 'no_asistente'    => $no_asistire,
                                 'extras'          => json_encode($extras)
                                 );
                #COMIENZO TRANSACCION
                $this->db->trans_start();
                $values  = array_merge($values, $this->i);
                $query   = $this->db->insert('acreditados',$values);
                $id      = $this->db->insert_id();
                #GENERO CODIGO DE BARRAS
                $codeGenerated = $this->_getCode($id);
                if($codeGenerated) {
                    $this->db->where('id', $id);
                    $this->db->update('acreditados',array('barcode'=>$codeGenerated, 'salt'=>md5($codeGenerated)));
                }
                $transact = $this->db->trans_complete();
                if($transact){
                    #DISPARO TODOS LOS MAILS
                    $this->session->set_userdata('cart_order',$id);
                    $values     = array_merge($values, array('id'=>$id, 'barcode'=>$codeGenerated));
                    switch($tipo_usuario) {
                        #TODOS PAGAN
                        case 0:
                            #RECUPERO LOS DATOS DEL USUARIO
                            $user_info  = $this->db->get_where('acreditados',array('id'=>$id, ))->row();
                            $user_email = $user_info->email;
                            $subject    = "PreAcreditación ".$this->evento_name;
                            $body       = $this->view('email/registro_regular', array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                            $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                            if($email){
                                $success = true;
                                $responseType = 'function';
                                $function     = 'afterRegisterUser';
                                $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Usted se ha pre-inscripto para participar de '.$this->evento_name.'<br>En breves instantes recibirá un e-mail de pre-confirmación. <br/>En caso de no recibirlo, por favor revise su bandeja de spam.</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                $data = array('success' =>$success,
                                              'responseType'=>$responseType,
                                              'html'=>$messages,
                                              'value'=>$function,
                                              'modal_redirect'=>lang_url(''),
                                              'evento_name' => $this->evento_name,
                                              'userID' => filter_input(INPUT_POST,'fbId'));
                            }
                            break;
                        #IAE // SOCIOS
                        case 1:

                            break;
                    }
                }
                return $data;
            } catch (Exception $ex) {
                $success      = true;
                $responseType = 'function';
                $function     = 'appendFormMessagesModal';
                $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>'.$ex->getMessage().'</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                $data         = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
                return $data;
            }
        }
    }


    public function _do_registro_payment(){
        #VALIDO FORM POR PHP
        $success = 'false';
        $config = array();
        $config[1] = array('field'=>'nombre', 'label'=>'Nombre', 'rules'=>'trim|required|xss_clean');
        $config[2] = array('field'=>'apellido', 'label'=>'Apellido', 'rules'=>'trim|required|xss_clean');
        $config[3] = array('field'=>'empresa', 'label'=>'Empresa', 'rules'=>'trim|required|xss_clean');
        $config[4] = array('field'=>'edad', 'label'=>'Edad', 'rules'=>'trim|required|xss_clean');
        $config[5] = array('field'=>'dni', 'label'=>'DNI', 'rules'=>'trim|required|xss_clean');
        $config[6] = array('field'=>'cargo', 'label'=>'Cargo', 'rules'=>'trim|required|xss_clean');
        $config[7] = array('field'=>'email', 'label'=>'Email', 'rules'=>'trim|required|xss_clean|valid_email');
        $config[8] = array('field'=>'telefono', 'label'=>'Telefono', 'rules'=>'trim|required|xss_clean');
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alerts',array('texto'=>validation_errors(), 'title'=>'Formulario de Contacto', 'class_type'=>'error'));
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
        } else {
            #VERIFICO QUE EL USUARIO NO ESTE REGISTRADO
            try {
                $this->db->select('a.id, a.nombre, a.apellido, a.email, p.pago_status, a.status', false)
                         ->from('acreditados a')
                         ->where('a.email', filter_input(INPUT_POST,'email'))
                         ->where('a.evento_id', $this->evento_id)
                         ->join('pagos p', 'p.acreditado_id = a.id','LEFT');
                $user = $this->db->get()->row();
                if(count($user)>0){
                    #VERIFICO QUE EL USUARIO ESTE ACTIVO Y QUE NO SE HAYA REGISTRADO PAGO
                    switch($user->status){
                        case 1:
                            switch($user->pago_status){
                                case 0:
                                case '0':
                                    throw new Exception('El email ingresado, ya se encuentra registrado; pero su pago no ha sido registrado, si quiere realizar el mismo lo podrá hacer con el siguiente link: <a href="'.lang_url().'">PAGAR</a>', 200);
                                    break;
                                case 1:
                                case '1':
                                    break;
                                case 2:
                                case '2':
                                    throw new Exception('El email ingresado, ya se encuentra registrado en nuestra base de datos. Su pago se encuentra en proceso de aprobación', 200);
                                    break;
                                case 3:
                                case '3':
                                    throw new Exception('El email ingresado, ya se encuentra registrado; pero su pago ha sido rechazado, si quiere intentar con una nueva tarjeta de crédito lo podrá hacer con el siguiente link: <a href="'.lang_url('payments/latecheckout/'.$user->salt).'">PAGAR</a>', 200);
                                    break;
                            }
                            break;
                        case 0:
                        default:
                            #ARMAR DEFAULT PARA USUARIO REGISTRADO PERO NO APROBADO
                            break;
                    }
                }
                #DEFINO NEWSLETTER
                $newsletter = 0;
                #VEO SI DONA LA ENTRADA
                $no_asistire = 0;
                if(filter_input(INPUT_POST,'no_asistente')){
                    $no_asistire = 1;
                }
                #VEO SI ES DONANTE MENSUAL
                $donante_mensual = 0;
                if(filter_input(INPUT_POST,'donante_mensual')){
                    $donante_mensual = 1;
                }
                #BUSCO ENTRADA // CODIGO DESCUENTO // ALMUERZO
                $ticket = '';
                $discount_code = '';
                $lunch = 0;
                $tipo_usuario = 0;
                foreach ($this->cart->contents() as $key => $row) {
                    if(preg_match('/^code/', $row['id'], $matches) === 1){
                        $discount_code = $row['options']['code'];
                    } else if(preg_match('/^almuerzo/', $row['id'], $matches) === 1){
                        $lunch = 1;
                    } else {
                        $ticket = $row['options']['ticket_id'];
                        #DEFINO TIPO DE USUARIO
                        if($ticket==5){
                             $tipo_usuario = 1;
                        }
                    }
                }
                $values = array ('evento_id'       => $this->evento_id,
                                 'empresa'         => filter_input(INPUT_POST,'empresa'),
                                 'cargo'           => filter_input(INPUT_POST,'cargo'),
                                 'nombre'          => filter_input(INPUT_POST,'nombre'),
                                 'apellido'        => filter_input(INPUT_POST,'apellido'),
                                 'dni'             => filter_input(INPUT_POST,'dni'),
                                 'edad'            => filter_input(INPUT_POST,'edad'),
                                 'email'           => filter_input(INPUT_POST,'email'),
                                 'telefono'        => filter_input(INPUT_POST,'telefono'),
                                 'conocio'         => filter_input(INPUT_POST,'conocio'),
                                 'tipo_usuario'    => $tipo_usuario,
                                 'newsletter'      => $newsletter,
                                 'medio_pago'      => ($this->session->userdata('cart_medio_pago')) ? $this->session->userdata('cart_medio_pago') : 'Free',
                                 'monto'           => $this->cart->total(),
                                 'id_ticket'       => $ticket,
                                 'discount_code'   => $discount_code,
                                 'lunch'           => $lunch,
                                 'full_cart'       => json_encode($this->cart->contents()),
                                 'fbId'             => filter_input(INPUT_POST,'fbId'),
                                 'donante_mensual' => $donante_mensual,
                                 'no_asistente'    => $no_asistire,
                                 );
                #COMIENZO TRANSACCION
                $this->db->trans_start();
                $values  = array_merge($values, $this->i);
                $query   = $this->db->insert('acreditados',$values);
                $id      = $this->db->insert_id();
                #GENERO CODIGO DE BARRAS
                $codeGenerated = $this->_getCode($id);
                if($codeGenerated) {
                    $this->db->where('id', $id);
                    $this->db->update('acreditados',array('barcode'=>$codeGenerated, 'salt'=>md5($codeGenerated)));
                    #CREO EL PAGO
                    $payment = array('acreditado_id'=>$id, 'pago_status'=>'-1');
                    $this->db->insert('pagos',$payment);
                    #BAJO EL CODIGO DE DESCUENTO
                    if(!empty($discount_code))
                    $this->Cupons->validate($discount_code,true);
                }
                $transact = $this->db->trans_complete();
                if($transact){
                    #DISPARO TODOS LOS MAILS
                    $this->session->set_userdata('cart_order',$id);
                    $values     = array_merge($values, array('id'=>$id, 'barcode'=>$codeGenerated));
                    switch($tipo_usuario) {
                        #TODOS PAGAN
                        case 0:
                            switch($values['medio_pago']) {
                                case 'mercado_pago':
                                default:
                                    $data   = $this->MP->getPreferences($values);
                                    break;
                                case 'transferencia_bancaria':
                                    #ACTUALIZO PAGO STATUS
                                    $this->db->where('acreditado_id', $id);
                                    $this->db->update('pagos', array('pago_status'=>2, 'status'=>'pending', 'currency_id'=>'ARS', 'transaction_amount'=>$values['monto'], 'payment_type'=>'transferencia_bancaria'));
                                    #RECUPERO LOS DATOS DEL USUARIO
                                    $user_info  = $this->db->get_where('acreditados',array('id'=>$id, ))->row();
                                    $user_email = $user_info->email;
                                    $subject    = "PreAcreditación ".$this->evento_name;
                                    $body       = $this->view('email/pago_transferencia_bancaria', array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                                    $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                    if($email){
                                        $success = true;
                                        $responseType = 'function';
                                        $function     = 'afterRegisterUser';
                                        $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Usted se ha pre-inscripto para participar del evento '.$this->evento_name.'.<br>En breves instantes recibirá un email con todos los datos para realizar la transferencia.<br/>Por favor revise su bandeja de SPAM.</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                        $data = array('success' =>$success,
                                                      'responseType'=>$responseType,
                                                      'html'=>$messages,
                                                      'value'=>$function,
                                                      'modal_redirect'=>lang_url('cart/finish'),
                                                      'evento_name' => $this->evento_name,
                                                      'userID' => filter_input(INPUT_POST,'fbId'));
                                    }
                                    break;
                                case 'pago_mis_cuentas':
                                    #ACTUALIZO PAGO STATUS
                                    $this->db->where('acreditado_id', $id);
                                    $this->db->update('pagos', array('pago_status'=>2, 'status'=>'pending', 'currency_id'=>'ARS', 'transaction_amount'=>$values['monto'], 'payment_type'=>'pago_mis_cuentas'));
                                    #RECUPERO LOS DATOS DEL USUARIO
                                    $user_info  = $this->db->get_where('acreditados',array('id'=>$id, ))->row();
                                    $user_email = $user_info->email;
                                    $subject    = "PreAcreditación ".$this->evento_name;
                                    $body       = $this->view('email/pago_mis_cuentas',array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                                    $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                    if($email){
                                        $success = true;
                                        $responseType = 'function';
                                        $function     = 'appendFormMessagesModal';
                                        $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Usted se ha pre-inscripto para participar del evento '.$this->evento_name.'.<br>En breves instantes recibirá un email con todos los datos para pagar a través de Pago Mis Cuentas.<br/>Por favor revise su bandeja de SPAM.</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                        $data = array('success' =>$success,
                                                      'responseType'=>$responseType,
                                                      'html'=>$messages,
                                                      'value'=>$function,
                                                      'modal_redirect'=>lang_url('cart/finish'),
                                                      'evento_name' => $this->evento_name,
                                                      'userID' => filter_input(INPUT_POST,'fbId'));
                                    }
                                    break;
                                case 0:
                                    #RECUPERO LOS DATOS DEL USUARIO
                                    $user_info  = $this->db->get_where('acreditados',array('id'=>$id, ))->row();
                                    $user_email = $user_info->email;
                                    $subject    = "PreAcreditación ".$this->evento_name;
                                    $body       = $this->view('email/pago_no_procesado',array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                                    $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                    if($email){
                                        $success = true;
                                        $responseType = 'function';
                                        $function     = 'appendFormMessagesModal';
                                        $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Usted se ha pre-inscripto para participar del evento '.$this->evento_name.'</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                        $data = array('success' =>$success,
                                                      'responseType'=>$responseType,
                                                      'html'=>$messages,
                                                      'value'=>$function,
                                                      'modal_redirect'=>lang_url('cart/finish'),
                                                      'evento_name' => $this->evento_name,
                                                      'userID' => filter_input(INPUT_POST,'fbId'));
                                    }
                                    break;
                            }
                            break;
                        #IAE // SOCIOS
                        case 1:
                            if($lunch){
                                switch($values['medio_pago']){
                                    case 'mercado_pago':
                                    default:
                                        $data   = $this->MP->getPreferences($values);
                                        break;
                                    case 'transferencia_bancaria':
                                        #ACTUALIZO PAGO STATUS
                                        $this->db->where('acreditado_id', $id);
                                        $this->db->update('pagos', array('pago_status'=>2, 'status'=>'pending', 'currency_id'=>'ARS', 'transaction_amount'=>$values['monto'], 'payment_type'=>'transferencia_bancaria'));
                                        #RECUPERO LOS DATOS DEL USUARIO
                                        $user_info  = $this->db->get_where('acreditados',array('id'=>$id, ))->row();
                                        $user_email = $user_info->email;
                                        $subject    = "Acreditación ".$this->evento_name;
                                        $body       = $this->view('email/pago_transferencia_bancaria_iae', array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                                        $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                        if($email){
                                            $success = true;
                                            $responseType = 'function';
                                            $function     = 'afterRegisterUser';
                                            $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Como Socio, su inscripción al evento '.$this->evento_name.' ha sido confirmada.<br>En breves instantes recibirá un email con todos los datos para pagar el almuerzo a través de transferencia bancaria.<br/>Por favor revise su bandeja de SPAM.</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                            $data = array('success' =>$success,
                                                          'responseType'=>$responseType,
                                                          'html'=>$messages,
                                                          'value'=>$function,
                                                          'modal_redirect'=>lang_url('cart/finish'),
                                                          'evento_name' => $this->evento_name,
                                                          'userID' => filter_input(INPUT_POST,'fbId'));
                                        }
                                        break;
                                    case 'pago_mis_cuentas':
                                        #ACTUALIZO PAGO STATUS
                                        $this->db->where('acreditado_id', $id);
                                        $this->db->update('pagos', array('pago_status'=>2, 'status'=>'pending', 'currency_id'=>'ARS', 'transaction_amount'=>$values['monto'], 'payment_type'=>'pago_mis_cuentas'));
                                        #RECUPERO LOS DATOS DEL USUARIO
                                        $user_info  = $this->db->get_where('acreditados',array('id'=>$id, ))->row();
                                        $user_email = $user_info->email;
                                        $subject    = "Acreditación ".$this->evento_name;
                                        $body       = $this->view('email/pago_mis_cuentas_iae',array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                                        $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                        if($email){
                                            $success = true;
                                            $responseType = 'function';
                                            $function     = 'appendFormMessagesModal';
                                            $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Como Socio, su inscripción al evento '.$this->evento_name.' ha sido confirmada.<br>En breves instantes recibirá un email con todos los datos para pagar el almuerzo a través de Pago Mis Cuentas.<br/>Por favor revise su bandeja de SPAM.</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                            $data = array('success' =>$success,
                                                          'responseType'=>$responseType,
                                                          'html'=>$messages,
                                                          'value'=>$function,
                                                          'modal_redirect'=>lang_url('cart/finish'),
                                                          'evento_name' => $this->evento_name,
                                                          'userID' => filter_input(INPUT_POST,'fbId'));
                                        }
                                        break;
                                    case 0:
                                        #RECUPERO LOS DATOS DEL USUARIO
                                        $user_info  = $this->db->get_where('acreditados',array('id'=>$id, ))->row();
                                        $user_email = $user_info->email;
                                        $subject    = "PreAcreditación ".$this->evento_name;
                                        $body       = $this->view('email/pago_no_procesado_iae',array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                                        $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                        if($email){
                                            $success = true;
                                            $responseType = 'function';
                                            $function     = 'appendFormMessagesModal';
                                            $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Como Socio, su inscripción al evento '.$this->evento_name.' ha sido confirmada. Lamentablemente no hemos podido procesar su pago al almuerzo</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                            $data = array('success' =>$success,
                                                          'responseType'=>$responseType,
                                                          'html'=>$messages,
                                                          'value'=>$function,
                                                          'modal_redirect'=>lang_url('cart/finish'),
                                                          'evento_name' => $this->evento_name,
                                                          'userID' => filter_input(INPUT_POST,'fbId'));
                                        }
                                        break;
                                }
                            } else {
                                #ACTUALIZO PAGO STATUS
                                $this->db->where('acreditado_id', $id);
                                $this->db->update('pagos', array('pago_status'=>1, 'status'=>'free', 'currency_id'=>'ARS', 'transaction_amount'=>$values['monto'], 'payment_type'=>''));
                                #RECUPERO LOS DATOS DEL USUARIO
                                $user_info  = $this->db->get_where('acreditados',array('id'=>$id, ))->row();
                                $user_email = $user_info->email;
                                $subject    = "Acreditación ".$this->evento_name;
                                $body       = $this->view('email/adherente_iae',array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                                $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                if($email){
                                    $success = true;
                                    $responseType = 'function';
                                    $function     = 'appendFormMessagesModal';
                                    $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li class="">Como Socio, su inscripción al evento '.$this->evento_name.' ha sido confirmada.</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                    $data = array('success' =>$success,
                                                  'responseType'=>$responseType,
                                                  'html'=>$messages,
                                                  'value'=>$function,
                                                  'modal_redirect'=>lang_url('cart/finish'),
                                                  'evento_name' => $this->evento_name,
                                                  'userID' => filter_input(INPUT_POST,'fbId'));
                                }
                            }
                            break;
                    }
                }
                return $data;
            } catch (Exception $ex) {
                $success      = true;
                $responseType = 'function';
                $function     = 'appendFormMessagesModal';
                $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>'.$ex->getMessage().'</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                $data         = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
                return $data;
            }
        }
    }


    public function doUpdateAccount(){
        #VALIDO FORM POR PHP
        $success = 'false';
        $config = array();
        $config[1] = array('field'=>'nombre', 'label'=>'Nombre', 'rules'=>'trim|required|xss_clean');
        $config[2] = array('field'=>'apellido', 'label'=>'Apellido', 'rules'=>'trim|required|xss_clean');
        $config[3] = array('field'=>'empresa', 'label'=>'Empresa', 'rules'=>'trim|required|xss_clean');
        $config[4] = array('field'=>'edad', 'label'=>'Edad', 'rules'=>'trim|required|xss_clean');
        $config[5] = array('field'=>'dni', 'label'=>'DNI', 'rules'=>'trim|required|xss_clean');
        $config[6] = array('field'=>'cargo', 'label'=>'Cargo', 'rules'=>'trim|required|xss_clean');
        $config[7] = array('field'=>'email', 'label'=>'Email', 'rules'=>'trim|required|xss_clean|valid_email');
        $config[8] = array('field'=>'telefono', 'label'=>'Telefono', 'rules'=>'trim|required|xss_clean');
        $this->form_validation->set_rules($config);
        if($this->form_validation->run()==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alerts',array('texto'=>validation_errors(), 'title'=>'Formulario de Contacto', 'class_type'=>'error'));
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
        } else {
            #VERIFICO QUE EL USUARIO NO ESTE REGISTRADO
            try {
                $this->db->select('a.*, p.id pago_id', false)
                         ->from('acreditados a')
                         ->where('a.salt', $this->session->userdata('cart_salt'))
                         ->where('a.evento_id', $this->evento_id)
                         ->join('pagos p', 'p.acreditado_id = a.id','LEFT');
                $user = $this->db->get()->row();

                #DEFINO NEWSLETTER
                $newsletter = 0;
                #VEO SI DONA LA ENTRADA
                $no_asistire = 0;
                if(filter_input(INPUT_POST,'no_asistente')){
                    $no_asistire = 1;
                }
                #VEO SI ES DONANTE MENSUAL
                $donante_mensual = 0;
                if(filter_input(INPUT_POST,'donante_mensual')){
                    $donante_mensual = 1;
                }
                #BUSCO ENTRADA // CODIGO DESCUENTO // ALMUERZO
                $ticket = '';
                $discount_code = '';
                $lunch = 0;
                $tipo_usuario = 0;
                foreach ($this->cart->contents() as $key => $row) {
                    if(preg_match('/^code/', $row['id'], $matches) === 1){
                        $discount_code = $row['options']['code'];
                    } else if(preg_match('/^almuerzo/', $row['id'], $matches) === 1){
                        $lunch = 1;
                    } else {
                        $ticket = $row['options']['ticket_id'];
                        #DEFINO TIPO DE USUARIO
                        if($ticket==5){
                             $tipo_usuario = 1;
                        }
                    }
                }
                $values = array ('evento_id'       => $this->evento_id,
                                 'empresa'         => filter_input(INPUT_POST,'empresa'),
                                 'cargo'           => filter_input(INPUT_POST,'cargo'),
                                 'nombre'          => filter_input(INPUT_POST,'nombre'),
                                 'apellido'        => filter_input(INPUT_POST,'apellido'),
                                 'dni'             => filter_input(INPUT_POST,'dni'),
                                 'edad'            => filter_input(INPUT_POST,'edad'),
                                 'email'           => filter_input(INPUT_POST,'email'),
                                 'telefono'        => filter_input(INPUT_POST,'telefono'),
                                 'conocio'         => filter_input(INPUT_POST,'conocio'),
                                 'tipo_usuario'    => $tipo_usuario,
                                 'newsletter'      => $newsletter,
                                 'medio_pago'      => ($this->session->userdata('cart_medio_pago')) ? $this->session->userdata('cart_medio_pago') : 'Free',
                                 'monto'           => $this->cart->total(),
                                 'id_ticket'       => $ticket,
                                 'discount_code'   => $discount_code,
                                 'lunch'           => $lunch,
                                 'full_cart'       => json_encode($this->cart->contents()),
                                 'fbId'             => filter_input(INPUT_POST,'fbId'),
                                 'donante_mensual' => $donante_mensual,
                                 'no_asistente'    => $no_asistire,
                                 );

                #COMIENZO TRANSACCION
                $this->db->trans_start();
                $values  = array_merge($values, $this->u);
                $this->db->where('id', $user->id);
                $query   = $this->db->update('acreditados',$values);
                $transact = $this->db->trans_complete();

                if($transact){
                    #DISPARO TODOS LOS MAILS
                    $this->session->set_userdata('cart_order',$user->id);
                    $values     = array_merge($values, array('id'=>$user->id, 'barcode'=>$user->barcode));
                    switch($tipo_usuario) {
                        #TODOS PAGAN
                        case 0:
                            switch($values['medio_pago']) {
                                case 'mercado_pago':
                                default:
                                    $data   = $this->MP->getPreferences($values);
                                    break;
                                case 'transferencia_bancaria':
                                    #ACTUALIZO PAGO STATUS
                                    $this->db->where('acreditado_id', $id);
                                    $this->db->update('pagos', array('pago_status'=>2, 'status'=>'pending', 'currency_id'=>'ARS', 'transaction_amount'=>$values['monto'], 'payment_type'=>'transferencia_bancaria'));
                                    #RECUPERO LOS DATOS DEL USUARIO
                                    $user_info  = $this->db->get_where('acreditados',array('id'=>$user->id, ))->row();
                                    $user_email = $user_info->email;
                                    $subject    = "PreAcreditación ".$this->evento_name;
                                    $body       = $this->view('email/pago_transferencia_bancaria', array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                                    $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                    if($email){
                                        $success = true;
                                        $responseType = 'function';
                                        $function     = 'afterRegisterUser';
                                        $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Usted se ha pre-inscripto para participar del evento '.$this->evento_name.'.<br>En breves instantes recibirá un email con todos los datos para realizar la transferencia.<br/>Por favor revise su bandeja de SPAM.</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                        $data = array('success' =>$success,
                                                      'responseType'=>$responseType,
                                                      'html'=>$messages,
                                                      'value'=>$function,
                                                      'modal_redirect'=>lang_url('cart/finish'),
                                                      'evento_name' => $this->evento_name,
                                                      'userID' => filter_input(INPUT_POST,'fbId'));
                                    }
                                    break;
                                case 'pago_mis_cuentas':
                                    #ACTUALIZO PAGO STATUS
                                    $this->db->where('acreditado_id', $user->id);
                                    $this->db->update('pagos', array('pago_status'=>2, 'status'=>'pending', 'currency_id'=>'ARS', 'transaction_amount'=>$values['monto'], 'payment_type'=>'pago_mis_cuentas'));
                                    #RECUPERO LOS DATOS DEL USUARIO
                                    $user_info  = $this->db->get_where('acreditados',array('id'=>$user->id, ))->row();
                                    $user_email = $user_info->email;
                                    $subject    = "PreAcreditación ".$this->evento_name;
                                    $body       = $this->view('email/pago_mis_cuentas',array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                                    $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                    if($email){
                                        $success = true;
                                        $responseType = 'function';
                                        $function     = 'appendFormMessagesModal';
                                        $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Usted se ha pre-inscripto para participar del evento '.$this->evento_name.'.<br>En breves instantes recibirá un email con todos los datos para pagar a través de Pago Mis Cuentas.<br/>Por favor revise su bandeja de SPAM.</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                        $data = array('success' =>$success,
                                                      'responseType'=>$responseType,
                                                      'html'=>$messages,
                                                      'value'=>$function,
                                                      'modal_redirect'=>lang_url('cart/finish'),
                                                      'evento_name' => $this->evento_name,
                                                      'userID' => filter_input(INPUT_POST,'fbId'));
                                    }
                                    break;
                                case 0:
                                    #RECUPERO LOS DATOS DEL USUARIO
                                    $user_info  = $this->db->get_where('acreditados',array('id'=>$user->id))->row();
                                    $user_email = $user_info->email;
                                    $subject    = "PreAcreditación ".$this->evento_name;
                                    $body       = $this->view('email/pago_no_procesado',array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                                    $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                    if($email){
                                        $success = true;
                                        $responseType = 'function';
                                        $function     = 'appendFormMessagesModal';
                                        $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Usted se ha pre-inscripto para participar del evento '.$this->evento_name.'</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                        $data = array('success' =>$success,
                                                      'responseType'=>$responseType,
                                                      'html'=>$messages,
                                                      'value'=>$function,
                                                      'modal_redirect'=>lang_url('cart/finish'),
                                                      'evento_name' => $this->evento_name,
                                                      'userID' => filter_input(INPUT_POST,'fbId'));
                                    }
                                    break;
                            }
                            break;
                        #IAE // SOCIOS
                        case 1:
                            if($lunch){
                                switch($values['medio_pago']){
                                    case 'mercado_pago':
                                    default:
                                        $data   = $this->MP->getPreferences($values);
                                        break;
                                    case 'transferencia_bancaria':
                                        #ACTUALIZO PAGO STATUS
                                        $this->db->where('acreditado_id', $user->id);
                                        $this->db->update('pagos', array('pago_status'=>2, 'status'=>'pending', 'currency_id'=>'ARS', 'transaction_amount'=>$values['monto'], 'payment_type'=>'transferencia_bancaria'));
                                        #RECUPERO LOS DATOS DEL USUARIO
                                        $user_info  = $this->db->get_where('acreditados',array('id'=>$user->id, ))->row();
                                        $user_email = $user_info->email;
                                        $subject    = "Acreditación ".$this->evento_name;
                                        $body       = $this->view('email/pago_transferencia_bancaria_iae', array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                                        $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                        if($email){
                                            $success = true;
                                            $responseType = 'function';
                                            $function     = 'afterRegisterUser';
                                            $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Como Socio, su inscripción al evento '.$this->evento_name.' ha sido confirmada.<br>En breves instantes recibirá un email con todos los datos para pagar el almuerzo a través de transferencia bancaria.<br/>Por favor revise su bandeja de SPAM.</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                            $data = array('success' =>$success,
                                                          'responseType'=>$responseType,
                                                          'html'=>$messages,
                                                          'value'=>$function,
                                                          'modal_redirect'=>lang_url('cart/finish'),
                                                          'evento_name' => $this->evento_name,
                                                          'userID' => filter_input(INPUT_POST,'fbId'));
                                        }
                                        break;
                                    case 'pago_mis_cuentas':
                                        #ACTUALIZO PAGO STATUS
                                        $this->db->where('acreditado_id', $user->id);
                                        $this->db->update('pagos', array('pago_status'=>2, 'status'=>'pending', 'currency_id'=>'ARS', 'transaction_amount'=>$values['monto'], 'payment_type'=>'pago_mis_cuentas'));
                                        #RECUPERO LOS DATOS DEL USUARIO
                                        $user_info  = $this->db->get_where('acreditados',array('id'=>$user->id))->row();
                                        $user_email = $user_info->email;
                                        $subject    = "Acreditación ".$this->evento_name;
                                        $body       = $this->view('email/pago_mis_cuentas_iae',array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                                        $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                        if($email){
                                            $success = true;
                                            $responseType = 'function';
                                            $function     = 'appendFormMessagesModal';
                                            $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Como Socio, su inscripción al evento '.$this->evento_name.' ha sido confirmada.<br>En breves instantes recibirá un email con todos los datos para pagar el almuerzo a través de Pago Mis Cuentas.<br/>Por favor revise su bandeja de SPAM.</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                            $data = array('success' =>$success,
                                                          'responseType'=>$responseType,
                                                          'html'=>$messages,
                                                          'value'=>$function,
                                                          'modal_redirect'=>lang_url('cart/finish'),
                                                          'evento_name' => $this->evento_name,
                                                          'userID' => filter_input(INPUT_POST,'fbId'));
                                        }
                                        break;
                                    case 0:
                                        #RECUPERO LOS DATOS DEL USUARIO
                                        $user_info  = $this->db->get_where('acreditados',array('id'=>$user->id))->row();
                                        $user_email = $user_info->email;
                                        $subject    = "PreAcreditación ".$this->evento_name;
                                        $body       = $this->view('email/pago_no_procesado_iae',array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                                        $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                        if($email){
                                            $success = true;
                                            $responseType = 'function';
                                            $function     = 'appendFormMessagesModal';
                                            $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Como Socio, su inscripción al evento '.$this->evento_name.' ha sido confirmada. Lamentablemente no hemos podido procesar su pago al almuerzo</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                            $data = array('success' =>$success,
                                                          'responseType'=>$responseType,
                                                          'html'=>$messages,
                                                          'value'=>$function,
                                                          'modal_redirect'=>lang_url('cart/finish'),
                                                          'evento_name' => $this->evento_name,
                                                          'userID' => filter_input(INPUT_POST,'fbId'));
                                        }
                                        break;
                                }
                            } else {
                                #ACTUALIZO PAGO STATUS
                                $this->db->where('acreditado_id', $user->id);
                                $this->db->update('pagos', array('pago_status'=>1, 'status'=>'free', 'currency_id'=>'ARS', 'transaction_amount'=>$values['monto'], 'payment_type'=>''));
                                #RECUPERO LOS DATOS DEL USUARIO
                                $user_info  = $this->db->get_where('acreditados',array('id'=>$user->id))->row();
                                $user_email = $user_info->email;
                                $subject    = "Acreditación ".$this->evento_name;
                                $body       = $this->view('email/adherente_iae',array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                                $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                if($email){
                                    $success = true;
                                    $responseType = 'function';
                                    $function     = 'appendFormMessagesModal';
                                    $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li class="">Como Socio, su inscripción al evento '.$this->evento_name.' ha sido confirmada.</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                                    $data = array('success' =>$success,
                                                  'responseType'=>$responseType,
                                                  'html'=>$messages,
                                                  'value'=>$function,
                                                  'modal_redirect'=>lang_url('cart/finish'),
                                                  'evento_name' => $this->evento_name,
                                                  'userID' => filter_input(INPUT_POST,'fbId'));
                                }
                            }
                            break;
                    }
                }

                return $data;
            } catch (Exception $ex) {
                $success      = true;
                $responseType = 'function';
                $function     = 'appendFormMessagesModal';
                $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>'.$ex->getMessage().'</li>', 'title'=>$this->evento_name, 'class_type'=>'info'));
                $data         = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
                return $data;
            }
        }
        ep($_POST);
        die;



    }
    private function _getCode ($id){
        $codigoBarrasNumber      = str_pad($id,12,0,STR_PAD_LEFT);
        $codigoBarrasFinalNumber = $this->_ean13_check_digit($codigoBarrasNumber);
        $this->_generateCode($codigoBarrasNumber,$codigoBarrasFinalNumber);
        return $codigoBarrasFinalNumber;
    }
    private function _generateCode($codigoBarrasNumber,$codigoBarrasFinalNumber){
        $this->barcode->save($codigoBarrasNumber,$codigoBarrasFinalNumber);
    }
    private function _ean13_check_digit($digits){
        //first change digits to a string so that we can access individual numbers
        $digits =(string)$digits;
        // 1. Add the values of the digits in the even-numbered positions: 2, 4, 6, etc.
        $even_sum = $digits{1} + $digits{3} + $digits{5} + $digits{7} + $digits{9} + $digits{11};
        // 2. Multiply this result by 3.
        $even_sum_three = $even_sum * 3;
        // 3. Add the values of the digits in the odd-numbered positions: 1, 3, 5, etc.
        $odd_sum = $digits{0} + $digits{2} + $digits{4} + $digits{6} + $digits{8} + $digits{10};
        // 4. Sum the results of steps 2 and 3.
        $total_sum = $even_sum_three + $odd_sum;
        // 5. The check character is the smallest number which, when added to the result in step 4,  produces a multiple of 10.
        $next_ten    = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;
        return $digits . $check_digit;
    }
}