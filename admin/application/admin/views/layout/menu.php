<div id="sidebar-left" class="span2">
	<div class="nav-collapse sidebar-nav">
        
		<ul class="nav nav-tabs nav-stacked main-menu">
			<li><a href="<?php echo lang_url()?>"><i class="icon-home"></i><span class="hidden-tablet"> Home</span></a></li>
            <li><a href="<?php echo lang_url('module/load/m/eventos/a/listado')?>"><i class="icon-bookmark"></i><span class="hidden-tablet"> Eventos</span></a></li>
            <li><a href="<?php echo lang_url('module/load/m/orders/a/listado')?>"><i class="icon-usd"></i><span class="hidden-tablet"> Ordenes</span></a></li>
            <li><a href="<?php echo lang_url('module/load/m/acreditados/a/listado')?>"><i class="icon-user"></i><span class="hidden-tablet"> Acreditaciones</span></a></li>

            
			            
			<li class=" hidden-tablet">
				<a class="dropmenu" href="#"><i class="icon-wrench"></i><span> Configuraciones</span></a>
				<ul>
                    <li><a class="submenu" href="<?php echo lang_url('module/load/m/categoriasponsor/a/listado')?>"><i class="icon-user"></i><span> Categorias Sponsor</span></a></li>
					<li><a class="submenu" href="<?php echo lang_url('module/load/m/gateways/a/listado')?>"><i class="icon-user"></i><span> Medios Pago</span></a></li>
                    <li><a class="submenu" href="<?php echo lang_url('module/load/m/asistentes/a/listado')?>"><i class="icon-user"></i><span> Asistentes</span></a></li>
    			 	<!-- </a><li><a class="submenu" href="<?php echo lang_url('module/load/m/configuraciones/a/listado')?>"><i class="icon-cog"></i><span> Configuraciones</span></a></li> -->								
				</ul>	
			</li>            
			<li><a href="<?php echo lang_url('auth/logout')?>"><i class="icon-off"></i><span class="hidden-tablet">Logout</span></a></li>
		</ul>
	</div>
</div>