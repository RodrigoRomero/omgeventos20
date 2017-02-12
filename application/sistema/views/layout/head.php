<?php
$metas = array(
    array('name' => 'description', 'content' =>$description),
    array('name' => 'keywords', 'content' => $keywords),
);
echo "<title>$title_page</title>\n";
echo meta($metas);
?>
<!-- GOOGLE FONTS -->
<link href="https://fonts.googleapis.com/css?family=Asap:400,700,700italic,400italic|Open+Sans:300,400,700,800|Dosis:300,400" rel="stylesheet" type="text/css" />
<?php
#CSS
foreach ($css_layout as $css) {
    echo css_asset($css.'.css');
}
?>
<script>
_base_url = "<?php echo config_item('base_url')?>"
</script>
<link rel="shortcut icon" href="<?php echo image_asset_url('http://amdia.org.ar/eventos/assets/img/favicon.ico')?>" type="image/x-icon"/>
<link rel="apple-touch-icon" href="<?php echo image_asset_url('favicon.ico')?>" />

<meta property="og:locale" content="es_ES" />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://amdia.omgeventos.com.ar/" />
<meta property="og:site_name" content="amdia eventos" />
<meta property="og:title" content="Sitio de eventos amdia" />
<meta property="og:description" content="Inscribite a todos los eventos de amdia" />
<meta property="og:image" content="http://amdia.omgeventos.com.ar/assets/img/site/shared_link_fb.jpg" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="627" />