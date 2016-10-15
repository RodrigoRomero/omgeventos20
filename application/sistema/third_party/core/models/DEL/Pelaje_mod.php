<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 *  TODO: LOG
 */
 

class Pelaje_mod extends RR_Model {
    var $atributo = 'pelajes';
    var $table    = 'pelajes';
	public function __construct() {	   
 		parent::__construct();
    }
    
    public function getListado(){
        
        $query = $this->db->get_where($this->table);
        
        //CONFIG
        $lnk_del = lang_url($this->atributo.'/chk_deletea');
        $upd_del = lang_url($this->atributo.'/iu');
        $html  = "<a class='ax-modal' href='".$lnk_del."/{%id%}'><span class='icon-trash'></span></a>"; 
		$html .= "<a class='' href='".$upd_del."/{%id%}'><span class='icon-pencil'></span></a>";
        $extra[] = array("html" => $html, "pos" => 0);
        $datagrid["columns"][] = array("title" => "", "field" => "", "width" => "46");      
        $datagrid["columns"][] = array("title"=>"Id", "field"=>"id");
        $datagrid["columns"][] = array("title" => "Abreviatura", "field" => "abreviatura");
        $datagrid["columns"][] = array("title" => "Nombre", "field" => "nombre");
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
            $row = $this->db->get_where($this->table,array('id'=>$id))->row();
        }
        $data = $row;        
        $panel = $this->view("panels/".$this->atributo, array('row'=>$row));
        return $panel;
    }
    
    public function do_iu(){
         #VALIDO FORM POR PHP
         $success = 'false';
         if($this->form_validation->run('Atributos')==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessages';
            $messages     = validation_errors();
            $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
         } else {
            $activo = 0;            
            if (isset($_POST['activo'])) $activo = 1;
            
            
            
            $values = array ('nombre'      => $this->input->post('nombre'),
                             'abreviatura' => $this->input->post('abreviatura'),
                             'activo'      => $activo
                             );
                                         
            if(!isset($_POST['id'])){
                $query = $this->db->insert($this->table, $values);
                $this->session->set_flashdata('insert_success', 'Registro Insertado Exitosamente');
            } else {
                $id = $this->input->post('id');
                $this->db->where('id', $id);
				$query = $this->db->update($this->table, $values);
                $this->session->set_flashdata('insert_success', 'Registro Actualizado Exitosamente');
            }
            
            if($query){
                $success = true;
                $responseType = 'redirect';
                
                $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>lang_url('pelajes/listado'));
            }
             
         }
         
         return $data;
    }
    

    

}