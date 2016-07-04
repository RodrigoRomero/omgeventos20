<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 */
 
class or_auth {
    private $or_auth_prefs;
    public function __construct(){
        $this->CI =& get_instance();
        $this->CI->load->config('Auth', TRUE);
        $this->_set_auth_prefs();
    }
    
    public function loggedin(){    
        
       if(!get_session($this->or_auth_prefs['login_table']."_id", false)){
        return false;
       } else {
        return true;
       };
    }
    
    private function _set_auth_prefs(){
        $this->or_auth_prefs = $this->CI->config->item('or_auth_prefs','Auth');
    }
}