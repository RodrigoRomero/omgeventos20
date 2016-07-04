<?php $json = json_decode($data->json); ?>
<div class="container">
    <?php echo $this->view('layout/elements/titles', array('title'=>lang('bio'), 'subtitle' => '')) ?>
    <div class="row-fluid">
        <div class="span4">
        <?php
            for($i=0;$i<$total_img;$i++){ 
                echo up_asset('institucional/'.$data->id.'_'.$i.'.jpg');
            } 
        ?>          
        </div>
        <div class="span8">
            <div class="title1">
				<h2><?php echo $json->lang->$Clang->nombre ?></h2>
				<h3 style="line-height: inherit;"><?php echo $json->lang->$Clang->cargo ?><br /> <?php echo $json->lang->$Clang->titulo ?></h3>
			</div>
            <p><?php echo $json->lang->$Clang->descripcion ?></p>
        </div>
    </div>
</div>
