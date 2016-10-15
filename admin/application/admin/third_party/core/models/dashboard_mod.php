<?phpif (!defined('BASEPATH')) exit('No direct script access allowed');error_reporting(E_ALL ^ E_NOTICE);/** * @author Rodrigo Romero * @version 1.0.0 *  *  TODO: LOG */class dashboard_mod extends RR_Model {	public function __construct() {	    		parent::__construct();            }        public function lastAcreditados(){        $this->db->select('a.id, a.nombre, a.empresa, a.apellido, a.email, p.status mp_status, a.status, a.medio_pago', false);           $this->db->where('a.status >=',0);                $this->db->where('a.evento_id',$this->evento_id);        $this->db->join('pagos p', 'p.acreditado_id = a.id','LEFT');        $this->db->from('acreditados a');        $this->db->limit(10);        $this->db->order_by('a.id','DESC');        $query = $this->db->get();        $result = $query->result();                $box_header = $this->view('layout/panels/box_header', array('title'=>'Últimos 10 Acreditados', 'icon'=>'icon-user', 'box_icon'=>true));        $box_content = '<ul class="unstyled">';        foreach($result as $usuario){            $box_content .= '<li><b>'.$usuario->empresa.'</b> - '.$usuario->nombre.' '.$usuario->apellido.' <i>('.$usuario->mp_status.')</i></li>';        }        $box_content .= '</ul>';        $box = $this->view('layout/panels/box', array('box_header'=>$box_header,'box_content'=>$box_content));        return $box;    }    //SELECT COUNT(id) total_by_date, DATE_FORMAT(fa, '%Y/%m/%d') fa FROM acreditados GROUP BY DATE_FORMAT(fa, '%Y/%m/%d')    public function getSmallStats(){       // $recaudado    = $this->getSmall('recaudado');        $suscriptores = $this->getSmall('suscriptores');        $smallStats = $recaudado.$suscriptores;        return $smallStats;    }    public function getTotal(){        $sql = "SELECT COUNT(id) total FROM acreditados WHERE status >= 0 AND evento_id = $this->evento_id";        $total = $this->db->query($sql)->row();        return $total;    }        public function getTotalActive(){        $sql = "SELECT COUNT(id) total FROM acreditados WHERE status = 1 AND evento_id = $this->evento_id";        $total = $this->db->query($sql)->row();        return $total;    }        public function getTotalActiveCheckins(){        $sql = "SELECT COUNT(id) total FROM acreditados WHERE status = 1 AND acreditado = 1 AND evento_id = $this->evento_id";        $total = $this->db->query($sql)->row();        return $total;    }    public function getTotalLunch(){        $sql = "SELECT COUNT(id) total FROM acreditados WHERE status >= 1  AND evento_id = $this->evento_id and lunch = 1";        $total = $this->db->query($sql)->row();        return $total;    }    private function getSmall($tipo){       /*        switch($tipo){            case 'recaudado':                            $this->db->where_in('pago_status',array(1,2));                $this->db->select_sum('transaction_amount','value');                $query = $this->db->get('pagos')->row();                $icon  = 'icon-money';                $color = 'blue';                $title = $tipo;                $value = $query->value;                  $this->db->flush_cache();                      break;            case 'suscriptores':                            $this->db->where('number.status',1);                $this->db->from('acreditados number');                $value = $this->db->count_all()->row();                  echo $value;                              $this->db->flush_cache();                $icon  = 'icon-user';                $color = 'blue';                $title = $tipo;                lq();                        break;        }        return $this->view('layout/panels/smallstats',array('value'=>$value, 'icon'=>$icon, 'color'=>$color, 'title'=>$title));        */            }    public function getInscriptosChart() {        $evento = $this->db->get_where('eventos',array('status'=>1))->row();        if(count($evento)>0){            $sql = "SELECT COUNT(id) total_by_date, DATE_FORMAT(fa, '%d-%m-%Y') fa FROM acreditados WHERE status >= 0  AND evento_id = $this->evento_id GROUP BY DATE_FORMAT(fa, '%d-%m-%Y')";            $inscriptos = $this->db->query($sql)->result();                    $fechainicio = date('Y-m-d',strtotime($evento->fa." - 1 day"));            $fechafin    = date('Y-m-d',strtotime($evento->fecha_baja));            $arrayFechas = $this->devuelveArrayFechasEntreOtrasDos($fechainicio,$fechafin);            $values = array();            if(count($inscriptos)>0){                foreach($inscriptos as $registro){                        $registros = ($registro->total_by_date) ? $registro->total_by_date : 0;                                                $values[] = array($registro->fa, (int)$registros);                }                } else {                    $values[] = array(date('Y-m-d'),0);                }        $success      = true;        $responseType = 'function';        $function     = 'initChart';        $messages     = $values;        $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);        return $data;        } else {            $success      = false;            $data = array('success' => $success);            return $data;        }    }     public function devuelveArrayFechasEntreOtrasDos($fechaInicio, $fechafin){        $arrayFechas=array();        $fechaMostrar = $fechaInicio;            while(strtotime($fechaMostrar) <= strtotime($fechafin)) {                                $fechaMostrar = date("d-m-Y", strtotime($fechaMostrar . " + 1 day"));                $arrayFechas[]=$fechaMostrar;            }            return $arrayFechas;    }    public function getTotalByTipo(){        $total_gral = $this->getTotal();                $sql = "SELECT COUNT(id) total FROM acreditados WHERE status >= 0  AND evento_id = $this->evento_id and tipo_usuario = 1";        $total_iae = $this->db->query($sql)->row();        return array('total'=> $total_gral->total, 'adherentes'=>$total_iae->total, 'no_adherentes'=>($total_gral->total - $total_iae->total));            }            public function getTotalCheckInByTipo(){                        $sql = "SELECT COUNT(id) total, 'Regulares' as tipo FROM acreditados WHERE tipo_usuario = 0 AND evento_id = $this->evento_id AND STATUS = 1 AND acreditado = 1                UNION                SELECT COUNT(id) total, 'Adherentes IAE' as tipo FROM acreditados WHERE tipo_usuario = 1 AND evento_id = $this->evento_id AND STATUS = 1 AND acreditado = 1";        $totals = $this->db->query($sql)->result();                return array('totales' =>$totals);            }        public function cuponsStats(){        $sql = "SELECT CONCAT(COUNT(a.id),'/',c.quantity) quantity_used, c.nombre         FROM acreditados a         LEFT JOIN cupons c ON c.code = a.discount_code         WHERE a.evento_id = 1 /*$this->evento_id*/          AND a.discount_code != ''         GROUP BY c.nombre";                  $result = $this->db->query($sql)->result();                return $result;    }        public function getTotalByMedioPago(){        $sql ="SELECT COUNT(id) total, medio_pago FROM acreditados WHERE STATUS >= 0  AND evento_id = $this->evento_id GROUP BY medio_pago";        $total_medio_pago = $this->db->query($sql)->result();        return $total_medio_pago;    }    public function getTotalByTicket(){        $sql ="SELECT COUNT(acreditados.id) total, tickets.nombre               FROM acreditados               LEFT JOIN tickets ON tickets.id = acreditados.id_ticket                WHERE acreditados.evento_id = $this->evento_id               GROUP BY id_ticket";        $total_tickets = $this->db->query($sql)->result();        return $total_tickets;    }    public function getBarsByTicket(){        $sql ="SELECT acreditados.evento_id, COUNT(acreditados.id) total, tickets.nombre, tickets.background               FROM acreditados               LEFT JOIN tickets ON tickets.id = acreditados.id_ticket                WHERE acreditados.evento_id = $this->evento_id                GROUP BY acreditados.id_ticket,               acreditados.evento_id";        $total_tickets = $this->db->query($sql)->result();        #$header = array(array("Ticket", "Total"));       # ep($header);        $values = array();        foreach($total_tickets as $tkt){            $values[] = array(ucwords($tkt->nombre), (int)$tkt->total, '#'.$tkt->background);        }           $success      = true;        $responseType = 'function';        $function     = 'initBarTickets';        //$messages     = array_merge($header,$values);        $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$values, 'value'=>$function);        return $data;    }    public function getTotalByMedioPagoIAE(){        $sql ="SELECT COUNT(id) total, medio_pago FROM acreditados WHERE tipo_usuario = 1 AND STATUS >=0 GROUP BY medio_pago  AND evento_id = $this->evento_id";        $total_medio_pago = $this->db->query($sql)->result();        return $total_medio_pago;    }    public function getFacturacionTotal(){        $sql ="SELECT SUM(p.transaction_amount) total FROM acreditados a LEFT JOIN pagos p ON p.acreditado_id = a.id WHERE a.status >=0";        $total_facturacion = $this->db->query($sql)->row();        return $total_facturacion;    }    public function getFacturacionTotalStatus(){        $total_facturacion = $this->getFacturacionTotal();        $sql = "SELECT SUM(p.transaction_amount) total FROM acreditados a LEFT JOIN pagos p ON p.acreditado_id = a.id WHERE a.status >=1 AND p.pago_status IN (2,-1,0)  AND a.evento_id = $this->evento_id";        $total_facturacion_pendiente = $this->db->query($sql)->row();        $sql = "SELECT SUM(p.transaction_amount) total FROM acreditados a LEFT JOIN pagos p ON p.acreditado_id = a.id WHERE a.status >=1 AND p.pago_status = 1  AND a.evento_id = $this->evento_id";        $total_facturacion_aprobada = $this->db->query($sql)->row();        $sql = "SELECT SUM(p.transaction_amount) total FROM acreditados a LEFT JOIN pagos p ON p.acreditado_id = a.id WHERE a.status >=1 AND p.pago_status = 3  AND a.evento_id = $this->evento_id";        $total_facturacion_rechazada = $this->db->query($sql)->row();        return array('total'=> ($total_facturacion->total) ? $total_facturacion->total : 0,                      'facturacion_pendiente'=> ($total_facturacion_pendiente->total) ? $total_facturacion_pendiente->total : 0,                                          'facturacion_aprobada'=> ($total_facturacion_aprobada->total) ? $total_facturacion_aprobada->total : 0,                       'facturacion_rechazada'=>($total_facturacion_rechazada->total) ? $total_facturacion_rechazada->total : 0);    }    public function getFacturacionPendienteByMedio(){        $sql ="SELECT SUM(p.transaction_amount) total, p.payment_type FROM acreditados a LEFT JOIN pagos p ON p.acreditado_id = a.id WHERE a.status >=1 AND p.pago_status IN (2,-1,0) AND p.payment_type != ''  AND a.evento_id = $this->evento_id GROUP BY p.payment_type";        $total_facturacion_pendiente_medio = $this->db->query($sql)->result();        return $total_facturacion_pendiente_medio;    }    public function getInscriptosPlanesPie(){        $evento = $this->db->get_where('eventos',array('status'=>1, 'id'=>$this->evento_id))->row();        $header = array(array('Tipo','Value'));               if(count($evento)>0){            $sql = "SELECT t.nombre, a.totals, t.id                    FROM tickets t                    LEFT JOIN (SELECT COUNT(id) totals, id_ticket FROM acreditados GROUP BY id_ticket) a ON a.id_ticket = t.id                    WHERE t.evento_id = $evento->id  AND t.id = a.id_ticket";                            $acreditados = $this->db->query($sql)->result();            $values = array();            foreach($acreditados as $acreditado){                $values[] = array($acreditado->nombre, (int)$acreditado->totals);            }        $success      = true;        $responseType = 'function';        $function     = 'intiPiePlanes';        $messages     = array_merge($header,$values);        $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);        return $data;        } else {            return false;        }    }    public function getInscriptosPagosPie(){                $this->db->from('acreditados');        $this->db->where('status >=',0);        $total = $this->db->count_all_results();        $sql = "SELECT COUNT(id) total_pagantes FROM acreditados WHERE STATUS >= 0 AND monto > 0  AND evento_id = $this->evento_id";        $pagantes_q = $this->db->query($sql)->row();        $pagantes = (int) $pagantes_q->total_pagantes;        $no_pagantes = (int)($total-$pagantes_q->total_pagantes);        $header = array(array('Tipo','Value'));        $pagos = array(array('Pagantes',$pagantes),                       array('No Pagantes',$no_pagantes)                                                            );        $pagos = array_merge($header,$pagos);        $success      = true;        $responseType = 'function';        $function     = 'intiPiePagos';        $messages     = $pagos;        $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);        return $data;    }}