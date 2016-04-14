<?php namespace AgreableAdvertPlugin;

/** @var \Herbert\Framework\Router $router */

$router->get([
  'as'   => 'advertView',
  'uri'  => '/advert/{post_id}/{generic_name}/{position}',
  'uses' => __NAMESPACE__ . '\Controllers\AdvertController@view'
]);