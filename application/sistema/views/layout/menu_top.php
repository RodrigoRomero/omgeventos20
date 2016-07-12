<?php if($layout=='one_page') { ?>
<!-- Main Nav -->
<header id="header">

	<nav class="navbar navbar-inverse" role="navigation"><!-- add "wihite" class for white nav bar -->
		<div class="container">

			<!-- Mobile Menu Button -->
			<button id="mobileMenu" class="fa fa-bars" type="button" data-toggle="collapse" data-target=".navbar-collapse"></button>

			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<a class="navbar-brand scrollTo" href="#home">
					<?php // echo image_asset('site/logo.png', '', array('alt'=>$evento->nombre, 'title'=>$evento->nombre, 'width'=>50, 'height'=>50)) ?>
					<!--
						Span class:
							- dark
							- white
							- styleColor (if you select "green" style color, the color will be green).

							You can combine them
							Example:
								<span class="white">ISIS</span><span class="styleColor">ONE</span>
					-->
					<span class="fa fa-home"><?php // echo $evento->nombre ?></span>
				</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

				<!-- Fullscreen Button - Unavailable for IE -->
				<a href="#" class="btn-fullscreen"><i class="fa fa-external-link"></i></a>

				<ul class="nav navbar-nav navbar-right">
					<li><a href="#agenda" class="scrollTo">Agenda</a></li>
					<li><a href="#oradores" class="scrollTo">Oradores</a></li>
					<li><a href="#sponsor" class="scrollTo">Sponsors</a></li>
                    <li><a href="#bisblick" class="scrollTo">amdia</a></li>
					<li><a href="#registrese" class="scrollTo">Registrese</a></li>
					<li><a href="#lugar" class="scrollTo">Lugar</a></li>

					<!--<li><a href="#galeria" class="scrollTo">Galería</a></li>-->

				</ul>
			</div><!-- /.navbar-collapse -->

		</div>
	</nav>

</header>
<!-- /Main Nav -->

<?php } elseif($layout=='multi_page'){ ?>
		<!-- Main Nav -->
		<header id="header">

			<nav class="navbar navbar-inverse" role="navigation"><!-- add "wihite" class for white nav bar -->
				<div class="container">

					<!-- Mobile Menu Button -->
					<button id="mobileMenu" class="fa fa-bars" type="button" data-toggle="collapse" data-target=".navbar-collapse"></button>

					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<a class="navbar-brand" href="<?php echo lang_url() ?>">
							<span class="fa fa-home"><?php //echo $evento->nombre ?></span>
						</a>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

						<!-- Fullscreen Button - Unavailable for IE -->
						<a href="#" class="btn-fullscreen"><i class="fa fa-external-link"></i></a>

						<ul class="nav navbar-nav navbar-right">
							<li><a href="<?php echo lang_url() ?>#agenda" >Agenda</a></li>
                           <!-- <li><a href="<?php echo lang_url() ?>#bisblick">Cena</a></li> -->
        					<li><a href="<?php echo lang_url() ?>#registrese">Registrese</a></li>
        					<li><a href="<?php echo lang_url() ?>#lugar" >Lugar</a></li>
        					<li><a href="<?php echo lang_url() ?>#oradores" >Oradores</a></li>
        					<li><a href="<?php echo lang_url() ?>#galeria" >Galería</a></li>
        					<li><a href="<?php echo lang_url() ?>#sponsor">Sponsors</a></li>
						</ul>
					</div><!-- /.navbar-collapse -->

				</div>
			</nav>

		</header>
		<!-- /Main Nav -->
<?php } ?>