<div class="row">
	<div class="fieldItem col-md-6">
		 <div class="col-md-5">
	        <?php echo form_label('Nombre <span>*</span>','frm_acreditado_nombre', array('class'=>'required')); ?>
	    </div>
	    <div class="col-md-7">
	        <?php
            $p = $position-1;
            $value = isset($nominados[$p]->nombre) ? $nominados[$p]->nombre : '';

	        $data = array('name'=>'acreditado_nombre['.$position.']','id'=>'frm_acreditado_nombre','placeholder'=>lang('nombre').'*', 'class'=>'required', 'value'=>$value

                );
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
        $value = isset($nominados[$p]->apellido) ? $nominados[$p]->apellido : '';
        $data = array('name'=>'acreditado_apellido['.$position.']','id'=>'frm_acreditado_apellido','placeholder'=>'Apellido*', 'class'=>'required', 'value'=>$value);
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
                 $value = isset($nominados[$p]->email) ? $nominados[$p]->email : '';
                $data = array('name'=>'acreditado_email['.$position.']','id'=>'frm_acreditado_email','placeholder'=>'Correo electrónico *', 'class'=>'required email', 'type'=>'email', 'value'=>$value);
                echo form_input($data);
                ?>
            </div>
        </div>
    </div>
   
</div>