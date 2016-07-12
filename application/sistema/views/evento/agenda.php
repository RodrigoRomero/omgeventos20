<!-- AGENDA -->
<section id="agenda" class="alternate arrow-down">
	<div class="container">
  <?php /*  <a class="social fa fa-facebook" href="javascript:void(0)" onclick="share_fb('<?php echo lang_url()?>')"></a>
    
    <script>
    function share_fb(url) {
        window.open('https://www.facebook.com/sharer/sharer.php?u='+url,'facebook-share-dialog',"width=670,height=340")
    }
    
   
    </script>
     <p><a href="#" onClick="logInWithFacebook()">Log In with the JavaScript SDK</a></p>
    <div id="fbfoto"></div>
    <div class="fb-send" data-href="http://demo.omgeventos.com.ar"></div> */ ?>
		<header class="text-center">
			<h1>AGENDA</h1>
		</header>
        
       


        
        
        
        <?php 
            foreach($agenda as $cronograma){                
                echo $cronograma->title.br();
                echo $cronograma->brief.br();
                echo $cronograma->hora.br();
                if($cronograma->orador_id>0){
                    echo $cronograma->nombre.br();
                }
                echo '<hr/>';
                br(3);
            }
        ?>
        
        <?php /*
        <article class="text-center">
            <div class="btn btn-primary black">MARTES 24 | 06</div>
        </article>
        <div class="agenda-wrapper">
            <ul class="timeline-list">
			      <li>
			        <div class="left">08:00 - 09:00 hs</div>
			        <div class="right">Recepción, desayuno e ingreso.</div>
			      </li> 
			      <li>
			        <div class="left">09:00 - 09:35 hs</div>
			        <div class="right"><strong>PRIMER BLOQUE</strong><br />
- Gabriel Noussan, Decano y Profesor de dirección financiera - IAE - Business School.<br />
- José Demicheli, Director Ejecutivo y Socio Fundador - ADBlick Agro.<br />
- Daphnee Mac Grath, Directora Ejecutiva y Socia Fundadora - BISBlick - Compromiso Social.<br />
- Marcelo Paladino, Ex Decano IAE y actual Director de Centro de Gobierno, Empresa,
Sociedad y Economía - IAE - Business School.</div>
			      </li> 
			      <li>
			        <div class="left">09:35 - 10:45 hs</div>
			        <div class="right"><strong>SEGUNDO BLOQUE</strong><br />
- Carlos Pagni, Periodista - La Nación.<br />
- Martín Lousteau, Economista, Diputado por la Ciudad Autónoma de Buenos Aires -
UNEN y Suma+<br />
- Teo Zorraquín, Consultor - Zorraquin +  Meneses<br />
- Juan Llach - Moderador, Economista - IAE Business School.<br />
Preguntas</div>
			      </li> 
			      <li>
			        <div class="left">10:45 - 11:15 hs.</div>
			        <div class="right">Intervalo</div>
			      </li>
			      <li>
			        <div class="left">11:15 - 11:45 hs</div>
			        <div class="right"><strong>TERCER BLOQUE</strong><br />
- Ariel Casarín, Profesor de Economía de Empresa y Estrategia - IAE Business School.<br /> 
- Carlos Steiger - Moderador, Director del Centro de Agronegocios y Alimentos -
Universidad Austral.<br />
Preguntas</div>
			      </li>                 
			      <li>
			        <div class="left">11:45 - 12:45 hs.</div>
			        <div class="right"><strong>CUARTO BLOQUE</strong><br />
- Gustavo Grobocopatel, Presidente - Grupo Los Grobo.<br />
- Federico Braun, Presidente - Supermercados La Anónima.<br />
- Renato Falbo, Vicepresidente de consumo masivo Mercosur - Alicorp.<br />
- A confirmar.<br />
- Alejandro Carrera - Moderador, Director del Área Académica Política de Empresa -
Chair de la Cátedra PwC de Gobierno de las Organizaciones.</div>
			      </li> 
			      <li>
			        <div class="left">12:45 - 13:00 hs</div>
			        <div class="right">Preguntas y cierre</div>
			      </li>
	    </ul>
        </div>
        */ ?>
	</div>
</section>
<!-- /AGENDA --> 
<?php #echo $this->view('evento/corte') ?>