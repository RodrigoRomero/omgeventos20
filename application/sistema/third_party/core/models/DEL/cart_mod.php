<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 */
class cart_mod extends RR_Model {
	public function __construct() {	   
 		parent::__construct();      
        $this->load->model('main_mod','Main');  
        $this->load->library('cart');
        //$this->mp->sandbox_mode(TRUE);
    }
    
    public function setArticle($values){     
      
        $evento = $this->Main->getEvento();
        set_session('security', $values['security'],false);
        $data = array('id'      =>'AMDIA'.$evento->id,
                      'name'    => $evento->nombre,
                      'price'   => 120,
                      'qty'     => 1,
                      'options' => array('nombre'=>$values['nombre'], 'apellido'=>$values['apellido'], 'email' => $values['email'])
                     );
                     
                          
            
             
        if($this->cart->insert($data)) {
            $success = true;
        } else {
            $success = false;
        };
        
        return $success;
    }
    
    public function getCart(){
        return $this->cart->contents();
    }
    


}