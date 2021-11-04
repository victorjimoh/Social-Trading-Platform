@extends('layouts.dashboard')
@section('contents')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                 <div class="card-header">Submit Stock Ticker</div>
                 <div class="card-body">
                  <form method="POST" action="/news1">
                   @csrf
                    <input id="website" type="website" class="form-control @error('website') is-invalid @enderror"
                        name="website" value="{{ old('email') }}" placeholder="e.g. AAPL" required autofocus>
                       <br>
                      <button type="submit" class="btn btn-primary">
                      Submit
                      </button>
                 </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection