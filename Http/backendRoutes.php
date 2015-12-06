<?php

$router->group(['prefix' => '/gallery'], function () {
    get('gallery', ['as' => 'backend::gallery.gallery.index', 'uses' => 'GalleryController@index']);
    get('gallery/{slug}', ['as' => 'backend::gallery.gallery.show', 'uses' => 'GalleryController@show']);
});
