<?php namespace AgreableAdvertPlugin\Hooks;

use AgreableAdvertPlugin\Helper;
use AgreableAdvertPlugin\Controllers\RenderController;

// use Herbert\Framework\Enqueue;

class SLMPluginEnqueue {

  public function init() {
    \add_action('agreable_advert-slot_enqueue', array($this, 'plugin_enqueue'), 10, 0);
  }

  public function plugin_enqueue(){
    $r = new RenderController();
    $r->enqueue();
  }

}
