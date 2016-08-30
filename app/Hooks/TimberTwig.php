<?php namespace AgreableAdvertPlugin\Hooks;

use add_filter;
use Twig_SimpleFunction;
use stdClass;

class TimberTwig {

  public function init() {
    add_filter('get_twig', array($this, 'add_to_twig'), 10);
    add_filter('timber/loader/paths', array($this, 'add_timber_paths'));
    add_filter('timber_context', array($this, 'add_to_context'));
  }

  public function add_to_twig($twig){
    $twig->addFunction(
      new Twig_SimpleFunction('get_advert_data',
        array('AgreableAdvertPlugin\Services\AdvertSlotGenerator', 'get_advert_data')));

    $twig->addFunction(
      new Twig_SimpleFunction('get_advert_html',
        array('AgreableAdvertPlugin\Services\AdvertSlotGenerator', 'get_advert_html')));

    return $twig;
  }

  public function add_to_context($context) {
    $context['advert_plugin'] = new stdClass();
    $context['advert_plugin']->js_string = $this->get_javascript_string();
    return $context;
  }

  protected function get_javascript_string() {
    $plugin_root = realpath(__DIR__ . '/../..');
    $port_file = 'webpack-current-port.tmp';
    $port_file_location = $plugin_root . '/' . $port_file;

    $javascript_string = '';

    if (getenv('WP_ENV') === 'development' && file_exists($port_file_location)) {
      $port_number = file_get_contents($port_file_location);
      $javascript_string .= "<script src='http://localhost:$port_number/static/app.js'></script>";
    } else {
      $javascript_string .= '<script>' . file_get_contents($plugin_root .
        '/../resources/assets/app.js') . '</script>';
    }

    $javascript_string .= '<script>' . file_get_contents($plugin_root .
      '/resources/assets/dct-dfp.js') . '</script>';

    return $javascript_string;
  }

  public function add_timber_paths($paths){
    $herbert_config = include __DIR__ . '/../../herbert.config.php';

    array_push($paths, ['AgreableAdvertPlugin' => __DIR__ . '/../../resources/views']);
    return $paths;
  }
}
