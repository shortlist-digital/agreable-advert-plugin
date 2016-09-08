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

  public static function get_setup_html($post = null) {
    if (!$post) {
      return '<script>console.warn("No category found, unable to load adverts")</script>';
    }

    $data = self::get_setup_data($post);

    $out = '<script>';

    if (isset($data->zone)) {
      $out .= 'window.agreableAdvert = ' . json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    $out .= '</script>';
    return $out;
  }

  public static function get_setup_data($post) {

    $data = new stdClass();
    $data->network = get_field('advert_account_network', 'adverts-configuration');
    $data->zone_prefix = get_field('advert_account_zone_prefix', 'adverts-configuration');

    $categories = AgreableCategoryService::get_post_category_hierarchy($post);

    if (isset($categories) && isset($categories->parent)) {
      $data->zone = $data->zone_prefix . '/' . $categories->parent->slug;
    }

    $data->targeting_all = [];
    if (isset($post->post_type)) {
      $targetting = new stdClass();
      $targetting->key = 'type';
      $targetting->value = 'article';
      $data->targeting_all[] = $targetting;

      $targetting = new stdClass();
      $targetting->key = 'is_article';
      $targetting->value = 'yes';
      $data->targeting_all[] = $targetting;
    } else if (isset($post->object_type) && $post->object_type === 'term') {
      $targetting = new stdClass();
      $targetting->key = 'type';
      $targetting->value = 'section';
      $data->targeting_all[] = $targetting;

      $targetting = new stdClass();
      $targetting->key = 'is_article';
      $targetting->value = 'no';
      $data->targeting_all[] = $targetting;
    } else {
      $targetting = new stdClass();
      $targetting->key = 'type';
      $targetting->value = 'unknown';
      $data->targeting_all[] = $targetting;

      $targetting = new stdClass();
      $targetting->key = 'is_article';
      $targetting->value = 'no';
      $data->targeting_all[] = $targetting;
    }

    $targetting = new stdClass();
    $targetting->key = 'post_id';
    $targetting->value = $post->ID;
    $data->targeting_all[] = $targetting;

    if (isset($post->slug)) {
      $targetting = new stdClass();
      $targetting->key = 'post_slug';
      $targetting->value = $post->slug;
      $data->targeting_all[] = $targetting;
    }

    return $data;
  }
}
