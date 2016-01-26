<?php

$router->group(['prefix' => '/gallery'], function ($router) {
    // Gallery
    $router->group(['middleware' => ['permission:gallery::manage-gallery']], function () {
        get('gallery', ['as' => 'backend::gallery.gallery.index', 'uses' => 'GalleryController@index']);
        get('gallery/create', ['as' => 'backend::gallery.gallery.create', 'uses' => 'GalleryController@create']);
        get('gallery/{slug}', ['as' => 'backend::gallery.gallery.show', 'uses' => 'GalleryController@show']);
    });

});
