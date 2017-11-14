<?php
/*
Plugin Name: ACF Header and Footer Scripts
Plugin URI: https://github.com/MWDelaney/acf-header-and-footer-scripts
Description: Options pages and Advanced Custom Fields configuration to add custom scripts to site header and footer.
Version: 1.0
Author: Michael W. Delaney
Author URI: https://github.com/MWDelaney/
*/
namespace MWD\HFS;
/**
 * Set up autoloader
 */
require __DIR__ . '/vendor/autoload.php';

/**
* Define Constants
*/
define( 'HFS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'HFS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Add new ACF JSON load point
 */
add_filter('acf/settings/load_json', function($paths) {
  if ( function_exists('icl_object_id') ) {
    $paths[] = HFS_PLUGIN_DIR . 'app/resources/acf-json';
  } else {
    $paths[] = HFS_PLUGIN_DIR . 'app/resources/acf-json/en';
  }
  return $paths;
});

$acf_hfs_init = new Init();
//$micro_fields = new Fields();
