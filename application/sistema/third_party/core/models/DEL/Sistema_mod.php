<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 *  TODO: LOG
 *  TODO: VALIDAR SISTEMAS / DOMINIOS REPETIDOS 
 *  TODO: UPLOAD LOGO SISTEMA
 */
 

class Sistema_mod extends RR_Model {
    var $atributo = 'sistemas';
    var $table    = 'sistemas';
	public function __construct() {	   
 		parent::__construct();
    }
    
    public function getListado(){        
        $this->db->select('s.nombre, s.dominio, CONCAT(u.nombre," ",u.apellido) responsable, u.email, s.activo, s.id',false);
        $this->db->from('sistemas s');
        $this->db->join('usuarios u', 'u.sistema_id = s.id');
        $query = $this->db->get();
        
        //CONFIG
        $lnk_del = lang_url($this->atributo.'/chk_deletea');
        $upd_del = lang_url($this->atributo.'/iu');
        $html  = "<a class='ax-modal' href='".$lnk_del."/{%id%}'><span class='icon-trash'></span></a>"; 
		$html .= "<a class='' href='".$upd_del."/{%id%}'><span class='icon-pencil'></span></a>";
        $extra[] = array("html" => $html, "pos" => 0);
        $datagrid["columns"][] = array("title" => "", "field" => "", "width" => "46");
        $datagrid["columns"][] = array("title" => "Sistema", "field" => "nombre");
        $datagrid["columns"][] = array("title" => "Dominio", "field" => "dominio");
        $datagrid["columns"][] = array("title" => "Titular", "field" => "responsable");
        $datagrid["columns"][] = array("title" => "Email", "field" => "email");
        $datagrid["columns"][] = array("title" => "Activo", "field" => "activo");
        $datagrid["rows"]      = $this->datagrid->query_to_rows($query->result(), $datagrid["columns"], $extra);

        $filter_data = array('new' => lang_url($this->atributo.'/iu'),
                            );
        
        $filter = $this->view("filters/".$this->atributo, $filter_data);
        
        $dg = array("datagrid" => $datagrid,
                    "filters"  => $filter);
        $grid = $this->datagrid->make($dg);
        return $grid;
    }
    
    public function set_iu($id= NULL){
        if(!empty($id)){
            $this->db->select('s.nombre, s.dominio, u.nombre user_nombre, u.apellido user_apellido, u.email, u.telefono, s.activo, s.id',false);
            $this->db->from('sistemas s');
            $this->db->where('s.id',$id);
            $this->db->join('usuarios u', 'u.sistema_id = s.id');
            $row = $this->db->get()->row();
            $row->password = 'ztentaGen';
        }
                
        $panel = $this->view("panels/".$this->atributo, array('row'=>$row));
        return $panel;
    }    
        
    public function do_iu(){
         #VALIDO FORM POR PHP
         $success = 'false';
         if($this->form_validation->run('Sistemas')==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessages';
            $messages     = validation_errors();
            $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
         } else {
            $activo = 0;            
            if (isset($_POST['activo'])) $activo = 1;
                        
            $nombre_sistema = $this->input->post('nombre');
            if(!empty($_POST['dominio'])) {
                $domino_sistema = $this->input->post('dominio');                
            } else {
                $domino_sistema = $this->input->post('nombre');
            }
            
            $domino_sistema = quitarAcentos($domino_sistema,2,1);
            
            #INICIO UNA TRANSACCION PARA MULTIPLES INSERT SEGUROS
            $this->db->trans_start();
            
            #ARMO EL ARRAY PARA INSERTAR LOS VALORES DEL SISTEMA
            $values_sistema = array ('nombre'  => $nombre_sistema,
                                     'dominio' => $domino_sistema,
                                     'activo'      => $activo
                                    );
                                    
            $this->db->insert($this->table,$values_sistema);
            $sistema_id = $this->db->insert_id();
            
            
            #ARMO EL ARRAY PARA INSERTAR EL PRIMER USUARIO DEL SISTEMA COMO PADRE 
            $values_primer_usuario = array('sistema_id' => $sistema_id,
                                           'nombre'     => $this->input->post('user-nombre'),
                                           'apellido'   => $this->input->post('user-apellido'),
                                           'email'      => $this->input->post('user-email'),
                                           'password'   => $this->input->post('password'),
                                           'telefono'   => $this->input->post('user-telefono'),
                                           'activo'     => $activo,
                                           'principal'  => 1
                                          );
            $this->db->insert('usuarios', $values_primer_usuario);
            
            #CIERRO TRANSACCION
            $this->db->trans_complete();
            
           
            if($this->db->trans_status()!=FALSE){
                $success = true;
                $responseType = 'redirect';
                $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>lang_url($this->atributo.'/listado'));
            };
            
            
            
            
            /*                                         
            if(!isset($_POST['id'])){
                $query = $this->db->insert($this->table, $values);
                $this->session->set_flashdata('insert_success', 'Registro Insertado Exitosamente');
            } else {
                $id = $this->input->post('id');
                $this->db->where('id', $id);
				$query = $this->db->update($this->table, $values);
                $this->session->set_flashdata('insert_success', 'Registro Actualizado Exitosamente');
            }
            

             */
         }
         
         return $data;
    }
    

    

}