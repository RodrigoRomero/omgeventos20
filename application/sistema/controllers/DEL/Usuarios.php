<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends RR_Controller {
    
    public function Usuarios(){
        parent::__construct();
        $this->load->model("usuarios_mod","Usuario");
        $this->widget_view = array('tables'=>array('js'=>array('jquery.dataTables.min')),
                                   'validate'=>array('js'=>array('jquery.validate','messages_es'))
                                   );
        
       //$this->output->enable_profiler(TRUE);
    }

	public function index(){}
    
    public function listado(){        
        $this->breadcrumb->addCrumb('Usuarios','');
        $this->breadcrumb->addCrumb('Listado','','current');        
        $module = $this->Usuario->getListado();
        $this->_show($module);
    }
    
    public function action(){  
        if(checkParam($this->params['iu'])){
            $this->breadcrumb->addCrumb('Usuarios',lang_url('usuario/listado'),'');
            if(!empty($this->params['id'])) {
                $this->breadcrumb->addCrumb('Editar','','current');    
            } else {
                $this->breadcrumb->addCrumb('Nuevo','','current');
            }
            
        } else {
            show_error('Ups la página que buscas no existe',301,'Ups');
        }
        $module = $this->Usuario->set_iu();
        $this->_show($module);     
    }
    
    public function do_iu(){
        $return = $this->Usuario->do_iu();
        echo json_encode($return);
    }
  
    private function _show($module){        
        echo $this->show_main($module);
    }
}