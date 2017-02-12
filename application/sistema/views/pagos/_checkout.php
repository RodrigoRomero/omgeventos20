<section id="checkout">
    <div class="container">        
        <div class="row">
            <div class="span12">
                <div id="checkoutBox">
                    <?php foreach ($cart_data as $key => $row) {?>
                        <div class="row-fluid">
                        <div class="span5">
                        <h3><?php echo $row['options']['nombre'].' '.$row['options']['apellido'] ?></h3>
                        <p class="email"><?php echo $row['options']['email'] ?></p>
                        </div>
                        <div class="span4">
                            <p class="entranceFee">Valor de la entrada <span>$ <?php echo $row['price'] ?></span></p>
                        </div>
                        <div class="span3">
                            
                        </div>
                    </div>
                    <?php } ?>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="span12">
                <a class="ax-modal pull-right paybutton simple_btn" href="<?php echo lang_url('pagos/confirm/'.$security)?>">PAGAR AHORA</a>
            </div>
        </div>
    </div>
</section>