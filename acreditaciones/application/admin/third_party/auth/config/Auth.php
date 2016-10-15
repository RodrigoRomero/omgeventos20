<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * @description Configuracion Módulo Auth
 */
          
$config['or_auth_prefs']['max_login_attempts']  = 3;
$config['or_auth_prefs']['login_table']         = 'asistentes';
$config['or_auth_prefs']['validationRules']     = 'AuthAsistentesLogin';
$config['or_auth_prefs']['userType']            = 'user_name';