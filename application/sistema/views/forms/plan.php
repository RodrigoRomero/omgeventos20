<?php
$hoy       = strtotime(date('Y-m-d'));
$timelimit = strtotime($fecha_baja);
$fecha_venta = explode("-",$fecha_baja);
$fecha_venta = implode("-",array($fecha_venta[2], getMes($fecha_venta[1]), $fecha_venta[0]));
$data_price = (!empty($precio_oferta) && ($hoy < $timelimit)) ? $precio_oferta : $precio_regular;
#9TcXWsJ0od
?>

<div class="col-md-3 col-xs-6 price-table <?php echo strtolower($nombre) ?> <?php echo (!$agotadas) ? 'pointer jPrice' : ''; ?>" data-price="<?php echo $data_price ?>" style="background-color: #<?php echo $background ?>">
<?php if($agotadas) { ?>
    <div class="overlay"></div>
<?php } ?>
    <h3><?php echo $nombre ?>
        <?php if($hoy < $timelimit) { ?>
        <br /><span>HASTA <?php echo $fecha_venta?></span>
        <?php } ?>
    </h3>
    <p>
      <?php if(!empty($precio_oferta) && ($hoy < $timelimit) && $precio_regular>$precio_oferta) { ?>  
        <?php 
            if($agotadas){
                echo '<br/><span style="text-decoration: line-through">Precio Regular $ '.$precio_regular.'</span>';
            } else {
                echo '$ '.$precio_oferta; 
                if(!empty($precio_regular) && ($precio_regular>0)){
                    echo '<br/><span style="text-decoration: line-through">Precio Regular $ '.$precio_regular.'</span>';
                } 
            }
        ?>
      <?php } else { ?>
        <?php if($agotadas){
                echo 'Entradas Agotadas';
                echo '<br/><span style="text-decoration: line-through">$ '.$precio_regular.'</span>';
            } else {
                echo ($precio_regular>=0) ? '$ '.$precio_regular : '$ '.$precio_oferta;
            } ?>
      <?php } ?>
      <span><?php echo $bajada ?></span>
    </p>
    <?php if(!empty($descripcion)) {  

    echo '<ul class="pricetable-items">';

   $descripcion = json_decode($descripcion);

   foreach($descripcion as $desc) {

        echo '<li>'.$desc.'</li>';

    }

    echo '</ul>';

    

} ?>

    <?php if(!$agotadas) { ?>

    <span class="price_check fa fa-square-o "  ></span>

    <?php } ?>
</div>
<?php /*

    

        

    

	



    

<?php } else { ?>

    

    

<?php } ?>



</p>





</div>
 * 
 */ ?>