<?php
/**
 * Onepaper taxonomies creator.
 *
 * This class defines Onepaper taxonomies.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    PPRWPH
 * @subpackage PPRWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class PPRWPH_Taxonomies_Onepaper_Section { 
	/**
	 * Register taxonomies.
	 *
	 * @since    1.0.0
	 */
	public static function register_taxonomies() {
		$taxonomies = [
			'pprwph_one_category' => [
				'name'               	=> _x('Onepaper section categories', 'Taxonomy general name', 'pprwph'),
				'singular_name'      	=> _x('Onepaper section category', 'Taxonomy singular name', 'pprwph'),
				'search_items'      	=> esc_html(__('Search Onepaper section categories', 'pprwph')),
        'all_items'         	=> esc_html(__('All Onepaper section categories', 'pprwph')),
        'parent_item'       	=> esc_html(__('Parent Onepaper section category', 'pprwph')),
        'parent_item_colon' 	=> esc_html(__('Parent Onepaper section category:', 'pprwph')),
        'edit_item'         	=> esc_html(__('Edit Onepaper section category', 'pprwph')),
        'update_item'       	=> esc_html(__('Update Onepaper section category', 'pprwph')),
        'add_new_item'      	=> esc_html(__('Add New Onepaper section category', 'pprwph')),
        'new_item_name'     	=> esc_html(__('New Onepaper section category', 'pprwph')),
        'menu_name'         	=> esc_html(__('Onepaper section categories', 'pprwph')),
				'manage_terms'      	=> 'manage_pprwph_one_category',
	      'edit_terms'        	=> 'edit_pprwph_one_category',
	      'delete_terms'      	=> 'delete_pprwph_one_category',
	      'assign_terms'      	=> 'assign_pprwph_one_category',
	      'archive'			      	=> false,
	      'slug'			      		=> 'onepaper-categories',
			],
		];;

	  foreach ($taxonomies as $taxonomy => $options) {
	  	$labels = [
				'name'          		=> $options['name'],
				'singular_name' 		=> $options['singular_name'],
				
			];

			$capabilities = [
				'manage_terms'      => $options['manage_terms'],
				'edit_terms'      	=> $options['edit_terms'],
				'delete_terms'      => $options['delete_terms'],
				'assign_terms'      => $options['assign_terms'],
	    ];

			$args = [
				'labels'            => $labels,
				'hierarchical'      => true,
				'public'            => false,
				'show_ui' 					=> false,
				'query_var'         => false,
				'rewrite'           => false,
				'show_in_rest'      => true,
	    	'capabilities'      => $capabilities,
			];

			if ($options['archive']) {
				$args['public'] = true;
				$args['publicly_queryable'] = true;
				$args['show_in_nav_menus'] = true;
				$args['query_var'] = $taxonomy;
				$args['show_ui'] = true;
				$args['rewrite'] = [
					'slug' => $options['slug'],
				];
			}

			register_taxonomy($taxonomy, 'pprwph_one', $args);
			register_taxonomy_for_object_type($taxonomy, 'pprwph_one');
		}
	}
}