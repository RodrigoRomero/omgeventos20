<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends RR_Controller {
    
    public function Dashboard(){
        parent::__construct();
        $this->load->model("caballo_mod", "Caballo");
        $this->load->model("dashboard_mod", "Dashboard");
        $this->load->model("stats_mod", "Stats");
        $this->widget_view = array('tables' => array('js'=>array('jquery.dataTables.min')),
                                   'canvas' => array('js'=>array('excanvas.min')),
                                   'charts' => array('js'=>array('jquery.flot.min','jquery.flot.pie.min','jquery.flot.resize.min','unicorn.charts')),
                                   'fullCalendar' => array('js'=>array('fullcalendar.min'),'css'=>array('fullcalendar'))
                                   );
        //$this->output->enable_profiler(TRUE);
    }

	public function index(){
	   $temporada_vigente = get_session('temporada',false);
	   $this->module_title = 'Inicio - Temporada: '.$temporada_vigente->nombre;
       $data = array('padrillos'  => $this->Caballo->getListadoDashboard(1, 10, 'Padrillos'),
                     'donantes'   => $this->Caballo->getListadoDashboard(2, 10, 'Donantes'),   
                     'receptoras' => $this->Caballo->getListadoDashboard(3, 10, 'Receptoras')
                     );
       
       $module =	$this->view('dashboard/index', $data);
       $this->_show($module);
	}
    
    public function getCalendar(){
        $calendar = $this->Dashboard->getCalendar();        
        echo json_encode($calendar);
    }
  
    private function _show($module){        
        echo $this->show_main($module);
    }
}