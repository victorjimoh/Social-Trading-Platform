@extends('layouts.dashboard')

@section('contents')

<main role = "main" class = "col-md-9 ml-sm-auto col-lg-12 px-md-4 main-body justify-content-center">
<div class = "row justify-content-center">
<div class = "col-12 col-sm-12 col-md-12 col-lg-12">
<div class="col">
<div class="row">
<div class="col mb-3">
<div class="card">
<div class="card-body">
<div class="e-profile">
<div class="row">
<div class="col-12 col-sm-auto mb-3">
<div class="mx-auto" style="width: 140px;">
<div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
@if (auth()->user()->image)
<img src="{{ asset(auth()->user()->image) }}" style="width: 100px; height: 100px; border-radius: 50%;">
@else
<img src = "img/meinAvatar.svg" style = "width:100px; height: 100px; border-radius: 50%;">
@endif
</div>
</div>
</div>
<div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
<div class="text-center text-sm-left mb-2 mb-sm-0">
<h4 class="pt-sm-2 pb-1 mb-0 text-nowrap">{{ Auth::user()->name }}</h4>
<p class="mb-0">@ {{Auth::user()->username }}</p>
</div>
</div>
</div>
<ul class="nav nav-tabs">
<li class="nav-item"><a href="" class="active nav-link">Edit Information</a></li>
</ul>
<div class="tab-content pt-3">
<div class="tab-pane active">
@if (session('status'))
<div class="alert alert-success" role="alert">
{{ session('status') }}
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
<ul>
@foreach ($errors->all() as $error)
<li>
{{ $error }}
</li>
@endforeach
</ul>
</div>
@endif
<form action="{{ route('profile.update') }}" method="POST" role="form" enctype="multipart/form-data">
@csrf
<div class="row">
<div class="col">
<div class="row">
<div class="col">
<div class="form-group">
<label>Full Name</label>
<input class="form-control" type="text" name="name" id = "name" value="{{ old('name', auth()->user()->name) }}">
</div>
</div>
<div class="col">
<div class="form-group">
<label>Username</label>
<input class="form-control" type="text" name="username" id ="username" value = "{{old('username', auth()->user()->username)}}">
</div>
</div>
</div>
<div class="row">
<div class="col">
<div class="form-group">
<label>Email Address</label>
<input class="form-control" type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" disabled>
</div>
</div>
</div>
<div class="row">
<div class="col">
<div class="form-group">
<label>Profile Image</label>
<input  type="file" class="form-control" id="profile_image" name="profile_image">
    @if (auth()->user()->image)
    <code>{{ auth()->user()->image }}</code>
    @endif
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-12 col-sm-6 mb-3">
<div class="mb-2"><b>Update Password</b></div>
<div class="row">
<div class="col">
<div class="form-group">
<label>Current Password</label>
<input class="form-control" type="password" name = "password" id = "password" value = "{{auth()->user()->password}}">
</div>
</div>
</div>
</div>
<div class="col-12 col-sm-5 offset-sm-1 mb-3">
<div class="mb-2"><b>Keeping in Touch</b></div>
<div class="row">
<div class="col">
<label>Email Notifications</label>
<div class="custom-controls-stacked px-2">
<div class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input" id="notifications-blog" checked="">
<label class="custom-control-label" for="notifications-blog">Blog posts</label>
</div>
<div class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input" id="notifications-news" checked="">
<label class="custom-control-label" for="notifications-news">Newsletter</label>
</div>
<div class="custom-control custom-checkbox">
<input type="checkbox" class="custom-control-input" id="notifications-offers" checked="">
<label class="custom-control-label" for="notifications-offers">Personal Offers</label>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">

<div class="col d-flex justify-content-end">

<button class="btn btn-primary" type="submit">Save Changes</button>
</div>
</div>
</form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-3 mb-3">
        <div class="card mb-3">
          <div class="card-body">
            <div class="px-xl-3">
              <button class="btn btn-block btn-secondary">
                <i class="fa fa-sign-out"></i>
                <span>Logout</span>
              </button>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h6 class="card-title font-weight-bold">Support</h6>
            <p class="card-text">Get fast, free help from our friendly assistants.</p>
            <button type="button" class="btn btn-primary">Contact Us</button>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>
</div>
</div>


<!--<h3>Edit Profile</h3>

@if (session('status'))
<div class="alert alert-success" role="alert">
{{ session('status') }}
</div>
@endif
<br/>
<br/>

<div class = "row justify-content-center">
<div class = "col-12 col-sm-12 col-md-12 col-lg-4 ">
@if ($errors->any())
<div class="alert alert-danger alert-dismissible" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
<ul>
@foreach ($errors->all() as $error)
<li>
{{ $error }}
</li>
@endforeach
</ul>
</div>
@endif
<form action="{{ route('profile.update') }}" method="POST" role="form" enctype="multipart/form-data">
@csrf
<div class="form-group">
    <label for="exampleInputEmail1">Full Name</label>
    <input type="text" name = "name" class="form-control" id="name" value="{{ old('name', auth()->user()->name) }}">
  </div>
<div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" disabled>
  </div>
<div class="form-group">
    <label for="exampleInputEmail1">Profile Image</label>
    <input  type="file" class="form-control" id="profile_image" name="profile_image">
    @if (auth()->user()->image)
    <code>{{ auth()->user()->image }}</code>
    @endif
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1">
  </div> 
  
  <button type = "submit" class = "btn-success">Update Profile</button>  
</form>                         
</div>
</div>-->
</main>
   <!--- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 ml-sm-auto col-lg-12 px-md-4">
                <br/>
                <br/>
        
                        
<div class="container">
                            <div class="row">
                                <div class="col-12">
                                                       
                                        
                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>
    </div>-->
@endsection