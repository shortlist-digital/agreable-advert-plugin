<?php namespace AgreableAdvertPlugin\Hooks;

use AgreableAdvertPlugin\Helper;
use AgreableAdvertPlugin\Controllers\RenderController;

// use Herbert\Framework\Enqueue;

class SLMPluginEnqueue {

  // Only enqueue the JS once to the page
  static protected $advert_code_enqueued = false;

  public function init() {
    // \add_action('agreable_advert-slot_enqueue', array($this, 'plugin_enqueue'), 10, 0);
    \add_action('wp_enqueue_scripts', array($this, 'plugin_enqueue'), 10, 0);
  }

  public function plugin_enqueue(){
    // Has the code already been enqueued once?
    if (self::$advert_code_enqueued === false) {
      $r = new RenderController();
      $r->enqueue();

      self::$advert_code_enqueued = true;
    }
  }

}
