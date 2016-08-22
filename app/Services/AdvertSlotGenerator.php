<?php
namespace AgreableAdvertPlugin\Services;

require_once get_template_directory() . "/libs/services/CategoryService.php";

use \AgreableCategoryService;
use \stdClass;

class AdvertSlotGenerator {
  public static function get_advert($post, $generic_type, $position = 'manual', $category_override = null) {
    $categories = AgreableCategoryService::get_post_category_hierarchy($post);

    $ad_slot = new stdClass();

    if ($category_override) {
      $ad_slot->category = $category_override;
    } else if ($categories->parent->slug) {
      $ad_slot->category = $categories->parent->slug;
    }

    if ($categories->child) {
      $ad_slot->sub_category = $categories->child->slug;
    }

    $ad_slot->network = get_field('advert_account_network', 'adverts-configuration');
    $ad_slot->zone_prefix = get_field('advert_account_zone_prefix', 'adverts-configuration');
    $ad_slot->zone = $ad_slot->zone_prefix . '/' . $ad_slot->category;

    $ad_slot->position = $position;
    $ad_slot->generic_type = $generic_type;
    $ad_slot->devices = [];
    switch ($ad_slot->generic_type) {
      case 'vertical':
        $creative_sizes = new stdClass();
        $creative_sizes->type = 'mobile';
        $creative_sizes->creative_sizes = '300x600,300x250';
        $ad_slot->devices[] = $creative_sizes;

        $creative_sizes = new stdClass();
        $creative_sizes->type = 'tablet';
        $creative_sizes->creative_sizes = '300x600,300x250';
        $ad_slot->devices[] = $creative_sizes;

        $creative_sizes = new stdClass();
        $creative_sizes->type = 'desktop';
        $creative_sizes->creative_sizes = '300x600,300x250';
        $ad_slot->devices[] = $creative_sizes;
        break;
      case 'horizontal':
        $creative_sizes = new stdClass();
        $creative_sizes->type = 'mobile';
        $creative_sizes->creative_sizes = '320x50';
        $ad_slot->devices[] = $creative_sizes;

        $creative_sizes = new stdClass();
        $creative_sizes->type = 'tablet';
        $creative_sizes->creative_sizes = '728x90,728x250';
        $ad_slot->devices[] = $creative_sizes;

        $creative_sizes = new stdClass();
        $creative_sizes->type = 'desktop';
        $creative_sizes->creative_sizes = '970x250,970x90,728x90';
        $ad_slot->devices[] = $creative_sizes;
        break;
      case 'skin-l':
      case 'skin-r':
        $creative_sizes = new stdClass();
        $creative_sizes->type = 'desktop';
        $creative_sizes->creative_sizes = '300x900';
        $ad_slot->devices[] = $creative_sizes;
        break;
      default:
        throw new \Exception('Unknown ad slot generic_type: ' . $ad_slot->generic_type);
        break;
    }

    return apply_filters('agreable_advert_slot_generator_filter', $ad_slot);
  }
}
