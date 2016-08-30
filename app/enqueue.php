<?php namespace AgreableAdvertPlugin;

/** @var \Herbert\Framework\Enqueue $enqueue */

$enqueue->front([
    'as'     => 'DctDfpJS',
    'src'    => Helper::assetUrl('/dct-dfp.js')
]);
