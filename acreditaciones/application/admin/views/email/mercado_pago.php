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
        <td colspan="3">
            <p style="<?php echo $p ?>"><?php echo $user_info->nombre.' '.$user_info->apellido ?><br/>
            
            Gracias por su inscripción al  Tercer Encuentro de Reflexión “Argentina Visión 2020” que se realizará el 18/6 en el Auditorio del IAE Business School en Pilar.<br /><br />

Queremos comunicarle que el evento es a total beneficio de la Fundación BisBlick que otorga becas de estudio a jóvenes de alto potencial bajos recursos económicos que desean terminar sus estudios superiores. Es por este motivo que, adquiriendo su entrada, usted está ayudando directamente a que más chicos puedan cumplir su sueño apostando a la educación como herramienta de cambio.<br /><br />

Usted puede abonar su ingreso a través del link que aparece más abajo. <br /><br />

Ante cualquier consulta quedo a su disposición. Desde ya le agradecemos mucho su colaboración.<br/>
María Maestre<br/>
mester@bisblick.org <br/>
Responsable administrativa
            </p> 
            
            <a href="http://www.argentinavision2020.com/2015/payments/latecheckout/<?php echo $user_info->salt ?>" style="<?php echo $btn ?>">Realizar Contribución</a><br/>
            <p style="<?php echo $p ?>"></p>
        </td>
    </tr>
    

    

</table>




