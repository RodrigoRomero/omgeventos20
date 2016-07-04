<div class="col-md-12 text-center conocio_opciones">
    <h4>Datos Personales</h4>
</div>
<?php 

echo form_hidden('fbId',0);
echo '<div class="row">';
echo '<div class="col-md-4">';
$data = array('name'=>'nombre','id'=>'frm_nombre','placeholder'=>lang('nombre').'*', 'class'=>'required fullwidth', 'tabindex'=>1);
echo form_input($data);
echo '</div>';
echo '<div class="col-md-4">';
$data = array('name'=>'apellido','id'=>'frm_apellido','placeholder'=>lang('apellido').'*', 'class'=>'required fullwidth', 'tabindex'=>2);
echo form_input($data);
echo '</div>';

echo '<div class="col-md-4">';
$data = array('name'=>'empresa','id'=>'frm_empresa','placeholder'=>lang('empresa').'*', 'class'=>'required fullwidth', 'tabindex'=>3);
echo form_input($data);
echo '</div>';

/*
echo '<div class="col-md-3">';
$data = array('name'=>'edad','id'=>'frm_edad','placeholder'=>lang('edad').'*', 'class'=>'number fullwidth', 'tabindex'=>4);
/* echo form_label(lang('empresa'),$data['id'], array('class'=>'required')); 
echo form_input($data);
echo '</div>';

echo '<div class="col-md-3">';
$data = array('name'=>'dni','id'=>'frm_dni','placeholder'=>lang('dni').'*', 'class'=>'required number fullwidth', 'tabindex'=>5);
echo form_input($data);
echo '</div>';
*/
echo '<div class="col-md-6">';
$data = array('name'=>'cargo','id'=>'frm_cargo','placeholder'=>lang('cargo').'*', 'class'=>'required fullwidth', 'tabindex'=>6);
echo form_input($data);
echo '</div>';

echo '<div class="col-md-6">';
$data = array('name'=>'email','id'=>'frm_email','placeholder'=>lang('email').'*', 'class'=>'required email fullwidth', 'type'=>'email', 'tabindex'=>7);
echo form_input($data);
echo '</div>';

echo '<div class="col-md-6">';
$data = array('name'=>'telefono','id'=>'frm_telefono','placeholder'=>lang('telefono'), 'class'=>'number fullwidth', 'type'=>'phone', 'tabindex'=>8);
echo form_input($data);
echo '</div>';

echo '<div class="col-md-12" style="margin: 10px 0;">';
    echo '<ul>';  
    /*
        echo '<li>';
            //$data = array('id'=>'adblick', 'type'=>'checkbox','name'=>'conocio', 'class'=>'', 'value'=>'ADBlick', 'tabindex'=>9);
            //echo form_input($data);
            $data =  array('name'=>'no_asistente', 'id'=>'no_asistente', 'checked'=>false, 'style'=>'margin-right: 10px', 'tabindex'=>10, 'value'=>true);
            echo form_checkbox($data);
            echo form_label('Dono mi entrada a BisBlick pero no asistiré al evento',$data['id'],array("class"=>""));
        echo '</li>';             
     * 
     
        echo '<li>';
            //$data = array('id'=>'adblick', 'type'=>'checkbox','name'=>'conocio', 'class'=>'', 'value'=>'ADBlick', 'tabindex'=>9);
            //echo form_input($data);
            $data =  array('name'=>'donante_mensual', 'id'=>'donante_mensual', 'checked'=>false, 'style'=>'margin-right: 10px', 'tabindex'=>10, 'value'=>true);
            echo form_checkbox($data);
            echo form_label('Deseo que me contacten para donar mensualmente',$data['id'],array("class"=>""));
        echo '</li>';
     * 
     */
        echo '<li>';
            //$data = array('id'=>'adblick', 'type'=>'checkbox','name'=>'conocio', 'class'=>'', 'value'=>'ADBlick', 'tabindex'=>9);
            //echo form_input($data);
            $data =  array('name'=>'antiguo_alumno_iae', 'id'=>'antiguo_alumno_iae', 'onclick'=>'$(\'.jPlanes\').toggleClass(\'hide\');', 'checked'=>false, 'style'=>'margin-right: 10px', 'tabindex'=>9, 'value'=>true);
            echo form_checkbox($data);
            echo form_label('Soy socio AMDIA',$data['id'],array("class"=>""));
        echo '</li>';
        if($evento->cupons_enabled){
        echo '<li>';           
            $data =  array('name'=>'cupon_enabled', 'id'=>'cupon_enabled', 'onclick'=>'$(\'.jCupons\').toggleClass(\'hide\').val(\'\');', 'checked'=>false, 'style'=>'margin-right: 10px', 'tabindex'=>9, 'value'=>true);
            echo form_checkbox($data);
            echo form_label('Cuento con un código de Evento',$data['id'],array("class"=>""));
           
            $data = array('name'=>'cupons','id'=>'cupons','placeholder'=>'Código Evento', 'class'=>'fullwidth hide jCupons', 'tabindex'=>5, 'onblur'=>'validateCupon()');
            echo form_input($data);
            
            
        echo '</li>';
        }
    echo '</ul>';
echo '</div>';



echo '<div class="col-md-12 text-center conocio_opciones">';
    echo '<h4>¿Cómo te enteraste del evento?</h4>';
    echo '<div class="col-md-12 text-center ">';
    echo '<ul>';   
        echo '<li>';
            $data = array('id'=>'redes_sociales', 'type'=>'radio','name'=>'conocio', 'class'=>'', 'value'=>'Redes Sociales', 'tabindex'=>10);
            echo form_input($data);
            echo form_label('Redes Sociales',$data['id'],array("class"=>""));
        echo '</li>';
        echo '<li>';
            $data = array('id'=>'email', 'type'=>'radio','name'=>'conocio', 'class'=>'', 'value'=>'Email', 'tabindex'=>10);
            echo form_input($data);
            echo form_label('Email',$data['id'],array("class"=>""));
        echo '</li>';
        echo '<li>';
            $data = array('id'=>'referido', 'type'=>'radio','name'=>'conocio', 'class'=>'', 'value'=>'Referido', 'tabindex'=>11);
            echo form_input($data);
            echo form_label('Referido',$data['id'],array("class"=>""));
        echo '</li>';
        echo '<li >';
            $data = array('id'=>'empresa', 'type'=>'radio','name'=>'conocio', 'class'=>'', 'value'=>'Empresa', 'tabindex'=>15);
            echo form_input($data);
            echo form_label('Empresa',$data['id'],array("class"=>""));
        echo '</li>';
        /*
        echo '<li >';
            $data = array('id'=>'diario', 'type'=>'radio','name'=>'conocio', 'class'=>'', 'value'=>'Diario', 'tabindex'=>12);
            echo form_input($data);
            echo form_label('Diario',$data['id'],array("class"=>""));
        echo '</li>';
        echo '<li >';
            $data = array('id'=>'internet', 'type'=>'radio','name'=>'conocio', 'class'=>'', 'value'=>'Internet', 'tabindex'=>13);
            echo form_input($data);
            echo form_label('Internet',$data['id'],array("class"=>""));
        echo '</li>';
        echo '<li >';
            $data = array('id'=>'referido', 'type'=>'radio','name'=>'conocio', 'class'=>'', 'value'=>'Referido', 'tabindex'=>14);
            echo form_input($data);
            echo form_label('Referido',$data['id'],array("class"=>""));
        echo '</li>';  
         * 
         */      
    echo '</ul>';
    echo '</div>';    
echo '</div>';


echo '</div>';

?>