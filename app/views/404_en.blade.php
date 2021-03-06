@extends('layout.english_layout.loginlayout')

@section('content')

<div class="page-content-inner">

    <!-- Page 404 -->
    <div class="single-page-block">
        <div class="margin-auto text-center max-width-500">
            <h1>{{$title}}</h1>
            <p>The page you are looking for does not exist. It may have been moved, or removed altogether. Alternatively, return to the front page.</p>
            <a class="btn btn-primary" href="{{ URL::action('AdminController@home') }}">GO BACK TO THE HOMEPAGE</a>
        </div>
    </div>
    <!-- End Page 404 -->

</div>

@stop