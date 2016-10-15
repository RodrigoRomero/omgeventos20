<section id="listados">
    <div class="container">
        <div class="row margin-10">
    		<div class="span9">
                <?php echo $this->view('layout/elements/section_title', array('title'=>'casos de éxito / '.$categoria->lang->$Clang->nombre)); ?>
                <div class="row caso_box">
                <?php
                    if(count($listado)>0){                        
                        foreach($listado as $k=>$item){                            
                            echo $this->view('casos_de_exito/item',array('pos'=>$k, 'item'=>$item));
                        }
                    } else {
                        echo $this->view('casos_de_exito/empty');
                    }
                
                ?>
                </div>
    		</div>
            <div class="span3">
            <?php echo $this->view('layout/elements/aside'); ?>
            </div>
        </div>
    </div>
</section>