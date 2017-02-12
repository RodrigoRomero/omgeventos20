<section id="donaciones">
    <div class="bs_titles">
        <div>
             <figure>
                    <i class="f-icon-pencil_font"></i>
                </figure>
                
         </div>
    </div>
    
    <div class="container">
        <div class="row-fluid">
            <div class="span12" style="text-align: center;">
                
                <h3><?php echo $user->nombre.' '.$user->apellido ?></h3>
                
                <p class="txt">
                <span>Su acreditación para el evento Argentina Visión 2020 ha sido aprobada.</span><br />
                Seleccione el monto que desea donar a beneficio de <b>BisBlick Compromiso Social</b><br /> 
                (Programa de becas para jóvenes de sectores vulnerables que hayan terminado su estudio secundario y quieran continuar su formación)
                
                </p>
            </div>
        </div>
        <div id="pricing" class="row-fluid">        
            <div class="span4">
                <?php                
                $attributes = array('id' => 'donaFormBronce');                
                echo form_open('donaciones/checkout',$attributes); 
                ?>
                <div class="price_wrapper bronce">
                    <div class="header">
                        <?php echo image_asset('site/bronce.png') ?>
                    </div>
                    <div class="section">
                        <div class="price">
                        <span>
                            <i>$</i>
                            <?php
                            $data = array('type'=>'text', 'name'=>'donar', 'value'=>150, 'readonly'=>true);
                            echo form_input($data);
                            ?>
                        </span>
                        </div>
                        <?php
                        $data = array('type'=>'submit', 'id'=>'jSubmitInputBronce', 'onclick'=>'validateForm(\'donaFormBronce\')', 'value'=>'donar ahora');
                        echo form_input($data);
                        ?> 
                        <div class="progress progress-striped active" style="display: none;" id="progress_donaFormBronce">
                            <div class="bar" style="width: 100%;">Procesando formulario...</div>
                        </div> 
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="span4">
                <?php                
                $attributes = array('id' => 'donaFormPlata');                
                echo form_open('donaciones/checkout',$attributes); 
                ?>
                <div class="price_wrapper plata">
                    <div class="header">
                        <?php echo image_asset('site/plata.png') ?>
                    </div>
                    <div class="section">
                        <div class="price">
                        <span>
                            <i>$</i>
                            <?php
                            $data = array('type'=>'text', 'name'=>'donar', 'value'=>300, 'readonly'=>true);
                            echo form_input($data);
                            ?>
                        </span>
                        <br />
                        * Incluye regalo Bodegas Trapiche
                        </div>
                        <?php
                        $data = array('type'=>'submit', 'id'=>'jSubmitInputPlata', 'onclick'=>'validateForm(\'donaFormPlata\')', 'value'=>'donar ahora');
                        echo form_input($data);
                        ?>
                        <div class="progress progress-striped active" style="display: none;" id="progress_donaFormPlata">
                            <div class="bar" style="width: 100%;">Procesando formulario...</div>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
            <div class="span4">
                <?php                
                $attributes = array('id' => 'donaFormOro');                
                echo form_open('donaciones/checkout',$attributes); 
                ?>
                <div class="price_wrapper oro">
                    <div class="header">
                        <?php echo image_asset('site/oro.png') ?>
                    </div>
                    <div class="section">
                        <div class="price">
                        <span>
                            <i>$</i>
                            <?php
                            $data = array('type'=>'text', 'name'=>'donar');
                            echo form_input($data);
                            ?>  
                        </span>
                        <br />
                        ESPECIFIQUE EL MONTO QUE DESEA DONAR
                        </div>
                        <?php
                        $data = array('type'=>'submit', 'id'=>'jSubmitInputOro', 'onclick'=>'validateForm(\'donaFormOro\')', 'value'=>'donar ahora');
                        echo form_input($data);
                        ?>
                        <div class="progress progress-striped active" style="display: none;" id="progress_donaFormOro">
                            <div class="bar" style="width: 100%;">Procesando formulario...</div>
                        </div>
                    </div>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
     <div class="row-fluid"  style="text-align: center;">
        <p class="txt">
            EXCLUSIVO EN $300: Bodegas Trapiche, agradeciendo su colaboración a BISBlick, le obsequia un vino de alta gama<br />
            <span>A continuación será dirigido a un sitio seguro de Mercado Pago, donde podrá ingresar su tarjeta de crédito</span>
            </p>    
     
     </div>
        
    </div>
</section>