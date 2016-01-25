@extends('layouts.master')

@section('title')
    {{ trans('gallery::gallery.title.gallery') }}
@endsection
@section('subTitle')
    {{ $album->title }}
@endsection

@section('content')

	<div class="ui massive transparent fluid icon input">
		<input type="text" placeholder="Album Title" value="{{ $album->title }}">
		<i class="write icon"></i>
	</div>

	<div class="ui divider"></div>

	<div class="ui photos" id="masonry">
		<photo :photo="photo" v-for="photo in album"></photo>
	</div>

@endsection

@section('styles')
	<link href="{{\Pingpong\Modules\Facades\Module::asset('gallery:css/Gallery.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('javascript')
	<script>

		var resourceGalleryAlbumPhotoIndex = '{{apiRoute('v1', 'api.gallery.album.photo.index', ['album' => $album->slug])}}';

	</script>
	<script src="{{\Pingpong\Modules\Facades\Module::asset('gallery:js/album.js')}}"></script>

@endsection
