<?php 
$json = json_decode($detalle['data']->json);

$img = array();
for($i=0;$i<$detalle['total_images'];$i++) {
               $img[$i]['image'] = up_file('porfolios/original/'.$detalle['data']->id.'_'.$i.'.jpg');
               $img[$i]['title'] = $json->lang->$Clang->proyecto;
               $img[$i]['thumb'] = up_file('porfolios/thumbs/'.$detalle['data']->id.'_'.$i.'_150.jpg');;                                                      
} 

?>
<section id="listados">
    <div class="container">
        <div class="row">
    		<div class="span12">
                <div class="row-fluid">
                    <div class="span4">
                        <div class="accordion" id="accordion">
                        <div class="accordion-group">
                            <div class="accordion-heading active">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse1"><?php echo $json->lang->$Clang->proyecto ?><span class="pull-right icon-chevron-down accordion-detail"></span></a>
                            </div>
                            <div id="collapse1" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <div class="content">
                                        <div class="row-fluid">
                                            <div class="span12">
                                                <p><b>Project:</b> <?php echo $json->lang->$Clang->proyecto ?></p>
                                                <p><b>Client:</b> <?php echo $json->lang->$Clang->cliente ?></p>
                                                <p><b>Scope:</b> <?php echo $json->lang->$Clang->descripcion ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="slidecaption" class="span6 offset2 hidden-phone"></div>
                    
                </div>

                
                <div class="span5 hidden-phone">
                <a id="prevslide" class="load-item"></a>
                <a id="nextslide" class="load-item"></a> 
                </div>
                <div id="thumb-tray" class="load-item">
                <div id="thumb-back"></div>
                <div id="thumb-forward"></div>
                </div>
                
                
                <!--Time Bar-->
                <div id="progress-back" class="load-item hidden-phone">
                <div id="progress-bar"></div>
                </div>
                <!--Control Bar-->
                <div id="controls-wrapper" class="load-item hidden-phone">
                <div class="container">
                <div id="controls">
                <a id="tray-button" class="tip" data-container="body" data-placement="top" data-trigger="hover" data-title="Abrir Galería">
                <img id="tray-arrow" src="<?php echo config_item('base_url').'assets/widgets/supersized/img/button-tray-up.png' ?>"/>
                </a>
                </div>
                </div>                     
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function() {
if($.supersized !== undefined) {
        init_supersized();
    }
})


function init_supersized(){
    jQuery(function($){
        $.supersized({
        	// Functionality
        	slideshow               :   1,			// Slideshow on/off
        	autoplay				:	1,			// Slideshow starts playing automatically
        	start_slide             :   1,			// Start slide (0 is random)
        	stop_loop				:	0,			// Pauses slideshow on last slide
        	random					: 	0,			// Randomize slide order (Ignores start slide)
        	slide_interval          :   5000,		// Length between transitions
        	transition              :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
        	transition_speed		:	1000,		// Speed of transition
        	new_window				:	1,			// Image links open in new window/tab
        	pause_hover             :   0,			// Pause slideshow on hover
        	keyboard_nav            :   1,			// Keyboard navigation on/off
        	performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
        	image_protect			:	1,			// Disables image dragging and right click with Javascript
        											   
        	// Size & Position						   
        	min_width		        :   0,			// Min width allowed (in pixels)
        	min_height		        :   0,			// Min height allowed (in pixels)
        	vertical_center         :   1,			// Vertically center background
        	horizontal_center       :   1,			// Horizontally center background
        	fit_always				:	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
        	fit_portrait         	:   1,			// Portrait images will not exceed browser height
        	fit_landscape			:   0,			// Landscape images will not exceed browser width
        											   
        	// Components							
        	slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
        	thumb_links				:	1,			// Individual thumb links for each slide
        	thumbnail_navigation    :   0,			// Thumbnail navigation
        	slides 					:  	<?php echo json_encode($img); ?>,
        	// Theme Options			   
        	progress_bar			:	1,			// Timer for each slide							
        	mouse_scrub				:	0
        	
        });   
    });
    
}    
</script>