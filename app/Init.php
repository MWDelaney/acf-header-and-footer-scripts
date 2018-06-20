<?php
namespace MWD\HFS;

// Set up plugin class
class Init {

  const LANGUAGE_SETTING_ACF_FILTER = 'acf/settings/current_language';

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

        // Disable WPML for ACF and get fields from the default language
        self::disableAcfLanguageAppending();

          if( have_rows('header_scripts', 'option') ) {
            if(class_exists('\FLBuilderModel')) {
              if(\FLBuilderModel::is_builder_active()) {
                die();
              }
            }
            wp_enqueue_script('header-scripts', HFS_PLUGIN_URL . 'app/resources/scripts/header-scripts.js', NULL, NULL, false);
            while ( have_rows('header_scripts', 'option') ) : the_row();
              if( get_row_layout() == 'snippet' ) {
                wp_add_inline_script('header-scripts', get_sub_field('script'));
              }
              elseif(get_row_layout() == 'linked' ) {
                wp_enqueue_script('header-scripts-' . esc_url(get_sub_field('name')) , get_sub_field('script'), NULL, NULL, false);
              }
            endwhile;
          }

        // Re-enable WPML for ACF
        self::reEnableAcfLanguageAppending();


      });


      /**
       * Enqueue footer scripts
       */
      add_action( 'wp_footer', function() {

        // Disable WPML for ACF and get fields from the default language
        self::disableAcfLanguageAppending();

        if(class_exists('\FLBuilderModel')) {
          if(\FLBuilderModel::is_builder_active()) {
            die();
          }
        }
        if( have_rows('footer_scripts', 'option') ) {
            wp_enqueue_script('footer-scripts', HFS_PLUGIN_URL . 'app/resources/scripts/footer-scripts.js', NULL, NULL, true);
            while ( have_rows('footer_scripts', 'option') ) : the_row();
              if( get_row_layout() == 'snippet' ) {
                wp_add_inline_script('footer-scripts', get_sub_field('script'));
              }
              elseif(get_row_layout() == 'linked' ) {
                wp_enqueue_script('footer-scripts-' . esc_url(get_sub_field('name')) , get_sub_field('script'), NULL, NULL, true);
              }
            endwhile;
          }

          // Re-enable WPML for ACF
          self::reEnableAcfLanguageAppending();

      });


       /**
        * Enqueue body open scripts
        */
        add_action( 'body_open', function() {

          // Disable WPML for ACF and get fields from the default language
          self::disableAcfLanguageAppending();

          if(class_exists('\FLBuilderModel')) {
            if(\FLBuilderModel::is_builder_active()) {
              die();
            }
          }

          if( have_rows('body_open_scripts', 'option') ) {
            while ( have_rows('body_open_scripts', 'option') ) : the_row();
              the_sub_field('script');
            endwhile;
          }

          // Re-enable WPML for ACF
          self::reEnableAcfLanguageAppending();

        });

  }

  /**
   * Use this to stop ACF from trying to look for a language-specific version of fields.
   *
   * @see http://www.advancedcustomfields.com/resources/acfsettings/
   */
  public static function disableAcfLanguageAppending() {
      add_filter(self::LANGUAGE_SETTING_ACF_FILTER, '__return_false');
  }

  /**
   * Use this to re-enable language-specific retrieval of ACF fields.
   *
   * @see http://www.advancedcustomfields.com/resources/acfsettings/
   * @see self::disableAcfLanguageAppending
   */
  public static function reEnableAcfLanguageAppending() {
      remove_filter(self::LANGUAGE_SETTING_ACF_FILTER, '__return_false');
  }

}
