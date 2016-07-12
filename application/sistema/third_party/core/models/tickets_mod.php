<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 */

class tickets_mod extends RR_Model {
    
    public function __construct() {
        parent::__construct();        
    }
    
    public function getTicketById($id){
        return $this->db->get_where('tickets',array('id'=>$id))->row();
    }
}