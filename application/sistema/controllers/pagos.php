<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pagos extends RR_Controller {
    
    public function Pagos(){
        parent::__construct();
        $this->load->model("cart_mod", "Cart");
        $this->load->model("pagos_mod", "Pago");
        $this->load->model("email_mod", "Email");
        $this->load->model("eventos_mod", "Evento");
        $this->widget_view = array('validate'=>array('js'=>array('jquery.validate','messages_es')));
    }

	public function index(){
	   redirect(lang_url());
	}    
    
    public function checkout($md5){
       
        if(count($this->Cart->getCart())==0){
            $evento = $this->Evento->getEvento();
            $user = $this->db->get_where('acreditados',array('security'=>$md5))->row();
           
            $values = array('email'=>$user->email, 
                            'nombre'=>$user->nombre, 
                            'apellido'=>$user->apellido, 
                            'security'=>$user->security);
            
            $this->Cart->setArticle($values);
        } 
        
        $data = array ('cart_data' => $this->Cart->getCart(),
                       'security'  => get_session('security',false));
                       
        $module = $this->view('pagos/checkout', $data);
        $this->_show($module);
    }
    
    public function confirm($md5){
        $return = $this->Pago->getPreferences();
        echo json_encode($return);
    }
    
    public function close(){
        $return = $this->Pago->close();
        echo json_encode($return);
    }
 
    public function op(){        
        $this->Pago->UpdStatus();
    }
     
    private function _show($module){        
        echo $this->show_main($module);
    }
}
