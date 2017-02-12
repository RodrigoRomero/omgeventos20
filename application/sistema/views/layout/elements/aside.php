<?php $json = json_decode(file_get_contents("http://gdata.youtube.com/feeds/api/videos/sTM8o5B9TtY?v=2&alt=jsonc")); ?>
<aside>
    <div class="row-fluid" id="caso_exito_aside">
        <div class="span12">
            <?php echo $this->view('layout/elements/aside_titles', array('title'=>'conozca nuestros casos de exito', 'icon'=>'like_m')) ?>
            <div class="caption">
                <?php echo  generateMenuTree($this->categorias['casos_de_exito'],0,1,'') ?>
            </div>
        </div>
    </div>
    <div class="row-fluid" id="world_aside">
        <div class="span12">
            <?php 
            echo $this->view('layout/elements/aside_titles', array('title'=>'global network', 'icon'=>'world_m'));            
            ?>            
            <div>
                <?php echo image_asset('site/mapa_mundi.jpg'); ?>
            </div>
        </div>
    </div>
    <div class="row-fluid" id="video_aside">
        <div class="span12">
            <?php echo $this->view('layout/elements/aside_titles', array('title'=>'videos destacados', 'icon'=>'video_m')) ?>
        </div>
        <div>
            <a href="<?php echo lang_url('galeria/detalle/')?>" style="color: #ffffff;">
                <img src="<?php echo $json->data->thumbnail->hqDefault?>"/>
                <div class="caption">
                    <p><?php echo $json->data->description?></p>
                </div>
            </a>
        </div>
    </div>
</aside>