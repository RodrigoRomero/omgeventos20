<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <?php $this->view('layout/head')?>
        <link rel="shortcut icon" href="<?php echo image_asset_url('favicon.ico')?>" type="image/x-icon"/>
        <link rel="apple-touch-icon" href="<?php echo image_asset_url('favicon.ico')?>" />
	</head>
	<body id="site" style="background: none repeat scroll 0 0 #EDEDED;">
        <script type="text/javascript" src="https://www.mercadopago.com/org-img/jsapi/mptools/buttons/render.js"></script>
        <div id='fb-root'></div>
        <script src='http://connect.facebook.net/es_LA/all.js'></script>
        <?php 
        $this->view('layout/header', array('show_menu'=>false));
        echo $module; 
          $this->view('layout/footer');
          ?>
          
	</body>
</html>