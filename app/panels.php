<?php namespace AgreableAdvertPlugin;

/** @var \Herbert\Framework\Panel $panel */

$args = array(
  /* (string) The title displayed on the options page. Required. */
  'page_title' => 'Adverts Configuration',
  'menu_title' => 'Adverts',
  'menu_slug' => 'adverts-configuration',
  'capability' => 'edit_posts',
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
			'key' => 'advert_account_prefix',
			'label' => 'Advert account ID/prefix',
			'name' => 'advert_account_prefix',
			'type' => 'text',
			'instructions' => 'The DFP account ID and prefix e.g. 3488664/ST',
			'placeholder' => 'e.g. 3488664/ST',
		),
		array (
			'key' => 'category_dfp_id_map',
			'label' => 'Category DFP ID Map',
			'name' => 'category_dfp_id_map',
			'type' => 'repeater',
			'layout' => 'table',
			'button_label' => 'Add Row',
			'sub_fields' => array (
				array (
					'key' => 'category_dfp_id_map_category',
					'label' => 'Category',
					'name' => 'category',
					'type' => 'taxonomy',
					'taxonomy' => 'category',
					'field_type' => 'select',
					'return_format' => 'id',
				),
				array (
					'key' => 'category_dfp_id_map_df_id',
					'label' => 'DFP ID',
					'name' => 'dfp_id',
					'type' => 'number',
				),
			),
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
