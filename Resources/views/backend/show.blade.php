@extends('layouts.master')

@section('title')
    {{ trans('gallery::gallery.title.gallery') }}
@endsection
@section('subTitle')
    {{ $album->title }}
@endsection

@section('content')


	<div class="ui active text loader" v-show="!loaded">Loading</div>

	<div class="ui grid">
		<div class="twelve wide column qq-upload-drop-area" id="photosGrid">
			<div class="ui segment sticky" id="albumToolbar">

				<div id="uploadButton">
					<div class="ui basic button" id="uploadImageButton">
						<i class="icon photo"></i>
						Add Photo
					</div>
					<div class="ui red basic right floated button" id="deleteAlbumButton">Delete Gallery</div>
				</div>

				<div class="ui indicating right floated progress qq-drop-processing-selector qq-drop-processing" id="uploadProgrssbar" style="display: none">
					<div class="bar"></div>
					<div class="label">Processing dropped files...</div>
				</div>

			</div>

			<div class="ui grid">
				<div class="eight wide tablet two wide computer photo column"  v-for="photo in album" v-bind:class="{'selected': photo == detailPhoto }" v-on:click="detail(photo)">
					<a class="ui basic photo raised segment">
						<div class="photo image"><img class="ui image" v-bind:src="photo.image.thumbnail.small"></div>
						<div class="photo title">@{{photo.title}}</div>
					</a>
				</div>
				<div class="eight wide tablet two wide computer photo column">
					<a class="ui basic photo drop indicator segment">
						<div class="photo image"></div>
						<div class="photo title"></div>
					</a>
				</div>
			</div>
		</div>

		<div class="four wide column">

            <div class="ui sticky" id="photosDetail" v-show="detailPhoto">
                <div class="ui raised segments">

                    <div class="ui segment">
                        <img class="ui image" v-bind:src="detailPhoto.image.thumbnail.large">

                    </div>
                    <div class="ui segment">

                            <form class="ui form">
                                <div class="field">
                                    <label>Title</label>
                                    <input type="text" name="title" placeholder="" v-model="detailPhoto.title" v-on:change="updatePhoto">
                                </div>
                                <div class="field">
                                    <label>Caption</label>
                                    <input type="text" name="caption" placeholder="" v-model="detailPhoto.caption" v-on:change="updatePhoto">
                                </div>
                            </form>

                            <table class="ui very basic celled table">
                                <tbody>
                                <tr>
                                    <td>
                                        <h4 class="ui header">
                                            Size:
                                        </h4></td>
                                    <td>
                                        @{{ detailPhoto.properties.humanReadableSize}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4 class="ui header">
                                            Uploaded on:
                                        </h4></td>
                                    <td>
                                        @{{ detailPhoto.properties.uploaded_on}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4 class="ui header">
                                            Modified on:
                                        </h4></td>
                                    <td>
                                        @{{ detailPhoto.properties.modified_on}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                    </div>
                    <div class="ui segment">
                        <button class="negative ui button" id="photoDeleteButton">Delete</button>
                    </div>
                </div>
            </div>
		</div>
	</div>

@endsection

@section('htmlComponents')
    <div class="ui small basic test modal" id="photoDeleteModal">

        <img class="ui centered medium image" v-bind:src="detailPhoto.image.thumbnail.large">

        <div class="ui centered aligned content">
            You are about to delete this photo, are you sure?
        </div>
        <div class="actions">
            <div class="ui basic cancel inverted button">
                <i class="remove icon"></i>
                No
            </div>
            <div class="ui red approve inverted button" v-on:click="deletePhoto">
                <i class="checkmark icon"></i>
                Yes
            </div>
        </div>
    </div>

@endsection

@section('styles')
	<link href="{{\Pingpong\Modules\Facades\Module::asset('gallery:css/Gallery.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('javascript')
	<script>
        $('#photoDeleteModal')
                .modal('attach events', '#photoDeleteButton', 'show');

        $('#albumToolbar')
                .sticky( {
                    observeChanges: true
                });

        $('#photosDetail')
                .sticky({
                    context: '#photosGrid',
                    observeChanges: true
                });



        VueInstance = new Vue({
			el: '#societyAdmin',
			data: {
				album:null,
				meta:null,
				detailPhoto: null,
				loaded: false
			},
			ready: function() {

				this.$http.get('{{apiRoute('v1', 'api.gallery.album.photo.index', ['album' => $album->slug])}}', function (data, status, request) {

                    this.$set('album', data.data);
					this.$set('meta', data.meta);
					this.$set('loaded', true);

                    this.detail(data.data[0])

				}).error(function (data, status, request) {
				});

			},
			methods: {
				detail: function (photo) {
					this.detailPhoto = photo;
				},
				updatePhoto: function() {
					var resource = this.$resource('{{apiRoute('v1', 'api.gallery.album.photo.update', ['album' => $album->slug, 'photo' => ':id'])}}');

					resource.update({id: this.detailPhoto.id}, this.detailPhoto, function (data, status, request) {
					}).error(function (data, status, request) {
					});
				},
				addPhoto: function(photo) {
					this.album.push(photo.data);
				},
                deletePhoto: function() {

                    var resource = this.$resource('{{apiRoute('v1', 'api.gallery.album.photo.destroy', ['album' => $album->slug, 'photo' => ':id'])}}');

                    resource.delete({id: this.detailPhoto.id}, this.detailPhoto, function (data, status, request) {
                        this.album.$remove(this.detailPhoto);
                        this.detailPhoto = this.album[0];
                        $('#deletePhotoModal').modal('hide');
                    }).error(function (data, status, request) {
                    });
                },
				deleteAlbum: function() {
					var resource = this.$resource('{{apiRoute('v1', 'api.gallery.album.destroy', ['album' => $album->slug])}}');

					resource.delete(function (data, status, request) {
						window.location.replace("{{route('backend::gallery.gallery.index')}}");
					}).error(function (data, status, request) {
					});
				}
			}

        });


		var dragAndDropModule = new fineUploader.DragAndDrop({
			dropZoneElements: [document.getElementById('photosGrid')],
			classes: {
				dropActive: "cssClassToAddToDropZoneOnEnter"
			},
			callbacks: {
				processingDroppedFilesComplete: function (files, dropTarget) {
					fineUploaderBasicInstanceImages.addFiles(files);
				}
			}
		});

		var fineUploaderBasicInstanceImages = new fineUploader.FineUploaderBasic({
			button: document.getElementById('uploadImageButton'),
			request: {
				endpoint: '{{app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.gallery.album.photo.store', ['album' => $album->slug])}}',
				customHeaders: {
					"Authorization": "Bearer {{$jwtoken}}"
				},
				inputName: 'image'
			},
			validation: {
				allowedExtensions: ['jpeg', 'jpg', 'png', 'bmp']
			},
			callbacks: {
				onComplete: function (id, name, responseJSON) {
					VueInstance.addPhoto(responseJSON)
				},
				onUpload: function() {
					$('#uploadButton').hide();
					$('#uploadProgrssbar').show();
				},
				onTotalProgress: function(totalUploadedBytes, totalBytes) {
					$('#uploadProgrssbar').progress({
						percent: Math.ceil(totalUploadedBytes / totalBytes * 100)
					});
				},
				onAllComplete: function(succeeded, failed) {
					$('#uploadButton').show();
					$('#uploadProgrssbar').hide();
					$('#uploadProgrssbar').progress({
						percent: 0
					});
				}
			}
		});


		$('#deleteAlbumButton').click(function(){VueInstance.deleteAlbum()});

    </script>

@endsection
