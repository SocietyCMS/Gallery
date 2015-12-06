<?php

$api->version('v1', function ($api) {
    $api->group([
        'prefix' => 'gallery',
        'namespace' => $this->namespace . '\api',
        'middleware' => config('society.core.core.middleware.api.backend', []),
        'providers' => ['jwt']
    ], function ($api) {

        $api->resource('album', 'AlbumController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
        $api->resource('album.photo', 'AlbumPhotoController',
            ['only' => ['index', 'store', 'show', 'update', 'destroy']]);

    });
});
