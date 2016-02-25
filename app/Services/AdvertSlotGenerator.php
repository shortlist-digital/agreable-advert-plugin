<?php namespace AgreableAdvertPlugin\Services;

class AdvertSlotGenerator {
  // public static function get_vertical_advert($advertWidget, $rowType, $rowWidgetIndex, $elementId) {
  public static function get_vertical_advert() {
    var_dump('adverty!'); exit;
    $adSlot = self::getBasicAdSlot();
    $adSlot->section = "Home";
    $adSlot->pageType = "Homepage";
    $adSlot->advertType = "300x600";
    $adSlot->index = 1;
    $adSlot->creativeSizes = [[300, 250]];
    $adSlot->tag = self::generateAdTag($adSlot);
    return $adSlot;
  }

  public static function getHeaderAdvert($section, $pageType) {
    if (!$section) {
        $section = "home";
    }

    $adSlot = self::getBasicAdSlot();
    $adSlot->section = $section;
    $adSlot->pageType = $pageType;
    $adSlot->advertType = "970x250";
    $adSlot->creativeSizes = [[320, 50]];
    $adSlot->index = "1A";
    $adSlot->tag = self::generateAdTag($adSlot);
    return $adSlot;
  }

  protected static function getBasicAdSlot() {
    $ad = new stdClass();
    $ad->accountId = "3488664";
    $ad->tagPrefix = "ST";
    $ad->section = "";
    $ad->pageType = "";
    $ad->advertType = "";
    $ad->index = 0;
    $ad->creativeSizes = [];
    return $ad;
  }

  protected static function generateAdTag($adSlot) {
    return "/" . $adSlot->accountId . "/" . $adSlot->tagPrefix . "_" . $adSlot->section . "_" . $adSlot->pageType . "_" . $adSlot->advertType . "_" . $adSlot->index;
  }
}
