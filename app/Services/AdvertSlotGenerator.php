<?php
namespace AgreableAdvertPlugin\Services;

require_once get_template_directory() . "/libs/services/CategoryService.php";

use \AgreableCategoryService;
use \stdClass;
use \AgreableAdvertPlugin\Services\AdvertSlotTypes;
use \Timber;

class AdvertSlotGenerator {
  public static function get_advert_html($post, $display_type, $key_values = [],
    $overrides = null) {

    $context = Timber::get_context();
    $context['post'] = $post;
    $context['display_type'] = $display_type;
    $context['key_values'] = $key_values;

    Timber::render('@AgreableAdvertPlugin/advert-container.twig', $context, false);
  }

  public static function get_advert_data($post, $display_type, $key_values = [],
    $overrides = null) {

    $categories = AgreableCategoryService::get_post_category_hierarchy($post);

    $advert = AdvertSlotTypes::get($display_type);

    if ($overrides && isset($overrides->category)) {
      $advert['category'] = $overrides->category;
    } else if ($categories->parent->slug) {
      $advert['category'] = $categories->parent->slug;
    }
    $advert['key_values'] = $key_values;
    $advert['network'] = get_field('advert_account_network', 'adverts-configuration');
    $advert['zone_prefix'] = get_field('advert_account_zone_prefix', 'adverts-configuration');
    $advert['zone'] = $advert['zone_prefix'] . '/' . $advert['category'];

    return apply_filters('agreable_advert_slot_generator_filter', $advert);
  }
}
