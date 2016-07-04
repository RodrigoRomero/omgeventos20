<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 */
 

class Sistema_mod extends RR_Model {    
    
	public function __construct() {	   
 		parent::__construct();
 	}
    
    public function getSistemas() {
        $query = $this->db->get('sistemas');
        
        return $query->result();
    }
    

}