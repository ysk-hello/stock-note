@extends('layouts.app')

@section('content')
<!-- <div class="container">  -->
<div class="row justify-content-center">
    <div id="side" class="col-md-3">
        @include('parts.calendar')
    </div>
    <div id="main" class="col-md-9">
        {{$selected_date}}
    </div>
</div>
<!-- </div> -->
@endsection
