<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin so that it is ready for translation.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    PPRWPH
 * @subpackage PPRWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class PPRWPH_i18n {
	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'pprwph',
			false,
			dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
		);
	}

	public function pprwph_pll_get_post_types($post_types, $is_settings) {
    if ($is_settings){
      unset($post_types['pprwph_white']);
    }else{
      $post_types['pprwph_white'] = 'pprwph_white';
    }

    if ($is_settings){
      unset($post_types['pprwph_one']);
    }else{
      $post_types['pprwph_one'] = 'pprwph_one';
    }

    return $post_types;
  }
}