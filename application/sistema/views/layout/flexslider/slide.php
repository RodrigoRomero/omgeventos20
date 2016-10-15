<?php $json = json_decode($data->json) ?>
<li class="item" style="background: url('<?php echo up_file('porfolios/'.$data->id.'_home.jpg')?>');">
    <div class="container">
        <div class="carousel-caption">
            <h2><?php echo $json->lang->$Clang->proyecto?></h2>
            <p class="lead"><?php echo $json->lang->$Clang->resumen?></p>
        </div>
    </div>
</li>