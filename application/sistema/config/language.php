<?php
/**
 * @author Rodrigo Romero
 * @version 1.0.0
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $langs = array('sp', 'en');
    $host_lang     = explode("/", $_SERVER["QUERY_STRING"]);
   
    $host_lang     = array_values(array_diff($host_lang, array('')));
    $language_show = (count($host_lang)>0) ? true : false;
    $host_lang     = (count($host_lang)>0) ? $host_lang[0] : $langs[0];

    if (in_array($host_lang, $langs)){
        $config['language']      = $host_lang;
        $config['language_show'] = $language_show;
    }else{
        $config['language']      = $langs[0];
        $config['language_show'] = false;
    }
    $config['languages']    = $langs;