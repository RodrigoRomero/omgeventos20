<?php
$data = array ('id'=>'asignarPadrillosForm', 'class'=>'form-horizontal');
echo form_open($action,$data);

$data = array('class'=>'padrillos_asignados', 'required'=>false);
echo control_group('Padrillos Asignados', frm_select_multi_trasfer($padrillos, 'padrillos', $data, $row->padrillos_asignados_id),$attr = array('class_controls'=>'clearfix'));

$buttons = '';
$buttons .= '<span class="pull-left">';
$data = array('type'=>'submit', 'value'=>'Asignar', 'class'=>'btn btn-inverse', 'onclick'=>"validateForm('asignarPadrillosForm')");
$buttons .= form_input($data);
$buttons .= '</span>'; 
echo form_action($buttons);

echo form_close();

?>