<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 *  TODO: LOG
 */
 

class Temporada_mod extends RR_Model {
    var $atributo = 'usuarios';
    var $table    = 'usuarios';
	public function __construct() {	   
 		parent::__construct();
    }
    
    public function getListado(){
            echo '124';
    }

    

    

}