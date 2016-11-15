<?php namespace AgreableAdvertPlugin;

/** @var \Herbert\Framework\Panel $panel */

$args = array(
  /* (string) The title displayed on the options page. Required. */
  'page_title' => 'Adverts Configuration',
  'menu_title' => 'Adverts',
  'menu_slug' => 'adverts-configuration',
  'capability' => 'manage_options',
  'position' => false,
  'parent_slug' => '',
  'icon_url' => 'dashicons-layout',
  'redirect' => true,
  'post_id' => 'adverts-configuration',
  'autoload' => false,
);

acf_add_options_page($args);

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_agreable_advert_configuration',
	'title' => 'Adverts Configurations',
	'fields' => array (
		array (
			'key' => 'advert_account_network',
			'label' => 'Advert account network',
			'name' => 'advert_account_network',
			'type' => 'text',
			'instructions' => 'The DFP account network e.g. /4987',
			'placeholder' => 'e.g. /4987',
		),
    array (
      'key' => 'advert_account_zone_prefix',
      'label' => 'Advert account zone prefix',
      'name' => 'advert_account_zone_prefix',
      'type' => 'text',
      'instructions' => 'The DFP account zone prefix e.g. /stylist',
      'placeholder' => 'e.g. /stylist',
    ),
	),
	'location' => array (
		array (
			array (
        'param' => 'options_page',
				'operator' => '==',
				'value' => 'adverts-configuration',
			),
		),
	),
	'menu_order' => 11,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
));

endif;
