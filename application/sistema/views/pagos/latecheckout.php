

		<!-- BLOG -->
		<section id="blog" class="alternate">
			<article class="container">
                <header class="text-center">           
			         <h1>Completa tu pago</h1>           
		       </header>   
               <div class="divider"><!-- lines divider --></div>
               <h2 class="text-center"><?php echo $user_info->nombre.' '.$user_info->apellido ?></h2>
               
               <?php 
                $data   = array ('id'=>'registroForm', 'class'=>'form relative');
                $action = lang_url('payments/checkout/'.$user_info->salt);
                echo form_open($action,$data);
                
                echo $this->view('forms/planes');
                echo $this->view('forms/medio_pago');
               
                echo '<div class="col-md-12 text-center">';
                $data = array('type'=>'submit', 'value'=>'PAGAR', 'class'=>'btn btn-primary green fsize20', 'id'=>'contact_submit', 'onclick'=>"validateForm('registroForm')");
                echo form_input($data);
                echo '</div>';  
                echo form_hidden('cupons',$user_info->discount_code);
                echo form_hidden('salt',$user_info->salt);
                echo form_close(); 
               ?>

			</article>
		</section>
		<!-- /BLOG -->