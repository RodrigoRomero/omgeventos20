<!-- Main Nav -->
<header id="header">

	<nav class="navbar navbar-inverse" role="navigation"><!-- add "wihite" class for white nav bar -->
		<div class="container">

			<!-- Mobile Menu Button -->
			<button id="mobileMenu" class="fa fa-bars" type="button" data-toggle="collapse" data-target=".navbar-collapse"></button>

			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<a class="navbar-brand scrollTo" href="#home">
					<?php // echo image_asset('site/logo.png', '', array('alt'=>$title_page, 'title'=>$title_page, 'width'=>50, 'height'=>50)) ?>
					<!--
						Span class:
							- dark
							- white
							- styleColor (if you select "green" style color, the color will be green).

							You can combine them 
							Example:
								<span class="white">ISIS</span><span class="styleColor">ONE</span>
					-->
					<span class=""><?php echo $title_page ?></span>
				</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

				<!-- Fullscreen Button - Unavailable for IE -->
				<a href="#" class="btn-fullscreen"><i class="fa fa-external-link"></i></a>

				<ul class="nav navbar-nav navbar-right">					
					<li><a href="#agenda" class="scrollTo">Agenda</a></li>
					<li><a href="#registrese" class="scrollTo">Registrese</a></li>
					<li><a href="#lugar" class="scrollTo">Lugar</a></li>
					<li><a href="#bisblick" class="scrollTo">Bisblick</a></li>
					<li><a href="#galeria" class="scrollTo">Galería</a></li>
					<li><a href="#sponsor" class="scrollTo">Sponsors</a></li>
				</ul>
			</div><!-- /.navbar-collapse -->

		</div>
	</nav>

</header>
<!-- /Main Nav -->  