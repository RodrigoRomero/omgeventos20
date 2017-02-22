<?php
$hoy       = strtotime(date('Y-m-d'));
$timelimit = strtotime($tickets->fecha_baja);
$fecha_venta = explode("-",$tickets->fecha_baja);
$fecha_venta = implode("-",array($fecha_venta[2], getMes($fecha_venta[1]), $fecha_venta[0]));
$data_price = (!empty($tickets->precio_oferta) && ($hoy < $timelimit)) ? $tickets->precio_oferta : $tickets->precio_regular;
$descripcion = json_decode($tickets->descripcion);

$step = 1;
$start = 0;
$end = 9;
if($tickets->min_qty == 0  && $tickets->max_qty == 0 ){
    $step = 1;
} elseif($tickets->min_qty>0 && $tickets->max_qty == 0 ) {
    $step = $tickets->min_qty;
} elseif($tickets->min_qty>0 && $tickets->max_qty > 0 ) {
     $step = 1;
     $start = $tickets->min_qty;
     $end = $tickets->max_qty;
}

$options = array_combine(range($start, $end, $step),range($start, $end, $step)) ;

?> 




<tr 
 class="price-table <?php echo (!$tickets->agotadas) ? 'pointer jPriceTkt' : 'active'; ?>"  
 data-ammount="<?php echo $data_price ?>"  
 data-name="<?php echo $tickets->nombre ?>"
 data-sku="<?php echo $tickets->sku ?>"  onclick="<?php echo (!$tickets->agotadas) ? 'setTickets($(this))' : ''; ?>"
>
    <td>
        <?php
        if(!$tickets->agotadas) {
            echo '<span class="price_check fa fa-square-o"></span>';
        }
        ?>
    </td>
    <td>
    <?php 
        echo '<h3>'.$tickets->nombre.'</h3>';
        echo ($tickets->bajada) ? '<p>'.$tickets->bajada.'</p>' : '';
        #DESCRIPCION DEL TICKET
        if(!empty($descripcion[0])) {  
            echo '<br/> <ul class="pricetable-items">';
            foreach($descripcion as $desc) {
                echo '<li>'.$desc.'</li>';
            }
            echo '</ul>';
        } 
    ?>
    </td>
    <td>

    <?php 
    if(!empty($tickets->precio_oferta) && ($hoy < $timelimit) && $tickets->precio_regular>$tickets->precio_oferta) { 
        if($tickets->agotadas){
            echo 'Entradas Agotadas';
            echo '<br/><span style="text-decoration: line-through">Precio Regular $ '.$tickets->precio_regular.'</span>';
        } else {
            echo '$ '.$tickets->precio_oferta; 
            if(!empty($tickets->precio_regular) && ($tickets->precio_regular>0)){
                echo '<br/><span style="text-decoration: line-through">Precio Regular $ '.$tickets->precio_regular.'</span>';
            } 
        }
        echo '<br/><span>HASTA ' . $fecha_venta . '</span>';
    } else {
        if($tickets->agotadas){
            echo 'Entradas Agotadas';
            echo '<br/><span style="text-decoration: line-through">$ '.$tickets->precio_regular.'</span>';
        } else {
            echo ($tickets->precio_regular>0) ? '$ '.$tickets->precio_regular : 'Free';
        }
    }
    ?>

    </td>
    <td>
    <?php 
    if(!$tickets->agotadas) {
        $js = 'onChange="setQty($(this))" disabled class="form-control input-lg"';   
        echo form_dropdown('cantidad',$options, 0,  $js);
    }
    ?>
    </td>
</tr>




