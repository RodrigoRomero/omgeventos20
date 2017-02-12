<?php
/* VERSION: 2.0.0
 * 
 * 
 */
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
/* 
| ------------------------------------------------------------------- 
| EMAIL CONFING 
| ------------------------------------------------------------------- 
| Configuration of outgoing mail server. 
| */ 


$email_src    = "../../../email.php";
$email_config =  $_SERVER["DOCUMENT_ROOT"].$email_src;

if(file_exists($email_config)){
    require_once($email_config);
}
/* End of file email.php */  
/* Location: ./system/application/config/email.php */  