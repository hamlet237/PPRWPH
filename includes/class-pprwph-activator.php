<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    pprwph
 * @subpackage pprwph/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class PPRWPH_Activator {
	/**
   * Plugin activation functions
   *
   * Functions to be loaded on plugin activation. This actions creates roles, options and post information attached to the plugin.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
    $post_functions = new PPRWPH_Functions_Post();
    $attachment_functions = new PPRWPH_Functions_Attachment();

    add_role('pprwph_role_manager', esc_html(__('Whitepaper manager - WPH', 'pprwph')));

    $role_admin = get_role('administrator');
    $pprwph_role_manager = get_role('pprwph_role_manager');

    $pprwph_role_manager->add_cap('upload_files'); 
    $pprwph_role_manager->add_cap('read'); 

    foreach (PPRWPH_WHITE_ROLE_CAPABILITIES as $cap_key => $cap_value) {
      $role_admin->add_cap($cap_value); 
      $pprwph_role_manager->add_cap($cap_value); 
    }

    foreach (PPRWPH_ONE_ROLE_CAPABILITIES as $cap_key => $cap_value) {
      $role_admin->add_cap($cap_value); 
      $pprwph_role_manager->add_cap($cap_value); 
    }

    update_option('pprwph_options_changed', true);
  }
}