<!doctype html>
<html>

<head>
   @include('admin.layout.head')
</head>

<body class='login theme-lightgrey'>
    <div class="wrapper">
        <h1>
            <a href="index.html">
                <img src="<?php echo asset('img/admin/site-logo.png') ?>" alt="{{ config('app.name', 'Laravel') }}" title="{{ config('app.name', 'Laravel') }}" class='retina-ready' >
            </a>
        </h1>
        <div class="login-body">
            @yield('content')
            
        </div>
    </div>
    @include('admin.layout.footer', ['show_footer'=>false]) 
</body>

</html>
