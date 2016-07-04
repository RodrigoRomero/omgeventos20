<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Institucional extends RR_Controller {
    
    public function Institucional(){
        parent::__construct();
        $this->load->model('Institucional_mod','Institucional');
        $this->widget_view = array('camera' => array('js'=>array('camera.min'),'css'=>array('camera')),
                                   'validate'=>array('js'=>array('jquery.validate','messages_es'))
                                   );
        
        //$this->output->enable_profiler(TRUE);
    }

	public function index(){
       die;
	}
    
    public function me(){
        $data   = array('data'      => $this->Institucional->getText('me'),
                        'total_img' => $this->Institucional->getNumberImages('me','institucional'),
                        );
        $module = $this->view('institucional/me', $data);
        $this->_show($module);
    }
    
    public function el_estudio(){
        $data   = array('data'      => $this->Institucional->getText('el-estudio'),
                        'total_img' => $this->Institucional->getNumberImages('el-estudio','institucional'),
                       );
        $module = $this->view('institucional/el_estudio',$data);
        $this->_show($module);
    }
    
    public function contacto(){
        $module = $this->view('institucional/contacto');
        $this->_show($module);
    }
    
    public function do_contacto(){
        $data = $this->Institucional->do_contacto();
        echo json_encode($data);
    }
    
    private function _show($module){        
        echo $this->show_main($module);
    }
}