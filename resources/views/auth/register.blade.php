@extends('layouts.app')
@section('login/register')
<a href = "{{ route('login') }}"> <input type = "button" class = 'login' value = "Login"></a>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class = "col-12 col-sm-12 col-md-5 col-lg-5 ">
    <h3 class = "text-center">Create An Account</h3>
            <br/>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                <input type="text" class="form-control login-form @error('name') is-invalid @enderror" id="name" name="name" placeholder = "Full-Name" required autocomplete="name" autofocus>
                @error('name')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
                  </div>
              <div class="form-group">
                <input type="email" id="email" name = "email" class="form-control login-form @error('email') is-invalid @enderror" placeholder = "E-mail" required autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group">
                <input type="text" name = "username" id = "username" class="form-control login-form @error('username') is-valid @enderror" placeholder = "User-Name">
                @error('username')
                <span class = "invalid-feedback" role = "alert">
                <strong>{{ $message}}</strong>
                </span>
                @enderror
              </div> 
              <div class="form-group">
                <input type="password" class="form-control login-form @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder = "Password">
                <small class = "password-text">Please the password should consist at least an Uppercase and a number.</small>
                @error('password')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class = "form-group">
              <input id="password-confirm" type="password" class="form-control login-form" name="password_confirmation" required autocomplete="new-password" placeholder = "Retype-Password">
                </div>
              <button type = "submit" class = "w-100 login-btn">{{ __('Register') }}</button>
              
              
            </form>
            <br/>
          <br/>
          <a href = "{{ url('/redirect') }}"><button type = "button" class = "w-100 using-google"><img src="https://img.icons8.com/color/50/000000/google-logo.png" class = "float-left google-img"/> Sign up using Google</button></a>
          <br/>
          <br/>
          <button type = "button" class = "w-100 using-facebook"><img src="https://img.icons8.com/ios-filled/48/ffffff/facebook-new.png" class = "float-left google-img"/>Sign up using Facebook</button>
          <br/>
          <br/>
          <p class = "new-account text-center">Already have an account? <a href = "{{ route('login') }}" class = "new-account-link">Sign in here.</a></p>
          
      <!--  <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>-->
    </div>
</div>
</div>
@endsection
