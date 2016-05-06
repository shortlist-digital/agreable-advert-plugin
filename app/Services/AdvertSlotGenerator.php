<?php
namespace AgreableAdvertPlugin\Services;

require_once get_template_directory() . "/libs/services/CategoryService.php";

use \AgreableCategoryService;
use \stdClass;

class AdvertSlotGenerator {
  public static function get_advert($post, $display_type, $content_type = 'article', $category_override = null, $art_name_override = null, $section_override = null, $post_fix_override = null) {
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

    if ($section_override) {
      $ad_slot->section = $section_override;
    } else {
      $section_map = [
        'fashion' => '2003',
        'beauty' => '2001',
        'books' => '2002',
        'life' => '2006',
        'people' => '2007',
        'travel' => '2009',
        'win' => '2010',
      ];

      if (isset($section_map[$categories->parent->slug])) {
        $ad_slot->section = $section_map[$categories->parent->slug];
      } else {
        $ad_slot->section = $categories->parent->slug;
      }
    }

    $ad_slot->contentType = $content_type;
    $ad_slot->accountPrefix = get_field('advert_account_prefix', 'option');

    if ($art_name_override) {
      $ad_slot->art_name = $art_name_override;
    } else {
      $ad_slot->art_name = substr($post->slug, 0, 40);
    }

    $ad_slot->displayType = $display_type;
    switch ($display_type) {
      case 'vertical':
        $ad_slot->typeTag = '300x600';

        $ad_slot->mobile = new stdClass();
        $ad_slot->mobile->creativeSizes = [/*[300, 601], */[300, 251]];
        $ad_slot->mobile->postfix = 'mobile';

        $ad_slot->tablet = new stdClass();
        $ad_slot->tablet->creativeSizes = [[300, 602], [300, 252]];
        $ad_slot->tablet->postfix = [1, 2, 'infinite'];

        $ad_slot->desktop = new stdClass();
        $ad_slot->desktop->creativeSizes = [[300, 600], [300, 250]];
        $ad_slot->desktop->postfix = [1, 2, 'infinite'];
        break;
      case 'horizontal':
        $ad_slot->typeTag = '970x250';
        $ad_slot->mobile = new stdClass();
        $ad_slot->mobile->creativeSizes = [[320, 50]];
        $ad_slot->mobile->postfix = ['1A', 2, 'infinite'];

        $ad_slot->tablet = new stdClass();
        $ad_slot->tablet->creativeSizes = [[728, 91], [728, 250]];
        $ad_slot->tablet->postfix = ['1A', 2, 'infinite'];

        $ad_slot->desktop = new stdClass();
        $ad_slot->desktop->creativeSizes = [[970, 250], [970, 90], [728, 90]];
        $ad_slot->desktop->postfix = ['1A', 2, 'infinite'];
        break;
      case 'SkinL':
        $ad_slot->typeTag = 'SkinL';
        $ad_slot->desktop = new stdClass();
        $ad_slot->desktop->creativeSizes = [[2, 1], [312, 900]];
        $ad_slot->desktop->postfix = [1];
        break;
      case 'SkinR':
        $ad_slot->typeTag = 'SkinR';
        $ad_slot->desktop = new stdClass();
        $ad_slot->desktop->creativeSizes = [[2, 2], [312, 901]];
        $ad_slot->desktop->postfix = [1];
        break;
      default:
        throw new \Exception('Unknown advert widget $display_type: ' . $display_type);
        break;
    }

    if ($post_fix_override) {
      $ad_slot->postFixOverride = $post_fix_override;
    }

    return apply_filters('agreable_advert_slot_generator_filter', $ad_slot);
  }

  public static function generate_advert_widget($type) {
    $widget = ['type' => $type];
    return $widget;
  }
}
