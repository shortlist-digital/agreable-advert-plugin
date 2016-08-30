<?php namespace AgreableAdvertPlugin\Hooks;

use add_filter;
use AgreableCategoryService;

class DfpZone {

  public function init() {
    add_action('wp_head', array($this, 'add_dfp_zone'));
  }

  public function add_dfp_zone() {
    $network = get_field('advert_account_network', 'adverts-configuration');
    $zone_prefix = get_field('advert_account_zone_prefix', 'adverts-configuration');
    global $post;
    if ($post) {
      $categories = AgreableCategoryService::get_post_category_hierarchy($post);
    }


    $out = '<script>';

    if (isset($categories->parent)) {
      $zone = $zone_prefix . '/' . $categories->parent->slug;
      $out .= <<<OUT
window.agreableAdvert = {
  network: '{$network}',
  zone_prefix: '{$zone_prefix}',
  zone: '{$zone}'
}
OUT;
    } else {
      $out .= 'console.warn("No category found, unable to load adverts")';
    }

    $out .= '</script>';

    echo $out;
  }
}
