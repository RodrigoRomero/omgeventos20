<?php 
$json = json_decode($json);
$class_filter = getAtributesCategories($atributos_id);
?>
<div class="sf-item <?php echo $class_filter ?>">
	<div class="sf-item-inner">
		<div class="sf-item-overlay">
			<div class="lsf">
				
                <a href="<?php echo lang_url('porfolio/detalle/'.$id.'/'.$json->lang->$Clang->nombre)?>">link</a>
			</div>
		</div>
		<?php echo up_asset('porfolios/thumbs/'.$id.'_0_655.jpg'); ?>
		<div class="sf-item-text">
			<h5><?php echo $json->lang->$Clang->nombre ?></h5>
		</div>
	</div>
</div>