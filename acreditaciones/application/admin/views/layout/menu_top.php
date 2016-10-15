<div class="nav-no-collapse header-nav">
	<ul class="nav pull-right">
		<li class="hidden-phone">
			<a class="btn" href="<?php echo lang_url('auth/logout')?>">
				<i class="icon-off"></i>
			</a>
		</li>
		<!-- start: User Dropdown -->
		<li>
			<a class="btn account dropdown-toggle"  href="javascript:void(0)">
				
				<div class="user">
					<span class="hello">Bienvenido!</span>
					<span class="name"><?php echo get_session("asistentes_nombre", false).' '.get_session("asistentes_apellido", false) ?></span>
				</div>
			</a>
		
		</li>
		<!-- end: User Dropdown -->
	</ul>
</div>