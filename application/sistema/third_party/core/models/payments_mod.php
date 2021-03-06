<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**




 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 */

class payments_mod extends RR_Model {
    var $id;
    var $codeBar;
    private $payment_enabled;
    private $cupons_enabled;
    private $evento_name; 

    public function __construct() {	   
        parent::__construct();
        $this->load->model('email_mod','Email');
        $this->load->model('eventos_mod','Evento');
        $this->load->config('mp', TRUE);
        $mp_config = $this->config->item('mp');
        
        $this->load->library('mp', $mp_config);
        #$this->mp->sandbox_mode(true);
        $this->_setConfig();
    }

    

     private function _setConfig(){
        $evento = $this->Evento->getEvento();
        $this->payment_enabled = $evento->payments_enabled;
        $this->evento_name = $evento->nombre;
        $this->cupons_enabled = $evento->cupons_enabled;    
    }

    

    public function getPreferences($values){       
        $preference = array("items" => array(
                                             array("title"        => $this->evento_name,
                                                   "quantity"     => 1,
                                                   "currency_id"  => "ARS",
                                                   "unit_price"   => (int)$values->total_discounted_price,
                                                   "picture_url"  => image_asset_url('logo_mp.jpg'),
                                                   "id"           => $values->id
                                                   )
                                             ),

                           "payment_methods" => array('excluded_payment_types' => array (
                                                                                         array("id" => "debit_card"),
                                                                                         array("id" => "ticket" ),
                                                                                         array("id" => "bank_transfer"),
                                                                                         array("id" => "atm" )
                                                                                         ),
                                                       'installments' => 1
                                                      ),
                           "external_reference" => $values->id.'-'.$values->barcode
                           );

        $preferenceResult = $this->mp->create_preference($preference);

        $success      = true;
        $responseType = 'function';
        $function     = 'paymentLink';
        #$messages     = $preferenceResult['response']['sandbox_init_point'];
        $messages     = $preferenceResult['response']['init_point'];
        $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
        return $data;       
    }

    
    public function abc($i){
        ep($this->mp->get_payment_info($i));  
    }
    
    public function checkOut(){
        #Status 1 - Pago Acreditado
        #Status 2 - Pago Pendiente Acreditacion
        #Status 3 - Pago Rechazado
        #Status 0 - Pago NO Procesado 
        /*
        #pending 	El usuario no completó el proceso de pago.
        #approved 	El pago fue aprobado y acreditado.
        #in_process 	El pago esta siendo revisado.
        #rejected 	El pago fue rechazado. El usuario puede intentar nuevamente.
        cancelled 	El pago fue cancelado por superar el tiempo necesario para realizar el pago o por una de las partes.
        refunded 	El pago fue devuelto al usuario.
        in_mediation 	Se inicio una disputa para el pago.
         * http://demo.omgeventos.com.ar/evento/payments/close/
         * id/41-0000000000413/
         * collection_id/1458191868/
         * collection_status/approved/
         * payment_type/credit_card/
         * preference_id/139398783-f15e9fed-d8d2-4895-b882-33b752144e86
        */
        $id_barcode = explode("-", $this->params['id']);
        $id         = $id_barcode[0];
        $barcode    = $id_barcode[1];       
        
        $order_info  = $this->db->get_where('orders',array('id'=>$id))->row();
        $user_info   = $this->db->get_where('customers',array('id'=>$order_info->customer_id))->row();
        $user_email = $user_info->email;    

        $success = false;
        if($this->params['collection_id'] != 'null'){
           
          $payment_info = $this->mp->get_payment_info($this->params['collection_id']);     
          $update  = array('collection_id'       => $payment_info['response']['collection']['id'],
                             'collection_status'   => $payment_info['response']['collection']['status'],
                             'preference_id'       => $this->params['preference_id'], 
                             'currency_id'         => $payment_info['response']['collection']['currency_id'],
                             'transaction_amount'  => $payment_info['response']['collection']['transaction_amount'],
                             'payment_type'        => $payment_info['response']['collection']['payment_type'],
                             'order_id'            => $payment_info['response']['collection']['order_id'],                                                      
                             'status'              => $payment_info['response']['collection']['status_detail']
                         );
            
            $this->db->where('order_id',$order_info->id);
            $query = $this->db->update('pagos',$update);            
            
            if(!$query){
                
            } else {                
                switch($payment_info['response']['collection']['status']){
                    case 'approved':
                    case 'accredited':
                        $template =  'pago_ok';
                        $subject    = "Acreditacion ".$this->evento_name; 
                        #ACTUALIZO PAGO STATUS
                        $this->db->where('order_id',$order_info->id);
                        $this->db->update('pagos', array('pago_status'=>$payment_info['response']['collection']['status']));

                        $this->db->where('id',$order_info->id);
                        $this->db->update('orders', array('status'=>1));

                        $body    = $this->view('email/'.$template, array('user_info'=>$user_info, 'datos'=>$payment_info,  'evento'=>$this->Evento->getEvento()));
                        break;                    

                    default:
                    case 'in_process':
                    case 'pending':
                    case 'pending_contingency':                                           
                        #ACTUALIZO PAGO STATUS
                        $this->db->where('order_id',$order_info->id);
                        $this->db->update('pagos', array('pago_status'=>$payment_info['response']['collection']['status']));

                        $this->db->where('id',$order_info->id);
                        $this->db->update('orders', array('status'=>2));

                       
                        $subject    = "PreAcreditacion ".$this->evento_name; 
                        $template   = 'pago_pendiente';
                        
                        $body    = $this->view('email/'.$template, array('user_info'=>$user_info, 'datos'=>$payment_info,  'evento'=>$this->Evento->getEvento()));
                        break;

                    case 'cancelled':
                    case 'rejected':
                    case 'cc_rejected_other_reason':
                        #ACTUALIZO PAGO STATUS
                         #ACTUALIZO PAGO STATUS
                        $this->db->where('order_id',$order_info->id);
                        $this->db->update('pagos', array('pago_status'=>$payment_info['response']['collection']['status']));

                        $this->db->where('id',$order_info->id);
                        $this->db->update('orders', array('status'=>3));
                        
                        
                        
                        $subject    = "Tarjeta Rechazada ".$this->evento_name; 
                        $template   = 'pago_rechazado';

                        $body    = $this->view('email/'.$template, array('user_info'=>$user_info, 'datos'=>$payment_info,  'evento'=>$this->Evento->getEvento()));                                                                 
                        break;
                }
                $email  = $this->Email->send('email_info', $user_email, $subject, $body, array());
            }
        } else {
            $subject    = "Completar Pago ".$this->evento_name; 
            $template   = 'pago_no_procesado';
          
            
            $body       = $this->view('email/'.$template, array('user_info'=>$user_info, 'order_info'=>$order_info, 'evento'=>$this->Evento->getEvento()));     
            $email   = $this->Email->send('email_info', $user_email, $subject, $body, array());             

            $this->db->where('order_id',$order_info->id);
            $query = $this->db->update('pagos', array('status'=>'pending', 'preference_id'=>$this->params['preference_id'], 'pago_status'=>2 ));

     
        }

        if($query) {
            $success      = true;
            $responseType = 'redirect';                
            $data         = array('success' =>$success, 'responseType'=>$responseType, 'value'=>lang_url('cart/finish'));
        } 
        return $data;
    }

    
    

    public function lateCheckOut($salt){        

        if( !empty($salt) && ($salt==$this->input->post('salt',$salt)) ){

         #VALIDO FORM POR PHP         
         $success = 'false';
         $config = array();
         $config[1] = array('field'=>'salt', 'label'=>'Security Key', 'rules'=>'trim|required|xss_clean');

         $this->form_validation->set_rules($config);

         if($this->form_validation->run()==FALSE){

            $this->form_validation->set_error_delimiters('<li>', '</li>');

            $responseType = 'function';

            $function     = 'appendFormMessagesModal';

            $messages     = $this->view('alerts/modal_alerts',array('texto'=>validation_errors(), 'title'=>'Formulario de Contacto', 'class_type'=>'error'));

            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);

         } else {
            $valid_salt = $this->input->post('salt', true);

            $order_info = $this->db->get_where('orders',['salt'=>$valid_salt])->row();
            $medio_pago = $order_info->gateway;

            $ticket_info = $this->db->get_where('tickets', ['id' => $order_info->ticket_id])->row();
            
            switch($medio_pago) {

                case 'mercado_pago';

                    $mp_values = array('id'=>$order_info->id, 'barcode'=>$order_info->barcode, 'total_discounted_price'=>$order_info->total_discounted_price);
                    $mp_values = (object) $mp_values;
                    return $this->getPreferences($mp_values);

                break;


            }

         }

        } else {

        }

        return $data;

    }

    public function buscarPagos(){       
    die;

        /*

        $old = $this->db->get_where('acreditados',array('status'=>1))->result();

        foreach($old as $infoUser) {

        } 

        */        

         $payment_info = $this->mp->get_payment_info(1953786882);        
         ep($payment_info);
         return $payment_info['response']['collection']['status'];

         die;

       die;

       echo 'Operaciones: '.$payment_info['response']['paging']['total'].'<br>';

       echo '<hr>';

       $i= 1;

       $coll_arr = array();

        foreach($payment_info['response']['results'] as $pagos){   

             $coll_arr[] = $pagos['collection']['id'];

             $data = array('collection_id' => $pagos['collection']['id'],

                          'collection_status' => $pagos['collection']['status_detail'],

                          'payment_type' => $pagos['collection']['payment_type'],

                          'transaction_amount' => $pagos['collection']['transaction_amount'],

                          'order_id' => $pagos['collection']['external_reference'],

                          'currency_id' => $pagos['collection']['currency_id'],

                          'email'       => $pagos['collection']['payer']['email']

                          );

             ep($data);

            foreach($old as $oldest) {

                if($oldest->collection_id == $pagos['collection']['id']) {

                    $existe = true;

                } 

            }

            if($existe){

                $this->db->where('collection_id',$pagos['collection']['id']);

                $query = $this->db->update('pagos',$data);

            } else {

                $query = $this->db->insert('pagos',$data);

            }

            echo $i++.') '.$pagos['collection']['payer']['first_name'].' '.$pagos['collection']['payer']['last_name'].': '.$pagos['collection']['id'].' - '.$pagos['collection']['status_detail'].' - '.$pagos['collection']['payment_type']. ' - '.$pagos['collection']['transaction_amount'].'<br/>';

            echo $pagos['collection']['payer']['email'].'<br/>';

            echo '<hr>';

             $existe = false;

        }

        echo '(';

        echo implode(',',$coll_arr);

        echo ')';

    }

}