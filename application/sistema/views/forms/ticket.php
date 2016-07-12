<?php
$hoy       = strtotime(date('Y-m-d'));
$timelimit = strtotime($tickets->fecha_baja);
$fecha_venta = explode("-",$tickets->fecha_baja);
$fecha_venta = implode("-",array($fecha_venta[2], getMes($fecha_venta[1]), $fecha_venta[0]));
$data_price = (!empty($tickets->precio_oferta) && ($hoy < $timelimit)) ? $tickets->precio_oferta : $tickets->precio_regular;
$descripcion = json_decode($tickets->descripcion);
?>
<div class="col-md-3 col-xs-6 price-table <?php echo (!$tickets->agotadas) ? 'pointer jPriceTkt' : ''; ?>" data-sku="<?php echo $tickets->sku ?>" data-ammount="<?php echo $data_price ?>"  data-name="<?php echo $tickets->nombre ?>" style="background-color: #<?php echo $tickets->background ?>" onclick="setTickets($(this))">
<?php if($tickets->agotadas) { ?>
    <div class="overlay"></div>
<?php } ?>
    <h3><?php echo $tickets->nombre ?>
        <?php if($hoy < $timelimit) { ?>
        <br /><span>HASTA <?php echo $fecha_venta ?></span>
        <?php } ?>
    </h3>
    <p>
      <?php if(!empty($tickets->precio_oferta) && ($hoy < $timelimit) && $tickets->precio_regular>$tickets->precio_oferta) { ?>  
        <?php 
            if($tickets->agotadas){
                echo 'Entradas Agotadas';
                echo '<br/><span style="text-decoration: line-through">Precio Regular $ '.$tickets->precio_regular.'</span>';
            } else {
                echo '$ '.$tickets->precio_oferta; 
                if(!empty($tickets->precio_regular) && ($tickets->precio_regular>0)){
                    echo '<br/><span style="text-decoration: line-through">Precio Regular $ '.$tickets->precio_regular.'</span>';
                } 
            }
        ?>
      <?php } else { ?>
        <?php if($tickets->agotadas){
                echo 'Entradas Agotadas';
                echo '<br/><span style="text-decoration: line-through">$ '.$tickets->precio_regular.'</span>';
            } else {
                echo ($tickets->precio_regular>=0) ? '$ '.$tickets->precio_regular : '$ '.$tickets->precio_oferta;
            } ?>
      <?php } ?>
      <?php echo ($tickets->bajada) ? '<span>'.$tickets->bajada.'</span>' : '' ?>
    </p>
    <?php 
    #DESCRIPCION DEL TICKET
    if(!empty($descripcion[0])) {  
        echo '<ul class="pricetable-items">';
        foreach($descripcion as $desc) {
            echo '<li>'.$desc.'</li>';
        }
        echo '</ul>';
    } ?>
    <?php if(!$tickets->agotadas) { ?>
        <span class="price_check fa fa-square-o"></span>
    <?php } ?>
</div>