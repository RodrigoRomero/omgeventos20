<section id="oradores">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            	<header class="text-center">
                	<h1>ORADORES</h1>
                <div class="divider"></div>
            </div>
        
        </div>
        <?php
            $i=0;
            foreach($oradores as $k=>$orador){                
                if($i==0){
                    echo '<div class="row">';
                }
                echo $this->view('evento/orador_row', $orador);
                
                $i++;
                if($i==4){
                    echo '</div>';
                    $i=0;
                }
            }
        ?>
    </div>
</section>