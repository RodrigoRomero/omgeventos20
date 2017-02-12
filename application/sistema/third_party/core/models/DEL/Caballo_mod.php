<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 *  TODO: LOG
 */
require_once(BASEPATH."../assets/widgets/uploadManager/UploadManager.php"); 
class Caballo_mod extends RR_Model {
    var $atributo = 'caballos';
    var $table    = 'caballos';
    var $categoria_id;
    var $caballo_id;    
	public function __construct() {	   
 		parent::__construct();
        $this->categoria_id = $this->params['c'];
        $this->caballo_id   = !empty($this->params['id']) ? $this->params['id'] : '';
    }
    
    public function getListado(){        
        $categoria_id = $this->params['c'];
        $sistema_id   = get_session('sistema_id',false);
        
        switch($this->categoria_id) {
            case 1:
                $query = $this->_getRecords();
                $tooltip_text = 'Ficha Semen';
                $new_title    = 'Nuevo Padrillo';
                break;
            
            case 2:
            default:
                $query = $this->_getRecords();
                $tooltip_text = 'Ficha Ginecológica';
                $new_title    = 'Nueva Donante';
                break;
            case 3:     
                $query = $this->_getRecords();        
                $new_title    = 'Nueva Receptora';
                $tooltip_text = 'Ficha Ginecológica';
                break;
        }
        
        
        //CONFIG
        $lnk_del   = set_url(array($this->atributo => 'chk_deletea'));
        $lnk_upd   = set_url(array($this->atributo =>'action', 'iu'=>'u', 'c'=>$this->params['c']));
        $lnk_fmed  = config_item("base_url").'fichas/detalle/c/'.$this->params['c'];
        
        $html  = "<a class='ax-modal tip-top icon-trash' href='".$lnk_del."/id/{%id%}' data-original-title='Eliminar' style='margin-right:10px'></a>"; 
		$html .= "<a class='tip-top icon-pencil' href='".$lnk_upd."/id/{%id%}' data-original-title='Editar' style='margin-right:10px'></a>";
        $html .= "<a class='icon-stethoscope tip-top' href='".$lnk_fmed."/id/{%id%}' data-original-title='".$tooltip_text."'></a>";
        
        $extra[] = array("html" => $html, "pos" => 0);                
        $datagrid["columns"][] = array("title" => "Acciones", "field" => "", "width" => "55");
        
        switch($this->categoria_id) {
            case 1:
                
                $datagrid["columns"][] = array("title" => "Nombre", "field" => "nombre");                
                $datagrid["columns"][] = array("title" => "Propietario", "field" => "json", 'json'=>'propietario->nombre');
                $datagrid["columns"][] = array("title" => "Saltos x <br/>Temporada Actual", "field" => "total_saltos");
                
                
                break;
            
            case 2:
            default:
                $datagrid["columns"][] = array("title" => "Nombre", "field" => "nombre");
                $datagrid["columns"][] = array("title" => "Admision", "field" => "fecha_admision", 'format'=>'date');
                $datagrid["columns"][] = array("title" => "Propietario", "field" => "json", 'json'=>'propietario->nombre');
                $datagrid["columns"][] = array("title" => "P. Solicitadas", "field" => "preneces_solicitadas");
                $datagrid["columns"][] = array("title" => "P. Logradas", "field" => "transferencias_logradas");
                $datagrid["columns"][] = array("title" => "Transferencias", "field" => "transferencias");
                break;
            case 3:     
                $datagrid["columns"][] = array("title" => "Car", "field" => "caravana");
                $datagrid["columns"][] = array("title" => "Nombre", "field" => "nombre");
                $datagrid["columns"][] = array("title" => "Admision", "field" => "fecha_admision", 'format'=>'date');
                $datagrid["columns"][] = array("title" => "Propietario", "field" => "json", 'json'=>'propietario->nombre');
                break;
        }
        
        
        
        
        
        
        $datagrid["rows"]      = $this->datagrid->query_to_rows($query->result(), $datagrid["columns"], $extra);

        $filter_data = array('new' => set_url(array($this->atributo =>'action', 'iu'=>'i', 'c'=>$this->params['c'])),
                             'new_title' => $new_title,
                            );
        
        $filter = $this->view("filters/".$this->atributo, $filter_data);
        
        $dg = array("datagrid" => $datagrid,
                    "filters"  => $filter);
        $grid = $this->datagrid->make($dg);
        return $grid;
    }
    
    public function set_iu(){
        $data_panel['action'] = set_url(array('caballos'=>'do_iu'));
        if(!empty($this->params['id'])){
            $id = $this->params['id'];
            $data_panel['row'] = $this->db->get_where($this->table,array('id'=>$id))->row();
        }
        
        #ATRIBUTOS DE PELAJES
        $data_panel['pelaje'] = $this->get_atributos('pelajes');
        
        #ATRIBUTOS DE PROPIETARIO
        $data_panel['propietario'] = $this->get_atributos('propietarios');
        
        #SET UPLOAD IMAGENES
        $data_panel['img_caballo'] = json_decode($this->env->getEnv('img_caballo'));        
        
        
        #TRAIGO PADRILLOS - PARA ASIGNAR A DONANTES        
        if($this->categoria_id==2){
            $data_panel['padrillos'] =   $this->_getCaballos(1);
        }
        
        
        $panel = $this->view("panels/".$this->atributo, $data_panel);
        return $panel;
    }
    
    public function do_iu(){
       
         #VALIDO FORM POR PHP
         $success = 'false';
         if($this->form_validation->run('Caballos')==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessages';
            $messages     = validation_errors();
            $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
         } else {            
            $temporada     = get_session('temporada',false);
            $categoria_id = $this->params['c'];
            $activo = 0;            
            if (isset($_POST['activo'])) $activo = 1;
            $fecha_admision = $this->input->post('fecha_admision',true);
            
            
            $json = array();
            
            #CATEGORIA            
            if(!empty($categoria_id)){
                $categoria = $this->get_atributos('categorias',true,$categoria_id);
                $json['categorias'] = array('id'=>$categoria->id, 'nombre'=>$categoria->nombre);
            }
            
            #PELAJE            
            if(isset($_POST['pelaje_id'])){
                $pelaje = $this->get_atributos('pelajes',true,$_POST['pelaje_id']);
                $json['pelaje'] = array('id'=>$pelaje->id, 'nombre'=>$pelaje->nombre);
            }
            
            #PROPIETARIO            
            if(isset($_POST['propietario_id'])){              
                $propietario = $this->get_atributos('propietarios',true,$_POST['propietario_id']);
                $json['propietario'] = array('id'=>$propietario->id, 'nombre'=>$propietario->nombre);
            }
            
            switch($categoria_id){
                case 1:
                    $values_extra = array();
                    break;
                    
                case 2:
                    #PADRILLOS ASIGNADOS
                    if(isset($_POST['padrillos_right'])){
                        $padrillos_ids = implode(",",$_POST['padrillos_right']);                        
                        
                        foreach($_POST['padrillos_right'] as $k => $v){                            
                            $padrillo = $this->_getCaballos(1,$v);
                            $json['padrillo_asignado'][] = array('id'=>$padrillo->id, 'nombre'=>$padrillo->nombre);
                        }
                        
                    }
                    $values_extra['padrillos_asignados_id'] = $padrillos_ids;
                    $values_extra['preneces_solicitadas']    = $this->input->post('preneces_solicitadas',true);
                    break;
                                    
                case 3:
                    $values_extra = array();
                    break;
            }
            
            $json = json_encode($json);
            $values = array('sistema_id'        => get_session('sistema_id',false),
                            'nombre'            => $this->input->post('nombre',true),
                            'categoria_id'      => $categoria->id,
                            'caravana'          => $this->input->post('caravana',true),
                            'codigo_sba'        => $this->input->post('codigo_sba',true),
                            'propietario_id'    => $propietario->id,
                            'pelaje_id'         => $pelaje->id,
                            'rp'                => $this->input->post('rp',true),
                            'tipificacion'      => $this->input->post('tipificacion',true),
                            'fecha_admision'    => getFechasSQL($fecha_admision),
                            'activo'            => $activo,
                            'json'              => $json                            
                           );
            
            $this->db->trans_start(); 
            switch($this->params['iu']) {
                case 'i':
                
                    $query = $this->db->insert($this->table, array_merge($values,$values_extra));
                    $id = $this->db->insert_id();
                   
                    switch($categoria->id){
                        #INICIALIZO TRANSFERENCIAS DE CABALLOS PARA X TEMPORADA
                        case 2:
                            $values_transferencias = array('caballo_id'   => $id,
                                                           'temporada_id' => $temporada->id);
                                                           
                            $query = $this->db->insert('caballos_transferencias',$values_transferencias);
                            break;
                    }
                    $this->session->set_flashdata('insert_success', 'Registro Insertado Exitosamente');
                    break;
                    
                case 'u':
                    if(isset($this->params["id"]) || empty($this->params["id"])) {
                        $id = $this->params["id"];
                        $this->db->where('id', $id);
				        $query = $this->db->update($this->table, array_merge($values,$values_extra));
                        $this->session->set_flashdata('insert_success', 'Registro Actualizado Exitosamente');
                    }
            }
            $this->db->trans_complete();

            if ($this->db->trans_status()){
                $success = true;
                $responseType = 'redirect';
                
                $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>lang_url('caballos/listado/c/'.$categoria->id));
            }
             
         }
         
         $up = new UploadManager();        
         $resize = $up->resize($id, BASEPATH . "../assets/widgets/uploadManager/");
         
         return $data;
    }
    
    public function asignar_padrillos(){
            $success = 1;
            $responseType = 'function';
            $data['padrillos'] = $this->_getCaballos(1);
            $data['action']    = set_url(array('caballos'=>'do_asignarPadrillos'));
            $data = array('title'   => 'Seleccionar Padrillos',
                          'texto'   => $this->view('panels/asignarPadrillos',$data),
                          'link'    => '',  
                          'buttons' => 'no'               
                    );
            $html         = $this->view('alerts/modal_dialog', $data);
            $function     = 'open_modal';
            $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$html, 'value'=>$function);
            return $data;
    }
    
    public function do_asignarPadrillos(){
        
        if(isset($_POST['padrillos_right'])){
            $padrillos_ids = implode(",",$_POST['padrillos_right']);                        
            
            foreach($_POST['padrillos_right'] as $k => $v){                            
                $padrillo = $this->_getCaballos(1,$v);
                $json['padrillo_asignado'][] = array('id'=>$padrillo->id, 'nombre'=>$padrillo->nombre);
            }
        }
        
        $row      = $this->db->select('json')->get_where($this->table,array('id'=>$this->caballo_id, 'activo'=>1))->row();
        $old_json = (array)json_decode($row->json);
        $json     = json_encode(array_merge($old_json,$json)); 
        
        $values = array('padrillos_asignados_id' => $padrillos_ids,
                        'json' => $json);
        
        $this->db->where('id', $this->caballo_id);
		$query = $this->db->update($this->table, $values);
        
        $success = true;
        $responseType = 'redirect';
        $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>lang_url('fichas/detalle/c/'.$this->categoria_id.'/id/'.$this->caballo_id));
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
                $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>lang_url('caballos/listado/c/2'));
            }
        }
        return $data;
    }
    
    
    public function getListadoDashboard($categoria_id, $limit, $grid_title){
        $sistema_id   = get_session('sistema_id',false);
        
        $this->db->select('id, nombre, activo');
        $this->db->limit($limit);        
        $query = $this->db->get_where($this->table, array('sistema_id'=>$sistema_id, 'categoria_id'=>$categoria_id, 'activo'=>1));
        
        
        $datagrid["columns"][] = array("title"=>"Id", "field"=>"id");
        $datagrid["columns"][] = array("title" => "Nombre", "field" => "nombre");        
        $datagrid["columns"][] = array("title" => "Activo", "field" => "activo", 'format'=>'icon-activo');        
        $datagrid["rows"]      = $this->datagrid->query_to_rows($query->result(), $datagrid["columns"]);

        
        $dg = array("datagrid"   => $datagrid,
                    "grid_title" => $grid_title,
                    "grid_type"  => 'jData-table-dashboard');
        $grid = $this->datagrid->make($dg);
        return $grid;
    }
    
    private function _getRecords(){
        $temporada     = get_session('temporada',false);
        
        $where = array('c.sistema_id'   => $this->sistema_id,
                       'c.categoria_id' => $this->categoria_id,
                       'c.activo'       => 1);
        
        
        switch ($this->categoria_id){
            case 1:
                $query = "SELECT c.*, f.total_saltos
                          FROM caballos c
                          LEFT JOIN (SELECT caballo_id, COUNT(id) total_saltos FROM fichas WHERE temporada_id = ".$temporada->id." GROUP BY caballo_id) f ON f.caballo_id = c.id
                          WHERE c.categoria_id = ".$this->categoria_id." 
                          AND c.sistema_id = ".$this->sistema_id." ";

                $query = $this->db->query($query);
                //ep($query->result());
                break;
            
            case 2:
                $this->db->from('caballos c');     
                $this->db->where($where);                   
                $this->db->select('c.*, ct.transferencias, ct.transferencias_logradas',false);
                $this->db->join('caballos_transferencias ct', 'c.id = ct.caballo_id');
                $query = $this->db->get();
                break;
            
            default:
                $this->db->from('caballos c');     
                $this->db->where($where);     
                $this->db->select('c.*',false);
                $query = $this->db->get();
                break;
        };
        
        return $query;
    }
    
    private function _getCaballos($categoria, $id=null){       
        
        $where = array('activo'       => 1,
                       'categoria_id' => $categoria,
                       'sistema_id'   => $this->sistema_id
                       );
        
        if(!empty($id) && $id!=null){
            $where_in = array('id' => $id);
            $where = array_merge($where,$where_in);
        }                      
        $query = $this->db->get_where('caballos',$where);
        if(!empty($id) && $id!=null){
            $result = $query->row();
        } else {
            $result = $query->result();
        }
        return $result;
    }
    

    

}