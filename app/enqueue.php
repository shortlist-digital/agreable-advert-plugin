<?php namespace AgreableAdvertPlugin;

/** @var \Herbert\Framework\Enqueue $enqueue */

$enqueue->front([
  'as'     => 'agreabltAdvertPluginEnqueueScript',
  'src'    => Helper::assetUrl('dfp.js'),
  'filter' => [ 'postType' => 'features-post' ]
]);
