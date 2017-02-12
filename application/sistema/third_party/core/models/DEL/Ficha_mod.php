<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 *  TODO: LOG
 *  TODO: GUARDAR EN SESSION LA TEMPORADA ACTUAL
 */
 

class Ficha_mod extends RR_Model {
    var $atributo = 'fichas';
    var $table    = 'fichas';
    var $caballo_id;
    var $categoria_id;
    var $ficha_id;
	public function __construct() {	   
 		parent::__construct();
        $this->caballo_id   = $this->params['id'];
        $this->categoria_id = $this->params['c'];
        $this->ficha_id     = isset($this->params['ficha_id']) ? $this->params['ficha_id'] : '';
    }
    
    public function getListado(){
    }
    
    
    public function getDetalle() {     
        $info_cabecera = array('data'=> $this->_getCabecerasFicha());
        
        
        $cabeceras = $this->view('fichas/cabeceras', $info_cabecera);        
        
        $this->db->select('f.*, c.nombre caballo_nombre',false);        
        $this->db->from('fichas f');
        $this->db->join('caballos c', 'f.caballo_id = c.id');
        $this->db->where('f.caballo_id', $this->caballo_id);
        $this->db->where('f.activo',1);
        $this->db->order_by('fecha_revision','DESC');
        $query = $this->db->get();
        
        //CONFIG
        $lnk_del = lang_url($this->atributo.'/chk_deletea/c/'.$this->categoria_id);
        $upd_del = lang_url($this->atributo.'/iu');
        $html  = "<a class='tip-top ax-modal' href='".$lnk_del."/id/{%caballo_id%}/ficha_id/{%id%}' data-toggle='modal' style='margin-right:10px' data-original-title='Eliminar'><span class='icon-trash'></span></a>";        
		$html .= "<a class='tip-top' href='".$upd_del."/{%id%}' data-original-title='Editar'><span class='icon-pencil'></span></a>";        
        $extra[] = array("html" => $html, "pos" => 0);        
        $datagrid["columns"][] = array("title" => "", "field" => "", "width" => "46");
        
        
        
        $fichaMedica_data_donantes = array('action'                  => set_url(array($this->atributo=>'do_iu','iu'=>'i')),
                                           'ovariosOpciones'         => $this->get_atributos('ovarios'),
                                           'cervixOpciones'          => $this->get_atributos('cervix'),
                                           'uteroOpciones'           => $this->get_atributos('utero'),
                                           'accionesMedicasOpciones' => $this->get_atributos('acciones_medicas'),
                                           'drogasOpciones'          => $this->get_atributos('drogas'),
                                           'caballo_id'              => $this->caballo_id,
                                           );
        
        $fichaMedica_data_padrillos = array('action'                  => set_url(array($this->atributo=>'do_iu','iu'=>'i')),
                                            'caballo_id'              => $this->caballo_id,
                                           );
        switch($this->categoria_id) {
            case 1:
                $datagrid["columns"][] = array("title" => "Fecha/Hora", "field" => "fecha_revision", 'format'=>'datetime');
                $datagrid["columns"][] = array("title" => "Nº Salto", "field" => "json", 'json'=>'numero_salto');
                $datagrid["columns"][] = array("title" => "Vol. (ml)", "field" => "json", 'json'=>'volumen_ml');
                $datagrid["columns"][] = array("title" => "Gel", "field" => "json", 'json'=>'gel', 'format'=>'icon-activo');
                $datagrid["columns"][] = array("title" => "Motilidad<br/> Total", "field" => "json", 'json'=>'motilidad->total');
                $datagrid["columns"][] = array("title" => "Motilidad<br/>  Progresiva", "field" => "json", 'json'=>'motilidad->progresiva');
                $datagrid["columns"][] = array("title" => "Motilidad<br/>  Circular", "field" => "json", 'json'=>'motilidad->circular');
                $datagrid["columns"][] = array("title" => "Vigor", "field" => "json", 'json'=>'vigor');
                $datagrid["columns"][] = array("title" => "Concentrac.", "field" => "json", 'json'=>'concentracion');
                $datagrid["columns"][] = array("title" => "Observaciones", "field" => "json", 'json'=>'observaciones');
                
                
                $fichaMedica      = $this->view("fichas/fichaMedicaOpcionesPadrillos", $fichaMedica_data_padrillos);
                break;
            case 2:
            case 3:
            default:
                $datagrid["columns"][] = array("title" => "Fecha/Hora", "field" => "fecha_revision", 'format'=>'datetime');
                $datagrid["columns"][] = array("title" => "Acción", "field" => "json", 'json'=>'accion_medica->nombre');         
                $datagrid["columns"][] = array("title" => "OI", "field" => "json", 'json'=>'ovarios->ovario_izquierdo->nombre');
                $datagrid["columns"][] = array("title" => "OD", "field" => "json", 'json'=>'ovarios->ovario_derecho->nombre');
                $datagrid["columns"][] = array("title" => "Cervix", "field" => "json", 'json'=>'cervix->nombre');
                $datagrid["columns"][] = array("title" => "Útero", "field" => "json", 'json'=>'utero->nombre');
                $datagrid["columns"][] = array("title" => "Observaciones", "field" => "json", 'json'=>'observaciones');
                $datagrid["columns"][] = array("title" => "Drogas", "field" => "json", 'json'=>'droga->nombre', 'format'=>'important');
                $datagrid["columns"][] = array("title" => "Próxima Revision", "field" => "fecha_proxima_revision", 'format'=>'date');
                
                $fichaMedica      = $this->view("fichas/fichaMedicaOpcionesDonantes", $fichaMedica_data_donantes);
                break;
            
        }
        
        $datagrid["rows"]      = $this->datagrid->query_to_rows($query->result(), $datagrid["columns"], $extra);
        $dg = array("datagrid"    => $datagrid,
                    "fichaMedica" => $fichaMedica
                    );
        $grid = $this->datagrid->make($dg);
        
        $data = array('cabecera'=>$cabeceras,
                      'grid' =>$grid  );
        
        $ficha_completa = $this->view('fichas/completa',$data);
        
        return $ficha_completa;
    }
    
    public function do_iu(){

       
         #VALIDO FORM POR PHP
         $success = 'false';
         if($this->form_validation->run('FichaMedica')==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessages';
            $messages     = validation_errors();
            $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
         } else {            
            #RECUPERO ID CABALLO
            $caballo_id = $this->caballo_id;
            
            #TRAIGO TEMPORADA
            $temporada     = get_session('temporada',false);            
            
            
            #ARMO JSON            
            $json = array();
            $json['temporada']      = array('id'=>$temporada->id, 'nombre'=>$temporada->nombre);
            
            switch($this->categoria_id){
                case 1:
                        #BUSCO FECHAS REVISION Y GUARDO EN SQL
                        $fecha_revision                 = $this->input->post('fecha_revision');
                        $hora_revision                  = $this->input->post('hora_revision');                        
                        $fechas_ficha['fecha_revision'] = getFechasSQL($fecha_revision).' '.$hora_revision;
                        $json['fechas']                 = array('revision'=>$fechas_ficha['fecha_revision']);
                        
                        #MOTILIDAD                                                                    
                        $json['motilidad']['total']         = !empty($_POST['motilidad_total']) ? $this->input->post('motilidad_total') : 0;
                        $json['motilidad']['progresiva']    = !empty($_POST['motilidad_progresiva']) ? $this->input->post('motilidad_progresiva') : 0;
                        $json['motilidad']['circular']      = !empty($_POST['motilidad_circular']) ? $this->input->post('motilidad_circular') : 0;                        
                        
                        #GEL
                        $gel = 0;            
                        if (isset($_POST['gel'])) $gel = 1;                                                                   
                        $json['gel'] = $gel;
                        
                        #NRO SALTO                                                                    
                        $json['numero_salto'] = !empty($_POST['numero_salto']) ? $this->input->post('numero_salto') : 0;
                        
                        #VOLUMEN
                        $json['volumen_ml'] = !empty($_POST['volumen_ml']) ? $this->input->post('volumen_ml') : 0;
                        
                        #VIGOR
                        $json['vigor'] = !empty($_POST['vigor']) ? $this->input->post('vigor') : 0;
                        
                        #CONCENTRACION
                        $json['concentracion'] = !empty($_POST['concentracion']) ? $this->input->post('concentracion') : 0;
                    break;
                case 2:
                case 3:
                default:
                        #BUSCO FECHAS REVISION Y GUARDO EN SQL
                        $fecha_revision         = $this->input->post('fecha_revision');
                        $hora_revision          = $this->input->post('hora_revision');
                        $fecha_proxima_revision = $this->input->post('fecha_proxima_revision');
                        
                        $fechas_ficha           = getFechasSQLFicha($fecha_revision, $fecha_proxima_revision, $hora_revision);
            
                        #ACCIONES MEDICAS
                        if(isset($_POST['acciones_medicas'])){
                            $accion_medica = $this->get_atributos('acciones_medicas',true, $this->input->post('acciones_medicas'));                
                            $json['accion_medica']  = array('id'=>$accion_medica->id, 'nombre'=>$accion_medica->nombre);
                        }                        
                        
                        #OVARIOS            
                        if(isset($_POST['ovario_izquierdo'])){
                            $ovario = $this->get_atributos('ovarios',true,$this->input->post('ovario_izquierdo'));
                            $json['ovarios']['ovario_izquierdo']  = array('id'=>$ovario->id, 'nombre'=>$ovario->nombre);
                        }
                        
                        if(isset($_POST['ovario_derecho'])){
                            $ovario = $this->get_atributos('ovarios',true,$this->input->post('ovario_derecho'));
                            $json['ovarios']['ovario_derecho']  = array('id'=>$ovario->id, 'nombre'=>$ovario->nombre);
                        }
                        
                        #CERVIX
                        if(isset($_POST['cervix'])){
                            $cervix = $this->get_atributos('cervix',true,$this->input->post('cervix'));
                            $json['cervix'] = array('id'=>$cervix->id, 'nombre'=>$cervix->nombre);
                        }
                        
                        #UTERO
                        if(isset($_POST['utero'])){
                            $utero = $this->get_atributos('utero',true,$this->input->post('utero'));
                            $json['utero'] = array('id'=>$utero->id, 'nombre'=>$utero->nombre);
                        }
                        
                        #DROGA
                        if(isset($_POST['droga'])){
                            $droga = $this->get_atributos('drogas',true,$this->input->post('droga'));
                            $json['droga'] = array('id'=>$droga->id, 'nombre'=>$droga->nombre);
                        }
                        
                        #INSEMINACION // FLUSHING
                        switch($accion_medica->id){
                                case 2:
                                    $tipoSemen            = $this->get_atributos('semen',true, $this->input->post('tipoSemen'));                        
                                    $ovarioInseminado     = ($this->input->post('ovarioInseminado')=='oi') ? 'Ovario Izquierdo' : 'Ovario Derecho';
                                    $padrillo             = $this->_getPadrilloDador($this->input->post('padrilloInseminacion'));                         
                                    $json['inseminacion'] = array('tipoSemen'=>$tipoSemen->nombre,'padrillo'=>$padrillo->nombre,'ovario_inseminado'=>$ovarioInseminado);
                                    $observaciones_extras = $ovarioInseminado.' - '.$tipoSemen->nombre.' - '.$padrillo->nombre.'('.$padrillo->id.')';
                                    break;
                                
                                case 3:
                                    break;
                            } 
                        
                        $json['fechas'] = array('revision'=>$fechas_ficha['fecha_revision'],'proxima_revision'=>$fechas_ficha['fecha_proxima_revision']);
                    break;
            }
            
            
            
            #OBSERVACIONES
            if(isset($_POST['observaciones']) && !empty($_POST['observaciones'])){                
                $json['observaciones']  = (!empty($observaciones_extras)) ? $observaciones_extras.'<br/>'.$this->input->post('observaciones',true) : $this->input->post('observaciones',true);
            } elseif(!empty($observaciones_extras)) {
                $json['observaciones']  = $observaciones_extras;
            }
      
            $json = json_encode($json);
            
            $values = array ('caballo_id'               => $caballo_id,
                             'temporada_id'             => $temporada->id,
                             'accion_medica_id'         => !empty($accion_medica->id) ? $accion_medica->id : 0,
                             'json'                     => $json,
                             'fecha_revision'           => $fechas_ficha['fecha_revision'],
                             'fecha_proxima_revision'   => !empty($fechas_ficha['fecha_proxima_revision']) ? $fechas_ficha['fecha_proxima_revision'] : $this->today,
                             'activo'                   => 1
                             
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
                $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>lang_url('fichas/detalle/c/'.$this->params['c'].'/id/'.$this->params['id']));
            }
             
         }
         
         return $data;
         
         
    }
    
    public function setOpcionesMedicasExtras(){
        $success      = 1;
        $responseType = 'function';
        $function     = 'appendAccionesMedicasExtras';
        $opcion       = $this->params['op'];        
        
        $html = '';        
        switch($opcion){
            case 2:
                $ficha_data = array('padrillos'     => $this->_getPadrillosAsignados(),
                                    'semenOpciones' => $this->get_atributos('semen'),
                                   );                
                $html = $this->view('fichas/accionesMedicasExtras/inseminacion',$ficha_data);
                break;
                
            case 3:
                
                $ficha_data = array('receptorasFlushing' => $this->_receptorasFlushing(),
                                    'calidadTransferenciaOpciones' => $this->get_atributos('calidad_transferencias'),
                                    );
                $html = $this->view('fichas/accionesMedicasExtras/flushing',$ficha_data);
                break;
            
        }
        
        $data = array('success' => $success, 'responseType'=>$responseType, 'html'=>$html, 'value'=>$function);
        
        return $data;
    }
    
    private function _receptorasFlushing(){                
        
        $this->db->select('c.nombre caballo_nombre, c.id',false);        
        $this->db->from('caballos c');        
        $this->db->where('c.categoria_id',3);        
        $query = $this->db->get();
        
        //CONFIG
        $html  = "<input type='checkbox' class='j-item-chk' name='item-{%id%}'>";
        $extra[] = array("html" => $html, "pos" => 0);
        $datagrid["columns"][] = array("title"=>"<i class='icon-h-sign'></i>", "field"=>"", "width"=>"10");
        $datagrid["columns"][] = array("title" => "Id", "field" => "id");
        $datagrid["columns"][] = array("title" => "Nombre", "field" => "caballo_nombre");
        
        $datagrid["rows"]      = $this->datagrid->query_to_rows($query->result(), $datagrid["columns"], $extra);
        
        
        $dg = array("datagrid"   => $datagrid,
                    "grid_title" => "Receptoras para Flushing");
        $grid = $this->datagrid->make($dg);
               
        return $grid;
        
    }
    private function _getPadrillosAsignados(){        
                
        $query = $this->db->select('json')
                          ->get_where('caballos',array('sistema_id'=>$this->sistema_id,'categoria_id'=>2, 'activo'=>1, 'id'=>$this->caballo_id))
                          ->row();
        
        $json = json_decode($query->json);        
        
        return $json->padrillo_asignado; 
    }
    
    
    private function _getPadrilloDador($id){
        return $this->db->get_where('caballos',array('sistema_id'=>get_session('sistema_id',false),'categoria_id'=>1, 'activo'=>1, 'id'=>$id))->row();
    }
    
    
    public function chk_deletea(){
       return $this->check_deletea();
    }
    
    public function deletea(){
        if(isset($this->params["id"]) || empty($this->params["id"])) {
          //  $id = $this->params["id"];
            $values = array('activo'=>-1);
            $this->db->where('id', $this->ficha_id);
	        $query = $this->db->update($this->table, $values);
            $this->session->set_flashdata('insert_success', 'Registro Eliminado Exitosamente');
            
            if($query){
                $success = true;
                $responseType = 'redirect';                
                $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>lang_url('fichas/detalle/c/'.$this->categoria_id.'/id/'.$this->caballo_id));
            }
        }
        return $data;
    }
    
    private function _getCabecerasFicha(){
        $query = $this->db->select('*')
                    ->from('caballos')
                    ->where('id',$this->caballo_id)
                    ->where('activo',1)
                    ->get()
                    ->row();
                    
        return $query;
    }
    
    public function set_iu($id= NULL){
        /*
        if(!empty($id)){
            $row = $this->db->get_where($this->table,array('id'=>$id))->row();
        }
        $data = $row;        
        $panel = $this->view("panels/".$this->atributo, array('row'=>$row));
        return $panel;
        */
    }
}