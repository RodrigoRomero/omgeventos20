<!-- BLOG -->
<section id="blog" class="alternate">
    <article class="container">
        <header class="text-center">           
            <h1> de Networking</h1>           
        </header>   
    <div class="divider"><!-- lines divider --></div>
    <div class="col-md-4">
        <?php echo image_asset('site/header_almuerzo.jpg', '', array('class'=>'img-responsive')) ?>
    </div>
    <div class="col-md-6">
    <h2 class="text"><?php echo $user_info->nombre.' '.$user_info->apellido ?></h2>
    <p>El objetivo del almuerzo de networking es generar un espacio de relacionamiento para los asistentes al evento, aprovechando que se encontrarán presentes los directivos y decisores de las principales compañías del país.<br/><br/>
Para confirmar tu inscripción simplemente es necesario efectuar el pago correspondiente.<br/>
Te esperamos el <b>18 de junio a las 8:00 hs en el IAE</b> para compartir la jornada de reflexión y el posterior almuerzo.<br/>
Por consultas podrás contactarte con <?php echo safe_mailto('mester@bisblick.org', 'mester@bisblick.org') ?>  o <?php echo safe_mailto('jpcarrera@adblickagro.com', 'jpcarrera@adblickagro.com') ?>.<br/>
Muchas gracias.</p>
    <?php 
    $data   = array ('id'=>'registroForm', 'class'=>'form relative');
    $action = lang_url('payments/almuerzo/'.$user_info->salt);
    echo form_open($action,$data);
    echo '<div class="col-md-12 text-center">';
    $data = array('type'=>'submit', 'value'=>'PARTICIPAR DEL ALMUERZO', 'class'=>'btn btn-primary green fsize20', 'id'=>'contact_submit', 'onclick'=>"validateForm('registroForm')");
    echo form_input($data);
    echo '</div>'; 
    echo form_hidden('plan',180);
    echo form_hidden('medio_pago','mercado_pago');
    echo form_hidden('salt',$user_info->salt);
    echo form_close(); 
    ?>
</div>
    </article>
</section>
<!-- /BLOG -->