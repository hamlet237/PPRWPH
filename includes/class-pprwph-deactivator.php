<?php

/**
 * Fired during plugin deactivation
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 *
 * @package    PPRWPH
 * @subpackage PPRWPH/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    PPRWPH
 * @subpackage PPRWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class PPRWPH_Deactivator {

	/**
	 * Plugin deactivation functions
	 *
	 * Functions to be loaded on plugin deactivation. This actions remove roles, options and post information attached to the plugin.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {		
		if (get_option('pprwph_options_remove') == 'on') {
      remove_role('pprwph_role_manager');

      $pprwph = get_posts(['fields' => 'ids', 'numberposts' => -1, 'post_type' => 'pprwph_white', 'post_status' => 'any', ]);

      if (!empty($pprwph)) {
        foreach ($pprwph as $post_id) {
          wp_delete_post($post_id, true);
        }
      }
    }

    update_option('pprwph_options_changed', true);
	}
}