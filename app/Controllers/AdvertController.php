<?php
namespace AgreableAdvertPlugin\Controllers;

use \Exception;

class AdvertController {

  public function view_category($category_slug, $generic_name, $position) {
    $config = [
      'category' => $category_slug,
      'generic_name' => $generic_name,
      'position' => $position,
    ];
    $this->render_advert($config);
  }

  public function view_category_sub($category_slug, $sub_category_slug, $generic_name, $position) {
    $config = [
      'category' => $category_slug,
      'category_sub' => $sub_category_slug,
      'generic_name' => $generic_name,
      'position' => $position,
    ];

    $this->render_advert($config);
  }

  protected function render_advert($config) {
    // $twig =
    // $twig_service = Herbert\Framework\Providers\TwigServiceProvider();
    $timber_loader = new \TimberLoader();

    $twig = $timber_loader->get_twig();
    // $twig = $timber_loader->get_twig();
    herbert('Twig_Environment')->addFunction( new \Twig_SimpleFunction('advert_data',
        array('AgreableAdvertPlugin\Services\AdvertSlotGenerator', 'get_advert')));

    // $context = \Timber::get_context();

    // $twig->render('@AgreableAdvertPlugin/views/advert.twig', $context); exit;

    $post_id = 569; // Hello Kitty
    $post = new \TimberPost($post_id);
    if (!$post) {
      throw new Exception('Unable to retrieve post ID ' . $post);
    }

    $plugin_root = realpath(__DIR__ . '/../..');
    $js_string = file_get_contents($plugin_root . '/resources/assets/dfp.js');

    echo view('@AgreableAdvertPlugin/advert.twig', [
      'post' => $post,
      'js_string' => $js_string,
    ])->getBody();

  }
}
