<?php
namespace MWD\HFS;

class Fields {
  
	function __construct() {
		//Initialize shortcodes
		add_action( 'acf/init', function() {
      foreach(glob(HFS_PLUGIN_DIR . 'app/resources/fields/*.php') as $field) {
  		    include($field);
  		}
    }, 0 );
	}

}
