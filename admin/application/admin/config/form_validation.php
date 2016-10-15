<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * @description Validaciones para Cabayada Gen Administrador y Auth Third Party
 */
                       
$config = array(
                 'AuthLogin' => array(
                                    array(
                                            'field' => 'user',
                                            'label' => 'Usuario',
                                            'rules' => 'trim|required|valid_email|xss_clean'
                                         ),
                                    array(
                                            'field' => 'password',
                                            'label' => 'Contraseña',
                                            'rules' => 'trim|required|xss_clean|md5'
                                         ),
                                    ),
                 
                 'Usuarios' => array(                                    
                                    array(
                                            'field' => 'nombre',
                                            'label' => 'Nombre',
                                            'rules' => 'trim|required|xss_clean'
                                         ),
                                    array(
                                            'field' => 'apellido',
                                            'label' => 'Apellido Responsable',
                                            'rules' => 'trim|required|xss_clean'
                                         ),                                    
                                    array(
                                            'field' => 'email',
                                            'label' => 'Email Responsable',
                                            'rules' => 'trim|required|valid_email|xss_clean'
                                         ),
                                    array(
                                            'field' => 'password',
                                            'label' => 'Passsword',
                                            'rules' => 'trim|required|xss_clean|matches[valid_password]|md5|min_length[7]'
                                         ),
                                    
                                    array(
                                            'field' => 'valid_password',
                                            'label' => 'Repetir Passsword',
                                            'rules' => 'trim|required|xss_clean|md5|min_length[7]'
                                         ),

                                    ),
                'Atributos' => array(
                                    array(
                                            'field' => 'nombre',
                                            'label' => 'Nombre',
                                            'rules' => 'trim|required|xss_clean'
                                         ),                                    
                                    ),
                'Proyectos' => array(
                                    array(
                                            'field' => 'nombre',
                                            'label' => 'Nombre',
                                            'rules' => 'trim|required|xss_clean'
                                         ),
                                    array(
                                            'field' => 'descripcion',
                                            'label' => 'Descripcion',
                                            'rules' => 'trim|required|xss_clean'
                                         ),                                    
                                    ),                                    
                                 
                 
                 'Inversores' => array(
                                    array(
                                            'field' => 'nombre',
                                            'label' => 'Nombre',
                                            'rules' => 'trim|required|xss_clean'
                                         ),
                                    array(
                                            'field' => 'apellido',
                                            'label' => 'Apellido',
                                            'rules' => 'trim|required|xss_clean'
                                         ),
                                    array(
                                            'field' => 'email',
                                            'label' => 'Email',
                                            'rules' => 'trim|required|valid_email|xss_clean'
                                         ),
                                    array(
                                            'field' => 'password',
                                            'label' => 'Passsword',
                                            'rules' => 'trim|required|xss_clean|matches[valid_password]|md5|min_length[7]'
                                         ),
                                    
                                    array(
                                            'field' => 'valid_password',
                                            'label' => 'Repetir Passsword',
                                            'rules' => 'trim|required|xss_clean|md5|min_length[7]'
                                         ),
                                    array(
                                            'field' => 'dni',
                                            'label' => 'DNI',
                                            'rules' => 'trim|required|xss_clean'
                                         ),
                                    ),
                   'Managers' => array(
                                    array(
                                            'field' => 'nombre',
                                            'label' => 'Nombre',
                                            'rules' => 'trim|required|xss_clean'
                                         ),
                                    array(
                                            'field' => 'apellido',
                                            'label' => 'Apellido',
                                            'rules' => 'trim|required|xss_clean'
                                         ),
                                    array(
                                            'field' => 'codigo',
                                            'label' => 'Código',
                                            'rules' => 'trim|required|xss_clean'
                                         ),                                    
                                    ),
                    'PDFS' => array(
                                    array(
                                            'field' => 'nombre',
                                            'label' => 'Nombre',
                                            'rules' => 'trim|required|xss_clean'
                                         ),
                                    array(
                                            'field' => 'bajada',
                                            'label' => 'Bajada',
                                            'rules' => 'trim|required|xss_clean'
                                         ),                                                                      
                                    ), 
                 
                 
                 
               );