<!-- FOOTER -->
<footer>

	<!-- SCROOL TO TOP -->
	<a href="#toTop" class="fa fa-arrow-up toTop"></a>

	<div class="container">

		<div class="row">

			<div class="col-md-2 copyright text-center">
				<a href="http://www.orsonia.com.ar" title="Orsonia Digital - Ideas que te vuelan la peluca" class="copy">
                    <?php echo image_asset('logo-orsonia.png') ?>
                </a>
			</div>
            <div class="col-md-2 text-center">
			     <!-- <h3>#OMG</h3> -->
			</div>
			<div class="col-md-3 text-center">
				<a href="https://www.facebook.com/adblickagro" class="social fa fa-facebook"></a>
				<a href="https://www.youtube.com/adblicktv" class="social fa fa-youtube-square" ></a>
                <!-- <a href="https://twitter.com/diego_lema" class="social fa fa-twitter" ></a>-->
				<!-- <a href="#" class="social fa fa-google-plus"></a> -->
			</div>
            <div class="col-md-5 separator newsletter-subscribe">
            <?php
                    $data   = array ('id'=>'newsletterForm', 'class'=>'form relative');
                    $action = lang_url('evento/subscribe');
                    echo form_open($action,$data);
                    echo '<div class="input-group bordered input-group-lg">';
                    $data = array('name'=>'newsletter_email','id'=>'newsletter_email','placeholder'=>'Suscribite al newsletter', 'class'=>'required form-control email', 'type'=>'email');

                    echo form_input($data);
    				echo '<span class="input-group-btn">';

                    $data = array('type'=>'submit', 'value'=>'suscribirse', 'class'=>'nomargin btn btn-primary', 'id'=>'newsletter-subscribe', 'onclick'=>"validateForm('newsletterForm')");
                    echo form_input($data);

                   // echo '<button class="nomargin btn btn-primary" id="newsletter-subscribe">ENVIAR</button>';
                    echo '</span>';
                    echo '</div>';
                    echo form_close();

                 ?>
                 <?php /*
                <form>

    				<!-- input field -->
    				<input type="email" placeholder="johndoe@domain.com" class="form-control" id="newsletter_email" name="newsletter_email" required="">

    				<!-- action button -->
    				<span class="input-group-btn">
    					<input type="hidden" value="" id="newsletter_captcha" name="newsletter_captcha" /><!-- hidden field - humans should not see it, only spam bots will see it -->
    					<button class="nomargin btn btn-primary" id="newsletter-subscribe">ENVIAR</button>
    				</span>
    			</div>
			</form>
            */ ?>
			</div>
		</div>

	</div>

</footer>
<!-- /FOOTER -->