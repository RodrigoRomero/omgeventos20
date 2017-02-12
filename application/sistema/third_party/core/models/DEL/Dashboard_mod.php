<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 *  TODO: LOG
 */
 

class Dashboard_mod extends RR_Model {

	public function __construct() {	   
 		parent::__construct();
    }
    
    
    public function getCalendar(){
        $proxima_revision = array();
        
        $where = array('c.sistema_id'   => $this->sistema_id,                       
                       'c.activo'       => 1,
                       'f.activo'       => 1);
                       
        $result = $this->db->select('f.fecha_proxima_revision, c.nombre, c.id,c.categoria_id',false)
                           ->from('fichas f')
                           ->join('caballos c', 'c.id = f.caballo_id')
                           ->where($where)
                           ->get()
                           ->result();
        
        
        foreach ($result as $k=>$v){
            $proxima_revision[$k]['url']             = lang_url('fichas/detalle/c/'.$v->categoria_id.'/id/'.$v->id);
            $proxima_revision[$k]['title']           = $v->nombre;     
            $proxima_revision[$k]['start']           = $v->fecha_proxima_revision;
            $proxima_revision[$k]['backgroundColor'] = "#FAA732";
        }
        
        
        return $proxima_revision;
        
    }


    

}