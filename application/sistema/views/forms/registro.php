<!--<h2 class="tableHead">Tu información </h2>-->
<p class="alerta">*Campos Obligatorios</p>
<!--<div id="registerBtns">
    <a href="javascript:void(0)" class="btnONE widthFacebook" onclick="logInWithFacebook()">Registrarse con facebook</a>
</div>-->
<?php

$data   = array ('id'=>'registroForm', 'class'=>'');
$action = lang_url('account/'.$action);
echo form_open($action,$data);
echo form_hidden('fbId',0);
?>

        <!-- fila de items -->
        <div class="row">
            <div class="fieldItem col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        echo form_label('Nombre <span>*</span>','frm_nombre', array('class'=>'required fullwidth'));
                        $data = array('name'=>'nombre','id'=>'frm_nombre','placeholder'=>lang('nombre').'*', 'class'=>'required fullwidth', 'tabindex'=>1, 'value'=>$user_data->nombre);
                        echo form_input($data);
                        ?>
                    </div>
                </div>
            </div>
            <div class="fieldItem col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        echo form_label('Apellido <span>*</span>','frm_apellido', array('class'=>'required fullwidth'));
                        $data = array('name'=>'apellido','id'=>'frm_apellido','placeholder'=>lang('apellido').'*', 'class'=>'required fullwidth', 'tabindex'=>2, 'value'=>$user_data->apellido);
                        echo form_input($data);
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- fila de items -->
        <div class="row">
            <div class="fieldItem col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <?php
                        echo form_label('Empresa <span>*</span>','frm_empresa', array('class'=>'required fullwidth'));
                        $data = array('name'=>'empresa','id'=>'frm_empresa','placeholder'=>lang('empresa').'*', 'class'=>'required fullwidth', 'tabindex'=>3, 'value'=>$user_data->empresa);
                        echo form_input($data);
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo form_label('Cargo <span>*</span>','frm_cargo', array('class'=>'required fullwidth'));
                        $data = array('name'=>'cargo','id'=>'frm_cargo','placeholder'=>lang('cargo').'*', 'class'=>'required fullwidth', 'tabindex'=>4, 'value'=>$user_data->cargo);
                        echo form_input($data);
                        ?>
                    </div>
                    <div class="col-md-4">
                        <?php echo form_label('Área de Trabajo <span>*</span>','frm_area', array('class'=>'frm_area fullwidth'));
                        $data = array('name'=>'area','id'=>'frm_area','placeholder'=>'Área de Trabajo*', 'class'=>'required fullwidth', 'tabindex'=>4, 'value'=>$user_data->cargo);
                        echo form_input($data);
                        ?>
                    </div>

                </div>
            </div>
        </div>

        <!-- fila de items -->


        <!-- fila de items -->
        <div class="row">
            <div class="fieldItem col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        echo form_label('Correo electrónico <span>*</span>','frm_email', array('class'=>'required fullwidth'));
                        $data = array('name'=>'email','id'=>'frm_email','placeholder'=>'Correo electrónico *', 'class'=>'required fullwidth email', 'type'=>'email', 'tabindex'=>7, 'value'=>$user_data->email);
                        echo form_input($data);
                        ?>
                    </div>
                </div>
            </div>
            <div class="fieldItem col-md-6">
                <div class="row">
                    <div class="col-md-12">
                       <?php
                       echo form_label('Teléfono <span>*</span>','frm_telefono', array('class'=>'required fullwidth'));
                        $data = array('name'=>'telefono','id'=>'frm_telefono','placeholder'=>'Teléfono *', 'class'=>'number fullwidth required', 'type'=>'phone', 'tabindex'=>8, 'value'=>$user_data->telefono);
                        echo form_input($data);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="fieldItem col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                         echo form_label('Cantidad de Empleados <span>*</span>','json-cantidad_empleados', array('class'=>'required fullwidth'));

                        $data = 'id="json_cantidad_empleados" tabindex="8" class="fullwidth"';
                        $options = array('' => '-- Seleccione --',
                            '0-500'  => '0-500',
                            '501-1000'    => '501-1000',
                            '1001-5000'   => '1001-5000',

                        );
                        echo form_dropdown('json_cantidad_empleados', $options, '', $data);
                        ?>
                    </div>
                </div>
            </div>
            <div class="fieldItem col-md-6">
                <div class="row">
                    <div class="col-md-12">
                       <?php echo form_label('Tipo de Asistente<span>*</span>','json-tipo_asistente', array('class'=>'required fullwidth'));

                        $data = 'id="json_tipo_asistente" tabindex="10"  class="fullwidth"';
                        $options = array('' => '-- Seleccione --',
                            'cliente'  => 'Cliente',
                            'partner'    => 'Partner',
                            'prensa'   => 'Prensa',
                            'otro' => 'Otro',
                        );
                        echo form_dropdown('json_tipo_asistente', $options, '', $data);
                      ?>
                    </div>
                </div>
            </div>
        </div>




    <div class="col-md-12 text-center">
    <?php
    $data = array('type'=>'submit', 'value'=>'Regístrese', 'class'=>'btn btn-primary red', 'id'=>'contact_submit', 'onclick'=>"validateForm('registroForm')");
    echo form_input($data);
    ?>
    </div>
<?php echo form_close(); ?>