<?php $json = json_decode($json); ?>
<table>
    <tr>
        <td>Empresa</td>
        <td><?php echo $json->empresa ?></td>
    </tr>
    <tr>
        <td>Nombre y Apellido</td>
        <td><?php echo $json->nombre.' '.$json->apellido ?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?php echo $json->email ?></td>
    </tr>
    <tr>
        <td>Teléfono</td>
        <td><?php echo $json->telefono ?></td>
    </tr>
    <tr>
        <td colspan="2">Mensaje:<br /><?php echo $json->mensaje ?></td>
    </tr>
    <tr>
        
    </tr>
</table>