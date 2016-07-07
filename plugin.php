<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Agreable Advert Plugin
 * Plugin URI:        http://shortlistmedia.co.uk
 * Description:       Croissant compatible adverts plugin.
 * Version:           0.1.0
 * Author:            Shortlist Media
 * Author URI:        http://shortlistmedia.co.uk
 * License:           MIT
 */

if ( ! class_exists( 'Jigsaw' ) ) {
  add_action( 'admin_notices', function() {
      echo '<div class="error"><p>Jigsaw not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url
( 'plugins.php' ) ) . '</a></p></div>';
    } );
  return;
}

if(file_exists(__DIR__ . '/../../../../vendor/getherbert/')){
  require_once __DIR__ . '/../../../../vendor/autoload.php';
} else {
  require_once __DIR__ . '/vendor/autoload.php';
}

if(file_exists(__DIR__ . '/../../../../vendor/getherbert/framework/bootstrap/autoload.php')){
  require_once __DIR__ . '/../../../../vendor/getherbert/framework/bootstrap/autoload.php';
} else {
  require_once __DIR__ . '/vendor/getherbert/framework/bootstrap/autoload.php';
}

