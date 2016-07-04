<?php $json = json_decode(file_get_contents("http://gdata.youtube.com/feeds/api/videos/Wxy0M6xyuCs?v=2&alt=jsonc")); ?>
<section id="videos">
    <div class="container">
        <div class="row margin-10">
    		<div class="span9 show_videos">
                <?php echo $this->view('layout/elements/section_title', array('title'=>'Galería / Videos / '.$json->data->title)) ?>                
                <article class="youtube video flex-video">
                    <iframe width="960" height="720" src="http://www.youtube.com/embed/<?php echo $json->data->id ?>"></iframe>
                </article>                
                
                <h4><?php echo $json->data->title?></h4>
                <p><?php echo $json->data->description?></p>
                <div class="row-fluid videos_relacionados">
                    <div class="span12">
                        <h4>Videos Relacionados</h4>
                    </div>
                    <ul class="unstyled">
                        <li class="span3">
                            <img src="<?php echo $json->data->thumbnail->hqDefault?>"/>
                            <p><?php echo $json->data->title?></p>
                        </li>
                        <li class="span3">
                            <img src="<?php echo $json->data->thumbnail->hqDefault?>"/>
                            <p><?php echo $json->data->title?></p>
                        </li>
                        <li class="span3">
                            <img src="<?php echo $json->data->thumbnail->hqDefault?>"/>
                            <p><?php echo $json->data->title?></p>
                        </li>
                        <li class="span3">
                            <img src="<?php echo $json->data->thumbnail->hqDefault?>"/>
                            <p><?php echo $json->data->title?></p>
                        </li>
                    </ul>
                </div>
    		</div>
            <div class="span3">
                <?php echo $this->view('layout/elements/aside'); ?>
            </div>
        </div>
    </div>
</section>