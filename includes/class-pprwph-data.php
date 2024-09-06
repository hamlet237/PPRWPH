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
class PPRWPH_Data {
	/**
	 * The main data array.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      PPRWPH_Data    $data    Empty array.
	 */
	protected $data = [];

	/**
	 * Load the plugin most usefull data.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_data() {
		$this->data['user_id'] = get_current_user_id();

		if (is_admin()) {
			$this->data['post_id'] = !empty($GLOBALS['_REQUEST']['post']) ? $GLOBALS['_REQUEST']['post'] : 0;
		}else{
			$this->data['post_id'] = get_the_ID();
		}

		$GLOBALS['pprwph_data'] = $this->data;
	}

	/**
	 * Flus wp rewrite rules.
	 *
	 * @since    1.0.0
	 */
	public function flush_rewrite_rules() {
    if (get_option('pprwph_options_changed')) {
      flush_rewrite_rules();
      update_option('pprwph_options_changed', false);
    }
  }
}