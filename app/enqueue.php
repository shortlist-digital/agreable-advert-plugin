<?php namespace AgreableAdvertPlugin;

/** @var \Herbert\Framework\Enqueue $enqueue */

$enqueue->front([
  'as'     => 'advertJS',
  'src'    => Helper::assetUrl('dfp.js'),
  // 'filter' => [ 'postType' => 'features-post' ]
  'filter' => [ 'page' => '*' ]
]);
