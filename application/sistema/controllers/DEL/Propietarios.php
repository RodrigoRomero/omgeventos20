<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Propietarios extends RR_Controller {
    
    public function Propietarios(){
        parent::__construct();
        $this->load->model("propietario_mod","Propietario");
        $this->widget_view = array('tables'=>array('js'=>array('jquery.dataTables.min')),
                                   'validate'=>array('js'=>array('jquery.validate','messages_es'))
                                   );
        
       //$this->output->enable_profiler(TRUE);
    }

	public function index(){}
    
    public function listado(){        
        $this->breadcrumb->addCrumb('Propietarios','');
        $this->breadcrumb->addCrumb('Listado','','current');        
        $module = $this->Propietario->getListado();
        $this->_show($module);
    }
    
    public function action(){  
        if(checkParam($this->params['iu'])){
            $this->breadcrumb->addCrumb('Propietarios',lang_url('propietarios/listado'),'');
            if(!empty($this->params['id'])) {
                $this->breadcrumb->addCrumb('Editar','','current');    
            } else {
                $this->breadcrumb->addCrumb('Nuevo','','current');
            }
            
        } else {
            show_error('Ups la página que buscas no existe',301,'Ups');
        }
        $module = $this->Propietario->set_iu();
        $this->_show($module);     
    }
    
    public function do_iu(){
        $return = $this->Propietario->do_iu();
        echo json_encode($return);
    }
    
    public function chk_deletea(){
        $return = $this->Propietario->chk_deletea();
        echo json_encode($return);
    }
    
    public function deletea(){
        $return = $this->Propietario->deletea();
        echo json_encode($return);
    }
    
  
    private function _show($module){        
        echo $this->show_main($module);
    }
}