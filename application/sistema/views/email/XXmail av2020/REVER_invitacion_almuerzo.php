<?php

$table = "width:600px;
                 border: none;
                 border-collapse: collapse;
                 margin: 0 auto;
                 font-family: arial, verdana, sans-serif;
                 font-size: 14px; 
                 background: #F6F6F6; 
                 text-align: center; 
                 display:inline-block";
                 
$p = "font-size:12px; 
      color:#292C28; 
      margin: 10px;
      text-align: left;";
                       
$btn = "background: none repeat scroll 0 0 #62AF66;
        border: 2px solid #5f6464;
        color: #FFFFFF;
        display: inline-block;
        font-size: 14px;
        font-weight: bold;
        margin: 10px auto;
        padding: 10px;
        text-decoration: none;
        text-transform: uppercase;";
?>

<table width="600" cellpadding="0" cellspacing="0" style="<?php echo $table ?>">
	<tr>
		<td><?php echo image_asset('site/almuerzo_header.jpg', '','') ?></td>
	</tr>
	<tr>
        <td colspan="3">
            <p style="<?php echo $p ?>"><?php echo $user_info->nombre.' '.$user_info->apellido ?><br />
             Desde la organización del <b>Tercer Encuentro de Reflexión "Argentina Visión 2020"</b>, queremos acercarle la oportunidad de participar del <b>almuerzo de networking</b>. Creemos que es una excelente oportunidad para interactuar con dueños, directores generales y decisores de las principales empresas del país, que estarán participando del encuentro. <br/> El almuerzo se realizará a partir de las <b>13:15 hs</b>, al finalizar la jornada. <br/> Para inscribirse es necesario simplemente ingresar al link que figura a continuación, y realizar el pago correspondiente. El costo del mismo es de $180.</p>
        </td>
    </tr>    
    <tr>
	    <td colspan="3"> <a href="<?php echo lang_url('evento/almuerzo/'.$user_info->salt) ?>" style="<?php echo $btn ?>">Participar del Almuerzo</a></td>
    </tr>
    <tr>
        <td colspan="3">
            <p style="<?php echo $p ?>">Cualquier duda o consulta podrá contactarse con mester@bisblick.org o jpcarrera@adblickagro.com<br/>ACLARACIÓN: Por motivos de organización, es requisito realizar la inscripción y el pago previamente al evento, hasta el lunes 15 de junio.<br/>Muchas gracias</p>
        </td>
    </tr>
    
  
    </table>