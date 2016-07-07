<?php namespace AgreableAdvertPlugin;

/** @var \Herbert\Framework\Panel $panel */

$panel->add([
    'type'   => 'panel',
    'as'     => 'advertsPanel',
    'title'  => 'Adverts',
    'slug'   => 'adverts-index',
    'icon'   => 'dashicons-layout',
    'uses'   => __NAMESPACE__ . '\Controllers\PanelController@index'
]);
