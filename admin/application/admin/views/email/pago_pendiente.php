<?php

$fecha_inicio = explode(" ",$evento->fecha_inicio);

$fecha_cierre = explode(" ",$evento->fecha_baja);

$hora_inicio  = substr($fecha_inicio[1],0,-3);

$hora_cierre  = substr($fecha_cierre[1],0,-3);

$fecha_inicio_array = explode("-", $fecha_inicio[0]); 

$fecha_cierre_array = explode("-", $fecha_cierre[0]);





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

        <td colspan="3">

            <p style="<?php echo $p ?>"><?php echo $user_info->nombre.' '.$user_info->apellido ?><br />

            Su pago se encuentra pendiente, si ya lo ha realizado por favor contactese con bla bla bla</p>
        </td>

    </tr>

</table>