<table width="600" cellpadding="0" cellspacing="0" style="width:600px; border: none; border-collapse: collapse; margin: 0 auto; font-family: arial, verdana, sans-serif; font-size: 14px; background: #ededed; text-align: center; display:inline-block">
    <tr>
        <td style="padding: 20px 0;">Estimado <span style="font-weight:bold; font-size:18px; color:#de7711; margin: 10px 0;"><?php echo $data_mail->nombre.' '.$data_mail->apellido ?></span></td>
    </tr>
    <tr>
        <td style="padding: 20px 0;">Este mail confirma su inscripción definitiva para el 1º Evento de Reflexión: Argentina Visión 2020. Agronegocios como motor de desarrollo.<br />
Recuerde traer el código de barras que figura aquí abajo para agilizar su ingreso. Puede traerlo en su celular.<br />
        La próxima semana podrá adquirir el bono contribución on-line y así agilizar su acreditación y acceso al Salón Auditorio.<br />

Desde ADBlick Agro, El IAE Business School y el CEAg, de la Universidad Austral queremos agradecer su interés.
        </td>
    </tr>
    <tr>
        <td style="text-align: center;"><?php echo up_asset('barcodes/'.$data_mail->barcode.'.png', array('style'=>'border: 3px solid #969596; padding: 5px')) ?></td>
    </tr>
    <tr>
        <td style="padding: 20px 0;"><?php echo image_asset('site/evento_mail.png', '','') ?></td>
    </tr>
    
</table>