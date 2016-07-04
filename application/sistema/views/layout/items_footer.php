<?php
$json_item = json_decode($item->json); 
?>

<div class="row-fluid footer_destacados">
    <div class="span3">
    <?php echo up_asset('porfolios/thumbs/'.$item->id.'_0_166.jpg'); ?>
    </div>
    <div class="span9">
        <h3><?php echo $json_item->lang->$Clang->nombre ?></h3>
        <p><?php echo $json_item->lang->$Clang->cliente ?> - <?php echo $json_item->lang->$Clang->temporada ?></p>
        <?php echo anchor(lang_url('porfolio/detalle/'.$item->id.'/'.$json_item->lang->$Clang->nombre), lang('ver_detalle'))?>
    </div>

</div>