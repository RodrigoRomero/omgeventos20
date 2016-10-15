<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Donaciones extends RR_Controller {
    
    public function Donaciones(){
        parent::__construct();
        $this->load->model("donaciones_mod", "Donacion");
        $this->widget_view = array('validate'=>array('js'=>array('jquery.validate','messages_es')));
    }

	public function index(){
	   redirect(lang_url());
	}
    
    public function colabora_con_nosotros($Md5=null){        
        if(!is_null($Md5)) {            
            $this->layout = 'donaciones';
            $data   = array('user'=> $this->Donacion->getUser($Md5));
            $module = $this->view('donaciones/pre_donacion', $data);
            $this->_show($module);
        } else {
            redirect(lang_url());
        }
        
    }
    
    public function gracias(){
        $this->layout = 'donaciones';
        $module = $this->view('donaciones/gracias');
        $this->_show($module);
    }
    
    public function checkout(){
        $return = $this->Donacion->getPreferences();
        echo json_encode($return);
    }
    
    public function op($pag){
        die('Close');
        $this->Donacion->UpdStatus($pag);
    }
    
    
    
    public function close(){
        $return = $this->Donacion->checkOut();
        echo json_encode($return);
    }
    
    
    private function _show($module){        
        echo $this->show_main($module);
    }
}
