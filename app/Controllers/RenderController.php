<?php namespace AgreableAdvertPlugin\Controllers;
use AgreableAdvertPlugin\Helper;
use \Exception;
class RenderController {
  public function enqueue(){
    /*
     * @AgreableAdvertPlugin is a Twig namespace which Herbert generates from
     * values in herbert.config.php.
     * @see http://twig.sensiolabs.org/doc/api.html#loaders
     *
     * Using get_field() which is an ACF function to retrieve theme
     * specific options affecting the style of the promo.
     * ACF definitions for Panel are in app/panels.php.
     */
    $ns = Helper::get('agreable_namespace');
    $plugin_root = realpath(__DIR__ . '/../..');
    $js_string = file_get_contents($plugin_root . '/resources/assets/dfp.js');
    echo view('@AgreableAdvertPlugin/files.twig', [
      'env' => getenv('WP_ENV'),
      'js_string' =>  $js_string,
    ])->getBody();
  }
}