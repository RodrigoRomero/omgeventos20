<?php $this->view('alerts/error') ?>
<div class="widget-box">
<div class="widget-title">
	<span class="icon">
		<i class="icon-pencil"></i>									
	</span>
	<h5>Caballos</h5>
</div>
<?php
$data = array ('id'=>'caballosForm', 'class'=>'form-horizontal');
echo form_open($action,$data);

$data = array('name'=>'fecha_admision','id'=>'fecha_admision','placeholder'=>'Fecha Admisión', 'class'=>'required datepicker', 'value'=>getFechaView($row->fecha_admision));
echo control_group('Fecha Admisión', form_input($data),$attr = array());


$data = array('name'=>'nombre','id'=>'nombre','placeholder'=>'Nombre', 'class'=>'required', 'value'=>$row->nombre);
echo control_group('Nombre', form_input($data),$attr = array());

$data = array('name'=>'caravana','id'=>'caravana','placeholder'=>'Caravana', 'class'=>'', 'value'=>$row->caravana);
echo control_group('Caravana', form_input($data),$attr = array());

$data = array('name'=>'codigo_sba','id'=>'codigo_sba','placeholder'=>'Codigo SBA', 'class'=>'', 'value'=>$row->codigo_sba);
echo control_group('Codigo SBA', form_input($data),$attr = array());

$data = array('name'=>'rp','id'=>'rp','placeholder'=>'RP', 'class'=>'', 'value'=>$row->rp);
echo control_group('RP', form_input($data),$attr = array());

$data = array('name'=>'tipificacion','id'=>'tipificacion','placeholder'=>'Tipificación', 'class'=>'', 'value'=>$row->tipificacion);
echo control_group('Tipificación', form_input($data),$attr = array());

echo control_group('Pelajes', frm_select('',array('name'=>'pelaje_id'),$pelaje,$row->pelaje_id),$attr = array());

echo control_group('Propietario', frm_select('',array('name'=>'propietario_id'),$propietario,$row->propietario_id),$attr = array());

if($this->params['c']==2){    
    
    $data = array('class'=>'padrillos_asignados', 'required'=>false);
    echo control_group('Padrillos Asignados', frm_select_multi_trasfer($padrillos, 'padrillos', $data, $row->padrillos_asignados_id),$attr = array('class_controls'=>'clearfix'));
    
    $data = array('name'=>'preneces_solicitadas','id'=>'preneces_solicitadas','placeholder'=>'Preñeces Solicitadas', 'class'=>'number input-small', 'value'=>$row->preneces_solicitadas);
    echo control_group('Preñeces Solicitadas', form_input($data),$attr = array());
}

$data = array('name'=>'activo','id'=>'activo', 'class'=>'', 'type'=>'checkbox', 'checked'=>'checked');
echo control_group('Activo', form_input($data),$attr = array());

$buttons = '';
$buttons .= '<span class="pull-left">';
$data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-inverse', 'onclick'=>"validateForm('caballosForm')");
$buttons .= form_input($data);
$buttons .= '</span>'; 
echo form_action($buttons);

echo form_close();

?>
</div>