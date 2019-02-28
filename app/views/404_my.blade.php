@extends('layout.malay_layout.default')

@section('content')

<div class="page-content-inner">

    <!-- Page 404 -->
    <div class="single-page-block">
        <div class="margin-auto text-center max-width-500">
            <h1>{{$title}}</h1>
            <p>Halaman yang anda cari tidak wujud. Ia mungkin telah dipadam. Sebagai alternatif, balik ke halaman utama.</p>            
            <a class="btn btn-primary" href="{{ URL::action('AdminController@home') }}">BALIK KE HALAMAN UTAMA</a>
        </div>
    </div>
    <!-- End Page 404 -->

</div>

@stop