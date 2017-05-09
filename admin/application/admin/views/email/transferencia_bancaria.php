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
            <p style="<?php echo $p ?>"><?php echo $customer->nombre.' '.$customer->apellido ?><br />
            Usted ha solicitado el cambio de medio de pago para abonar las entradas al evento <?php echo $evento->nombre ?> a llevarse a cabo el día  <?php echo $fecha_inicio_array[2] ?> de <?php echo strtoupper(getMes($fecha_inicio_array[1])) ?>.<br />
Si usted no solicitó el cambio de medio de pago, deje sin efecto este aviso.<br /><br />

Los datos para la transferencia bancaria son:<br />

            Cta.Cte. Número: 0543/02000174/75<br />
            Banco: ICBC - Florida 99 – Casa Central<br />
            Titular: Asociación de Marketing Directo e Interactivo de Argentina<br />
            CBU: 01505436-02000000174756<br />
            CUIT: 33-63225747-9<br /><br />
            Agradecemos enviar el comprobante de transferencia a Jessica Meccia <a href="mailto:soporte@amdia.org.ar">soporte@amdia.org.ar</a> para mayor certeza<br />
            Muchas gracias.</p>
        </td>
    </tr>
</table>