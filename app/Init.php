<?php
namespace MWD\HFS;

// Set up plugin class
class Init {
  function __construct() {

    /**
     * Create ACF options page(s)
     */
     add_action('admin_menu', function() {
       \acf_add_options_sub_page(array(
      		'page_title' 	=> 'Header & Footer Scripts',
      		'menu_title'	=> 'Header & Footer Scripts',
      		'parent_slug'	=> 'options-general.php',
      	));
     });


     /**
      * Add scripts to new options page(s)
      */
      add_action( 'admin_enqueue_scripts', function($hook) {
        if ( 'settings_page_acf-options-header-footer-scripts' != $hook ) {
          return;
        }
        wp_enqueue_script( 'acf-header-and-footer-scripts', HFS_PLUGIN_URL . '/app/dist/app.bundle.js', 'jQuery' );
      });


      /**
       * Enqueue header scripts
       */
      add_action( 'wp_enqueue_scripts', function() {
        if( have_rows('header_scripts', 'option') ) {
          wp_enqueue_script('acf-header-scripts', '<script></script>', array(), '');
          while ( have_rows('header_scripts', 'option') ) : the_row();
            wp_add_inline_script( 'acf-header-scripts', get_sub_field('script') );
          endwhile;
        }
      });


      /**
       * Enqueue footer scripts
       */
       add_action( 'wp_enqueue_scripts', function() {
         if( have_rows('footer_scripts', 'option') ) {
           wp_enqueue_script('acf-footer-scripts', '<script></script>', array(), '', true);
           while ( have_rows('footer_scripts', 'option') ) : the_row();
             wp_add_inline_script( 'acf-footer-scripts', get_sub_field('script') );
           endwhile;
         }
       }, 9999);

  }
}