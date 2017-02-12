<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 */
class pagos_mod extends RR_Model {
	public function __construct() {	   
 		parent::__construct();
        $this->load->model('email_mod','Email');        
        $this->load->config('mp', TRUE);
        $mp_config = $this->config->item('mp');       
        $this->load->library('mp', $mp_config);
        #$this->mp->sandbox_mode(TRUE);
        
    }
    
    
    private function _getUser($id){
        $query  = $this->db->get_where('acreditados',array('id'=>$id));
        $isUser = $query->num_rows();
        if($isUser==1){
            return $query->row();            
        } else {
            redirect(lang_url());
        }
    }
    
    
    
    public function getPreferences() {
        
        
        $cart = array();
        
        foreach($this->Cart->getCart() as $items) {
            $title      = $items['name'];
            $precio     = $items['price'];            
            $payer      = $items['options']['email'];
            
        }
        
         
        $preference = array(
                        "items" => array(
                                        array(
                                            "title"        => $title,
                                            "quantity"     => 1,
                                            "currency_id"  => "ARS",
                                            "unit_price"   => (int)$precio,
                                            "picture_url"  => image_asset_url('logo.png')
                                            )
                                        ),
    
                        "payment_methods" => array(
                                                    'excluded_payment_types' => array (
                                                                                        array("id" => "debit_card"),
                                                                                        array("id" => "ticket" ),
                                                                                        array("id" => "bank_transfer"),
                                                                                        array("id" => "atm" )
                                                                                       ),
                                                    'installments' => 1
                                                    ),
                        "payer" => array ("email"    => $payer
                                         ),
                        
                        "external_reference" => RR_ENCRYPTION_KEY
                        );       
                                      
       
      
                        
        $preferenceResult = $this->mp->create_preference($preference);
        
       
        $success = true;
        $responseType = 'function';
        $function     = 'appendFormLink';
        $messages     = $preferenceResult['response']['init_point'];
        $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
        
        return $data;
    
    }
    public function close(){
        $this->load->library('cart');
        $success = false;
        
        $user    = $this->_getUser(get_session('id',false));
        $evento  = $this->Evento->getEvento();
                
        $datos   = array('user' => $user, 'evento' => $evento);
        $subject = $evento->nombre;
       
        if($this->params['collection_id']!= 'null'){        
            $payment_info = $this->mp->get_payment_info($this->params['collection_id']);
            
            $insert = array('acreditado_id'       => get_session('id', false),
                            'collection_id'       => $this->params['collection_id'],
                            'collection_status'   => $payment_info['response']['collection']['status_detail'],
                            'preference_id'       => $this->params['preference_id'], 
                            'currency_id'         => $payment_info['response']['collection']['currency_id'],
                            'transaction_amount'  => $payment_info['response']['collection']['transaction_amount'],
                            'payment_type'        => $payment_info['response']['collection']['payment_type'],
                            'order_id'            => $payment_info['response']['collection']['order_id']
                         );
            
            $query = $this->db->insert('pagos',$insert);            
        
            if(!$query){
                
            } else {
                
                switch($payment_info['response']['collection']['status_detail']){
                    case 'accredited':
                        $this->db->where('id',$user->id);
                        $this->db->update('acreditados', array('status'=>1));

                        $body    = $this->view('email/pago_ok', $datos);
                        break;
                    
                    case 'pending_contingency':
                    default:
                        $this->db->where('id',$user->id);
                        $this->db->update('acreditados', array('status'=>1));
                        
                        $body    = $this->view('email/pago_pendiente', $datos);
                        break;
                    case 'cc_rejected_other_reason':
                    
                        $body    = $this->view('email/pago_rechazado', $datos);
                        break;
                }
            }
            
        } else {           
             $body = $this->view('email/pago_no_procesado', $datos);
        }
        
        $email   = $this->Email->send('email_info', $user->email, $subject, $body);
        if($email) {
            $success      = true;
            $responseType = 'redirect';                
            $data         = array('success' =>$success, 'responseType'=>$responseType, 'value'=>lang_url());
        }
        
        $this->cart->destroy();
        return $data;
        
    }
    

    public function UpdStatus($pag=0){
        $evento = $this->Evento->getEvento();        
        $old = $this->db->select('collection_id')->get_where('pagos', array('collection_status !='=>'accredited'))->result();
        
        $filters = array(
            "site_id" => "MLA", // Argentina: MLA; Brasil: MLB
            "external_reference" => RR_ENCRYPTION_KEY
        );
        
        $payment_info = $this->mp->search_payment($filters,$pag,500);
       
       $coll_arr = array();
        foreach($payment_info['response']['results'] as $pagos){   
             $coll_arr[] = $pagos['collection']['id'];
             $data = array('collection_id' => $pagos['collection']['id'],
                          'collection_status' => $pagos['collection']['status_detail'],
                          'payment_type' => $pagos['collection']['payment_type'],
                          'transaction_amount' => $pagos['collection']['transaction_amount'],
                          'order_id' => $pagos['collection']['external_reference'],
                          'currency_id' => $pagos['collection']['currency_id'],                          
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
              //  $query = $this->db->insert('pagos',$data);
            }
           
             $existe = false;
                
        }
        
    }

}