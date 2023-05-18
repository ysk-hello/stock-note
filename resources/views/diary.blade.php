@extends('layouts.app')

@section('content')
<!-- <div class="container">  -->
<div class="row justify-content-center">
    <div id="side" class="col-md-3">
        <calendar></calendar>
    </div>
    <div id="main" class="col-md-9">
        <h2>{{$selected_date}}</h2>
        <diary ymd="{{$selected_date}}"></diary>
    </div>
</div>
<!-- </div> -->
@endsection
