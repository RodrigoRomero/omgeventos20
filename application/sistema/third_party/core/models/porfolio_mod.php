<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 */
 

class Porfolio_mod extends RR_Model {
	public function __construct() {	   
 		parent::__construct();
    }
    
    public function getItemsGaleria(){
        $result = $this->db->get_where('casos_de_exito',array('status'=>1))->result();
        $galeria = array();
        foreach($result as $item){
            $json = json_decode($item->json);
            $galeria[$item->id]['total_images'] = $this->getTotalImages($item->id,'porfolios/original');
            $galeria[$item->id]['titulo']       = $json->lang->{$this->Clang}->nombre;
            $galeria[$item->id]['id']           = $item->id;
        }
        
        return $galeria;
    }
    
    public function getItems($id){
        $this->db->like('atributos_id',$id);
        $result = $this->db->get_where('casos_de_exito',array('status'=>1))->result();
        return $result;
    }
    
    public function getDetails($id){
        $row = $this->db->get_where('casos_de_exito',array('status'=>1, 'id'=>$id))->row();
        return array('data'=>$row, 'total_images'=>$this->getTotalImages($id,'porfolios/original'));
    }
    
    /*
    public function getDestacadosHome(){
        $this->db->like('atributos_id','20002');
        $this->db->limit(3);
        $this->db->order_by('id', 'DESC');
        $result = $this->db->get_where('porfolios',array('status'=>1))->result();
        return $result;
        
    }
    
    public function getSlider(){
        $this->db->like('atributos_id','20003');
        $result = $this->db->get_where('porfolios',array('status'=>1))->result();
        shuffle($result);
        return $result;   
    }
    
    
    */
}