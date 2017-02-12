<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends RR_Controller {
    public function Home(){
        parent::__construct();
        $this->load->model('main_mod','Main');
    }
	public function index(){
	   $this->widget_view = array('fitvids' => array('js'=>array('jquery.fitvids.min')),
                                  'superslides' => array('js'=>array('jquery.superslides.min'),'css'=>array('superslides')),                                   
                                  'magnific-popup' => array('js'=>array('jquery.magnific-popup.min'),'css'=>array('magnific-popup')),
                                  'holder' => array('js'=>array('holder')),
                                  'wizard' => array('js'=>array('wizard'),'css'=>array('fuelux','fuelux-responsive')),
                                   );
	   $data = array(
                     'evento' => $this->Main->getEvento(),
                     );
       $data_agenda   = array('agenda' => $this->Main->getAgenda());
       $data_sponsors = array('sponsor' => $this->Main->getSponsors());
       $data_oradores = array('oradores' => $this->Main->getOradores());
       $data_planes  = array('planes' => $this->Main->getPlanes());
	   $module = array ('home'      => $this->view('home/index', $data),
                        'agenda'    => $this->view('evento/agenda', $data_agenda),
                        'registro'  => $this->view('evento/registrese', $data_planes),
                        'lugar'     => $this->view('evento/lugar', $data),                        
                        'galeria'   => $this->view('evento/galeria'),
                        'bisblick' => $this->view('evento/bisblick'),
                        'oradores'  => $this->view('evento/oradores', $data_oradores),
                        'sponsor'   => $this->view('evento/sponsor', $data_sponsors),
       );      
       $this->_show($module);
	}
    private function _show($module){        
        echo $this->show_main($module);
    }
}