<?php

$router->get('gallery', ['uses' => 'PublicController@index', 'as' => 'gallery.index']);
$router->get('gallery/{slug}', ['uses' => 'PublicController@show', 'as' => 'gallery.show']);
