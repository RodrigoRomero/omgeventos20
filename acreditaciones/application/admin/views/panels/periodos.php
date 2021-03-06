<div class="box span12">
<?php echo $this->view('layout/panels/box_header', array('title'=>'Períodos', 'icon'=>'icon-pencil')) ?>
<div class="box-content">
<?php $this->view('alerts/error') ?>
<?php
$data = array ('id'=>'atributosForm', 'class'=>'form-horizontal');
echo form_open($action,$data);

$data = array('name'=>'nombre','id'=>'nombre','placeholder'=>'Nombre', 'class'=>'required input-xlarge', 'value'=>$row->nombre);
echo control_group('Nombre', form_input($data),$attr = array());
/*
$data = array('name'=>'abr','id'=>'abreviatura','placeholder'=>'Abreviatura', 'class'=>'input-xlarge', 'value'=>$row->abr);
echo control_group('Abreviatura', form_input($data),$attr = array());

$data = array('name'=>'descripcion','id'=>'descripcion','placeholder'=>'Descripción', 'class'=>'input-xlarge', 'value'=>$row->descripcion);
echo control_group('Descripción', form_textarea($data),$attr = array());
*/
$checked = ($row->activo==1) ? array('checked'=>true) : array();
$data = array('name'=>'activo','id'=>'activo', 'class'=>'', 'type'=>'checkbox');
echo control_group('Activo', form_input($data+$checked),$attr = array());

$checked = ($row->status==1) ? array('checked'=>true) : array();
$data = array('name'=>'status','id'=>'status', 'class'=>'', 'type'=>'checkbox');
echo control_group('Status', form_input($data+$checked),$attr = array());

$buttons = '';

$buttons .= '<span class="">';
$data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-primary', 'onclick'=>"validateForm('atributosForm')", 'style' =>'margin-right: 10px');
$buttons .= form_input($data);
$buttons .= anchor($back,'Cancelar',array('class'=>'btn btn-inverse'));
$buttons .= '</span>'; 
echo form_action($buttons);

echo form_close();

?>
</div>
</div>