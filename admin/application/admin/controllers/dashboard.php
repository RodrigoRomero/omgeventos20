<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends RR_Controller {
    
    public function Dashboard(){
        parent::__construct();
        $this->load->model("dashboard_mod", "Dashboard");       
        $this->widget_view = array('charts' => array('js'=>array('Chart.min'))
                                   );
       
        //$this->output->enable_profiler(TRUE);
    }

	public function index(){
	   $data = array ('smallStats'                          => $this->Dashboard->getSmallStats(),
                      'ultimos_acreditados'                 => $this->Dashboard->lastAcreditados(),
                      'total_registros'                     => $this->Dashboard->getTotal(),
                      'total_registros_activos'             => $this->Dashboard->getTotalActive(),
                      'total_acreditados_lunch'             => $this->Dashboard->getTotalLunch(),
                      'total_by_tipo'                       => $this->Dashboard->getTotalByTipo(),    
                      'total_by_medio_pago'                 => $this->Dashboard->getTotalByMedioPago(),
                      'total_facturacion'                   => $this->Dashboard->getFacturacionTotalStatus(),
                      'total_facturacion_pendiente_medio'   => $this->Dashboard->getFacturacionPendienteByMedio(),
                      'total_by_medio_pago_iae'             => $this->Dashboard->getTotalByMedioPagoIAE(),
                      'total_by_ticket'                     => $this->Dashboard->getTotalByTicket(),
                      'total_checkins'                      => $this->Dashboard->getTotalActiveCheckins(),
                      'total_checkins_by_tipo'              => $this->Dashboard->getTotalCheckInByTipo(),
                      'cupons_stats'                        => $this->Dashboard->cuponsStats()
                    );
       $module =	$this->view('dashboard/index', $data);
       $this->_show($module);
	}
    
    public function getInscriptos(){        
        $data = $this->Dashboard->getInscriptosChart();
        echo json_encode($data);
    }
    public function getInscriptosPlanesPie(){
        $data = $this->Dashboard->getInscriptosPlanesPie();
        echo json_encode($data);
    }
    
    
    public function getBarsByTicket(){
        $data = $this->Dashboard->getBarsByTicket();
        echo json_encode($data);
    }
    
    public function getInscriptosPagosPie(){
        $data = $this->Dashboard->getInscriptosPagosPie();    
        echo json_encode($data);
    }
    private function _show($module){        
        echo $this->show_main($module);
    }
}