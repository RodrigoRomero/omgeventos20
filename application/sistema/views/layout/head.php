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

<link rel="shortcut icon" href="<?php echo image_asset_url('favicon.ico')?>" type="image/x-icon"/>
<link rel="apple-touch-icon" href="<?php echo image_asset_url('favicon.ico')?>" />
<meta property="og:locale" content="es_ES" />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://bghtechpartner.omgeventos.com.ar/" />
<meta property="og:site_name" content="BGH Tech Partner" />
<meta property="og:title" content="BGH Tech Partner - Inspire Forum" />
<meta property="og:description" content="Inscribite al BGH Tech Partner Inspire Forum" />
<meta property="og:image" content="http://bghtechpartner.omgeventos.com.ar/assets/img/site/shared_link_fb.jpg" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="627" />

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-77225141-1', 'auto');
  ga('send', 'pageview');

</script>