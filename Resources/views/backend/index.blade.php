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

	<div class="ui cards">

		<div class="ui special card" v-for="album in gallery" style="display: none" v-show="gallery">

			<div class="blurring dimmable image" >
				<div class="ui dimmer">
					<div class="content">
						<div class="center">
							<a v-bind:href="album.links.backend" class="ui inverted button">Edit Gallery</a>
						</div>
					</div>
				</div>
				<img src="" v-bind:src="album.cover.data.image.thumbnail.cover">
			</div>

			<div class="content">
				<a v-bind:href="album.links.backend" class="header">@{{ album.title }}</a>
				<div class="meta">
					<span class="date"></span>
				</div>
				<div class="description">

				</div>
			</div>
			<div class="extra content">
				<a v-bind:href="album.links.backend" class="right floated star">
					<i class="pencil icon"></i>
					Edit
				</a>
			</div>
		</div>
	</div>

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
					{{ trans('core::elements.button.cancel') }}
				</div>
				<div class="ui positive right labeled icon button">
					{{ trans('core::elements.button.create') }}
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
					this.$set('gallery', data.data);
					this.$set('meta', data.meta);

					setTimeout(function(){
								$('.special.card .image').dimmer({
									on: 'hover'
								});}, 0);

				}).error(function (data, status, request) {
				})
			}

		});



	</script>
@endsection
