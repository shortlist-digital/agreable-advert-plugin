<?php namespace AgreableAdvertPlugin\Services;

use \stdClass;

class AdvertSlotGenerator {
  public static function get_vertical_advert($advert_widget, $category, $rowWidgetIndex, $elementId) {
    $ad_slot = self::get_basic_ad_slot();
    $ad_slot->section = $category->slug;
    $ad_slot->pageType = "Article";

    if ($advert_widget['type'] === 'vertical') {
      $ad_slot->type = 'vertical';
      $ad_slot->typeTag = "300x600";
      $ad_slot->creativeSizes = [[300, 600], [300, 250]];
      $ad_slot->index = 1;
    } else if ($advert_widget['type'] === 'horizontal') {
      $ad_slot->type = 'horizontal';
      $ad_slot->typeTag = "970x250";
      $ad_slot->index = '1A';
      $ad_slot->creativeSizes = [[970, 250], [728, 90], [320, 50]];
    } else {
      throw new \Exception('Unknown advert widget $type: ' . $advert_widget->type);
    }

    $ad_slot->tag = self::generate_ad_tag($ad_slot);
    return apply_filters('agreable_advert_slot_generator_filter', $ad_slot);
  }

  protected static function get_basic_ad_slot() {
    $ad = new stdClass();
    $ad->account = get_field('advert_account_prefix', 'option');
    $ad->section = "";
    $ad->pageType = "";
    $ad->typeTag = "";
    $ad->index = 0;
    $ad->creativeSizes = [];
    return $ad;
  }

  protected static function generate_ad_tag($ad_slot) {
    return "/" . $ad_slot->account . "_" . $ad_slot->section . "_" . $ad_slot->pageType . "_" . $ad_slot->typeTag . "_" . $ad_slot->index;
  }
}
