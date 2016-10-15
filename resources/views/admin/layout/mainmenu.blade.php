<div class="subnav">
	<div class="subnav-title">
		<a href="#" class='toggle-subnav'>
			<i class="fa fa-angle-down"></i>
			<span>Configuracion</span>
		</a>
	</div>
	<ul class="subnav-menu">


		@foreach ($modules as $module)
			
			<li>
				<a href="{{ route('admin.'.strtolower($module->module)) }}">{{ $module->module }}</a>
			</li>
		@endforeach
	</ul>
</div>