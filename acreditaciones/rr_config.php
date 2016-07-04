<?php
$local =  ($_SERVER['SERVER_NAME']=="localhost") ? true : false;
define ('RR_ENCRYPTION_KEY', md5('rrKey'));
define("RR_PREF", "rr_");
//define('ENVIRONMENT', ($local) ? 'development' : 'production');