@extends('layouts.dashboard')
@section('contents')
<main role="main" class="col-sm-12 col-12 col-md-12  col-lg-12  main-body">
  <div class="row justify-content-center">

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
                        <img src="img/meinAvatar.svg" style="width:100px; height: 100px; border-radius: 50%;">
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
                  <li class="nav-item"><a href="" class="active nav-link">Posts</a></li>
                  <li class="nav-item"><a href="" class="nav-link">Friends/Followers </a></li>
                  <li class="nav-item"><a href="" class="nav-link">Photos</a></li>
                  <li class="nav-item"><a href="" class="nav-link">Trades</a></li>
                </ul>
                <div class="tab-content pt-3">
                  <div class="tab-pane active">
                    <div class="row">
                      <div class="col-12 col-sm-12 col-md-12 col-lg-7 ">
                        @if ($profile->count())
                        @foreach($profile as $post)
                        <div class="post-container">
                          <div class="post-row">
                            <div class="user-profile">
                              @if (auth()->user()->image)
                              <img src="{{ asset(auth()->user()->image) }}" style="width: 40px; height: 40px; border-radius: 50%;">
                              @else
                              <img src="img/meinAvatar.svg" style="width:40px; height: 40px; border-radius: 50%;">
                              @endif
                              <div class="paragraph-text">
                                <p><b>{{ $post->user->name }}</b></p>
                                <small>{{$post->created_at->diffForHumans()}}.</small>
                              </div>
                            </div>
                            <div class="dropdown">
                              <button class="options" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                              </button>
                              <div class="dropdown-menu options-dropdown" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item options-icon" href="#"><i class="fas fa-save mr-3"></i>Save Post</a>
                                <a class="dropdown-item options-icon" href="#"><i class="fas fa-pen mr-3"></i>Edit Post</a>
                                <a class="dropdown-item  options-icon" href="{{'delete/'.$post['id'] }}"><i class="fas fa-trash mr-3"></i>Delete Post</a>
                                </form>
                              </div>
                            </div>
                          </div>
                          <p class="post-text">{{ $post->body }}</p>
                          <span> <i class="fas fa-thumbs-up"></i> {{ $post->likes->count() }}</span>

                          <hr>
                          <div class="post-row-1">
                            @if(!$post->likedby(auth()->user()))
                            <form action="{{route('posts.likes', $post)}}" method="post">
                              @csrf
                              <button class="btn text-center" type="submit">Like</button>
                            </form>
                            @else
                            <form action="{{route('posts.likes', $post)}}" method="post">
                              @csrf
                              @method("DELETE")
                              <button class="btn text-center" type="submit">Unlike</button>
                            </form>
                            @endif
                            <form action="" method="post">
                              @csrf
                              <button class="btn" type="submit">Comment</button>
                            </form>
                          </div>
                          @include('commentsDisplay', ['comments' => $post->comments, 'post_id' => $post->id])
                          <hr />
                          <form method="post" action="{{ route('comments.store') }}">
                            @csrf
                            <div class="form-group">
                              <textarea class="form-control" name="body"></textarea>
                              <input type="hidden" name="post_id" value="{{ $post->id }}" />
                              <div class="form-group">
                                <input type="submit" class="btn btn-success" value="Add Comment" />
                              </div>
                            </div>
                          </form>
                        </div>
                        @endforeach
                        {!! $profile->render() !!}
                        @else
                        <div class="col-12 col-sm-12 col-md-12 col-lg-7">
                          <p>Your Posts are empty </p>
                        </div>
                        @endif
                      </div>
                    </div>
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
</main>





<!--<main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-md-4  main-body">

  <div class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom ">
    <div class="user-profile">
      <div class="paragraph-text">
        <p><b>{{Auth::user()->name}}</b></p>
      </div>
    </div>

    <a href="{{ route('profile-edit') }}"> <button class="edit-profile" type="button"><i
          class="fas fa-user-edit mr-2"></i>Edit Profile</button></a>
  </div>
  <div class="mb-3">
    <div class=' d-flex justify-content-center'>
      <ul class="nav" role="tablist">
        <li class="nav-item">
          <a href="#posts" id="posts-tab" class="nav-link sub-menus active " aria-selected="true" data-toggle="tab"
            role="tab">Posts</a>
        </li>
        <li class="nav-item">
          <a href="#friends" id="friends-tab" class="nav-link sub-menus" aria-selected="false" data-toggle='tab'
            role='tab'>Friends </a>
        </li>
        <li class="nav-item">
          <a href="#comments" id="comments-tab" class="nav-link sub-menus" aria-selected="false" data-toggle='tab'
            role='tab'>Comments</a>
        </li>
        <li class="nav-item">
          <a href="#trades" id='trades-tab' class="nav-link sub-menus" aria-selected="false" data-toggle="tab"
            role="tab">Trades</a>
        </li>
        <li class="nav-item">
          <a href="#media" id='media-tab' class="nav-link sub-menus" aria-selected="false" data-toggle="tab"
            role="tab">Media</a>
        </li>
      </ul>
      <hr />
    </div>

  </div>
  <div class="tab-content something">
    <div class="tab-pane fade show active container-fluid" id="posts" aria-labelledby="posts-tab" role="tabpanel">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-7 ">
          @if ($profile->count())
          @foreach($profile as $post)
          <div class="post-container">
            <div class="post-row">
              <div class="user-profile">
                @if (auth()->user()->image)
                <img src="{{ asset(auth()->user()->image) }}" style="width: 40px; height: 40px; border-radius: 50%;">
                @else
                <img src="img/meinAvatar.svg" style="width:40px; height: 40px; border-radius: 50%;">
                @endif
                <div class="paragraph-text">
                  <p><b>{{ $post->user->name }}</b></p>
                  <small>{{$post->created_at->diffForHumans()}}.</small>
                </div>
              </div>
              <div class="dropdown">
                <button class="options" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                  aria-expanded="false">
                  <i class="fas fa-ellipsis-h"></i>
                </button>
                <div class="dropdown-menu options-dropdown" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item options-icon" href="#"><i class="fas fa-save mr-3"></i>Save Post</a>
                  <a class="dropdown-item options-icon" href="#"><i class="fas fa-pen mr-3"></i>Edit Post</a>
                  <a class="dropdown-item  options-icon" href="{{'delete/'.$post['id'] }}"><i
                      class="fas fa-trash mr-3"></i>Delete Post</a>
                  </form>
                </div>
              </div>
            </div>
            <p class="post-text">{{ $post->body }}</p>
            <span> <i class="fas fa-thumbs-up"></i> {{ $post->likes->count() }}</span>

            <hr>
            <div class="post-row-1">
              @if(!$post->likedby(auth()->user()))
              <form action="{{route('posts.likes', $post)}}" method="post">
                @csrf
                <button class="btn text-center" type="submit">Like</button>
              </form>
              @else
              <form action="{{route('posts.likes', $post)}}" method="post">
                @csrf
                @method("DELETE")
                <button class="btn text-center" type="submit">Unlike</button>
              </form>
              @endif
              <form action="" method="post">
                @csrf
                <button class="btn" type="submit">Comment</button>
              </form>
            </div>
            @include('commentsDisplay', ['comments' => $post->comments, 'post_id' => $post->id])
            <hr />
            <form method="post" action="{{ route('comments.store'   ) }}">
              @csrf
              <div class="form-group">
                <textarea class="form-control" name="body"></textarea>
                <input type="hidden" name="post_id" value="{{ $post->id }}" />
                <div class="form-group">
                  <input type="submit" class="btn btn-success" value="Add Comment" />
                </div>
              </div>
            </form>
          </div>
          @endforeach
          @else
          <div class="col-12 col-sm-12 col-md-12 col-lg-7">
            <p>Your Posts are empty </p>
          </div>
          @endif
        </div>
      </div>
    </div>
    <div class="tab-pane fade  container-fluid" id="friends" aria-labelledby="friends-tab" role="tabpanel">

      <h5>Friends</h5>
      <div class="float-left">
        <div class="user-profile">
          <img src="img/Ellipse 2.png" />
          <div class="paragraph-text">
            <p><b>Jimoh Money</b></p>
            <small>20 Mutual Friends</small>
          </div>
        </div>
      </div>
      <div class="float-right">
        <div class="user-profile">
          <img src="img/Ellipse 2.png" />
          <div class="paragraph-text">
            <p><b>Jimoh Money</b></p>
            <small>20 Mutual Friends</small>
          </div>
        </div>
      </div>
      <div class="float-LEFT">
        <div class="user-profile">
          <img src="img/Ellipse 2.png" />
          <div class="paragraph-text">
            <p><b>Jimoh Money</b></p>
            <small>20 Mutual Friends</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>-->

@endsection