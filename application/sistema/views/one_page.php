<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?php $this->view('layout/head.php')?>
    </head>
    <body>
      <script>
                
   
  window.fbAsyncInit = function() {    
    FB.init({
      appId      : '1297715346922201',
      xfbml      : true,
      cookie     : true,
      version    : 'v2.5',
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
    
    <div class="alert alert-success">
      <button type="button" class="close" <a href="#" class="close" data-dismiss="alert">&times;</a>
    </button>
      Este sitio esta optimizado para ser visualizado en Chrome. No se garantiza el correcto funcionamiento en Internet Explorer y Safari.
    </div>
        <script type="text/javascript" src="https://www.mercadopago.com/org-img/jsapi/mptools/buttons/render.js"></script> 
        <?php
        
        echo $module['home'];
        echo $menu_top;
        $this->view('evento/home');
        echo $module['agenda'];
        echo $module['bisblick'];
        echo $module['registro'];
        echo $module['lugar'];        
        echo $module['oradores'];
        echo $module['galeria'];       
        echo $module['sponsor'];
        
        echo $footer;
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