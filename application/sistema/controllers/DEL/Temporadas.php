<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Temporadas extends RR_Controller {
    
    public function Temporadas(){
        parent::__construct();
        $this->load->model("temporada_mod","Temporada");
        $this->widget_view = array('tables'=>array('js'=>array('jquery.dataTables.min')),
                                   'validate'=>array('js'=>array('jquery.validate','messages_es'))
                                   );
        
       //$this->output->enable_profiler(TRUE);
    }

	public function index(){}
    
    public function listado(){        
        $this->breadcrumb->addCrumb('Temporadas','');
        $this->breadcrumb->addCrumb('Listado','','current');        
        $module = $this->Temporada->getListado();
        $this->_show($module);
    }
    
    public function action(){
        if(checkParam($this->params['iu'])){
            $this->breadcrumb->addCrumb('Temporadas',lang_url('temporadas/listado'),'');
            if(!empty($this->params['id'])) {
                $this->breadcrumb->addCrumb('Editar','','current');    
            } else {
                $this->breadcrumb->addCrumb('Nuevo','','current');
            }
            
        } else {
            show_error('Ups la página que buscas no existe',301,'Ups');
        }
        
        $module = $this->Temporada->set_iu();
        $this->_show($module);     
    }
    
    public function do_iu(){
        $return = $this->Temporada->do_iu();
        echo json_encode($return);
    }
  
    private function _show($module){        
        echo $this->show_main($module);
    }
}