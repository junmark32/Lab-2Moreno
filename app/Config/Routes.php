<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->get('playlist', 'PlaylistController::index');
$routes->post('playlist/store', 'PlaylistController::store_pl');
$routes->get('/playlist/display/(:num)', 'PlaylistController::display/$1');


$routes->post('song/store', 'SongController::store_song');
$routes->post('song/store/playlist', 'SongController::addToPlaylist');
