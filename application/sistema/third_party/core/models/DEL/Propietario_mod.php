<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 *  TODO: LOG
 */
 

class Propietario_mod extends RR_Model {
    var $atributo = 'propietarios';
    var $table    = 'propietarios';
	public function __construct() {	   
 		parent::__construct();
    }
    
    public function getListado(){
        
        $this->db->select('id, CONCAT(nombre," ", apellido) nombre, activo',false);        
        $query = $this->db->get_where($this->table, array('sistema_id'=>get_session('sistema_id',false), 'activo >'=>0));
        
        //CONFIG
        $lnk_del = lang_url($this->atributo.'/chk_deletea');
        $upd_del = set_url(array($this->atributo =>'action', 'iu'=>'u'));
        $html  = "<a class='ax-modal tip-top icon-trash' href='".$lnk_del."/id/{%id%}' data-original-title='Eliminar' style='margin-right:10px'></a>";         
		$html .= "<a class='tip-top' href='".$upd_del."/id/{%id%}' data-original-title='Editar'><span class='icon-pencil'></span></a>";
        $extra[] = array("html" => $html, "pos" => 0);
        $datagrid["columns"][] = array("title" => "", "field" => "", "width" => "46");      
        $datagrid["columns"][] = array("title"=>"Id", "field"=>"id");
        $datagrid["columns"][] = array("title" => "Nombre", "field" => "nombre");        
        $datagrid["columns"][] = array("title" => "Activo", "field" => "activo", 'format'=>'icon-activo');
        
        $datagrid["rows"]      = $this->datagrid->query_to_rows($query->result(), $datagrid["columns"], $extra);

        $filter_data = array('new' => set_url(array($this->atributo =>'action', 'iu'=>'i')),
                            );
        
        $filter = $this->view("filters/".$this->atributo, $filter_data);
        
        $dg = array("datagrid" => $datagrid,
                    "filters"  => $filter);
        $grid = $this->datagrid->make($dg);
        return $grid;
    }
    
    public function set_iu($id= NULL){
        $action = set_url(array('propietarios'=>'do_iu'));        
        if(!empty($this->params['id'])){
            $id = $this->params['id'];
            $row = $this->db->get_where($this->table,array('id'=>$id))->row();
        }
                
        $panel = $this->view("panels/".$this->atributo, array('row'=>$row, 'action'=>$action));
        return $panel;
    }
    
    public function do_iu(){
         #VALIDO FORM POR PHP
         $success = 'false';
         if($this->form_validation->run('Propietarios')==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessages';
            $messages     = validation_errors();
            $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
         } else {
            $activo = 0;            
            if (isset($_POST['activo'])) $activo = 1;
            
            $values = array ('nombre'      => $this->input->post('nombre',true),
                             'apellido'    => $this->input->post('apellido', true),
                             'activo'      => $activo,
                             'sistema_id'  => get_session('sistema_id',false)
                             );
            
            switch($this->params['iu']) {
                case 'i':
                    $query = $this->db->insert($this->table, $values);
                    $this->session->set_flashdata('insert_success', 'Registro Insertado Exitosamente');
                    break;
                    
                case 'u':
                    if(isset($this->params["id"]) || empty($this->params["id"])) {
                        $id = $this->params["id"];
                        $this->db->where('id', $id);
				        $query = $this->db->update($this->table, $values);
                        $this->session->set_flashdata('insert_success', 'Registro Actualizado Exitosamente');
                    }
            }

            if($query){
                $success = true;
                $responseType = 'redirect';
                
                $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>lang_url('propietarios/listado'));
            }
             
         }
         
         return $data;
    }
    
    public function chk_deletea(){
       return $this->check_deletea();
    }
    
    public function deletea(){
        if(isset($this->params["id"]) || empty($this->params["id"])) {
            $id = $this->params["id"];
            $values = array('activo'=>-1);
            $this->db->where('id', $id);
	        $query = $this->db->update($this->table, $values);
            $this->session->set_flashdata('insert_success', 'Registro Eliminado Exitosamente');
            
            if($query){
                $success = true;
                $responseType = 'redirect';                
                $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>lang_url('propietarios/listado'));
            }
        }
        return $data;
    }
    

    

}