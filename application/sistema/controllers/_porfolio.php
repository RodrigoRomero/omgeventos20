<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Porfolio extends RR_Controller {
    
    public function Porfolio(){
        parent::__construct();
        $this->load->model('Porfolio_mod','Porfolio');
        $this->widget_view = array('camera' => array('js'=>array('camera.min'),'css'=>array('camera')),
                                   'isotope' => array('js'=>array('jquery.isotope.min'),'css'=>array('isotope'))
                                   );
        
        //$this->output->enable_profiler(TRUE);
    }

	public function index(){
       die;
	}
    
    public function listado(){
        $categorias = $this->Porfolio->getCategoriesMenu();
        
        $data = array('filter' => $this->view('porfolio/filters', array('filter'=>$categorias)),
                      'items'  => $this->Porfolio->getItems()  
                     );
        
        $module = $this->view('porfolio/listado', $data);
        $this->_show($module);
    }
  
    public function detalle($id){
        $info = $this->Porfolio->getDetails($id);
        $data = array('full_details'    => $info['data'],
                      'total_img'       => $info['total_images'],
                     );
        $module = $this->view('porfolio/detalle', $data);
        $this->_show($module);
    }
    
    private function _show($module){        
        echo $this->show_main($module);
    }
}