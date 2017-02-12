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