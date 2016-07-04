<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cupons extends RR_Controller {
    
    public function Cupons(){
        parent::__construct();
        $this->load->model('cupons_mod','Cupons');
        //$this->output->enable_profiler(TRUE);
    }

    public function index(){
        redirect(lang_url());
        die;
    }
    
    public function validate_cupon($c=""){
        $data = $this->Cupons->validate_cupon($c);
        echo json_encode($data);
    }

    
    
    private function _show($module){        
        echo $this->show_main($module);
    }
}