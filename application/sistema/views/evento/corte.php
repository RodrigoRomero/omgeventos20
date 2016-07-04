<?php
    $logos = array('iae_footer', 'austral_footer', 'adblick_footer', 'bisblick_footer');
?>

<section class="util-row">
	<div class="container text-center">
        <div class="row">
            <div class="divider-util col-md-4 col-md-offset-4">
                <h2>#ElTrabajoEnElFuturo</h2>
            </div>
        </div>
        <div class="row">        
        <?php foreach($logos as $logo){ ?>
           <div data-animation="animate_from_bottom" class="animated animate_from_bottom col-md-3">
		      <?php // echo image_asset('site/'.$logo.'.jpg') ?>
              <img src="holder.js/300x100/text:sponsor 300x100"/> 
	       </div>
                
        <?php } ?>
        </div>
		
	</div>
</section>