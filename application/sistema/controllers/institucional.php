<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Institucional extends RR_Controller {
    
    public function Institucional(){
        parent::__construct();        
        $this->load->model('Institucional_mod','Institucional');
        //$this->output->enable_profiler(TRUE);
    }

	public function index(){
	   redirect(lang_url());
       die;
	}
    
    public function contacto(){        
        $module = $this->view('institucional/contacto');
        $this->_show($module);
    }
    
    public function hseq(){
        $module = $this->view('institucional/hseq');
        $this->_show($module);
    }
    
    public function soluciones(){
        $module = $this->view('institucional/soluciones');
        $this->_show($module);
    }
    
    public function empresa(){
        $module = $this->view('institucional/empresa');
        $this->_show($module);
    }
    
    public function por_que_shipway(){
        $module = $this->view('institucional/porque');
        $this->_show($module);
    }
    
    public function do_suscription(){
        $data = $this->Institucional->do_suscription();
        echo json_encode($data);
    }
    
    public function do_contacto(){
        $data = $this->Institucional->do_contacto();
        echo json_encode($data);
    }
    
    private function _show($module){        
        echo $this->show_main($module);
    }
}