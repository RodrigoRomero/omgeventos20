<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Galeria extends RR_Controller {
    
    public function Galeria(){
        parent::__construct();
        $this->load->model('porfolio_mod','Casos');
        $this->widget_view = array('shadowbox' => array('js'=>array('shadowbox'),'css'=>array('shadowbox')),                                   
                                   );
        
        //$this->output->enable_profiler(TRUE);
    }

	public function index(){
	   redirect(lang_url());
       die;
	}
    
    public function fotos(){        
        $data = array('galeria'=>$this->Casos->getItemsGaleria());
        $module = $this->view('galeria/fotos', $data);
        $this->_show($module);
    }
  
    public function videos(){        
        $module = $this->view('galeria/videos', $data);
        $this->_show($module);
    }
    
    public function detalle(){        
        $module = $this->view('galeria/detalle_video', $data);
        $this->_show($module);
    }
    
    private function _show($module){        
        echo $this->show_main($module);
    }
}