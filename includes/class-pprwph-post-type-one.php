<?php
/**
 * Onepaper creator.
 *
 * This class defines Onepaper options, menus and templates.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    PPRWPH
 * @subpackage PPRWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class PPRWPH_Post_Type_Onepaper_Section {
	/**
	 * Register Onepaper_section.
	 *
	 * @since    1.0.0
	 */
	public function register_post_type() {
		$labels = [
      'name'                => _x('Onepaper section', 'Post Type general name', 'pprwph'),
      'singular_name'       => _x('Onepaper section', 'Post Type singular name', 'pprwph'),
      'menu_name'           => esc_html(__('Onepaper section', 'pprwph')),
      'parent_item_colon'   => esc_html(__('Parent Onepaper section', 'pprwph')),
      'all_items'           => esc_html(__('All Onepaper sections', 'pprwph')),
      'view_item'           => esc_html(__('View Onepaper section', 'pprwph')),
      'add_new_item'        => esc_html(__('Add new Onepaper section', 'pprwph')),
      'add_new'             => esc_html(__('Add New', 'pprwph')),
      'edit_item'           => esc_html(__('Edit Onepaper section', 'pprwph')),
      'update_item'         => esc_html(__('Update Onepaper section', 'pprwph')),
      'search_items'        => esc_html(__('Search Onepaper sections', 'pprwph')),
      'not_found'           => esc_html(__('Not Onepaper found', 'pprwph')),
      'not_found_in_trash'  => esc_html(__('Not Onepaper found in Trash', 'pprwph')),
    ];

    $args = [
      'labels'              => $labels,
      'rewrite'             => ['slug' => (!empty(get_option('pprwph_slug')) ? get_option('pprwph_slug') : 'whitepaper'), 'with_front' => false],
      'label'               => esc_html(__('Onepaper section', 'pprwph')),
      'description'         => esc_html(__('Onepaper description', 'pprwph')),
      'supports'            => ['title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', ],
      'hierarchical'        => true,
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 5,
      'menu_icon'           => esc_url(PPRWPH_URL . 'assets/media/pprwph-menu-icon.svg'),
      'can_export'          => true,
      'has_archive'         => true,
      'exclude_from_search' => true,
      'publicly_queryable'  => true,
      'capability_type'     => 'page',
      'taxonomies'          => PPRWPH_ONE_ROLE_CAPABILITIES,
      'show_in_rest'        => true, /* REST API */
    ];

		register_post_type('pprwph_one', $args);
    add_theme_support('post-thumbnails', ['page', 'pprwph_one']);
	}

  /**
   * Defines single template for Onepaper_section.
   *
   * @since    1.0.0
   */
  public function single_template($single) {
    if (get_post_type() == 'pprwph_one') {
      if (file_exists(PPRWPH_DIR . 'templates/public/single-pprwph_one.php')) {
        return PPRWPH_DIR . 'templates/public/single-pprwph_one.php';
      }
    }

    return $single;
  }

  /**
   * Defines archive template for Onepaper_section.
   *
   * @since    1.0.0
   */
  public function archive_template($archive) {
    if (get_post_type() == 'pprwph_one') {
      if (file_exists(PPRWPH_DIR . 'templates/public/archive-pprwph_one.php')) {
        return PPRWPH_DIR . 'templates/public/archive-pprwph_one.php';
      }
    }

    return $archive;
  }

  public function activated_plugin($plugin) {
    if($plugin == 'pprwph/pprwph.php') {
      wp_redirect(home_url((!empty(get_option('pprwph_slug')) ? get_option('pprwph_slug') : 'whitepaper')));exit();
    }
  }
}