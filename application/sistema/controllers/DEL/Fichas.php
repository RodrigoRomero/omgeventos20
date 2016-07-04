<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fichas extends RR_Controller {
    
    public function Fichas(){
        parent::__construct();
        $this->load->model("ficha_mod","Ficha");
        $this->widget_view = array('tables'=>array('js'=>array('jquery.dataTables.min')),
                                   'validate'=>array('js'=>array('jquery.validate','messages_es')),
                                   'datepicker'=>array('css'=>array('datepicker'), 'js'=>array('bootstrap-datepicker','bootstrap-datepicker.es')),
                                   'timepicker'=>array('css'=>array('bootstrap-timepicker'), 'js'=>array('bootstrap-timepicker')),
                                   );
        
      //  $this->output->enable_profiler(TRUE);
    }

	public function index(){}
    
    public function detalle(){
        $categoria_id = $this->params['c'];
        switch($categoria_id){
            case 1:
                $this->module_title = 'Ficha Semen';
                break;
            
            case 2:
            case 3:
            default:
                $this->module_title = 'Ficha Ginecológica';
                break;
        }
        $this->breadcrumb->addCrumb($this->module_title,'');
        $this->breadcrumb->addCrumb('Detalle','','current');
        $module = $this->Ficha->getDetalle();
        $this->_show($module);
    } 
    
    public function do_iu(){
        $return = $this->Ficha->do_iu();
        echo json_encode($return);
    }   
    
    public function chk_deletea(){
        $return = $this->Ficha->chk_deletea();
        echo json_encode($return);
    }
    
    public function deletea(){
        $return = $this->Ficha->deletea();
        echo json_encode($return);
    }
    public function setOpcionesMedicas(){
        $return = $this->Ficha->setOpcionesMedicasExtras();
        echo json_encode($return);
    }
  
    private function _show($module){        
        echo $this->show_main($module);
    }
}