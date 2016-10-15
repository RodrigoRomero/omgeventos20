@extends('admin.layout.login')


<!-- Main Content -->
@section('content')
<h2>RESET PASSWORD</h2>
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<form class="form-vertical form-validate" id="resetFrm" role="form" method="POST" action="{{ url('/admin/password/email') }}" novalidate>
    {{ csrf_field() }}
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <label for="email" class="col-md-12 control-label">E-Mail Address</label>
        <div class="email controls">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>
     <div class="submit">
        <input type="submit" value="Send Password Reset Link" class='btn btn-primary'>
    </div>                        
</form>
 <div class="forget">
        <a href="{{ url('/admin/login') }}">
            <span>Go to Login</span>
        </a>
    </div>
@endsection
