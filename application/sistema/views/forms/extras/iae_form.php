<div class="fieldItem col-md-12">
            <?php
            $data =  array('name'=>'no_asistente', 'id'=>'no_asistente', 'checked'=>false, 'style'=>'margin-left: 10px', 'tabindex'=>10, 'value'=>true);
            $checked = ($user_data->no_asistente==1) ? array('checked'=>TRUE) : array();
            
            echo form_label('Dono mi entrada a BisBlick pero no asistiré al evento',$data['id'],array("class"=>""));
            echo form_checkbox($data+$checked);
            ?>
            </div>
            <div class="fieldItem col-md-12">
            <?php
            $data =  array('name'=>'donante_mensual', 'id'=>'donante_mensual', 'checked'=>false, 'style'=>'margin-left: 10px', 'tabindex'=>11, 'value'=>true);
            $checked = ($user_data->donante_mensual==1) ? array('checked'=>TRUE) : array();
            echo form_label('Deseo que me contacten para donar mensualmente',$data['id'],array("class"=>""));
            echo form_checkbox($data+$checked);
            ?>
            </div>