<?php

$data = array ('id'=>'loginform', 'class'=>'form_vertical');
echo form_open('auth/do_login',$data); 

echo '<p>Ingrese Usuario y Password</p>';

$data = array('name'=>'user','id'=>'user','placeholder'=>'Usuario', 'class'=>'');
echo control_group('', form_input($data),$attr = array('prepend'=>'<i class="icon-user"></i>'));

$data = array('name'=>'password','id'=>'password','placeholder'=>'Password', 'class'=>'required', 'type'=>'password');
echo control_group('', form_input($data),$attr = array('prepend'=>'<i class="icon-lock"></i>'));



$data = array('type'=>'submit', 'value'=>'Ingresar', 'class'=>'btn btn-inverse', 'onclick'=>"validateLoginForm('loginform')");
$buttons = '';
/*
$buttons .= '<span class="pull-left">';
$buttons .= anchor('#','Recuperar Password',array('class'=>'flip-link', 'id'=>'to-recober'));
$buttons .= '</span>';
*/
$buttons .= '<span class="pull-right">';
$buttons .= form_input($data);
$buttons .= '</span>'; 
echo form_action($buttons);

echo form_close();

?>