<?php 
$data = array ('id'=>'fichasForm', 'class'=>'form-horizontal');
echo form_open($action,$data);

#HIDDENS
echo form_hidden('caballo_id',$caballo_id);
?>
<div class="widget-box">
    <?php $this->view('layout/fichas/fichaMedicaHeader', array('title'=>'Registro Ficha Ginecológica', 'button_title'=>'NUEVA REVISIÓN')) ?>
    <div id="collapseTwo" class="widget-content collapse nopadding" style="height: 0px;">
    
    <div class="row-fluid">
        <div class="span3">
            <?php              
            $html = form_input(array('class'=>'datepicker fecha_revision input-small', 'data-date'=>date('d/m/Y'), 'value'=>date('d/m/Y'), 'name'=>'fecha_revision'));
            echo control_group('Fecha Revisión', $html, $attr = array());
            ?>  
        </div>
        <div class="span3">
            <?php              
            $html = form_input(array('class'=>'timepicker hora_revision input-small', 'id'=>'timepicker', 'name'=>'hora_revision'));
            echo control_group('Hora Revisión', $html, $attr = array('class_controls'=>'bootstrap-timepicker'));
            ?>  
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <?php
                $html = frm_multiples_radio($ovariosOpciones,array('name'=>'ovario_izquierdo'));                
                echo control_group('Ovario Izquierdo', $html, $attr = array());
                
                $html = frm_multiples_radio($ovariosOpciones,array('name'=>'ovario_derecho'));                
                echo control_group('Ovario Derecho', $html,$attr = array());
                
                $html = frm_multiples_radio($cervixOpciones,array('name'=>'cervix'));                
                echo control_group('Cervix', $html,$attr = array());
                
                $html = frm_multiples_radio($uteroOpciones,array('name'=>'utero'));                
                echo control_group('Utero', $html,$attr = array());
                
                $html = frm_multiples_radio($accionesMedicasOpciones,array('name'=>'acciones_medicas', 'id'=>'j-accionesMedicas', 'onclick'=>'getOpcionesMedicasExtras(this.value)'));                
                echo control_group('Acciones', $html, $attr = array('id'=>'jAccionesMedicas'));
                
                $html = frm_multiples_radio($drogasOpciones,array('name'=>'droga'));                
                echo control_group('Drogas', $html,$attr = array());
            ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span6">
            <?php
                $data = array('name'=>'observaciones','id'=>'observaciones','placeholder'=>'Observaciones', 'class'=>'', 'value'=>'');
                echo control_group('Observaciones', form_textarea($data),$attr = array(),'observaciones');
            ?>
        </div>