@extends('admin.layouts.auth.layout')
@section('content')
  <!-- /.login-logo -->
  @include('admin.flashes.flash')
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    {!! Form::open() !!}
      <div class="form-group has-feedback">
        {!! Form::text('email',null,['class'=>'form-control','placeholder'=>'Email']) !!}
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        {!! Form::password('password',['class'=>'form-control','placeholder'=>'Password']) !!}
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-6">
          <a href="{{ url('login/forgot') }}">I forgot my password</a><br>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <button type="submit" class="btn btn-primary btn-sm">Sign In</button>
          <a href = "{{ url('absent') }}" class="btn btn-success btn-sm">Absen</a>
        </div>
        <!-- /.col -->
      </div>
    {!! Form::close() !!}
    <!-- /.social-auth-links -->
  </div>
  <!-- /.login-box-body -->
@endsection