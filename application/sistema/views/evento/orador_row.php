<?php $social_arr = json_decode($json_socials); 

?>
<div class="speaker_container col-md-3">    
        <div class="speaker_img">
            <?php echo up_asset('oradores/'.$id.'_0.jpg',array('class'=>'img-circle', 'alt'=>$nombre, 'title'=>$nombre)) ?>
        </div>
        <div class="speaker_data">
            <div class="speaker_name clearfix">
                <h3><?php echo $nombre ?></h3>                
                <h4><?php echo $cargo ?></h4>
                <div class="speaker_social">
                    <?php if(!empty($social_arr->faceboook)) { ?>
                    <a href="http://www.facebook.com/<?php echo $social_arr->faceboook ?>" class="fb fa fa-facebook rotate" target="_blank" title="Facebook de <?php echo $nombre ?>"></a>
                    <?php } ?>
                    <?php if (!empty($social_arr->twitter)) { ?>
                    <a href="https://twitter.com/<?php echo $social_arr->twitter ?>" class="tw fa fa-twitter rotate" target="_blank" title="Facebook de <?php echo $nombre ?>"></a>
                     <?php } ?>
                     <?php if (!empty($social_arr->linkedin)) { ?>
                    <a href="https://www.linkedin.com/in/<?php echo $social_arr->linkedin ?>" class="in fa fa-linkedin rotate" target="_blank" title="Linkedin de <?php echo $nombre ?>"></a>
                    <?php } ?>


                </div>
            </div>
             <?php if(!empty($brief)) { ?>
            <div class="speaker_profile">
                <p><?php echo $brief ?></p>                
            </div>
             <?php } ?>
        </div>
    
</div>