<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?php $this->view('layout/head.php')?>
    </head>
    <body id="multi-page"> 
     <script>
                
   
  window.fbAsyncInit = function() {    
    FB.init({
      appId      : '184093205310557',
      xfbml      : true,
      cookie     : true,
      version    : 'v2.5',
      status     : true,   // check FB login status
    });
  };

  (function(d, s, id){    
     var js, fjs = d.getElementsByTagName(s)[0];     
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
    <!-- Google Analytics -->
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
    ga('create', 'UA-54622937-1', 'auto');  // Replace with your property ID.
    ga('send', 'pageview');
    
    </script>
    <!-- End Google Analytics -->
    <script type="text/javascript" src="https://www.mercadopago.com/org-img/jsapi/mptools/buttons/render.js"></script>    
	
    
    
    <div class="alert alert-success">
      <button type="button" class="close" <a href="#" class="close" data-dismiss="alert">&times;</a>
    </button>
            Este sitio esta optimizado para ser visualizado en Chrome. No se garantiza el correcto funcionamiento en Internet Explorer o Safari.

    </div>
    
    
    
    
    <div class="inner-cover blog-header" style="background-image:url('<?php echo up_file('slider/1_0.jpg')?>')">
    
    
    
    			
    	<div class="container text-center">
    		<!-- <h1 class="big-title">Argentina Vision 2020</h1>				-->
    	</div>
	</div>
	<?php 
    echo $menu_top; 
    echo $module;
    echo $footer 
    ?>
<?php

#JS
foreach ($js_layout as $js) {
    echo js_asset($js.'.js');
}

#WIDGETS
foreach($widgets as $folder => $v){
    $widgetFolder = $folder;
    foreach ($v as $type => $file){        
        if($type=='css'){
            if(is_array($file)){
                foreach ($file as $f){
                    echo css_asset($type.'/'.$f.'.'.$type,'../widgets/'.$widgetFolder);
                }
                
            } else {
                echo css_asset($type.'/'.$file.'.'.$type,'../widgets/'.$widgetFolder);
            }
            
        } elseif ($type=='js'){
            if(is_array($file)){
                foreach ($file as $f){
                    echo js_asset($type.'/'.$f.'.'.$type,'../widgets/'.$widgetFolder);
                }
            } else {
                echo js_asset($type.'/'.$file.'.'.$type,'../widgets/'.$widgetFolder);
            }
        } else {
            show_error('formato no valido',500,'Problema al parsear Widget');
        }
    }
}
?>
	</body>
</html>