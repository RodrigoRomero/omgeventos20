<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');class Account extends RR_Controller {    public function Account(){        parent::__construct();        $this->load->model('account_mod','Accounts');        $this->load->model('cart_mod','Cart');    }    public function index(){        redirect(lang_url());        die;    }    public function my_store(){        $this->layout = 'multi_page';                $data = array();        $module = $this->view('accounts/index', $data);;        $this->_show($module);    }    public function create(){                foreach ($this->cart->contents() as $key => $row) {            if(!preg_match('/^code/', $row['id'], $matches)){                $aux = $row;            }                  }                $this->widget_view = array('masked' => array('js'=>array('maskedInput'))                                   );        $this->css_view = array('bootstrap.min2','site/main');        if($this->cart->total_items()==0){            redirect(lang_url());        }                $data = array('user_data' => ($this->session->userdata('cart_salt')) ? $this->Accounts->getAccountBySalt() : '',                      'action'    => ($this->session->userdata('cart_salt')) ? 'do-update' : 'do-create',                      'nominar'   => $aux['options']['nominar']                );                $this->layout = 'multi_page';        $module = $this->view('accounts/create', $data);                $this->_show($module);            }    public function do_create(){        $data = $this->Accounts->doCreateAccount();        echo json_encode($data);    }        public function do_update(){        $data = $this->Accounts->doUpdateAccount();        echo json_encode($data);    }    private function _show($module){                echo $this->show_main($module);    }}