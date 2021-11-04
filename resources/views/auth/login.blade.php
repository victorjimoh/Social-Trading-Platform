@extends('layouts.app')
@section('login/register')
<a href = "{{ route('register') }}"><input type = "button" class = 'signup' value = "Create Account"></a>
@endsection
@section('header')
<h3 class = "text-center">Sign in to your account.</h3>
@endsection
@section('content')
<div class="container">
<div class="row justify-content-center">
<div class = "col-12 col-sm-12 col-md-4 col-lg-4 ">
<br/>
<h3 class = "text-center">Sign in to your account. </h3>
<br/>
<form method="POST" action="{{ route('login') }}">
@csrf
<div class="form-group">
<input type="email" class="form-control login-form @error('email') is-invalid @enderror" name="email" placeholder = "Phone Number or E-mail" required autocomplete="email" autofocus>
@error('email')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>
<div class="form-group">
<input type="password" class="form-control login-form @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder = "Password">
@error('password')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
@enderror
</div>          
<button type = "submit" class = "w-100 login-btn">  {{ __('Login') }}</button>
</form>
<br/>
<br/>
<a href = "{{ route('login.google') }}" ><button type = "button" class = "w-100 using-google"><img src="https://img.icons8.com/color/50/000000/google-logo.png" class = "float-left google-img"/> Sign in using Google</button></a>
<br/>
<br/>
<button type = "button" class = "w-100 using-facebook"><img src="https://img.icons8.com/ios-filled/48/ffffff/facebook-new.png" class = "float-left google-img"/>Sign in using Facebook</button>
<br/>
<br/>
<a href = "forgotpassword.html" class = "f-p-l"><p class = "text-center forgot-password-link">Forgot Password?</p></a>
<p class = "new-account text-center">Don't have an account? <a href = "{{ route('register') }}" class = "new-account-link">Create an account here.</a></p>
<p>Note: All Trading involves risk. </p>
</div>
</div>
</div>
@endsection
