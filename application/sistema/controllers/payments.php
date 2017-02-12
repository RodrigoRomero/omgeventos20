<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');class payments extends RR_Controller {    public function payments(){        parent::__construct();                $this->load->model('payments_mod','MP');        $this->load->model("eventos_mod", "Evento");        //$this->output->enable_profiler(TRUE);    }    	public function index(){	   redirect(lang_url());       die;	}    public function lateCheckOut($salt){        $this->layout = 'multi_page';        $user = $this->db->select('a.*, p.status payment_status', false)                         ->where('a.status =',1)                         ->where('a.salt =',$salt)                         ->join('pagos p', 'p.acreditado_id = a.id','LEFT')                         ->from('acreditados a')                         ->get();        $values = $user->row();               switch($values->payment_status){             default:                $this->load->model('main_mod','Main');                $data_planes  = array('planes' => $this->Main->getPlanes(),                                      'user_info'=>$values);                $module = $this->view('pagos/latecheckout',$data_planes);                break;            case 'approved':                $module = $this->view('pagos/payment_status', array('user_info'=>$values, 'message'=>'Su Pago ya se encuentra acreditado'));                                break;            case 'pending':                $module = $this->view('pagos/payment_status', array('user_info'=>$values, 'message'=>'Su Pago se encuentra en proceso de revisión'));                break;        }                       }    public function CheckOut($salt){        $return = $this->MP->lateCheckOut($salt);        /*        $user = $this->db->get_where('acreditados',array('salt'=>$salt))->row();        $values = array('id'      => $user->id,                        'monto'   => $user->monto,                        'barcode' => $user->barcode);        //print_r($values);        $return = $this->MP->getPreferences($values);        */        echo json_encode($return);    }     public function almuerzo($salt){        $return = $this->MP->lunchCheckOut($salt);        echo json_encode($return);    }    public function close(){        $return = $this->MP->checkOut();        echo json_encode($return);    }    public function lunch_close(){        $return = $this->MP->lunchClose();        echo json_encode($return);    }    private function _show($module){                echo $this->show_main($module);    }}