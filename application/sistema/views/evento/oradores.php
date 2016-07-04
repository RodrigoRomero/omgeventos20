<section id="oradores">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            	<header class="text-center">
                	<h1>ORADORES</h1>
                </header>
            </div>
        </div>
        <?php foreach($oradores as $o) { ?>
            <?php if(!empty($o['oradores'])) { ?>
                <div class="row">
                    <div class="col-md-12 oradores_titles">
                        <h5><?php echo $o['categoria']->name ?></h5>
                    </div>
                </div>
                <?php 
                $i = 0;
                foreach ($o['oradores'] as $orador) { ?>
                <?php
                if($i==0){
                    echo '<div class="row"><div class="col-md-12">';
                }
                echo $this->view('evento/orador_row', $orador);
                $i++;
                if($i==4){
                    echo '</div></div>';
                    $i=0;
                }
            
        ?>
                <?php } ?>     
            <?php } ?>
        <?php } ?>
        
        
        
        
        
        
    </div>
</section>