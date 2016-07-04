<div class="row-fluid jAccionesMedicasExtras" style="border-bottom: 1px solid #eee">
    <div class="span3">    
    <?php
    $tipoEmbrion = array(
        array('nombre'=>'Fresco','id'=>'fresco'),
        array('nombre'=>'Congelado', 'id'=>'congelado'), 
    );
    
    $html = frm_multiples_radio($tipoEmbrion,array('name'=>'tipoEmbrion'));                
    echo control_group('Tipo de Embrión', $html,$attr = array('class'=>'jAccionesMedicasExtras'));    
   
    $sexado = array(
        array('nombre'=>'Macho','id'=>'M'),
        array('nombre'=>'Hembra', 'id'=>'H'), 
    );
    
    $html = frm_multiples_radio($sexado,array('name'=>'sexado'));                
    echo control_group('Sexado', $html,$attr = array('class'=>'jAccionesMedicasExtras'));    
    ?>
    </div>
    <div class="span3">
    <?php
    $calidadEmbrion = array(
        array('nombre'=>'XB1','id'=>'XB1'),
        array('nombre'=>'XB1','id'=>'XB1'),
        array('nombre'=>'XB1','id'=>'XB1'),
        array('nombre'=>'XB1','id'=>'XB1'), 
    );
    
    $html = frm_multiples_radio($calidadEmbrion,array('name'=>'calidadEmbrion'));                
    echo control_group('Calidad de Embrión', $html,$attr = array('class'=>'jAccionesMedicasExtras')); 
    
    $html = form_checkbox(array('name'=>'descarte'));                
    echo control_group('Descarte', $html,$attr = array('class'=>'jAccionesMedicasExtras'));   
    ?>
    </div>
    <div class="span3">
    <?php
    echo '<div class="jAccionesMedicasExtras">'.$receptorasFlushing.'</div>'; 
    ?>
    </div>
    <div class="span3">
    <?php
    $html = frm_multiples_radio($calidadTransferenciaOpciones,array('name'=>'calildad_transferencia'));                
    echo control_group('Calidad de Transferencia', $html,$attr = array('class'=>'jAccionesMedicasExtras'));    
    ?>
    </div>
    
</div>