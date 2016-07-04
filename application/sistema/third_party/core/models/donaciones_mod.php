<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 */
class Donaciones_mod extends RR_Model {
	public function __construct() {	   
 		parent::__construct();
        $this->load->model('email_mod','Email');
        $mp_config = $this->config->item('mp');
        $this->load->library('mp', $mp_config);
        //$this->mp->sandbox_mode(TRUE);
    }
    
    
    public function getUser($Md5){
        #1c746f1c41067bd4bc82d788fb5077de
        
        
        $query  = $this->db->get_where('acreditaciones',array('salt'=>$Md5,'status'=>1));
        $isUser = $query->num_rows();
        if($isUser==1){
            $user = $query->row();
            set_session("id", $user->id, false);
            set_session("nombre", $user->nombre, false);
            set_session("apellido", $user->apellido, false);
            set_session("email", $user->email, false);
            set_session("salt", $user->salt, false);
            return $user;             
        } else {
            redirect(lang_url());
        }
    }
    
    public function getPreferences() {
        
        $monto = (int)$this->input->post('donar', TRUE);  
        
        $preference = array(
                        "items" => array(
                                        array(
                                            "title"        => "Donación Bisblick",
                                            "quantity"     => 1,
                                            "currency_id"  => "ARS",
                                            "unit_price"   => $monto,
                                            "picture_url"  => image_asset_url('logo_mp.jpg')
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
                        "payer" => array ("email"    => trim(get_session('email',false))
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
    public function checkOut(){
        
        $success = false;
        if(!is_null($this->params['collection_id'])){
        $payment_info = $this->mp->get_payment_info($this->params['collection_id']);
        
        $insert = array('cliente_id'        => get_session('id', false),
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
            $subject        = "Confirmación bono contribución Argentina Visión 2020";
            $data_mail      = array('nombre'=>get_session('nombre',false).' '.get_session('apellido',false)
                                    );
            $email_user     = get_session("email", false);
            $body           = $this->view('email/gracias_donacion',array('data_mail'=>$data_mail));  
            $email          = $this->Email->send('email_info', $email_user, $subject, $body, array('logo_body'=>'BK'));
            if($email) {
                $success      = true;
                $responseType = 'redirect';                
                $data         = array('success' =>$success,
                                      'responseType'=>$responseType, 
                                      'value'=>lang_url('donaciones/gracias')
                                      );
            }
        }
        } else {
            $responseType = 'redirect';                
            $data         = array('success' =>$success,
                                  'responseType'=>$responseType, 
                                  'value'=>lang_url('donaciones/colabora-con-nosotros'.get_session('salt',false))
                                  );
        }
        
        return $data;
        
    }
    
    public function UpdStatus($pag=0){
        $old = $this->db->select('collection_id')->get_where('pagos')->result();        
         
        
        $filters = array(
            "site_id" => "MLA", // Argentina: MLA; Brasil: MLB
            "external_reference" => RR_ENCRYPTION_KEY
        );
        $payment_info = $this->mp->search_payment($filters,$pag,500);   
      // ep($payment_info);
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