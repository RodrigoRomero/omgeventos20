<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Casos_de_exito extends RR_Controller {
    
    public function Casos_de_exito(){
        parent::__construct();
        $this->load->model('porfolio_mod','Casos');
        $this->load->model('main_mod','Main');
        //$this->output->enable_profiler(TRUE);
    }

	public function index(){
	   redirect(lang_url());
       die;
	}
    
    public function listado($id){
        $categoria = $this->Main->get_one($id);
        $json_categoria = json_decode($categoria['json']);
        $this->setMeta('title', $json_categoria->lang->{$this->Clang}->nombre);
        $this->setMeta('description', $json_categoria->lang->{$this->Clang}->descripcion);
        $this->setMeta('keywords', $json_categoria->lang->{$this->Clang}->descripcion);
        
        $data = array('listado'   => $this->Casos->getItems($id),
                      'categoria' => $json_categoria);
        $module = $this->view('casos_de_exito/listado', $data);
        $this->_show($module);
    }
    
    public function detalle($id=null) {
        $this->widget_view = array('supersized' => array('js'=>array('supersized.3.2.7.min','supersized.shutter.min'),'css'=>array('supersized', 'supersized.shutter')),                                   
                                   );
        
        $data = array('detalle'=>$this->Casos->getDetails($id));
        $module = $this->view('casos_de_exito/detalle',$data);
        $this->_show($module);
    }
    
    private function _show($module){        
        echo $this->show_main($module);
    }
}