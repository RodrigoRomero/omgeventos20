<?php

$table = "width:650px;
          border: none;
          border-collapse: collapse;
          margin: 0 auto;
          font-family: arial, verdana, sans-serif;
          font-size: 14px; 
          background: #f6f6f6; 
          text-align: center; 
          color: #292C28";
          
$template_header = "background-color:  #444242;
	                color: #292C28;
	                -webkit-border-top-left-radius:6px !important;
	                -webkit-border-top-right-radius:6px !important;
	                border-top-left-radius:6px !important;
	                border-top-right-radius:6px !important;
	                border-bottom: 0;
	                font-family:Arial;
	                font-weight:bold;
	                line-height:100%;
	                vertical-align:middle;
                    padding: 20px 0;";
                             
$template_body = "padding: 15px 0;"; 
$inner_table = "text-align: left;
                width:650px;               
                border-collapse: collapse;
                margin: 20px auto;";       
?>

<table width="650" cellpadding="0" cellspacing="0" style="<?php echo $table ?>">
    <tr>
        <td style="<?php echo $template_header ?>"></td>
    </tr>
    <tr>       
        <td style="<?php echo $template_body ?>"><?php echo $body ?></td>
    </tr>   
    <tr>
        <td style="text-align: center; padding: 10px 0;">
            <p style="display: inline-block; vertical-align: middle; margin: 0 10px 0 0; font-size:12px; color:#292C28;">PLATAFORMA DE EVENTOS</p>
            <a href="http://www.orsonia.com.ar/omg_eventos" style="display: inline-block; vertical-align: middle;">
                <?php echo up_asset('logo_mail.png', array('style'=>'display: inline-block; vertical-align: middle;')) ?>
            </a>
        </td>
    </tr>
</table>