<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorias extends RR_Controller {
    
    public function Categorias(){
        parent::__construct();
        $this->load->model("categoria_mod","Categoria");
        $this->widget_view = array('tables'=>array('js'=>array('jquery.dataTables.min')),
                                   'validate'=>array('js'=>array('jquery.validate','messages_es'))
                                   );
        
      //  $this->output->enable_profiler(TRUE);
    }

	public function index(){}
    
    public function listado(){        
        $this->breadcrumb->addCrumb('Categorías','');
        $this->breadcrumb->addCrumb('Listado','','current');        
        $module = $this->Categoria->getListado();
        $this->_show($module);
    }
    
    public function iu($id=null){  
        if(checkParam($id)){
            $this->breadcrumb->addCrumb('Categorías',lang_url('categorias/listado'),'');
            if(!empty($id)) {
                $this->breadcrumb->addCrumb('Editar','','current');    
            } else {
                $this->breadcrumb->addCrumb('Nuevo','','current');
            }
            
        } else {
            show_error('Ups la página que buscas no existe',301,'Ups');
        }
        $module = $this->Categoria->set_iu($id);
        $this->_show($module);     
    }
    
    public function do_iu(){
        $return = $this->Categoria->do_iu();
        echo json_encode($return);
    }
  
    private function _show($module){        
        echo $this->show_main($module);
    }
}