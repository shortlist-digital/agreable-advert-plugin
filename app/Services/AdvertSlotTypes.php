<?php
namespace AgreableAdvertPlugin\Services;

use \AgreableCategoryService;
use \stdClass;
use \Symfony\Component\Yaml\Yaml;

class AdvertSlotTypes {
  public static function get($type_name) {
    $value = Yaml::parse(file_get_contents(__DIR__ . '/types.yml'));
    var_dump(376478647823, $value);
    exit;
    return apply_filters('agreable_advert_slot_types_get_filter', $type);
  }
}
