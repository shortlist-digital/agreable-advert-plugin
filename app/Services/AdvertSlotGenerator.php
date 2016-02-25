<?php namespace AgreableAdvertPlugin\Services;

use \stdClass;

class AdvertSlotGenerator {
  public static function get_vertical_advert($advert_widget, $category, $rowWidgetIndex, $elementId) {
    $ad_slot = self::get_basic_ad_slot();
    $ad_slot->section = $category->slug;
    $ad_slot->pageType = "Article";
    $ad_slot->advertType = "300x600";
    $ad_slot->index = 1;
    $ad_slot->creativeSizes = [[300, 600], [300, 250]];
    $ad_slot->tag = self::generate_ad_tag($ad_slot);
    return apply_filters('agreable_advert_slot_generator_filter', $ad_slot);
  }

  public static function get_header_advert($category, $pageType) {
    // todo
    exit;
    if (!$section) {
        $section = "home";
    }

    $ad_slot = self::get_basic_ad_slot();
    $ad_slot->section = $section;
    $ad_slot->pageType = $pageType;
    $ad_slot->advertType = "970x250";
    $ad_slot->creativeSizes = [[320, 50]];
    $ad_slot->index = "1A";
    $ad_slot->tag = self::generate_ad_tag($ad_slot);
    return $ad_slot;
  }

  protected static function get_basic_ad_slot() {
    $ad = new stdClass();
    $ad->account = get_field('advert_account_prefix', 'option');
    $ad->section = "";
    $ad->pageType = "";
    $ad->advertType = "";
    $ad->index = 0;
    $ad->creativeSizes = [];
    return $ad;
  }

  protected static function generate_ad_tag($ad_slot) {
    return "/" . $ad_slot->account . "_" . $ad_slot->section . "_" . $ad_slot->pageType . "_" . $ad_slot->advertType . "_" . $ad_slot->index;
  }
}
