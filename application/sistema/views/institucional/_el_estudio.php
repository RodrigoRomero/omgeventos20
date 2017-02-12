<?php $json = json_decode($data->json); ?>

<div class="container">
    <?php echo $this->view('layout/elements/titles', array('title'=>lang('el_estudio'), 'subtitle' => '')) ?>
    <div class="row-fluid">
        <div class="span7">
            <div class="camera_wrap camera_white_skin" id="camera_wrap_2">
                <?php
                for($i=0;$i<$total_img;$i++){ 
                    echo '<div data-src="'.up_file('institucional/'.$data->id.'_'.$i.'.jpg').'" class="sf-image"></div>';
                }
                ?>
			</div>
            
        </div>
        <div class="span5">
            <div class="title1">
				<h2><?php echo $json->lang->$Clang->nombre ?></h2>
			</div>
            <p><?php echo $json->lang->$Clang->descripcion ?></p>
        </div>
    </div>
    <div class="row-fluid" id="institucional">
                <div class="span6">
                    
        				<h4>Servicios de Diseño</h4>
                        <hr />
                        <ul class="unstyled">
                            <li><i class="sf-icon-asterisk"></i>Estudio de tendencias y adaptación de las mismas</li>
                            <li><i class="sf-icon-asterisk"></i>Viajes de producto</li>
                            <li><i class="sf-icon-asterisk"></i>Armado de Carta de colores</li>
                            <li><i class="sf-icon-asterisk"></i>Asesoramiento y Matriz comercial</li>
                            <li><i class="sf-icon-asterisk"></i>Consultoría de diseño</li>
                            <li><i class="sf-icon-asterisk"></i>Diseño, armado y desarrollo de colecciones de indumentaria y textil</li>
                            <li><i class="sf-icon-asterisk"></i>Nuevas lineas de producto y accesorios</li>
                            <li><i class="sf-icon-asterisk"></i>Diseño de estampas únicas o full prints</li>
                        </ul>
        			
                </div>
                <div class="span6">
                    <div class="title2">
        				<h4>Servicion de producción</h4>
                        <hr />
                        <ul class="unstyled">
                            <li><i class="sf-icon-asterisk"></i>Búsqueda de proveedores locales e internacionales</li>
                            <li><i class="sf-icon-asterisk"></i>Armado de fichas técnica</li>
                            <li><i class="sf-icon-asterisk"></i>Desarrollo de muestrarios y auditoría de los mismos</li>
                            <li><i class="sf-icon-asterisk"></i>Seguimiento y coordinación de las etapas productivas</li>
                            <li><i class="sf-icon-asterisk"></i>Control de Materia Prima</li>
                            <li><i class="sf-icon-asterisk"></i>Auditoría de calidad, Calce y terminación de la producción</li>
                        </ul>
        			</div>
                </div>
            </div>
</div>