@extends('layouts.dashboard')
@section('contents')
<main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-md-4 main-body justify-content-center">
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <!-- Following -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    All Users
                </div>
                <div class="panel-body">
                    <table class="table table-striped task-table">
                        <thead>
                            <th>User</th>
                            <th> </th>
                        </thead>
                        <tbody>
                            @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                            @else(session()->has('error'))
                            <div class="alert alert-failure">
                                {{ session()->get('error') }}
                            </div>
                            @endif
                            @foreach ($types as $user)
                            <tr>
                                <td clphpass="table-text">
                                    <div><a href="#">{{ $user->name }}</a></div>
                                </td>
                                @if (Auth::User()->isFollowing($user->id))
                                <td>
                                    <form action="{{url('unfollow/' . $user->id)}}" method="POST">
                                        @csrf
                                        {{ method_field('DELETE') }}



                                        <button type="submit" id="delete-follow-{{ $user->target_id }}" class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i>Unfollow
                                        </button>
                                    </form>
                                </td>
                                @else
                                <td>
                                    <form action="{{url('follow/' . $user->id)}}" method="POST">
                                        @csrf

                                        <button type="submit" id="follow-user-{{ $user->id }}" class="btn btn-success">
                                            <i class="fa fa-btn fa-user"></i>Follow
                                        </button>
                                    </form>
                                </td>
                                @endif

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection