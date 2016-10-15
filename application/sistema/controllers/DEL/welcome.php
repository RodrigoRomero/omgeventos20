<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	 public function Welcome(){
        parent::__construct();
        $this->output->enable_profiler(TRUE);
        $this->load->model("sistema_mod", "sistema");        
    }
    
	public function index(){
		$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */