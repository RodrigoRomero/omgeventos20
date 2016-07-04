<?php $this->view('alerts/error') ?>
<div class="widget-box">
<div class="widget-title">
	<span class="icon">
		<i class="icon-pencil"></i>									
	</span>
	<h5>Temporadas</h5>
</div>
<?php
$data = array ('id'=>'temporadasForm', 'class'=>'form-horizontal');
echo form_open($action,$data);

$data = array('name'=>'nombre','id'=>'nombre','placeholder'=>'Nombre', 'class'=>'required', 'value'=>$row->nombre);
echo control_group('Nombre', form_input($data),$attr = array());

$data = array('name'=>'abreviatura','id'=>'abreviatura','placeholder'=>'Abreviatura', 'class'=>'', 'value'=>$row->abreviatura);
echo control_group('Abreviatura', form_input($data),$attr = array());

$data = array('name'=>'activo','id'=>'activo', 'class'=>'', 'type'=>'checkbox', 'checked'=>'checked');
echo control_group('Activo', form_input($data),$attr = array());

$buttons = '';
$buttons .= '<span class="pull-left">';
$data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-inverse', 'onclick'=>"validateForm('temporadasForm')");
$buttons .= form_input($data);
$buttons .= '</span>'; 
echo form_action($buttons);

echo form_close();

?>
</div>