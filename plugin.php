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

$acf_hfs_init = new Init();
$acf_hfs_fields = new Fields();
