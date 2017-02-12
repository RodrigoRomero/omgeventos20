<!-- AGENDA -->

<section id="agenda" class="alternate arrow-down">
	<div class="container">
		<header class="text-center">
			<h1>AGENDA</h1>
		</header>
        <?php 
            foreach($agenda as $cronograma){                
                echo $cronograma->title.br();
                if(isset($cronograma->brief) && !empty($cronograma->brief)) {
                	echo $cronograma->brief.br();
                }
                echo substr($cronograma->hora, 0, -3).br();
                if($cronograma->orador_id>0){
                    echo $cronograma->nombre.br();
                }
                echo '<hr/>';
                br(3);
            }
        ?>

	</div>
</section>
<!-- /AGENDA --> 
<?php #echo $this->view('evento/corte') ?>