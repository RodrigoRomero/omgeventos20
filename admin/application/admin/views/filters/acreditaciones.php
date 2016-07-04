<div class="box span12">
    <div class="box-header">
        <h2><i class="icon-search"></i> Filtros</h2> 
    </div>
    <div class="box-content">
        <?php
        $data   = array ('id'=>'frmFilter');      
        echo form_open($action,$data);     
        ?>
        <div class="row" style="margin: 0;">
        <div class="span6">
            <?php
            $data = array('id'=>'', 'class'=>'filt', 'value'=>$nombre, 'name'=>'search', 'placeholder'=>'Buscar');    
            echo form_label($data['placeholder']);
            echo form_input($data);
            ?>
        </div>
        <div class="span6">
            <?php
            $opciones = array('-1'  =>'Seleccione una opción',
                              '1'   =>'Ex Alumnos IAE',
                              );
            echo form_label('Tipo de Registro');
            echo form_dropdown('tipo_usuario',$opciones);            
            ?>
        </div>
        </div>
        <div class="row"  style="margin: 0;">
        <div class="span6">
            <?php
            $opciones = array('-1'                      =>'Seleccione una opción',
                              '0'                       =>'Sin Medio de Pago',
                              'mercado_pago'            =>'Mercado Pago',
                              'transferencia_bancaria'  =>'Transferencia Bancaria',
                              'pago_mis_cuentas'        =>'Pago Mis Cuentas',
                              );
            echo form_label('Medio de Pago');
            echo form_dropdown('medio_pago',$opciones);            
            ?>
        </div>
        <div class="span6">
            <?php
            $opciones = array('-1'          =>'Seleccione una opción',
                              '1'           =>'No Asistiré',
                              '0'           =>'Asistiré');
            echo form_label('Asistencia al Evento');
            echo form_dropdown('no_asistente',$opciones);            
            ?>
        </div>
        </div>
        <div class="row"  style="margin: 0;">
        <div class="span12">
        <?php
        echo form_close();
        echo anchor_js('Buscar', array('class'=>"cg-filters btn btn-small btn-primary", 'id'=>'j-filter-send', 'style'=>'margin-right:10px'));
        echo anchor_js('Exportar', array('class'=>"cg-filters btn btn-small btn-primary", 'id'=>'j-filter-export', 'style'=>'margin-right:10px'));
        echo anchor_js('Resetear', array('class'=>"cg-filters btn btn-small btn-inverse", 'id'=>'j-filter-reset'));        
        ?>
        </div>
        </div>
   </div>
</div>