<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);

/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 *  TODO: LOG
 */
 

class dashboard_mod extends RR_Model {

	public function __construct() {	   
 		parent::__construct();        
    }
    
    public function lastAcreditados(){
        $this->db->select('a.id, a.nombre, a.apellido, a.email, p.status mp_status, a.status, a.medio_pago', false);   
        $this->db->where('a.status >=',0);        
        $this->db->join('pagos p', 'p.acreditado_id = a.id','LEFT');
        $this->db->from('acreditados a');
        $this->db->limit(10);
        $this->db->order_by('a.id','DESC');
        $query = $this->db->get();
        $result = $query->result();        
        $box_header = $this->view('layout/panels/box_header', array('title'=>'Últimos Acreditados', 'icon'=>'icon-user', 'box_icon'=>true));
        $box_content = '<ul class="unstyled">';
        foreach($result as $usuario){
            $status_pago = ($usuario->mp_status) ? $usuario->mp_status : $usuario->medio_pago;
            $box_content .= '<li>'.$usuario->nombre.' '.$usuario->apellido.' ('.$status_pago.')</li>';
        }
        $box_content .= '</ul>';
        
        $box = $this->view('layout/panels/box', array('box_header'=>$box_header,'box_content'=>$box_content));
        
        return $box;
    }
    
    //SELECT COUNT(id) total_by_date, DATE_FORMAT(fa, '%Y/%m/%d') fa FROM acreditados GROUP BY DATE_FORMAT(fa, '%Y/%m/%d')
    public function getSmallStats(){
       // $recaudado    = $this->getSmall('recaudado');
        $suscriptores = $this->getSmall('suscriptores');
        
        $smallStats = $recaudado.$suscriptores;
        return $smallStats;
    }
    
    public function getTotal(){
        $sql = "SELECT COUNT(id) total FROM acreditados WHERE status >= 0";
        $total = $this->db->query($sql)->row();
        return $total;
    }
    
    private function getSmall($tipo){
       /*
        switch($tipo){
            case 'recaudado':            
                $this->db->where_in('pago_status',array(1,2));
                $this->db->select_sum('transaction_amount','value');
                $query = $this->db->get('pagos')->row();
                $icon  = 'icon-money';
                $color = 'blue';
                $title = $tipo;
                $value = $query->value;  
                $this->db->flush_cache();          
            break;
            case 'suscriptores':            
                $this->db->where('number.status',1);
                $this->db->from('acreditados number');
                $value = $this->db->count_all()->row();  
                echo $value;              
                $this->db->flush_cache();
                $icon  = 'icon-user';
                $color = 'blue';
                $title = $tipo;
                lq();            
            break;
            
            
        }
        
        return $this->view('layout/panels/smallstats',array('value'=>$value, 'icon'=>$icon, 'color'=>$color, 'title'=>$title));
        */        
    }
    
    public function getInscriptosChart() {
        $sql = "SELECT COUNT(id) total_by_date, DATE_FORMAT(fa, '%d-%m-%Y') fa FROM acreditados WHERE status >= 0 GROUP BY DATE_FORMAT(fa, '%d-%m-%Y')";
        $inscriptos = $this->db->query($sql)->result();        
        $fechainicio = '2015-03-15';
        $fechafin    = '2015-06-18';
        $arrayFechas = $this->devuelveArrayFechasEntreOtrasDos($fechainicio,$fechafin);
        
        $stats = array();
       
        
        $totals = array();
        foreach($arrayFechas as $k_date => $fecha){
                $totals[$k_date] = 0;
            foreach($inscriptos as $totales){
                    if($totales->fa == $fecha){
                        $totals[$k_date] = (int)$totales->total_by_date;    
                    } else {
                        
                    }
            }
        }
        $stats['labels'] = $arrayFechas;
        $stats['values']  = $totals;
     
        $success      = true;
        $responseType = 'function';
        $function     = 'initChart';
        $messages     = $stats;
        $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
        
        return $data;
        
    }
   

     public function devuelveArrayFechasEntreOtrasDos($fechaInicio, $fechafin){
        $arrayFechas=array();
        $fechaMostrar = $fechaInicio;
        
            while(strtotime($fechaMostrar) <= strtotime($fechafin)) {                
                $fechaMostrar = date("d-m-Y", strtotime($fechaMostrar . " + 1 day"));
                $arrayFechas[]=$fechaMostrar;
            }
        
            return $arrayFechas;
    }
    
    public function getTotalByTipo(){
        $total_gral = $this->getTotal();        
        
        $sql = "SELECT COUNT(id) total FROM acreditados WHERE status >= 0 and tipo_usuario = 1";
        $total_iae = $this->db->query($sql)->row();
        return array('total'=> $total_gral->total, 'adherentes'=>$total_iae->total, 'no_adherentes'=>($total_gral->total - $total_iae->total));        
    }
    
    public function getTotalByMedioPago(){
        $sql ="SELECT COUNT(id) total, medio_pago FROM acreditados WHERE STATUS >= 0 GROUP BY medio_pago";
        $total_medio_pago = $this->db->query($sql)->result();
        return $total_medio_pago;
    }
    
    public function getTotalByMedioPagoIAE(){
        $sql ="SELECT COUNT(id) total, medio_pago FROM acreditados WHERE tipo_usuario = 1 AND STATUS >=0 GROUP BY medio_pago";
        $total_medio_pago = $this->db->query($sql)->result();
        return $total_medio_pago;
        
    }
    public function getFacturacionTotal(){
        $sql ="SELECT SUM(p.transaction_amount) total FROM acreditados a LEFT JOIN pagos p ON p.acreditado_id = a.id WHERE a.status >=0";
        $total_facturacion = $this->db->query($sql)->row();
        return $total_facturacion;
    }
    public function getFacturacionTotalStatus(){
        $total_facturacion = $this->getFacturacionTotal();
       
        $sql = "SELECT SUM(p.transaction_amount) total FROM acreditados a LEFT JOIN pagos p ON p.acreditado_id = a.id WHERE a.status >=0 AND p.pago_status IN (2,-1,0)";
        $total_facturacion_pendiente = $this->db->query($sql)->row();
        
        $sql = "SELECT SUM(p.transaction_amount) total FROM acreditados a LEFT JOIN pagos p ON p.acreditado_id = a.id WHERE a.status >=0 AND p.pago_status = 1";
        $total_facturacion_aprobada = $this->db->query($sql)->row();
      
        $sql = "SELECT SUM(p.transaction_amount) total FROM acreditados a LEFT JOIN pagos p ON p.acreditado_id = a.id WHERE a.status >=0 AND p.pago_status = 3";
        $total_facturacion_rechazada = $this->db->query($sql)->row();
        
        return array('total'=> $total_facturacion->total, 'facturacion_pendiente'=>$total_facturacion_pendiente->total, 'facturacion_aprobada'=>$total_facturacion_aprobada->total, 'facturacion_rechazada'=>$total_facturacion_rechazada->total);
        
    }
    
    public function getFacturacionPendienteByMedio(){
        $sql ="SELECT SUM(p.transaction_amount) total, p.payment_type FROM acreditados a LEFT JOIN pagos p ON p.acreditado_id = a.id WHERE a.status >=0 AND p.pago_status IN (2,-1,0) AND p.payment_type != '' GROUP BY p.payment_type";
        $total_facturacion_pendiente_medio = $this->db->query($sql)->result();
        return $total_facturacion_pendiente_medio;
    }
    
    public function getInscriptosPlanesPie(){
        
        $planes_array = array('100'  =>array('color'=>'#F38630', 'label'=>'Plan 100', 'labelColor'=>'#000000', 'labelFontSize'=>"12"),
                              '250'  =>array('color'=>'#F38630', 'label'=>'Plan 250', 'labelColor'=>'#000000', 'labelFontSize'=>"12"),
                              '350'  =>array('color'=>'#E0E4CC', 'label'=>'Plan 350', 'labelColor'=>'#000000', 'labelFontSize'=>"12"),
                              '1800' =>array('color'=>'#69D2E7', 'label'=>'Plan 1800', 'labelColor'=>'#000000', 'labelFontSize'=>"12"),
                              '0'    =>array('color'=>'#69cb6e', 'label'=>'No Paga', 'labelColor'=>'#000000', 'labelFontSize'=>"12"),
                              );
        $sql = "SELECT COUNT(id) total_planes, monto FROM acreditados WHERE STATUS >= 0 GROUP BY monto";
        $planes = $this->db->query($sql)->result();
        
        foreach($planes_array as $k=>$plan){
            $planes_array[$k]['value'] = (int)0;
            foreach($planes as $plan){
                if($plan->monto == $k){
                    $planes_array[$k]['value'] = (int)$plan->total_planes;
                } 
            }
            
        }
        $success      = true;
        $responseType = 'function';
        $function     = 'intiPiePlanes';
        $messages     = $planes_array;
        $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
        return $data;
    }
    
    public function getInscriptosPagosPie(){
        $total = $this->totalRegistros();        
        
        $sql = "SELECT COUNT(id) total_pagantes FROM acreditados WHERE STATUS >= 0 AND monto > 0";
        $pagantes = $this->db->query($sql)->row();
        $pagantes = (int) $pagantes->total_pagantes;
        $no_pagantes = (int)($total-$pagantes);
        
        
      
        
        $pagos = array('Paga'  =>array('color'=>'#F38630', 'label'=>'Pagantes', 'labelColor'=>'#000000', 'labelFontSize'=>"12", "value"=>$pagantes),
                        'NoPaga'  =>array('color'=>'#69D2E7', 'label'=>'No Pagantes', 'labelColor'=>'#000000', 'labelFontSize'=>"12", "value"=>$no_pagantes),                              
                              );
                              
        
        $success      = true;
        $responseType = 'function';
        $function     = 'intiPiePagos';
        $messages     = $pagos;
        $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
        
        return $data;
        
        
    }

}