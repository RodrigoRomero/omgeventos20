<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 */
 
class eventos_mod extends RR_Model {
    private $payment_enabled;
    private $cupons_enabled;
    private $evento_name;
	public function __construct() {
 		parent::__construct();        
        #$this->load->model('email_mod','Email');
        #$this->load->model('payments_mod','MP');
        $this->_setConfig();
    }
    
    private function _setConfig(){
        $evento = $this->getEvento();
        $this->payment_enabled = $evento->payments_enabled;
        $this->evento_name = $evento->nombre;
        $this->cupons_enabled = $evento->cupons_enabled;
    }
    /*
    public function getEvento(){
        $result = $this->db->get_where('eventos',array('status'=>1, 'id'=>$this->evento_id))->result();
        return $result;
    }
    */
    public function getOradores(){
        $result = $this->db->get_where('oradores',array('status'=>1, 'evento_id'=>$this->evento_id))->result();
        return $result;
    }
    
    public function do_contacto(){
         #VALIDO FORM POR PHP
         $success = 'false';
         if($this->form_validation->run('Contacto')==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alerts',array('texto'=>validation_errors(), 'title'=>'Formulario de Contacto', 'class_type'=>'error'));
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
         } else {
            
            $json = json_encode($_POST);
            
            $values = array ('nombre'       => $this->input->post('nombre'),
                             'apellido'     => $this->input->post('apellido'), 
                             'email'        => $this->input->post('email'),
                             'tipo_form'    => 'ctc',
                             'status'       => 1,
                             'fa'           => $this->today,
                             'json'         => $json,
                             ); 
                                      
            $query = $this->db->insert('formularios', $values);
            if($query){
                $subject = lang('subject_contacto');
                $body    = $this->view('email/contacto', $values);
                $email   = $this->Email->send('email_info',$values['email'],$subject,$body);
                if($email){
                    $success      = true;
                    $responseType = 'function';
                    $function     = 'appendFormMessagesModal';
                    $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>'.lang('message_success').'</li>', 'title'=>'Formulario de Contacto', 'class_type'=>'success'));
                    $data         = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
                }
                
            }
             
         }
         
         return $data;
    }
    
    public function do_registro(){
        
         if($this->payment_enabled){
            return $this->_do_registro_payment();
         } else {
            return $this->_do_registro_regular();
         }
    }
    
    private function _do_registro_regular(){
         $success = 'false';
         $config = array();
         $config[1] = array('field'=>'nombre', 'label'=>'Nombre', 'rules'=>'trim|required|xss_clean');
         $config[2] = array('field'=>'apellido', 'label'=>'Apellido', 'rules'=>'trim|required|xss_clean');
         $config[3] = array('field'=>'email', 'label'=>'Email', 'rules'=>'trim|required|xss_clean|valid_email');
         $config[4] = array('field'=>'dni', 'label'=>'DNI', 'rules'=>'trim|required|xss_clean');
         $this->form_validation->set_rules($config);
         if($this->form_validation->run()==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alerts',array('texto'=>validation_errors(), 'title'=>'Formulario de Contacto', 'class_type'=>'error'));
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
         } else {
            #Valido si el usuario ya se registro
            $user = $this->db->get_where('acreditados', array('email'=>$this->input->post('email'), 'evento_id'=>$this->evento_id))->row();            
            if(count($user)==0) {
                $newsletter   = 0;
                $tipo_usuario = 0;
                
                $values = array ('evento_id'    => $this->evento_id,
                                 'nombre'       => $this->input->post('nombre',true),
                                 'apellido'     => $this->input->post('apellido',true),
                                 'edad'         => $this->input->post('edad',true),
                                 'email'        => $this->input->post('email',true),
                                 'dni'          => $this->input->post('dni',true),
                                 'telefono'     => $this->input->post('telefono',true),                                 
                                 'conocio'      => $this->input->post('conocio', true),
                                 'newsletter'   => $newsletter,
                                 'tipo_usuario' => $tipo_usuario,
                                 'medio_pago'   => 'Free',
                                 'donante_mensual' => $this->input->post('donante_mensual',true),
                                 'no_asistente'  => $this->input->post('no_asistente',true)
                                 );
                
                #COMIENZO TRANSACCION
                $this->db->trans_start();
                $values  = array_merge($values, $this->i);
                $query   = $this->db->insert('acreditados',$values);
                $id      = $this->db->insert_id();
                #GUARDO CODIGO DE BARRAS
                $codeGenerated = $this->_getCode($id);                                
                if($codeGenerated) {
                    $this->db->where('id', $id);
                    $this->db->update('acreditados',array('barcode'=>$codeGenerated, 'salt'=>md5($codeGenerated)));
                }
                $transact = $this->db->trans_complete();
                if($transact){                    
                    $values = array_merge($values, array('id'=>$id, 'barcode'=>$codeGenerated));
                    
                    $user_info  = $this->db->get_where('acreditados',array('id'=>$id, ))->row();                                    
                    $user_email = $user_info->email;
                    $subject    = $this->evento_name;
                    $body       = $this->view('email/registro_regular',array('user_info'=>$user_info, 'evento'=>$this->getEvento()));
                    $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                    if($email){
                        $success = true;
                        $responseType = 'function';
                        $function     = 'appendFormMessagesModal';
                        $modal        = $this->view('alerts/subscribe_success');
                        $messages     = $this->view('alerts/modal_alerts', array('texto'=>$modal, 'title'=>$this->evento_name, 'class_type'=>'info'));
                        $data = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function, 'modal_redirect'=>lang_url());
                    }
                }
            } else {
                $success      = true;
                $responseType = 'function';
                $function     = 'appendFormMessagesModal';
                $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>El email ingresado, ya se encuentra registrado en nuestra base de datos.</li>', 'title'=>$this->evento_name, 'class_type'=>'warning'));
                $data = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
            }
        }
        return $data;
    }
    
    private function _do_registro_payment(){
        #VALIDO FORM POR PHP         
        $success = 'false';
        $config = array();

        $config[1] = array('field'=>'nombre', 'label'=>'Nombre', 'rules'=>'trim|required|xss_clean');
        $config[2] = array('field'=>'apellido', 'label'=>'Apellido', 'rules'=>'trim|required|xss_clean');         
        $config[3] = array('field'=>'empresa', 'label'=>'Empresa', 'rules'=>'trim|required|xss_clean');         
        #$config[4] = array('field'=>'edad', 'label'=>'Edad', 'rules'=>'trim|required|xss_clean');         
        #$config[5] = array('field'=>'dni', 'label'=>'DNI', 'rules'=>'trim|required|xss_clean');
        $config[6] = array('field'=>'cargo', 'label'=>'Cargo', 'rules'=>'trim|required|xss_clean');         
        $config[7] = array('field'=>'email', 'label'=>'Email', 'rules'=>'trim|required|xss_clean|valid_email');
        $config[0] = array('field'=>'plan', 'label'=>'Plan', 'rules'=>'trim|required|xss_clean');
        $config[8] = array('field'=>'medio_pago', 'label'=>'Medio Pago', 'rules'=>'trim|required|xss_clean');

        $this->form_validation->set_rules($config);
        if($this->form_validation->run()==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alerts',array('texto'=>validation_errors(), 'title'=>'Formulario de Contacto', 'class_type'=>'error'));
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
        } else {
            $tipo_usuario = 0;
            if($this->cupons_enabled){                
                $this->load->model('cupons_mod','Cupons');
                $c = filter_input(INPUT_POST,'cupons'); 
                if(!empty($c)) {
                    $validate = $this->Cupons->validate(filter_input(INPUT_POST,'cupons'),true);
                    if(count($validate)==1){      
                        
                        if($validate->value==100 && $validate->percent==1){
                            $tipo_usuario = 2;
                        }    
                    }
                }
                   
            }
            
            $user = $this->db->get_where('acreditados', array('email'=>$this->input->post('email'), 'evento_id'=>$this->evento_id))->row();
            if(count($user)==0) {
                $newsletter = 0;
                
                #DEFINO TIPO DE USUARIO SI ES ADHERENTE O NO                
                if(filter_input(INPUT_POST,'antiguo_alumno_iae')){ 
                    $tipo_usuario = 1; 
                }
                
                $values = array ('evento_id'       => $this->evento_id,
                                 'empresa'         => filter_input(INPUT_POST,'empresa'),
                                 'cargo'           => filter_input(INPUT_POST,'cargo'),   
                                 'nombre'          => filter_input(INPUT_POST,'nombre'),
                                 'apellido'        => filter_input(INPUT_POST,'apellido'),
                                 'dni'             => 0, #filter_input(INPUT_POST,'dni'),
                                 'edad'            => 0, #filter_input(INPUT_POST,'edad'),
                                 'email'           => filter_input(INPUT_POST,'email'),                                 
                                 'conocio'         => filter_input(INPUT_POST,'conocio'),                                 
                                 'medio_pago'      => filter_input(INPUT_POST,'medio_pago'),   
                                 'monto'           => filter_input(INPUT_POST,'plan'),
                                 'telefono'        => filter_input(INPUT_POST,'telefono'),
                                 'newsletter'      => $newsletter,
                                 'tipo_usuario'    => $tipo_usuario,
                                 'discount_code'   => filter_input(INPUT_POST,'cupons'),
                                 'fbId'             => filter_input(INPUT_POST,'fbId'),
                                 'donante_mensual' => 0, #$this->input->post('donante_mensual',true),
                                 'no_asistente'    => 0, #$this->input->post('no_asistente',true)
                                 );
                
                #COMIENZO TRANSACCION
                $this->db->trans_start();
                $values  = array_merge($values, $this->i);
                $query   = $this->db->insert('acreditados',$values);
                $id      = $this->db->insert_id();
                #GUARDO CODIGO DE BARRAS
                $codeGenerated = $this->_getCode($id);                                
                if($codeGenerated) {
                    $this->db->where('id', $id);
                    $this->db->update('acreditados',array('barcode'=>$codeGenerated, 'salt'=>md5($codeGenerated)));
                    
                    #CREO EL PAGO
                    $payment = array('acreditado_id'=>$id, 'pago_status'=>'-1');
                    $this->db->insert('pagos',$payment);
                    
                    #CREO EL PAGO
                    $payment = array('acreditado_id'=>$id, 'pago_status'=>'-1', 'status'=>'sin_pago', 'id'=>$id);
                    $this->db->insert('lunch',$payment);
                }
                $transact = $this->db->trans_complete();
                if($transact){                    
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
                                    $this->db->where('acreditado_id', $id);
                                    $this->db->update('pagos', array('pago_status'=>2, 'status'=>'pending', 'currency_id'=>'ARS', 'transaction_amount'=>$this->input->post('plan',true), 'payment_type'=>'transferencia_bancaria'));
                                    $user_info  = $this->db->get_where('acreditados',array('id'=>$id, ))->row();                                    
                                    $user_email = $user_info->email;
                                    $subject    = "PreAcreditación ".$this->getEvento()->nombre;
                                    $body       = $this->view('email/pago_transferencia_bancaria',array('user_info'=>$user_info, 'evento'=>$this->getEvento()));
                                    $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                    
                                    if($email){
                                        $success = true;
                                        $responseType = 'function';
                                        $function     = 'afterRegisterUser';
                                        $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Usted se ha pre-inscripto para participar del evento '.$this->getEvento()->nombre.'.<br>En breves instantes recibirá un email con todos los datos para realizar la transferencia.<br/>Por favor revise su bandeja de SPAM.</li>', 'title'=>$this->getEvento()->nombre, 'class_type'=>'info'));
                                        $data = array('success' =>$success,
                                                      'responseType'=>$responseType,
                                                      'html'=>$messages, 
                                                      'value'=>$function, 
                                                      'modal_redirect'=>lang_url(),
                                                      'evento_name' => $this->getEvento()->nombre,
                                                      'userID' => filter_input(INPUT_POST,'fbId'));
                                    }
                                    break;
                                case 'pago_mis_cuentas':
                                    $this->db->where('acreditado_id', $id);
                                    $this->db->update('pagos', array('pago_status'=>2, 'status'=>'pending', 'currency_id'=>'ARS', 'transaction_amount'=>$this->input->post('plan',true), 'payment_type'=>'pago_mis_cuentas'));
                                    $user_info  = $this->db->get_where('acreditados',array('id'=>$id, ))->row();                                    
                                    $user_email = $user_info->email;
                                    $subject    = "PreAcreditación ".$this->getEvento()->nombre;
                                    $body       = $this->view('email/pago_mis_cuentas',array('user_info'=>$user_info, 'evento'=>$this->getEvento()));
                                    $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                                    
                                    if($email){
                                        $success = true;
                                        $responseType = 'function';
                                        $function     = 'appendFormMessagesModal';
                                        $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Usted se ha pre-inscripto para participar del evento '.$this->getEvento()->nombre.'.<br>En breves instantes recibirá un email con todos los datos para pagar a través de Pago Mis Cuentas.<br/>Por favor revise su bandeja de SPAM.</li>', 'title'=>$this->getEvento()->nombre, 'class_type'=>'info'));
                                        $data = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function, 'modal_redirect'=>lang_url());
                                    }
                                    break;
                                case 0:
                                    $user_info  = $this->db->get_where('acreditados',array('id'=>$id, ))->row();                                    
                                    $user_email = $user_info->email;
                                    $subject    = "PreAcreditación ".$this->getEvento()->nombre;
                                    $body       = $this->view('email/pago_no_procesado',array('user_info'=>$user_info, 'evento'=>$this->getEvento()));
                                    $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                               
                                    if($email){
                                        $success = true;
                                        $responseType = 'function';
                                        $function     = 'appendFormMessagesModal';
                                        $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Usted se ha pre-inscripto para participar del evento '.$this->getEvento()->nombre.'.<br><p class="text-center"><a class="btn btn-primary" href="'.lang_url('payments/latecheckout/'.$user_info->salt).'">REALIZAR PAGO</a></p></li>', 'title'=>$this->getEvento()->nombre, 'class_type'=>'info'));
                                        $data = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function, 'modal_redirect'=>lang_url());
                                    }
                                    break;                                    
                            }
                            break;
                        #SOCIOS
                        case 1:
                            $user_info  = $this->db->get_where('acreditados',array('id'=>$id, ))->row();
                            $user_email = $user_info->email;
                            $subject    = "Acreditación ".$this->getEvento()->nombre;                                  
                            $body       = $this->view('email/adherente_iae',array('user_info'=>$user_info, 'evento'=>$this->getEvento())); 
                            $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                            
                            if($email) {                                        
                                $success = true;
                                $responseType = 'function';
                                $function     = 'appendFormMessagesModal';
                                $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li class="">Como Socio, su inscripción al evento '.$this->getEvento()->nombre.' ha sido confirmada.</li>', 'title'=>$this->getEvento()->nombre, 'class_type'=>'info'));
                                $data = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function, 'modal_redirect'=>lang_url());
                            }
                            break;
                        #100% DESCUENTO 
                        case 2:
                            $user_info  = $this->db->get_where('acreditados',array('id'=>$id))->row();
                            $user_email = $user_info->email;
                            $subject    = "Acreditación ".$this->getEvento()->nombre;                                  
                            $body       = $this->view('email/pago_ok',array('user_info'=>$user_info, 'evento'=>$this->getEvento())); 
                            $email      = $this->Email->send('email_info', $user_email, $subject, $body);
                            
                            if($email) {                                        
                                $success = true;
                                $responseType = 'function';
                                $function     = 'appendFormMessagesModal';
                                $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li class="">Su inscripción al evento '.$this->getEvento()->nombre.' ha sido confirmada.</li>', 'title'=>$this->getEvento()->nombre, 'class_type'=>'info'));
                                $data = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function, 'modal_redirect'=>lang_url());
                            }
                            break;    
                            
                            
                            
                    }
                }
            } else {
                $success      = true;
                $responseType = 'function';
                $function     = 'appendFormMessagesModal';
                
                if($user->status ==1 && $user->pago_status=='0'){                    
                    $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>El email ingresado, ya se encuentra registrado; pero su pago no ha sido registrado, si quiere realizar el mismo lo podrá hacer con el siguiente link: <a href="'.lang_url('payments/latecheckout/'.$user->salt).'">PAGAR</a> .</li>', 'title'=>$this->getEvento()->nombre, 'class_type'=>'info'));                    
                } elseif ($user->status ==1 && $user->pago_status=='3') {
                    $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>El email ingresado, ya se encuentra registrado; pero su pago ha sido rechazado, si quiere intentar con una nueva tarjeta de crédito lo podrá hacer con el siguiente link: <a href="'.lang_url('payments/latecheckout/'.$user->salt).'">PAGAR</a>  .</li>', 'title'=>$this->getEvento()->nombre, 'class_type'=>'danger'));
                } elseif ($user->status == 1) {
                    $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>El email ingresado, ya se encuentra registrado en nuestra base de datos.</li>', 'title'=>$this->getEvento()->nombre, 'class_type'=>'warning'));
                } 
                $data = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
            }
        }
        return $data;
    }
         
    public function do_subscribe(){
         #VALIDO FORM POR PHP
         $success = 'false';
         $config = array();                 
         $config[0] = array('field'=>'newsletter_email', 'label'=>'Email', 'rules'=>'trim|required|xss_clean|valid_email|is_unique[formularios.email]');        
         $this->form_validation->set_rules($config);         
         if($this->form_validation->run()==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alerts',array('texto'=>validation_errors(), 'title'=>'Suscripción Newsletter', 'class_type'=>'danger'));
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
         } else {
            
            $values = array ('email'        => $this->input->post('newsletter_email', true),
                             'tipo_form'    => 'subscribers',
                             'status'       => 1,
                             'fa'           => $this->today                             
                             ); 
                                      
            $query = $this->db->insert('formularios', $values);
            if($query){
                $success      = true;
                $responseType = 'function';
                $function     = 'appendFormMessagesModal';
                $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>'.lang('newsletter_success').'</li>', 'title'=>'Suscripción Newsletter', 'class_type'=>'success'));
                $data         = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
            }
             
         }
         
         return $data;
    }
    /*
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
    
   */
    public function getEvento(){        
        $this->db->join('lugares','lugares.evento_id = eventos.id','left');
        $result = $this->db->get_where('eventos',array('eventos.status'=>1, 'eventos.id'=>$this->evento_id))->row();
		return $result;
    }
    
   
    public function getNumberImages($id,$folder){
        return $this->getTotalImages($id,$folder);
    }
    
    public function _doReminder(){        
        $evento      = $this->getEvento();
        $subject     = $evento->nombre.' '.$evento->bajada;
        $remider_one = strtotime($evento->reminder_one);
        $remider_two = strtotime($evento->reminder_two);
        $hoy         = strtotime(date('Y-m-d'));       
        
        if($hoy == $remider_one){
            $result = $this->db->get_where('acreditados',array('status'=>1,'reminder'=>0),50)->result();            
            #$result = $this->db->get_where('acreditados',array('status'=>1,'reminder'=>1, 'id'=>39),50)->result();
            #ep($result);          
            foreach ($result as $acreditado) {            
                
                $body  = $this->view('email/reminder_one',array('user'=>$acreditado, 'evento'=>$evento));
                $email = $this->Email->send('email_info', $acreditado->email, $subject, $body, array('bcc_no'=>TRUE));
                #echo $email; 
                if($email) {
                    $this->db->where('id',$acreditado->id);
                    $this->db->update('acreditados',array('reminder'=>1));                    
                }
               
                
            }
            
        } elseif ($hoy == $remider_two) {
            $result = $this->db->get_where('acreditados',array('status'=>1,'reminder'=>1),50)->result();            
            foreach ($result as $acreditado) {                
                $body  = $this->view('email/reminder_two',array('user'=>$acreditado, 'evento'=>$evento));
                $email = $this->Email->send('email_info', $acreditado->email, $subject, $body, array('bcc_no'=>TRUE));
                
                if($email) {
                    $this->db->where('id',$acreditado->id);
                    $this->db->update('acreditados',array('reminder'=>2));
                } 
                
            }
            
        }
     
      return false;
      
    }
    
    public function emailDomain_check($str){
        $str = explode("@",$str);
        $blackList = array('hotmail.com', 'gmail.com', 'outlook.com');        
        
        if(in_array($str[1], $blackList)) {
            $this->form_validation->set_message('emailDomain_check', 'Debes ingresar una cuenta corporativa');
			return FALSE;    
        } else {
            return TRUE;
        }
        
    }
    
    public function sendPayments() {
        die;
        $cont=0;
        $query = "SELECT a.* 
                FROM acreditados a
                LEFT OUTER JOIN pagos p ON p.acreditado_id = a.id 
                WHERE p.acreditado_id IS NULL AND a.tipo_usuario = 1";
                
        $result = $this->db->query($query)->result();
        
        $evento  = $this->getEvento();
        
        foreach($result as $user) {        
            $datos   = array('user' => $user, 'evento' => $evento);
            $subject = $evento->nombre;
            $body = $this->view('email/pago_no_procesado', $datos);
            $email = $this->Email->send('email_info', $user->email, $subject, $body);
            if($email){
                $cont++;
            }                    
                    
        }
                   
        
        echo $cont;
        die;
    }    
    
    public function test(){
        #lynx -dump http://desarrollos.orsonia.com.ar/demos/eventos/evento/test
        $mails = array('diego@orsonia.com.ar', 'holadiegol@gmail.com', 'rodrigo.thepulg@gmail.com', 'construirweb@hotmail.com');
        $body  = "EL QUE LEE ES PUTO. Si te llega esto es que el cron que hice a las 2.00 am llega OK<br/>";
        $body .= 'Status Prueba MC Sandbox: '.$this->MP->buscarPagos()."\n";
        
        $subject = "TEST CRON";
        $st = '';
        foreach($mails as $m) {        
            $email = $this->Email->send('email_info', $m, $subject, $body);            
            $st .= $this->today.' '.$m."\n";
            $st .= 'Status Prueba MC Sandbox: '.$this->MP->buscarPagos()."\n";
        }
        
        
        $fichero = 'uploads/test.txt';
        file_put_contents($fichero, $st, FILE_APPEND | LOCK_EX);
        return true;
    }
    
    public function sendInvitacion(){
       
        $this->db->join('pagos','pagos.acreditado_id = acreditados.id','left');
        $this->db->where('pagos.pago_status',1);
        $user = $this->db->select('*', true)->get_where('acreditados', array('acreditados.invitacion'=>0))->result();
        $subject = "Almuerzo Networking - Argentina Visión 2020";
        ep($user);
        foreach($user as $user_info){
            $body = $this->view('email/invitacion_almuerzo', array('user_info'=>$user_info));
            $email = $this->Email->send('email_info',$user_info->email, $subject, $body);
            if($email){
                $this->db->where('id',$user_info->id);
                $upd = $this->db->update('acreditados', array('invitacion'=>1));
                
            }
        }
        
        
    }
    
    public function buscarPagos(){
        die('asd');
        $this->MP->buscarPagos();
    }

    

}