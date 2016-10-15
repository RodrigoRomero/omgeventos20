<?php $this->view('alerts/error') ?>
<div class="widget-box">
<div class="widget-title">
	<span class="icon">
		<i class="icon-pencil"></i>									
	</span>
	<h5>Usuario</h5>
</div>
<?php
$data = array ('id'=>'usuariosForm', 'class'=>'form-horizontal');
echo form_open($action,$data);

$data = array('name'=>'user-nombre','id'=>'user-nombre','placeholder'=>'Nombre', 'class'=>'required', 'value'=>$row->nombre);
echo control_group('Nombre', form_input($data),$attr = array());

$data = array('name'=>'user-apellido','id'=>'user-apellido','placeholder'=>'Apellido', 'class'=>'required', 'value'=>$row->apellido);
echo control_group('Apellido', form_input($data),$attr = array());

$data = array('name'=>'user-email','id'=>'email','placeholder'=>'Email', 'class'=>'required email', 'value'=>$row->email);
echo control_group('Email', form_input($data),$attr = array('help-block'=>'(Será el usuario para ingresar a la plataforma de Cabayada Gen)'));

$data = array('name'=>'password','id'=>'password','placeholder'=>'Password', 'class'=>'password', 'value'=>$row->password, 'type'=>'password');
echo control_group('Password', form_input($data),$attr = array());

$data = array('name'=>'valid_password','id'=>'valid_password','placeholder'=>'Repetir Password', 'class'=>'valid_password', 'value'=>$row->password, 'type'=>'password');
echo control_group('Repetir Password', form_input($data),$attr = array());

$data = array('name'=>'user-telefono','id'=>'user-telefono','placeholder'=>'Teléfono', 'class'=>'number', 'value'=>$row->telefono);
echo control_group('Teléfono', form_input($data),$attr = array());


$data = array('name'=>'activo','id'=>'activo', 'class'=>'', 'type'=>'checkbox', 'checked'=>'checked');
echo control_group('Activo', form_input($data),$attr = array());

$buttons = '';
if(isset($row->id)){
    $data = array('name'=>'id', 'class'=>'', 'type'=>'hidden', 'value'=>$row->id);
    $buttons .= form_input($data);
}

$buttons .= '<span class="pull-left">';
$data = array('type'=>'submit', 'value'=>'Guardar', 'class'=>'btn btn-inverse', 'onclick'=>"validateForm('usuariosForm')");
$buttons .= form_input($data);
$buttons .= '</span>'; 
echo form_action($buttons);

echo form_close();

?>
</div>