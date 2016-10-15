<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Residencias extends RR_Controller {
    
    public function Residencias(){
        parent::__construct();
        $this->load->model("residencia_mod","Residencia");
        $this->widget_view = array('tables'=>array('js'=>array('jquery.dataTables.min')),
                                   'validate'=>array('js'=>array('jquery.validate','messages_es'))
                                   );
        
       //$this->output->enable_profiler(TRUE);
    }

	public function index(){}
    
    public function listado(){        
        $this->breadcrumb->addCrumb('Residencias','');
        $this->breadcrumb->addCrumb('Listado','','current');        
        $module = $this->Residencia->getListado();
        $this->_show($module);
    }
    
    public function action(){  
        if(checkParam($this->params['iu'])){
            $this->breadcrumb->addCrumb('Residencias',lang_url('residencias/listado'),'');
            if(!empty($id)) {
                $this->breadcrumb->addCrumb('Editar','','current');    
            } else {
                $this->breadcrumb->addCrumb('Nuevo','','current');
            }
            
        } else {
            show_error('Ups la página que buscas no existe',301,'Ups');
        }
        $module = $this->Residencia->set_iu();
        $this->_show($module);     
    }
    
    public function do_iu(){
        $return = $this->Residencia->do_iu();
        echo json_encode($return);
    }
    
    public function chk_deletea(){
        $return = $this->Residencia->chk_deletea();
        echo json_encode($return);
    }
    
    public function deletea(){
        $return = $this->Residencia->deletea();
        echo json_encode($return);
    }
  
    private function _show($module){        
        echo $this->show_main($module);
    }
}