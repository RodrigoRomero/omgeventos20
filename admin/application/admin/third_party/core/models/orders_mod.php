<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL ^ E_NOTICE);
/**
 * @author Rodrigo Romero
 * @version 1.0.0
 * 
 *  TODO: LOG
 */
class orders_mod extends RR_Model {
    var $atributo       = 'ordenes';
    var $table          = 'orders';
    var $module         = 'ordenes';
    var $module_title   = "Ordenes";

    var $id;
    public function __construct() {	   
        parent::__construct();
        $this->load->model('eventos_mod','Evento');
        $this->id   = !empty($this->params['id']) ? $this->params['id'] : '';
    }

    public function listado(){   
        if(isset($_POST['exporta']) && filter_input(INPUT_POST,'exporta')==1){
            return $this->exporta();
            die;
        }
        
        if(isset($this->params['f']) && !empty($this->params['f'])){
            $this->download_file();
            die;
        }
        $this->breadcrumb->addCrumb($this->module_title,'');
        $this->breadcrumb->addCrumb('Listado','','current');
        $datagrid["columns"][] = array("title" => "", "field" => "", "width" => "46");        
        $datagrid["columns"][] = array("title" => "Order #", "field" => "id", 'sort'=>'o.id');
        $datagrid["columns"][] = array("title" => "Total", "field" => "total_price", 'sort'=>'o.total_price', 'format'=> 'money');
        $datagrid["columns"][] = array("title" => "Discount", "field" => "discount_amount", 'sort'=>'o.discount_amount', 'format'=> 'money');
        $datagrid["columns"][] = array("title" => "Grand Total", "field" => "total_discounted_price", 'sort'=>'o.total_discounted_price', 'format'=> 'money');
        $datagrid["columns"][] = array("title" => "Empresa", "field" => "empresa", 'sort'=>'c.empresa');
        $datagrid["columns"][] = array("title" => "Apellido", "field" => "apellido", 'sort'=>'c.apellido');
        $datagrid["columns"][] = array("title" => "Nombre", "field" => "nombre", 'sort'=>'c.nombre');        
        $datagrid["columns"][] = array("title" => "Email", "field" => "email", 'sort'=>'c.email');
        $datagrid["columns"][] = array("title" => "Pago", "field" => "payment_status", 'sort'=>'p.status');        
        $datagrid["columns"][] = array("title" => "Status", "field" => "status", 'format'=>'icon-activo');    


        #CONDICIONES & CACHE DE CONDICIONES     
        $this->db->start_cache();   
        $this->db->select('o.id, o.total_price, o.discount_amount, o.total_discounted_price, c.empresa, c.nombre, c.apellido, c.email, o.status, p.status payment_status', false);   
        $this->db->where('o.status >=',0);        
        $this->db->where('o.evento_id',$this->evento_id);
        $this->db->join('customers c', 'c.id = o.customer_id','INNER');
        $this->db->join('pagos p', 'p.order_id = o.id','INNER');


        
        
        
        if(isset($_POST['search']) && !empty($_POST['search'])) {
            $like_arr = array('c.nombre', 'c.apellido', 'c.email', 'c.empresa');            
            foreach($like_arr as  $l){
                $like_str .= $l." LIKE '%".$this->input->post('search',true)."%' OR ";
            }
            $like_str = '('.substr($like_str,0,-4).')';
            $this->db->where($like_str);    
        }
        
       
        
        if(isset($_POST['medio_pago']) && $_POST['medio_pago'] != '-1') {
            $this->db->where('gateway',filter_input(INPUT_POST,'medio_pago'));    
        }
        
        if(isset($_POST['payment_status']) && $_POST['payment_status'] != '-1') {
            $this->db->where('p.status',filter_input(INPUT_POST,'payment_status'));    
        }
        
        if(isset($_POST['order']) && !empty($_POST['order'])) {
            $order = explode("-",$this->input->post('order',true));            
            $this->db->order_by($datagrid['columns'][$order[1]]['sort'],$order[0]);
        } else {
            $this->db->order_by('o.id','DESC');
        }
        $this->db->from($this->table.' o');
        $this->db->stop_cache();
        #TOTAL REGISTROS
        $total = $this->db->count_all_results();        
        $limit = isset($_POST['limit']) ? $this->input->post('limit',true) : '';
        switch($limit){
            case '-1':            
            case '':
                break;
            case 'all':
                $this->limit = $total;
                break;
            default:
                $this->limit = $limit;
                break;
        }
        #PAGINADO
        $page  = (isset($_POST['page']) && !empty($_POST['page'])) ? $this->input->post('page',true) : 1;        
        if($page!="all"){
            $from  = ($page-1)*$this->limit;
            $this->db->limit($this->limit, $from);
        }
        $paginador = $this->paging_mod->get_paging($total, $this->limit);
        $query = $this->db->get();
        $this->db->flush_cache();
        //CONFIG
        //$lnk_del = set_url(array('a'=>'chk_deletea'));        
        //$html  = "<a class='ax-modal tip-top icon-trash' href='".$lnk_del."/id/{%id%}' data-original-title='Eliminar' style='margin-right:10px'></a>";
        $upd_del = set_url(array('a' =>'newa', 'iu'=>'update')); 
		$html = "<a class='tip-top' href='".$upd_del."/id/{%id%}' data-original-title='Editar'><span class='icon-pencil'></span></a>";
        $extra[] = array("html" => $html, "pos" => 0);
        $datagrid["rows"]      = $this->datagrid->query_to_rows($query->result(), $datagrid["columns"], $extra);
        //echo $this->input->post('nombre');
        $filter_data = array('nombre' => $this->input->post('nombre',true),
                             'limit'  => $this->limit
                            );
        //$action_links['new'] =  array('action' => set_url(array('a'=>'newa', 'iu'=>'new')), 'title' => 'Nuevo');
        #$action_links['exporta'] =  array('action' => set_url(array('a' =>'exporta')), 'title' => 'Exportar');
        $filter = $this->view("filters/".$this->atributo, $filter_data);
        $dg = array("datagrid"   => $datagrid,
                    "filters"    => $filter,
                    'grid_lnk'   => $action_links,
                    "paging"     => $paginador,
                    'grid_title' => $this->module_title
                    );
        $grid = $this->datagrid->make($dg);
        if(!$this->input->is_ajax_request()) {
            return $grid;
        } else {
            return array('success'=>false, 'value'=>$grid, 'responseType' => 'inject', 'inject'=>'j-a');
        }
    }
    public function newa(){
        $data_panel['action']      = set_url(array('a'=>'savea'));
        $data_panel['back']        = lang_url('module/load/m/acreditados/a/listado');
        $this->breadcrumb->addCrumb($this->module_title,lang_url('module/load/m/acreditados/a/listado'));     
        $data_panel['tickets']     = $this->db->get_where('tickets',array('evento_id'=>$this->evento_id, 'status'=>1))->result();
        
           
        if(!empty($this->id)) {
            $this->breadcrumb->addCrumb('Editar','','current');  
            $data_panel['user_info'] = $this->db->get_where($this->table,array('id'=>$this->id))->row();
            $data_panel['pago_info'] = $this->db->get_where('pagos',array('acreditado_id'=>$this->id))->row();           
        } else {
            $this->breadcrumb->addCrumb('Nueva','','current');
        }
        $panel = $this->view("panels/".$this->atributo, $data_panel);
        return $panel;
    }
    public function chk_deletea(){        
       return $this->check_deletea();
    }
    public function deletea(){ 
        if(!empty($this->id)) {            
            $values = array('status'=>-1);
            $this->db->where('id', $this->id);
	        $query = $this->db->update($this->table, array_merge($this->u, $values));
            if($query){                
                $success = true;
                $responseType = 'function'; 
                $function     = 'reloadTable';        
                $status       = $this->view('alerts/generic', array('success'=>'Registro Eliminado Exitosamente', 'type'=>'success'));                    
                $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>$function,  "html"=>lang_url('module/load/m/'.$this->module.'/a/listado'), 'status'=>$status);
            }
        }
        return $data;
    }
    public function savea(){
        #VALIDO FORM POR PHP
         $success = 'false';
         $config = array(array('field'   => 'payment_status', 'label'   => 'Status Pago', 'rules'   => 'trim|required|xss_clean')
                      );
         $this->form_validation->set_rules($config);
         if($this->form_validation->run()==FALSE){
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $responseType = 'function';
            $function     = 'appendFormMessages';
            $messages     = validation_errors();
            $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function);
         } else {
            $user_info = $this->db->get_where($this->table,array('id'=>$this->id))->row();
            $pago_info = $this->db->get_where('pagos',array('acreditado_id'=>$this->id))->row();
          
            $status = 0;            
            if (isset($_POST['status'])) $status = 1;
            
            $values = array('status' => $status);
            
            #STATUS PAGOS
            if($status===0) {                            
                $pago_status['pago_status'] = '-1';
                $pago_status['status']      = 'cancelled';
            }
            
            $payment_status = filter_input(INPUT_POST,'payment_status');
            if($status===1 && ($payment_status != $user_info->medio_pago) ) {
                switch($payment_status) {
                    case 'rejected':
                    case 'refunded':
                    case 'refunded':
                    case 'cancelled':
                    case 'in_mediation':
                    case 'sin_pago':
                        $pago_status['pago_status'] = '-1';
                        break;
                    case 'approved':
                        $pago_status['pago_status'] = 1;
                        break;
                    case 'in_process':    
                    case 'pending':
                        $pago_status['pago_status'] = 2;
                        break;                    
                }
                $pago_status['status'] = $payment_status;
            }                
            
            /*
            
         
            #SI EL PASS CAMBIA AL DEFAULT ORSONIA LO ACTUALIZO
            if($this->input->post('password') != md5($this->check_pass)) {
                    $values['password']   = $this->input->post('password', true);
            }
            */
            #VALIDACIÓN CAMBIO PAGOS
            #$pago_status    = array();
            #$medio_pago     = $this->input->post('medio_pago',true);
            #$payment_status = $this->input->post('payment_status',true);
            #$monto          = $this->input->post('monto',true);
            #CAMBIO 
            #$values = array('medio_pago' => $medio_pago,
             #               'monto'      => $monto
              #              );
            /*
            $invitacion = 0;          
            if (isset($_POST['autorizar'])) $invitacion = 2;
            if($invitacion==2){
                $values = array_merge($values, array('invitacion'=>$invitacion));
            }
            */
            /*
            if($medio_pago != $user_info->medio_pago){                
                $pago_status['currency_id']        = 'ARS';
                $pago_status['status']             = $payment_status;
                $pago_status['collection_id']       = "";
                $pago_status['collection_status']   = "";
                $pago_status['preference_id']       = "";
                $pago_status['payment_type']        = $medio_pago;
            }
            if($monto!=$user_info->monto){
                $pago_status['transaction_amount']  = $monto;
            }
            switch($payment_status) {
                case 'rejected':
                case 'refunded':
                case 'refunded':
                case 'cancelled':
                case 'in_mediation':
                case 'sin_pago':
                    $pago_status['pago_status'] = '-1';
                    break;
                case 'approved':
                    $pago_status['pago_status'] = 1;
                    break;
                case 'in_process':    
                case 'pending':
                    $pago_status['pago_status'] = 2;
                    break;                    
            }
            $pago_status['status'] = $payment_status;
            */
            switch($this->params['iu']) {
                case 'new':
                    /*
                    $query = $this->db->insert($this->table, array_merge($values,$this->i));                    
                    $this->session->set_flashdata('insert_success', 'Registro Insertado Exitosamente');
                     * 
                     */
                    break;
                case 'update':                    
                    $this->db->where('id',$this->id);
                    $query = $this->db->update($this->table, array_merge($values,$this->u));                    
                    
                    if($query){
                        $this->db->where('acreditado_id',$this->id);
                        $query = $this->db->update('pagos',$pago_status);
                    }
                    /*
                    if($query){
                        if($medio_pago != $user_info->medio_pago){
                            $subject    = "Cambio Medio de Pago - Argentina Visión 2020";
                            if($medio_pago == 'transferencia_bancaria')  {
                                $body = $this->view('email/transferencia_bancaria',array('user_info'=>$user_info));                                
                            } else if ($medio_pago == 'mercado_pago') {
                                $body = $this->view('email/mercado_pago',array('user_info'=>$user_info));
                            } else if ($medio_pago == 'pago_mis_cuentas'){
                                $body = $this->view('email/pago_mis_cuentas',array('user_info'=>$user_info));
                            }
                            $this->Email->send('email_info',$user_info->email, $subject,$body);
                        }
                        if($user_info->medio_pago=='transferencia_bancaria' && $payment_status=='approved' && $pago_info->status != $payment_status){
                            $subject    = "Transferencia Bancaria Acreditada - Argentina Visión 2020";
                            $body = $this->view('email/transferencia_bancaria_ok',array('user_info'=>$user_info, 'evento'=>$this->Evento->getEvento()));
                            $this->Email->send('email_info',$user_info->email, $subject,$body);
                        }
                        if($user_info->medio_pago=='pago_mis_cuentas' && $payment_status=='approved' && $pago_info->status != $payment_status){                            
                            $subject    = "Pago Mis Cuentas Acreditado - Argentina Visión 2020";
                            $body = $this->view('email/transferencia_bancaria_ok',array('user_info'=>$user_info,'evento'=>$this->Evento->getEvento()));
                            $this->Email->send('email_info',$user_info->email, $subject,$body);
                        }
                    }
                    */
                    $this->session->set_flashdata('insert_success', 'Registro Actualizado Exitosamente');  
                    break;
            }
            if($query){
                $success = true;
                $responseType = 'redirect';                
                $data    = array('success' =>$success,'responseType'=>$responseType, 'value'=>lang_url('module/load/m/'.$this->module.'/a/listado'));
            }
        }
        return $data;
    }
    public function exporta(){
        
        $this->db->start_cache();   
        $this->db->select('a.id, 
                           a.empresa,
                           a.cargo,
                           a.nombre, 
                           a.apellido, 
                           a.dni,
                           a.edad,
                           a.email,
                           a.telefono,
                           a.conocio,
                           a.tipo_usuario,
                           a.medio_pago, 
                           a.monto,
                           a.discount_code,
                           a.lunch,
                           a.barcode,
                           a.donante_mensual,
                           a.no_asistente,
                           a.acreditado,
                           a.status,
                           a.fa,
                           t.nombre as ticket,
                           p.status mp_status', false);   
        $this->db->where('a.evento_id',$this->evento_id);       
        $this->db->join('pagos p', 'p.acreditado_id = a.id','LEFT');
        $this->db->join('tickets t', 't.id = a.id_ticket','LEFT');
        if(isset($_POST['search']) && !empty($_POST['search'])) {
            $like_arr = array('a.nombre', 'a.apellido', 'a.email', 'p.status');            
            foreach($like_arr as  $l){
                $like_str .= $l." LIKE '%".$this->input->post('search',true)."%' OR ";
            }
            $like_str = '('.substr($like_str,0,-4).')';
            $this->db->where($like_str);    
        }
        
        if(isset($_POST['tipo_usuario']) && $_POST['tipo_usuario'] != '-1') {
            $this->db->where('a.tipo_usuario',filter_input(INPUT_POST,'tipo_usuario'));    
        }
        
        if(isset($_POST['medio_pago']) && $_POST['medio_pago'] != '-1') {
            $this->db->where('medio_pago',filter_input(INPUT_POST,'medio_pago'));    
        }
        
        if(isset($_POST['no_asistente']) && $_POST['no_asistente'] != '-1') {
            $this->db->where('no_asistente',filter_input(INPUT_POST,'no_asistente'));    
        }
        
        $this->db->from($this->table.' a');
        $this->db->stop_cache();
        $result = $this->db->get()->result();
         $this->db->flush_cache();
        unset($_POST);
        $_POST = array();
        $file_name = 'acreditados_omg';
        $alphas = array('A');
        $current = 'A';
        while ($current != 'ZZZ') {
            $alphas[] = ++$current;
        }       
        $this->load->library('PHPExcel');
        $this->phpexcel->getProperties()->setCreator("Orsonia Digital")
							            ->setLastModifiedBy("Orsonia Digital")
							            ->setTitle("Orsonia Digital")
							            ->setSubject("Orsonia Digital")
							            ->setDescription("Orsonia Digital")
							            ->setKeywords("Orsonia Digital")
							            ->setCategory("Orsonia Digital");
                                        
        $columns[] = array("title" => "Id");        
        $columns[] = array("title" => "Tipo Usuario");
        $columns[] = array("title" => "Código de Barras");
        $columns[] = array("title" => "Empresa");
        $columns[] = array("title" => "Cargo");        
        $columns[] = array("title" => "Nombre");
        $columns[] = array("title" => "Apellido");
        $columns[] = array("title" => "Edad");
        $columns[] = array("title" => "DNI");        
        $columns[] = array("title" => "Email");
        $columns[] = array("title" => "Teléfono");
        $columns[] = array("title" => "Conocio");    
        $columns[] = array("title" => "Ticket");
        $columns[] = array("title" => "Código Descuento");
        $columns[] = array("title" => "Medio Pago");
        $columns[] = array("title" => "Monto");
        $columns[] = array("title" => "Status Pago");
        $columns[] = array("title" => "Almuerzo");
        $columns[] = array("title" => "No Asistente");
        $columns[] = array("title" => "Donante Mensual");        
        $columns[] = array("title" => "Status");
        $columns[] = array("title" => "Fecha Registro");      
        $columns[] = array("title" => "Asistió");
        $nro_cols = (count($columns)-1);
        
        $this->phpexcel->getActiveSheet()->mergeCells('A1:'.$alphas[$nro_cols].'1');
        $this->phpexcel->getActiveSheet()->mergeCells('A2:'.$alphas[$nro_cols].'2');
        $this->phpexcel->getActiveSheet()->setCellValue("A2", "");
        $this->phpexcel->getActiveSheet()->setCellValue("A1", "Suscriptos al ".date('d-M-Y'));
        $this->phpexcel->getActiveSheet()->getStyle("A1:".$alphas[$nro_cols].'1')->applyFromArray(
                                                                            array('fill' => array(
    	                                                                                          'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
    	                                                                                          'color'   => array('rgb' => 'EFEFEF')
                                                                                                 ),
                                                                                  'font' => array(
                                                                                                  'bold' => true,
                                                                                                  'size' => 14
                                                                                                 ),
                                                                                  'alignment' => array(
                                                                                                       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                                                                      ),
                                                                                  'borders' => array(
                                                                                                     'outline' => array(
                                                                                                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                                                                                                            'color' => array('argb' => '0000000'),
                                                                                                     ),
                                                                                               ),
                                                                                  )
                                                                           );
        foreach($columns as $columnKey => $column){
            $this->phpexcel->getActiveSheet()->setCellValue($alphas[$columnKey]."3", $column['title']);
            $this->phpexcel->getActiveSheet()->getColumnDimensionByColumn($alphas[$columnKey]."3")->setAutoSize(true);
        }
        $this->phpexcel->getActiveSheet()->getStyle("A3:".$alphas[$nro_cols].'3')->applyFromArray(
                                                                            array(
                                                                                  'font' => array(
                                                                                                  'bold' => true,
                                                                                                  'size' => 12
                                                                                                 ),
                                                                                  'alignment' => array(
                                                                                                       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                                                                      ),
                                                                                  'borders' => array(
                                                                                                     'outline' => array(
                                                                                                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                                                                                                            'color' => array('argb' => '0000000'),
                                                                                                     ),
                                                                                               ),
                                                                                  )
                                                                           );
        $i = 4;               

            foreach($result as $rowKey =>$row) {
            $this->phpexcel->getActiveSheet()->setCellValue("A".$i, $row->id);
            $this->phpexcel->getActiveSheet()->getStyle("A".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("B".$i, $row->tipo_usuario);
            $this->phpexcel->getActiveSheet()->getStyle("B".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
                        
            $this->phpexcel->getActiveSheet()->setCellValue("C".$i, $row->barcode);
            $this->phpexcel->getActiveSheet()->getStyle("C".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("D".$i, $row->empresa);
            $this->phpexcel->getActiveSheet()->getStyle("D".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("E".$i, $row->cargo);
            $this->phpexcel->getActiveSheet()->getStyle("E".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("F".$i, $row->nombre);
            $this->phpexcel->getActiveSheet()->getStyle("F".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
                        
            $this->phpexcel->getActiveSheet()->setCellValue("G".$i, $row->apellido);
            $this->phpexcel->getActiveSheet()->getStyle("G".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
                        
            $this->phpexcel->getActiveSheet()->setCellValue("H".$i, $row->edad);
            $this->phpexcel->getActiveSheet()->getStyle("H".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
                        
            $this->phpexcel->getActiveSheet()->setCellValue("I".$i, $row->dni);
            $this->phpexcel->getActiveSheet()->getStyle("I".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);
        
            $this->phpexcel->getActiveSheet()->setCellValue("J".$i, $row->email);
            $this->phpexcel->getActiveSheet()->getStyle("J".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
        
            $this->phpexcel->getActiveSheet()->setCellValue("K".$i, $row->telefono);
            $this->phpexcel->getActiveSheet()->getStyle("K".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("L".$i, $row->conocio);
            $this->phpexcel->getActiveSheet()->getStyle("L".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
        
            $this->phpexcel->getActiveSheet()->setCellValue("M".$i, $row->ticket);
            $this->phpexcel->getActiveSheet()->getStyle("M".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("N".$i, $row->discount_code);
            $this->phpexcel->getActiveSheet()->getStyle("N".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("N")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("O".$i, $row->medio_pago);
            $this->phpexcel->getActiveSheet()->getStyle("O".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("P".$i, $row->monto);
            $this->phpexcel->getActiveSheet()->getStyle("P".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("P")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("Q".$i, $row->mp_status);
            $this->phpexcel->getActiveSheet()->getStyle("Q".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("Q")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("R".$i, $row->lunch);
            $this->phpexcel->getActiveSheet()->getStyle("R".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("R")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("S".$i, $row->no_asistente);
            $this->phpexcel->getActiveSheet()->getStyle("S".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("S")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("T".$i, $row->donante_mensual);
            $this->phpexcel->getActiveSheet()->getStyle("T".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("T")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("U".$i, $row->status);
            $this->phpexcel->getActiveSheet()->getStyle("U".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("U")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("V".$i, $row->fa);
            $this->phpexcel->getActiveSheet()->getStyle("V".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("V")->setAutoSize(true);
            
            $this->phpexcel->getActiveSheet()->setCellValue("W".$i, $row->acreditado);
            $this->phpexcel->getActiveSheet()->getStyle("W".$i)->getAlignment()->setWrapText(true);
            $this->phpexcel->getActiveSheet()->getColumnDimension("W")->setAutoSize(true);
            $i++;
        }                   
        
    
       $this->phpexcel->getActiveSheet()->setTitle('Acreditados Evento');
       $this->phpexcel->setActiveSheetIndex(0);
       $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel2007');    
       $objWriter->save('../uploads/data/'.$file_name.'.xlsx');                   
       $messages     = $this->session->set_flashdata('insert_success', 'Archivo Generado Exitosamente');;
       $success      = true;
       $responseType = 'function';
       $function     = 'appendExportSuccess';
       $extraUrl     = set_url(array('a'=>'listado', 'f'=>$file_name));
       $data = array('success' => $success, 'responseType'=>$responseType, 'messages'=>$messages, 'value'=>$function, 'extraUrl'=>$extraUrl);
      
       return $data;
    
    }
    function download_file(){
       $this->load->helper('download');
       $data = file_get_contents('../uploads/data/'.$this->params['f'].'.xlsx');
       force_download($this->params['f'].'.xlsx',$data);
       return true;
    }
}