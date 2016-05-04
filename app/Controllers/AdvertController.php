<?php
namespace AgreableAdvertPlugin\Controllers;

use \Exception;

class AdvertController {

  public function view($post_id, $generic_name, $position) {

    herbert('Twig_Environment')->addFunction( new \Twig_SimpleFunction('advert_data',
      array('AgreableAdvertPlugin\Services\AdvertSlotGenerator', 'get_advert')));

    $post = new \TimberPost($post_id);
    if (!$post) {
      throw new Exception('Unable to retrieve post ID ' . $post);
    }

    $plugin_root = realpath(__DIR__ . '/../..');
    $js_string = file_get_contents($plugin_root . '/resources/assets/dfp.js');

    echo view('@AgreableAdvertPlugin/advert.twig', [
      'post' => $post,
      'js_string' => $js_string,
      'position' => $position,
      'generic_name' => $generic_name,
    ])->getBody();
  }
}