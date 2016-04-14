<?php namespace AgreableAdvertPlugin;

/** @var \Herbert\Framework\Router $router */

$router->get([
  'as'   => 'advertView',
  'uri'  => '/advert/{category_slug}/{sub_category_slug}/{generic_name}/{position}',
  'uses' => __NAMESPACE__ . '\Controllers\AdvertController@view_category_sub'
]);

$router->get([
  'as'   => 'advertView',
  'uri'  => '/advert/{category_slug}/{generic_name}/{position}',
  'uses' => __NAMESPACE__ . '\Controllers\AdvertController@view_category'
]);

