<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 */
 
class Zt_Auth {
    
    public function __construct(){
        $this->CI =& get_instance();
    }
    
    public function loggedin(){
       if(!get_session("id", false)){
        return false;
       } else {
        return true;
       };
    }
}