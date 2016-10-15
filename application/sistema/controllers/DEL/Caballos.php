<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Caballos extends RR_Controller {
    
    public function Caballos(){
        parent::__construct();
        $this->load->model("caballo_mod", "Caballo");
        $this->js_view     = array('swfobject');
        $this->widget_view = array('tables'=>array('js'=>array('jquery.dataTables.min')),
                                   'validate'=>array('js'=>array('jquery.validate','messages_es')),
                                   'datepicker'=>array('css'=>array('datepicker'), 'js'=>array('bootstrap-datepicker','bootstrap-datepicker.es')),
                                   );
        
        $categoria_id = $this->params['c'];
        switch($categoria_id){
            case 1:
                $this->module_title = 'Padrillos';
                break;
            
            case 2:
                $this->module_title = 'Donantes';
                break;
            
            case 3:            
                $this->module_title = 'Receptoras';
                break;
        }
        
       //$this->output->enable_profiler(TRUE);
    }

	public function index(){}
    
    public function listado(){        
        $this->breadcrumb->addCrumb($this->module_title,'');
        $this->breadcrumb->addCrumb('Listado','','current');        
        $module = $this->Caballo->getListado();
        $this->_show($module);
    }
    
    public function action($id=null){
        if(checkParam($this->params['iu'])){
            $this->breadcrumb->addCrumb($this->module_title,lang_url('caballos/listado/c/'.$this->params['c']),'');
            if(!empty($this->params['id'])) {
                $this->breadcrumb->addCrumb('Editar','','current');    
            } else {
                $this->breadcrumb->addCrumb('Nuevo','','current');
            }
            
        } else {
            show_error('Ups la página que buscas no existe',301,'Ups');
        }
        $module = $this->Caballo->set_iu();
        $this->_show($module);     
    }
    
    public function do_iu(){
        $return = $this->Caballo->do_iu();
        echo json_encode($return);
    }
    
    public function asignar_padrillos(){
        $return = $this->Caballo->asignar_padrillos();
        echo json_encode($return);
    }
    
    public function do_asignarPadrillos(){
        $return = $this->Caballo->do_asignarPadrillos();
        echo json_encode($return);
    }
    
    public function chk_deletea(){
        $return = $this->Caballo->chk_deletea();
        echo json_encode($return);
    }
    
    public function deletea(){
        $return = $this->Caballo->deletea();
        echo json_encode($return);
    }
    
    private function _show($module){        
        echo $this->show_main($module);
    }
}