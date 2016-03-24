<?php namespace AgreableAdvertPlugin\Services;

use \stdClass;

class AdvertSlotGenerator {
  public static function get_advert($advert_widget, $post, $rowWidgetIndex, $elementId) {

    $post_categories = \wp_get_post_categories($post->id);
    $categories = array();

    foreach($post_categories as $c){
      $cat = get_category($c);
      $categories[] = ['name' => $cat->name, 'slug' => $cat->slug];
    }

    $ad_slot = new stdClass();

    if (count($categories) >= 1) {
      $ad_slot->category = $categories[0]['slug'];
    } else {
      $ad_slot->category = null;
    }

    if (count($categories) == 2) {
      $ad_slot->sub_category = $categories[1]['slug'];
    } else {
      $ad_slot->sub_category = null;
    }

    $ad_slot->pageType = 'article';
    $ad_slot->accountPrefix = get_field('advert_account_prefix', 'option');

    $ad_slot->art_name = substr($post->slug, 0, 40);

    if ($advert_widget['type'] === 'vertical') {
      $ad_slot->typeTag = '300x600';
      $ad_slot->type = 'vertical';

      $ad_slot->mobile = new stdClass();
      $ad_slot->mobile->creativeSizes = [[300, 601], [300, 251]];
      $ad_slot->mobile->postfix = 'mobile';

      $ad_slot->tablet = new stdClass();
      $ad_slot->tablet->creativeSizes = [[300, 602], [300, 252]];
      $ad_slot->tablet->postfix = [1, 2, 'infinite'];

      $ad_slot->desktop = new stdClass();
      $ad_slot->desktop->creativeSizes = [[300, 600], [300, 250]];
      $ad_slot->desktop->postfix = [1, 2, 'infinite'];
    } else if ($advert_widget['type'] === 'horizontal') {
      $ad_slot->typeTag = '970x250';
      $ad_slot->type = 'horizontal';
      $ad_slot->mobile = new stdClass();
      $ad_slot->mobile->creativeSizes = [[320, 50]];
      $ad_slot->mobile->postfix = ['1A', 2, 'infinite'];

      $ad_slot->tablet = new stdClass();
      $ad_slot->tablet->creativeSizes = [[728, 91], [728, 250]];
      $ad_slot->tablet->postfix = ['1A', 2, 'infinite'];

      $ad_slot->desktop = new stdClass();
      $ad_slot->desktop->creativeSizes = [[970, 250], [970, 90], [728, 90]];
      $ad_slot->desktop->postfix = ['1A', 2, 'infinite'];
    } else {
      throw new \Exception('Unknown advert widget $type: ' . $advert_widget->type);
    }

    return apply_filters('agreable_advert_slot_generator_filter', $ad_slot);
  }

  public static function generate_advert_widget($type) {
    $widget = ['type' => $type];
    return $widget;
  }
}
