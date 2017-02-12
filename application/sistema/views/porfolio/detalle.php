<?php $json = json_decode($full_details->json);?>
<div class="container">
    <div class="row-fluid">
    	<div class="span7">
    		<div class="camera_wrap camera_white_skin" id="camera_wrap_2">
                <?php
                
                for($i=0;$i<$total_img;$i++){ 
                    echo '<div data-src="'.up_file('porfolios/thumbs/'.$full_details->id.'_'.$i.'_655.jpg').'" data-portrait="true" class="sf-image"></div>';
                }
                ?>
    			
    		</div>
    
    	</div>
    
    	<div class="span5 blog-sidebar">
    		<div class="iconframe">
    			<i class="sf-icon-tag-4"></i>
    		</div>
    		<div class="title1">
    			<h2><?php echo $json->lang->$Clang->nombre ?></h2>
    			<h3><?php echo $json->lang->$Clang->cliente ?></h3>
                <h4><?php echo $json->lang->$Clang->temporada ?></h4>
    		</div>
    		<hr/>
    		<p><?php echo $json->lang->$Clang->descripcion ?></p>
    	</div>
    </div>
    </div>