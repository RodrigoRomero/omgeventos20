<section id="listados">
    <div class="container">
        <div class="row margin-10">
    		<div class="span12">
                <?php echo $this->view('layout/elements/section_title', array('title'=>'Galería / Fotos')) ?>
                
                <div class="row">
                    <?php foreach($galeria as $item_gal){
                        echo $this->view('galeria/item',array('data'=>$item_gal));
                    } ?>
                </div>
    		</div>
        </div>
    </div>
</section>