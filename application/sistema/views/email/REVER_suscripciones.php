<?php
$fecha_inicio = explode(" ",$evento->fecha_inicio);
$fecha_cierre = explode(" ",$evento->fecha_baja);
$hora_inicio  = substr($fecha_inicio[1],0,-3);
$hora_cierre  = substr($fecha_cierre[1],0,-3);
$fecha_inicio_array = explode("-", $fecha_inicio[0]); 
$fecha_cierre_array = explode("-", $fecha_cierre[0]);
?>
<table width="580" cellpadding="0" cellspacing="0" style="width:580px; border: none; border-collapse: collapse; margin: 0 auto; font-family: arial, verdana, sans-serif; font-size: 14px; text-align: left; margin: 0 auto">
    <tr>
        <td  style="text-align: center; padding: 10px" colspan="3">
            <p style="text-transform: uppercase; color: #ce5c5f; font-size: 15px;">¡Gracias <?php echo $user['nombre'].' '. $user['apellido'] ?>!</p>
            <p>Ya estás inscripto al próximo desayuno de AMDIA</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 10px 0; border-top: 2px solid #ebebeb; border-bottom: 2px solid #ebebeb" colspan="3">
            <p style="text-transform: uppercase; text-align: center; color: #ce5c5f; font-size: 34px; font-weight: bold; margin: 0"><?php echo $evento->nombre ?><br /><?php echo $evento->bajada ?></p>
        </td>
    </tr>
    <tr style="border-bottom: 2px solid #ebebeb;">
        <td style="width: 33%;">
            <?php if($fecha_inicio[0] == $fecha_cierre[0]) { ?>
            <p style="margin: 0; text-align: center; color: #444242; font-size: 30px;"><span style="font-weight: bold; font-size: 58px"><?php echo $fecha_inicio_array[2] ?></span><br /><?php echo strtoupper(getMes($fecha_inicio_array[1])) ?></p>
            <?php } ?>
        </td>
        <td style="width: 33%;">
            <table style="width: 80%; border-left: 2px solid #ebebeb; border-right: 2px solid #ebebeb; margin: 0 auto; padding:0 10%; color: #444242; font-size: 12px;">
                <tr>
                    <td style="border-bottom: 2px solid #ebebeb; padding: 10px 0; "><b>Desde</b> <?php echo $hora_inicio ?>Hs.</td>
                </tr>
                <tr>
                    <td style="padding: 10px 0;"><b>Hasta</b> <?php echo $hora_cierre?>Hs.</td>
                </tr>
            </table>
        </td>
        <td style="width: 33%; text-align: center;">
            <p style="font-weight: bold; margin: 0;"><?php echo $evento->lugar ?></p>
            <p style="margin: 0;"><?php echo $evento->direccion ?></p>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding: 20px 0;"></td>
    </tr>
</table>