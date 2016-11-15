<?php namespace AgreableAdvertPlugin\Hooks;

use add_filter;
use AgreableCategoryService;
use AgreableAdvertPlugin\Services\AdvertSlotGenerator;

class DfpZone {

  public function init() {
    add_action('wp_head', array($this, 'add_dfp_zone'));
  }

  public function add_dfp_zone() {
    global $post;

    echo AdvertSlotGenerator::get_adverts_page_setup_html($post);
  }
}
