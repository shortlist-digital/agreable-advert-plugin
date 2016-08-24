<?php
namespace AgreableAdvertPlugin\Controllers;

use \Exception;
use \Timber;
use \TimberPost;

class AdvertController {

  public function view($post_id, $display_type, $key_values) {

    $post = new TimberPost($post_id);

    if (!$post) {
      throw new Exception('Unable to retrieve post ID ' . $post);
    }

    $context = Timber::get_context();
    $context['post'] = $post;
    $context['display_type'] = $display_type;

    $key_values = $this->map_key_values_to_array($key_values);

    $context['key_values'] = $key_values;

    Timber::render('@AgreableAdvertPlugin/advert-embed.twig', $context, false);
  }

  /**
   * Map URL params to arrays:
   * Input: "pos=top,will=biscuit"
   * Output: [["pos" => "top"], ["will" => "biscuit"]]
   */
  protected function map_key_values_to_array($key_values_string) {
    return array_map(function($key_value) {
      $key_value_array = explode('=', $key_value);
      return [$key_value_array[0] => $key_value_array[1]];
    }, explode(',', $key_values_string));
  }
}
