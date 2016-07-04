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

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50805014-1', 'auto');
  ga('send', 'pageview');

</script>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '416224331877519');
fbq('track', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=416224331877519&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<link rel="shortcut icon" href="<?php echo image_asset_url('favicon.ico')?>" type="image/x-icon"/>
<link rel="apple-touch-icon" href="<?php echo image_asset_url('favicon.ico')?>" />
<meta property="og:locale" content="es_ES" />
<meta property="og:type" content="website" />
<meta property="og:url" content="http://argentinavision2020.com/2016/" />
<meta property="og:site_name" content="Argentina Visión 2020" />
<meta property="og:title" content="Argentina Visión 2020, Agronegocios motor de desarrollo y disrupciones que vienen" />
<meta property="og:description" content="Inscribite al 4º encuentro de reflexión, Argentina Visión 2020" />
<meta property="og:image" content="http://argentinavision2020.com/2016/assets/img/site/share_link_fb.jpg" />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="627" />