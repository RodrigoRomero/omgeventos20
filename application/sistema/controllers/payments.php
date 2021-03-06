<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class payments extends RR_Controller {
    public function payments(){
        parent::__construct();        
        $this->load->model('payments_mod','MP');
        $this->load->model("eventos_mod", "Evento");
        //$this->output->enable_profiler(TRUE);
    }
    
	public function index(){
	   redirect(lang_url());
       die;
	}
    public function lateCheckOut($salt){
        $this->layout = 'multi_page';
        $user = $this->db->select('o.*, p.status payment_status', false)
                         ->where('o.status =',1)
                         ->where('o.salt =',$salt)
                         ->join('pagos p', 'p.order_id = o.id','LEFT')
                         ->from('orders o')
                         ->get();
        $values = $user->row();       
        
        switch($values->payment_status){ 
            default:
                $module = $this->view('pagos/payment_status', array('user_info'=>$values, 'message'=>'Su Pago se encuentra en proceso de revisión'));
                
                break;
            case 'approved':
                $module = $this->view('pagos/payment_status', array('user_info'=>$values, 'message'=>'Su Pago ya se encuentra acreditado'));
                
                break;
            case 'pending':
                $this->load->model('main_mod','Main');

                $data_planes  = array('planes' => $this->Main->getPlanes(),
                                      'user_info'=> $values);
                $module = $this->view('pagos/latecheckout',$data_planes);
                
                break;
        }    
        
       $this->_show($module);
    }

    public function CheckOut($salt){
        $return = $this->MP->lateCheckOut($salt);
        /*
        $user = $this->db->get_where('acreditados',array('salt'=>$salt))->row();
        $values = array('id'      => $user->id,
                        'monto'   => $user->monto,
                        'barcode' => $user->barcode);
        //print_r($values);
        $return = $this->MP->getPreferences($values);
        */
        echo json_encode($return);
    }
     
    public function close(){
        $return = $this->MP->checkOut();
        echo json_encode($return);
    }
   
    private function _show($module){        
        echo $this->show_main($module);
    }
}