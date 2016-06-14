@extends('layouts.master')

@section('title')
    {{ trans('gallery::gallery.title.gallery') }}
@endsection
@section('subTitle')
    {{ trans('gallery::gallery.title.all albums') }}
@endsection

@section('content')
    <router-view keep-alive></router-view>
@endsection

@section('javascript')
    <script src="{{\Pingpong\Modules\Facades\Module::asset('gallery:js/gallery.js')}}"></script>
@endsection
