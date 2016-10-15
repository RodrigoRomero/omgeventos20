<?php
$switchONOFF = ($acreditado->acreditado) ? 'switchON' : 'switchOFF';
?>
 <section id="content" class="container">
            <div id="userDetail">
                <!-- head content -->
                <?php /*
                <div id="headContent">
                    <figure class="avatar">
                        <img src="assets/img/avatar.png" alt="">
                    </figure>
                </div>
                */ ?>
                <!-- user info -->
                <ul class="userInfo">
                    <li><?php echo $acreditado->nombre.' '.$acreditado->apellido?></li>
                    <li><?php echo $acreditado->email ?></li>
                    <li>Tipo de entrada: <?php echo $acreditado->ticket_nombre ?></li>
                    <li>Código de barras: <?php echo $acreditado->barcode ?></li>
                </ul>
            </div>

            <div class="line"></div>

            <div class="row">
                <div class="col-xs-9 col-sm-9 col-md-10">
                    <h3 class="bajada">Estado de acreditación</h3>
                </div>
                <div class="switch col-xs-3 col-sm-3 col-md-2 text-right">
                    <a href="javascript:void(0)" class="<?php echo $switchONOFF ?>" onClick="return false"  data-link="<?php echo lang_url('acreditar/alta/id/'.$acreditado->id)?>"></a>
                </div>
            </div>

            <div class="line"></div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <a href="<?php echo lang_url() ?>" class="btnONE">Volver</a>
            </div>

        </section>