<!-- GALERIA -->
<section id="galeria" class="alternate arrow-down">
	<div class="container">
		<header class="text-center">
			<h1>GALERÍA</h1>
		</header>
		<div class="divider"><!-- lines divider --></div>
		<div id="portfolio" class="text-center animate_fade_in">

			<!-- PORTFOLIO FILTER -->
			<div class="text-center">
				<ul class="nav nav-tabs bstrap-tabs isotope-filter" data-sort-id="isotope-list" data-option-key="filter">
					<li data-option-value="*" class="active"><a href="#">TODO</a></li>
					<li data-option-value=".image"><a href="#">FOTOS</a></li>							
					<li data-option-value=".video"><a href="#">VIDEOS</a></li>
				</ul>
			</div>
			<!-- /PORTFOLIO FILTER -->


			<div class="row">

				<ul class="sort-destination isotope" data-sort-id="isotope-list">

				
								
                    
					
					<li class="isotope-item col-sm-6 col-md-3 video"><!-- item -->
						<a class="popup-video" href="https://vimeo.com/138487938">
							<?php echo up_asset('galeria/video_1.jpg', array('class'=>'img-responsive')) ?>
                            
							<div class="caption">
								<i class="rounded fa fa-film"></i>
								<h3>Artista: Sougwen Chung</h3>
								<p>Drawing Operations <br /></p>
							</div>
						</a>
					</li>
                    

                    
                    <li class="isotope-item col-sm-6 col-md-3 video"><!-- item -->
						<a class="popup-video"  href="https://vimeo.com/144184627">
							<?php echo up_asset('galeria/video_2.jpg', array('class'=>'img-responsive')) ?>
                           
							<div class="caption">
								<i class="rounded fa fa-film"></i>
								<h3>Artista: Doze Green</h3>
								<p>Arklandia Dreamstate</p>
							</div>
						</a>
					</li>
                    
                    <li class="isotope-item col-sm-6 col-md-3 image"><!-- item -->
						<a class="popup-image" href="<?php echo up_file('galeria/1.jpg')?>">
							<?php echo up_asset('galeria/S_1.jpg', array('class'=>'img-responsive')) ?>
							<div class="caption">
								<i class="rounded fa fa-camera"></i>
								<h3>Snapchat Animations </h3>
								<p>Joel Plosz</p>
							</div>
						</a>
					</li>				
                    <li class="isotope-item col-sm-6 col-md-3 image"><!-- item -->
						<a class="popup-image" href="<?php echo up_file('galeria/2.jpg')?>">
							<?php echo up_asset('galeria/S_2.jpg', array('class'=>'img-responsive')) ?>
							<div class="caption">
								<i class="rounded fa fa-camera"></i>
								<h3>Silkie “Love Affair”</h3>
								<p>Animation</p>
							</div>
						</a>
					</li>	
					
					
					
                    
                    
                                       
                  
                    
                    
				</ul>
			</div>

		</div>

	</div>
</section>
<!-- /GALERIA -->
<?php #echo $this->view('evento/corte') ?>        