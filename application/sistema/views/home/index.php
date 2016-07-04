<!-- HOME -->
<?php
$place = explode(",", $evento->direccion);
$fecha_inicio = explode(" ",$evento->fecha_inicio);
$fecha_cierre = explode(" ",$evento->fecha_baja);
$hora_inicio  = substr($fecha_inicio[1],0,-3);
$hora_cierre  = substr($fecha_cierre[1],0,-3);
$fecha_inicio_array = explode("-", $fecha_inicio[0]);
$fecha_cierre_array = explode("-", $fecha_cierre[0]);
?>


<section id="home" class="half-screen"><!-- full-screen or half-screen (550px height) -->

	<div id="slider">

		<!-- slider navigation -->
		<nav class="slides-navigation">
			<a class="prev" href="#"></a>
			<a class="next" href="#"></a>
		</nav>

		<ul class="slides-container">

			<!-- Item 1 -->
			<li>
				<div class="image-caption">

					<div class="inner">


                        <h2 class="bigtext strtoupper nomargin"><?php echo $evento->nombre ?></h2>
                        <p><?php echo $evento->bajada ?></p>

                        <a class="btn btn-primary white nofill popup-video" href="https://www.youtube.com/watch?v=Oit4HoWH4b8"><i class="fa fa-play"></i> Ver video </a>
                        <a class="btn btn-primary red scrollTo" href="#registrese">Registrese Ahora</a>

                        <div class="event">
                            <div class="venue_date">
                                <span class="icon-calendar"></span>
                                <p>
                                <?php if($fecha_inicio[0]==$fecha_cierre[0]) { ?>
                                    <span class="day"><?php echo $fecha_inicio_array[2] ?></span>
                                    <span class="month"><?php echo strtoupper(getMes($fecha_inicio_array[1])) ?></span>
                                <?php } else { ?>
                                    <?php echo $fecha_inicio[0] ?><br />
                                    <?php echo $fecha_cierre[0] ?>
                                <?php } ?>
                                <br /><span><?php echo $hora_inicio.' a '.$hora_cierre.' hs.' ?></span>
                                </p>
                            </div>

                            <div class="venue_place">
                                <span class="icon-location"></span>
                                <p><?php echo $place[0] ?><br /><?php echo $evento->lugar ?></p>
                            </div>
                        </div>

					</div>

				</div>

			<!--	<span class="overlay"></span>-->
				<div style="background-image: url('<?php echo up_file('slider/'.$evento->id.'_0.jpg')?>');" class="fullscreen-img"></div>


			</li>
		</ul>

	</div>

</section>
<!-- /HOME -->