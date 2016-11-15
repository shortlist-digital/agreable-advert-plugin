<?php
namespace AgreableAdvertPlugin\Services;

use \AgreableCategoryService;
use \stdClass;
use \Symfony\Component\Yaml\Yaml;
use Exception;

class AdvertSlotTypes {
  public static function get($type_name) {
    $types = Yaml::parse(file_get_contents(__DIR__ . '/types.yml'));
    if (!isset($types[$type_name])) {
      throw new Exception('Unknown advert type: "' . $type_name . '"');
    }
    $type = $types[$type_name];
    $type['display_type'] = $type_name;
    return apply_filters('agreable_advert_slot_types_get_filter', $type);
  }
}
