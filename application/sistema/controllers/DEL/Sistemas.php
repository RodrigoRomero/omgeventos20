<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sistemas extends RR_Controller {
    
    public function Sistemas(){
        parent::__construct();
        $this->load->model("sistema_mod","Sistema");
        $this->widget_view = array('tables'=>array('js'=>array('jquery.dataTables.min')),
                                   'validate'=>array('js'=>array('jquery.validate','messages_es'))
                                   );
        
       //$this->output->enable_profiler(TRUE);
    }

	public function index(){}
    
    public function listado(){        
        $this->breadcrumb->addCrumb('Sistemas','');
        $this->breadcrumb->addCrumb('Listado','','current');        
        $module = $this->Sistema->getListado();
        $this->_show($module);
    }
    
    public function iu($id=null){  
        if(checkParam($id)){
            $this->breadcrumb->addCrumb('Sistemas',lang_url('sistema/listado'),'');
            if(!empty($id)) {
                $this->breadcrumb->addCrumb('Editar','','current');    
            } else {
                $this->breadcrumb->addCrumb('Nuevo','','current');
            }
            
        } else {
            show_error('Ups la página que buscas no existe',301,'Ups');
        }
        $module = $this->Sistema->set_iu($id);
        $this->_show($module);     
    }
    
    public function do_iu(){
        $return = $this->Sistema->do_iu();
        echo json_encode($return);
    }
  
    private function _show($module){        
        echo $this->show_main($module);
    }
}