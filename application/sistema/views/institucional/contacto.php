<section id="contacto">
    <div class="container">
        <div class="row margin-10">
    		<div class="span12">
                <?php echo $this->view('layout/elements/section_title', array('title'=>'contacto')) ?>
    		</div>
        </div>
        <div class="row">
            <div class="orange_bg clearfix span12" style="padding: 10px;">
                
                    <div class="span6" style="margin-left: 0;">                        
                        <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.ar/maps?f=q&amp;source=s_q&amp;hl=es-419&amp;geocode=&amp;q=Bernardo+de+Irigoyen+722+12%C2%BA&amp;aq=&amp;sll=-34.615853,-58.433298&amp;sspn=0.376354,0.727158&amp;ie=UTF8&amp;hq=&amp;hnear=Bernardo+de+Irigoyen+722,+Monserrat,+Buenos+Aires&amp;t=m&amp;z=14&amp;iwloc=A&amp;ll=-34.616686,-58.38029&amp;output=embed"></iframe>            
                        <div class="row-fluid contact_details">
                            <div class="span7">
                                <address>
                                    <dl class="unstyled">
                                        <dt>Bernardo de Irigoyen 722 12º floor (C1072AAP)</dt>
                                        <dt>Ciudad Autonoma de Buenos Aires - Argentina</dt>
                                    </dl>
                                </address>
                            </div>
                            <div class="span5">
                                <dl class="unstyled">
                                    <dt>Ph: 54 (11) 5032-2020</dt>
                                    <dt>Fax: 54 (11) 5032-2027</dt>
                                </dl>
                            </div>
                            
                        </div>
                    </div>
                    <div class="span5" style="float: right;">
                        <?php 
            			$data   = array ('id'=>'contactForm', 'class'=>'form');
                        $action = lang_url('institucional/do-contacto');
                        echo form_open($action,$data);                            
                        
                        echo '<div class="row-fluid">';
                            echo '<div class="span6">';
                                $data = array('name'=>'nombre','id'=>'frm_nombre','placeholder'=>lang('nombre'), 'class'=>'required span12', 'tabindex'=>1);
                                echo form_label(lang('nombre'),$data['id']);
                                echo form_input($data);
                        
                                $data = array('name'=>'email','id'=>'frm_email','placeholder'=>lang('email'), 'class'=>'required email span12', 'type'=>'email', 'tabindex'=>3);
                                echo form_label(lang('email'),$data['id']);
                                echo form_input($data);
                                
                            echo '</div>';
                            echo '<div class="span6">';
                                $data = array('name'=>'apellido','id'=>'frm_apellido','placeholder'=>lang('apellido'), 'class'=>'required span12', 'tabindex'=>2);
                                echo form_label(lang('apellido'),$data['id']);
                                echo form_input($data);
                                
                                $data = array('name'=>'telefono','id'=>'frm_telefono','placeholder'=>lang('telefono'), 'class'=>'number span12', 'tabindex'=>4);
                                echo form_label(lang('telefono'),$data['id']);
                                echo form_input($data);
                            echo '</div>';
                            
                        echo '</div>';
                        
                        echo '<div class="row-fluid">';
                            echo '<div class="span12">';                             
                                $data = array('name'=>'empresa','id'=>'frm_empresa','placeholder'=>lang('empresa'), 'class'=>'required span12', 'tabindex'=>5);
                                echo form_label(lang('empresa'),$data['id']);
                                echo form_input($data);
                                
                                $data = array('name'=>'mensaje','id'=>'frm_mensaje','placeholder'=>lang('dejanos_tu_mensaje'), 'class'=>'required span12', 'value'=>'', 'tabindex'=>6);
                                echo form_label(lang('dejanos_tu_mensaje'),$data['id']);
                                echo form_textarea($data);
                                
                                $data = array('type'=>'submit', 'value'=>'Enviar', 'class'=>'simple_btn span12', 'onclick'=>"validateForm('contactForm')");
                                echo form_input($data);
                            echo '</div>';
                        echo '</div>';
                        
                        
                        
            
            
                        echo form_close(); 
                        ?>
                    </div>
                
            </div>
        </div>
    </div>
</section>