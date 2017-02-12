<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 */
 

class Institucional_mod extends RR_Model {
	public function __construct() {	   
 		parent::__construct();
        $this->load->model('email_mod','Email');
    }
    
    public function getText($id){
        $row = $this->db->get_where('institucional',array('id'=>$id))->row();
        return $row;
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
    
    public function do_suscription(){
         #VALIDO FORM POR PHP
         $success = 'false';
         if($this->form_validation->run('Suscripcion')==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessagesModal';
            $messages     = $this->view('alerts/modal_alerts',array('texto'=>validation_errors(), 'title'=>'Formulario de Contacto', 'class_type'=>'error'));
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
         } else {
            $existe = $this->db->from('formularios')->where(array('email'=>$this->input->post('frmNltr_email'),'tipo_form'=>'nltr'))->count_all_results();
            
            if(!$existe || $existe==0){
                
                $json = json_encode($_POST);
                
                $values = array ('email'        => $this->input->post('frmNltr_email'),
                                 'tipo_form'    => 'nltr',
                                 'status'       => 1,
                                 'fa'           => $this->today,
                                 'json'         => $json,
                                 ); 
                                          
                $query = $this->db->insert('formularios', $values);
                if($query){
                        $success      = true;
                        $responseType = 'function';
                        $function     = 'appendFormMessagesModal';
                        $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>Suscripción realizada exitosamente</li>', 'title'=>'Suscripción Newsletter', 'class_type'=>'success'));
                        $data         = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
                    }
            } else {
                $success      = true;
                $responseType = 'function';
                $function     = 'appendFormMessagesModal';
                $messages     = $this->view('alerts/modal_alerts', array('texto'=>'<li>El email ingresado, ya se encuentra registrado en nuestra base de datos.</li>', 'title'=>'Suscripción Newsletter', 'class_type'=>'success'));
                $data         = array('success' =>$success,'responseType'=>$responseType, 'html'=>$messages, 'value'=>$function);
            }
                
            }
            
            
            return $data; 
         }
         
         
    
    
    public function getNumberImages($id,$folder){
        return $this->getTotalImages($id,$folder);
    }
    

    

}