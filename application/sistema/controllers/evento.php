<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');class Evento extends RR_Controller {    public function Evento(){        parent::__construct();        $this->load->model('eventos_mod','Evento');        $this->load->library('cart');           }    public function index(){        redirect(lang_url());        die;    }    public function sendInvitacion(){        $this->Evento->sendInvitacion();    }    public function oradores(){         $data = array('oradores' => $this->Evento->getOradores());                $module = $this->view('evento/oradores', $data);        $this->_show($module);    }        public function lugar(){                $data = array('evento' => $this->Evento->getEvento());        $module = $this->view('evento/lugar',$data);        $this->_show($module);    }        public function registrese(){        $data = array('evento' => $this->Evento->getEvento());        $module = $this->view('evento/registrese', $data);        $this->_show($module);    }    public function reminder(){        $this->Evento->_doReminder();    }    public function subscribe(){        $return = $this->Evento->do_subscribe();        echo json_encode($return);    }        public function test(){        $this->Evento->test();    }        public function find(){           $this->Evento->buscarPagos();        die;    }        public function do_registro(){           $data = $this->Evento->do_registro();        echo json_encode($data);    }        public function sendPayments(){        die;        $this->Evento->sendPayments();    }        public function emailDomain_check($str){        $return = $this->Evento->emailDomain_check($str);        return $return;	}            private function _show($module){                echo $this->show_main($module);    }}