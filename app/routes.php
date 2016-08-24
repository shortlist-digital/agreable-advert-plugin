<?php namespace AgreableAdvertPlugin;

/** @var \Herbert\Framework\Router $router */

$router->get([
  'as'   => 'advertView',
  'uri'  => '/advert/{post_id}/{display_type}/{key_values}',
  'uses' => __NAMESPACE__ . '\Controllers\AdvertController@view'
]);
