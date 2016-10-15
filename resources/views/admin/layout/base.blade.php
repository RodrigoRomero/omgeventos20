@inject('layout', 'omg\Http\Controllers\Admin\AdminController')
<!doctype html>
<html>
<head>
	@include('admin.layout.head')
</head>
<body class="theme-lightgrey">
	@include('admin.layout.topnav')
	<div class="container-fluid" id="content">
		<div id="left">
		{!! $layout->show()->render() !!}
		</div>
		<div id="main">
			<div class="container-fluid">				
				@yield('content')
			</div>
		</div>
	</div>

	
	@include('admin.layout.footer', ['show_footer'=>true])	
</body>
</html>
