<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Trade 360 </title>
  <script src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
  <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
  <link rel="stylesheet" href="{{ asset('css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{asset('css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/mystyle.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_horizontal-navbar.html -->
    <div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container-fluid">
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between">

            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
              <a class="navbar-brand brand-logo" href="">Trade 360</a>
              <a class="navbar-brand brand-logo-mini" href="index.html">Trade 360</a>
            </div>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown  d-lg-flex d-none">
                <a href="{{ route('profile-edit') }}"><button type="button" class="btn btn-inverse-primary btn-sm">Edit Profile</button></a>
              </li>
              <li class="nav-item dropdown d-lg-flex d-none">
                <button type="button" class="btn btn-inverse-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop">Create Post</button>
              </li>
              <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">

                  <span class="nav-profile-name">{{ Auth::user()->name }}</span>

                  @if (auth()->user()->image)
                  <img src="{{ asset(auth()->user()->image) }}" style="width: 30px; height: 30px; border-radius: 50%;">
                  @else
                  <img src="{{ asset('img/meinAvatar.svg') }}" style="width:30px; height: 30px; border-radius: 50%;">
                  @endif

                </a>

                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                  <a class="dropdown-item">
                    Settings
                  </a>
                  <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                      @csrf
                    </form>
                  </a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
              <i class="fas fa-bars"></i>
            </button>
          </div>
        </div>
      </nav>
      <nav class="bottom-navbar">
        <div class="container">
          <ul class="nav page-navigation">

            <li class="nav-item">
              <a href="{{route('home')}}" class="nav-link">
                <p class="menu-icon"></p>
                <span class="menu-title">Home</span>
              </a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="{{ route('profile') }}">
                <p class="menu-icon"></p>
                <span class="menu-title">My Profile</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('markets') }}" class="nav-link ">
                <p class="menu-icon"></p>
                <span class="menu-title">Trade Markets</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url(config('forum.web.router.prefix'))}}" class="nav-link">
                <p class="menu-icon"></p>
                <span class="menu-title">Forums</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('users')}}" class="nav-link">
                <p class="menu-icon"></p>
                <span class="menu-title">Friends/Followers</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('charts')}}" class="nav-link">
                <p class="menu-icon"></p>
                <span class="menu-title">Trading Charts</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{route('market')}}">
                <p class="menu-icon"></p>
                <span class="menu-title">Stock News</span>
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('contents')
          @yield('test-script')
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="staticBackdropLabel"><b>Create Post</b></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="fas fa-times-circle"></i>
          </button>
        </div>

        <div class="modal-body">
          <div class="user-profile">
            @if (auth()->user()->image)
            <img src="{{ asset(auth()->user()->image) }}" style="width: 40px; height: 40px; border-radius: 50%;">
            @else
            <img src="img/meinAvatar.svg" style="width:40px; height: 40px; border-radius: 50%;">
            @endif
            <div class="paragraph-text">
              <p><b>{{Auth::user()->name}}</b></p>
            </div>
          </div>
          <br />
          <form class="{{ route('profile') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <textarea class="form-control create-post-text-area omo @error('body') border-danger @enderror" name="body" id="body" rows="4" placeholder="Share your thoughts........." maxlength="500"></textarea>
              <p id="log"></p>

              @error('body')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <button class="create-post-button hey w-100" id="submit" type="submit">{{ __('Post') }}</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- content-wrapper ends -->
  <!-- partial:partials/_footer.html -->
  <!--<footer class="footer">
          <div class="footer-wrap">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard templates</a> from Bootstrapdash.com</span>
            </div>
          </div>
        </footer>-->
  <!-- partial -->
  </div>
  <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->

  <script src="js/hover.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
  <script src="{{ asset('js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('js/template.js') }}"></script>
  <script src="{{asset('js/jquery.js')}}"></script>
  @yield('custom-script')

  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js"></script>
  
  <!-- Custom js for this page-->
  <script src="{{ asset('js/dashboard1.js') }}"></script>
  <!-- End custom js for this page-->

  <script src="https://use.fontawesome.com/releases/v5.15.3/js/all.js"></script>
  <script src="https://use.fontawesome.com/releases/v5.15.3/js/v4-shims.js"></script>
</body>

</html>