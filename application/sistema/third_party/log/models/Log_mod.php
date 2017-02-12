<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 *  TODO: Login Attempts, Restore Password, Update User
 *  LOG
 */
 

class Log_mod extends RR_Model {    
    
	public function __construct() {	   
 		parent::__construct();        
    }
    
    public function setLog($log_action, $mensaje=NULL){
        
        $data = array('logaccion_id' => $log_action,
                      'usuario_id'   => get_session('id',false),
                      'sistema_id'   => $this->sistema_id,
                      'fecha'        => $this->today,
                      'mensaje'      => !empty($mensaje) ? $mensaje : '-',
                      'ip'           => $this->input->ip_address()
                     );        
                     
        $this->db->insert('logs',$data);
    }
    

}