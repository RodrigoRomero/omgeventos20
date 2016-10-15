<!-- LUGAR -->
<?php
$direccion = explode(",",$evento->direccion);
$lat_lng = json_decode($evento->json_direccion); 
?>
<section id="lugar" class="arrow-down">
    <div class="container">
        <header class="text-center">            
            <h1>LUGAr</h1>
            <div class="divider"><!-- lines divider --></div>
        </header>
    </div>
    <section id="googleMap" class="noindicator nomargin nopadding">
			<div class="container">
				<address class="animate_fade_in" id="address_box">
					<strong class="font-dosis fsize20"><?php echo $evento->lugar ?></strong>
					<ul>
						<li class="address-sprite address">
							<?php echo $lat_lng->place ?><br />
							<?php echo (!empty($lat_lng->postal_code))  ? $lat_lng->postal_code.', '.$lat_lng->region : $lat_lng->region ?><br />
						</li>
						<li class="address-sprite phone"><?php echo $evento->telefono ?></li>
					</ul>
				</address>
			</div>
            
			<div id="gmap"  data-lat="<?php echo !empty($lat_lng->lat) ? $lat_lng->lat : "-34.6073283"  ?>" data-lng="<?php echo !empty($lat_lng->lng) ? $lat_lng->lng : "-58.4486622" ?>"></div>
		</section>
</section>
<!-- /LUGAR --> 
<?php #echo $this->view('evento/corte') ?>