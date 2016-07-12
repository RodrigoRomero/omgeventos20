<section id="registrese" class="">
    <div class="container">
        <?php if($evento->show_register) { ?>
            <header class="text-center">
                <h1>SELECCIONÁ TU ENTRADA</h1>
            </header>
            <article>
                <?php

                $this->view('forms/tickets', array('evento' =>$evento, 'planes'=>$planes)); ?>
            </article>
        <?php } else { ?>
            <header class="text-center">
                <h1>INSCRIPCIÓN FINALIZADA</h1>
            </header>
            <article>
                <p class="text-center">La inscripción esta cerrada.<br />
                Si desea hacer alguna consulta puede enviar un email <br />
                <?php echo safe_mailto("soporte@amdia.org.ar", "Contacto", array('class'=>'btn btn-primary red')); ?><br/><br/>
                </p>
            </article>
        <?php } ?>

    </div>
</section>


<?php /*
<section id="registrese" class="">
    <div class="container">
        <?php if($evento->show_register) { ?>
            <header class="text-center">
                <h1>REGISTRATE</h1>
            </header>
            <article>
            <div
  class="fb-like"
  data-share="true"
  data-width="450"
  data-show-faces="true">
</div>


                <a href="javascript:void(0)" onClick="logInWithFacebook()" class="btn btn-primary red">FACEBOOK</a>


                <?php  $this->view('forms/registro', array('evento' =>$evento, 'planes'=>$planes)); ?>
            </article>
        <?php } else { ?>
            <header class="text-center">
                <h1>INSCRIPCIÓN FINALIZADA</h1>
            </header>
            <article>
                <p class="text-center">Lamentablemente dada la capacidad física del lugar los cupos están agotados.<br />
                Si lo desea puede inscribirse en lista de espera para el caso de que se vuelva a abrir la inscripción.<br />
                <?php echo safe_mailto("aportes@bisblick.com", "Ingrese en lista de Espera", array('class'=>'btn btn-primary red')); ?><br/><br/>

                </p>
            </article>
        <?php } ?>

    </div>
</section>
<?php //echo $this->view('evento/corte') ?>
*/ ?>