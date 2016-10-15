@extends('admin.layout.login')

@push('footer_plugins')
    <script src="{{ asset('plugins/validation/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/validation/js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('plugins/validation/js/messages_es.js') }}"></script>
    <script src="{{ asset('plugins/icheck/js/jquery.icheck.min.js') }}"></script>
@endpush

@push('head_css')
    <link rel="stylesheet" href="{{ asset('plugins/icheck/css/all.css') }}">
@endpush

@section('content')
<h2>SIGN IN</h2>
<form class="form-vertical form-validate" id="loginFrm" role="form" method="POST" action="{{ url('/admin/login') }}" novalidate>
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label for="email" class="col-md-12 control-label">E-Mail Address</label>
        <div class="email controls">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="col-md-12 control-label">Password</label>

        <div class="pw controls">
            <input id="password" type="password" class="form-control" name="password" required>

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>
     <div class="submit">
        <div class="remember">
            <input type="checkbox" name="remember" class='icheck-me' data-skin="square" data-color="grey" id="remember">
            <label for="remember">Remember me</label>
        </div>
        <input type="submit" value="Sign me in" class='btn btn-primary'>
    </div>
       
    </form>
            
    <div class="forget">
        <a href="{{ url('/admin/password/reset') }}">
            <span>Forgot password?</span>
        </a>
    </div>
@endsection