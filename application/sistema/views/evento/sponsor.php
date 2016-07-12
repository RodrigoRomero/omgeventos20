<!-- SPONSOR -->
<section id="sponsor" class=" arrow-down">
	<div class="container">
        <header class="text-center">
            <h1>sponsors</h1>
        </header>
        <?php foreach($sponsor as $s) { ?>
            <?php if(!empty($s['sponsors'])) { ?>
                <div class="row">
                    <div class="col-md-12 platino sponsor_titles">
                        <h5><?php echo $s['categoria']->nombre ?></h5>
                    </div>
                </div>
                <?php foreach ($s['sponsors'] as $publi) { ?>
                    <?php if($s['categoria']->orden == 1) { ?>
                        <div class="col-md-4 sponsor_item">                     
                            <?php echo up_asset('sponsors/'.$publi->id.'_0.jpg', array('class'=>'animated img-responsive', 'data-animation'=>"bounceIn", 'title'=>$publi->nombre)) ?>                    
                        </div>
                    <?php } else { ?>
                        <div class="col-md-3 sponsor_item">                     
                            <?php echo up_asset('sponsors/'.$publi->id.'_0.jpg', array('class'=>'animated img-responsive', 'data-animation'=>"bounceIn", 'title'=>$publi->nombre)) ?>                    
                        </div>
                    <?php } ?>
                <?php } ?>     
            <?php } ?>
        <?php } ?>
	</div>
</section>
<!-- /SPONSOR --> 