<table width="600" cellpadding="0" cellspacing="0" style="width:600px; border: none; border-collapse: collapse; margin: 0 auto; font-family: arial, verdana, sans-serif; font-size: 14px; background: #ededed; text-align: center; display:inline-block">
    <tr>
        <td style="padding: 20px 0;">Estimado <span style="font-weight:bold; font-size:18px; color:#de7711; margin: 10px 0;"><?php echo $data_mail->nombre.' '.$data_mail->apellido ?></span></td>
    </tr>
    <tr>
        <td style="padding: 20px 0;">Lo esperamos el <span style="font-weight: bold;">miércoles 26 de Junio a partir de las 8:00 hs</span> en el primer encuentro de reflexión Argentina Visión 2020.<br />

Le recordamos que si todavía no contribuyó con la fundación, podrá realizar su donación on-line a beneficio de BISBlick Compromiso Social con el siguiente link. De esta manera agilizará su acreditación y acceso al Salón Auditorio en las primeras filas.
        </td>
    </tr>   
    <tr>
        <td style="padding: 20px 0; border-top: 1px solid #cccccc; border-bottom: 1px solid #cccccc;"> 
        <a href="<?php echo lang_url('donaciones/colabora-con-nosotros/'.$data_mail->salt)?>" title="Donación Bisblick">
            <?php echo image_asset('site/btn_donar.jpg', '',array('style'=>'width:182px', 'alt'=>'Donación Bisblick', 'title'=>'Donación Bisblick')); ?>
        </a>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px 0;"><span style="font-weight:bold; font-size:18px; color:#de7711;">¿COMO LLEGAR?<br />
Acceso y estacionamiento</span>
        </td>
    </tr>
    <tr>
        <td> 
        <a href="http://bit.ly/1a816jG" title="Como Llegar - Click sobre el mapa para ampliar">
            <?php echo image_asset('site/mapa_evento.jpg', '',array('style'=>'width:378px', 'alt'=>'Como Llegar - Click sobre el mapa para ampliar', 'title'=>'Como Llegar - Click sobre el mapa para ampliar')); ?>
        </a>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px 0;">
Los lugares dentro del auditorio principal son limitados por lo que rogamos ser puntuales.
Es importante contar con el siguiente código de barras ya sea en forma digital o impresa para acceder rápidamente. Todas las personas que accedan al evento deben estar pre-inscriptas.<br /><br />

Desde ADBlick Agro, El IAE Business School y el CEAg, de la Universidad Austral queremos agradecer su interés.
        </td>
    </tr>    
    
    <tr>
        <td style="text-align: center;"><?php echo up_asset('barcodes/'.$data_mail->barcode.'.png', array('style'=>'border: 3px solid #969596; padding: 5px')) ?></td>
    </tr>
</table>
