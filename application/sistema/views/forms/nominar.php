<div class="row">
	<div class="fieldItem col-md-6">
		 <div class="col-md-5">
	        <?php echo form_label('Nombre <span>*</span>','frm_acreditado_nombre', array('class'=>'required')); ?>
	    </div>
	    <div class="col-md-7">
	        <?php
	        $data = array('name'=>'acreditado_nombre['.$position.']','id'=>'frm_acreditado_nombre','placeholder'=>lang('nombre').'*', 'class'=>'required', 'value'=>"");
	        echo form_input($data);
	        ?>
	    </div>
    </div>
    <div class="fieldItem col-md-6">
    	<div class="col-md-5">
        <?php echo form_label('Apellido <span>*</span>','frm_acreditado_apellido', array('class'=>'required')); ?>
    </div>
    <div class="col-md-7">
        <?php
        $data = array('name'=>'acreditado_apellido['.$position.']','id'=>'frm_acreditado_apellido','placeholder'=>lang('nombre').'*', 'class'=>'required', 'value'=>"");
        echo form_input($data);
        ?>
    </div>
    </div>
</div>
<div class="row">
    <div class="fieldItem col-md-6">
        <div class="row">
            <div class="col-md-5">
                <?php echo form_label('Correo electrónico <span>*</span>','frm_acreditado_email', array('class'=>'required')); ?>
               
            </div>
            <div class="col-md-7">
                <?php
                $data = array('name'=>'acreditado_email['.$position.']','id'=>'frm_acreditado_email','placeholder'=>'Correo electrónico *', 'class'=>'required email', 'type'=>'email', 'tabindex'=>7, 'value'=>$user_data->email);
                echo form_input($data);
                ?>
            </div>
        </div>
    </div>
   
</div>