@extends('layouts.master')

@section('title')
    {{ trans('gallery::gallery.title.gallery') }}
@endsection
@section('subTitle')
    {{ trans('gallery::gallery.title.all albums') }}
@endsection

@section('content')

	<div class="ui blue segment">
		<a href="#" id="createNewAlbumButton" class="fluid ui blue button">{{trans('gallery::gallery.button.create album')}}</a>
	</div>

	<a v-bind:href="album.links.backend" class="ui compact left floated center aligned piled segment" v-for="album in gallery" class="gallery images" style="display: none" v-show="gallery">
		<img v-if="album.cover" class="ui small image" src="{{\Pingpong\Modules\Facades\Module::asset('gallery:images/no-preview.png')}}" v-bind:src="album.cover.data.image.thumbnail.square" >
		<img v-if="!album.cover" class="ui small image" src="{{\Pingpong\Modules\Facades\Module::asset('gallery:images/no-preview.png')}}" alt="">
		<h4 class="ui header">@{{ album.title }}</h4>
	</a>


@endsection

@section('htmlComponents')
		<form class="ui modal" id="createNewAlbumModal">
			<i class="close icon"></i>
			<div class="header">
				{{trans('gallery::gallery.button.create album')}}
			</div>
			<div class="content">
				<div class="ui form">
					<div class="field">
						<label>Album name:</label>
						<input type="text" name="title">
					</div>
				</div>
			</div>
			<div class="actions">
				<div class="ui black deny button">
					{{ trans('core::core.button.cancel') }}
				</div>
				<div class="ui positive right labeled icon button">
					{{ trans('core::core.button.create') }}
					<i class="checkmark icon"></i>
				</div>
			</div>
		</form>
@endsection


@section('javascript')

	<script>

		$('#createNewAlbumModal')
				.modal('attach events', '#createNewAlbumButton', 'show');

		$('#createNewAlbumModal .positive.button')
				.api({
					url: '{{apiRoute('v1', 'api.gallery.album.store')}}',
					method : 'POST',
					serializeForm: true,
					data: {
					},
					beforeXHR: function(xhr) {
						xhr.setRequestHeader ('Authorization', 'Bearer {{$jwtoken}}');
						return xhr;
					},
					onSuccess: function(response) {
						location.reload();
					}
				});


		new Vue({
			el: '#societyAdmin',
			data: {
				gallery:null,
				meta:null
			},
			ready: function() {
				this.$http.get('{{apiRoute('v1', 'api.gallery.album.index')}}', function (data, status, request) {
					this.$set('gallery', data.data)
					this.$set('meta', data.meta);

				}).error(function (data, status, request) {
				})
			}

		});

	</script>
@endsection
