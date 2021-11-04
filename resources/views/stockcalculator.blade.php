@extends('layouts.dashboard')
@section('contents')
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4  main-body">
    <h3>Stocks Calculator.</h3>
    <input placeholder="Stock Name" onInput="{(event) => setStock(event.target.value)}"/>
    <input placeholder="Purchased Price" onInput="{event => setPurchasedPrice(event.target.value)}>
</main>
@endsection