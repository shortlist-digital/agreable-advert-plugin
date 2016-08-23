<?php
namespace AgreableAdvertPlugin\Services;

require_once get_template_directory() . "/libs/services/CategoryService.php";

use \AgreableCategoryService;
use \stdClass;
use \AgreableAdvertPlugin\Services\AdvertSlotTypes;

class AdvertSlotGenerator {
  public static function get_advert($post, $type, $key_values = [],
    $overrides = null) {

    $categories = AgreableCategoryService::get_post_category_hierarchy($post);

    $ad_slot = new stdClass();

    if ($overrides && isset($overrides->category)) {
      $ad_slot->category = $overrides->category;
    } else if ($categories->parent->slug) {
      $ad_slot->category = $categories->parent->slug;
    }

    $ad_slot->network = get_field('advert_account_network', 'adverts-configuration');
    $ad_slot->zone_prefix = get_field('advert_account_zone_prefix', 'adverts-configuration');
    $ad_slot->zone = $ad_slot->zone_prefix . '/' . $ad_slot->category;

    $advert_type = AdvertSlotTypes::get('horizontal');

    var_dump($advert_type); exit;


    return apply_filters('agreable_advert_slot_generator_filter', $ad_slot);
  }
}
