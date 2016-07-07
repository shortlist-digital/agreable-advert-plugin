<?php namespace AgreableAdvertPlugin;

use AgreableAdvertPlugin\Helper;
// $ns = Helper::get('agreable_namespace');
$ns = 'agreable_news';

/*
 * Although we're in the Herbert panel file, we're not using any built in
 * panel functionality because you have to write you're own HTML forms and
 * logic. We're using ACF instead but seems sensible to leave ACF logic in
 * here (??).
 */

// Constructed using (lowercased and hyphenated) 'menu_title' from above.
$options_page_name = 'acf-options';

if( function_exists('register_field_group') ):

register_field_group(array (
  'key' => 'group_'.$ns.'_plugin',
  'title' => 'Advert Configuration',
  'fields' => array (
    array (
      'key' => 'advert_account_prefix',
      'label' => 'Advert account ID/prefix',
      'name' => 'advert_account_prefix',
      'type' => 'text',
      'instructions' => 'The DFP account ID and prefix e.g. 3488664/ST',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
      'readonly' => 0,
      'disabled' => 0,
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'options_page',
        'operator' => '==',
        'value' => $options_page_name,
      ),
    ),
  ),
  'menu_order' => 11,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
));

endif;
