<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current version of the plugin.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    PPRWPH
 * @subpackage PPRWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */

class PPRWPH {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      PPRWPH_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin. Load the dependencies, define the locale, and set the hooks for the admin area and the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if (defined('PPRWPH_VERSION')) {
			$this->version = PPRWPH_VERSION;
		} else {
			$this->version = '1.0.0';
		}

		$this->plugin_name = 'pprwph';

		$this->define_constants();
		$this->load_dependencies();
		$this->set_i18n();
		$this->define_common_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_post_types();
		$this->define_taxonomies();
		$this->load_ajax();
		$this->load_ajax_nopriv();
		$this->load_data();
		$this->load_templates();
		$this->load_menus();
		$this->load_shortcodes();
	}

	/**
	 * Define the plugin main constants.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_constants() {
		define('PPRWPH_DIR', plugin_dir_path(dirname(__FILE__)));
		define('PPRWPH_URL', plugin_dir_url(dirname(__FILE__)));
		
		define('PPRWPH_WHITE_ROLE_CAPABILITIES', ['edit_post' => 'edit_wph_white', 'edit_posts' => 'edit_pprwph', 'edit_private_posts' => 'edit_private_pprwph', 'edit_published_posts' => 'edit_published_pprwph', 'edit_others_posts' => 'edit_other_pprwph', 'publish_posts' => 'publish_pprwph', 'read_post' => 'read_wph_white', 'read_private_posts' => 'read_private_pprwph', 'delete_post' => 'delete_wph_white', 'delete_posts' => 'delete_pprwph', 'delete_private_posts' => 'delete_private_pprwph', 'delete_published_posts' => 'delete_published_pprwph', 'delete_others_posts' => 'delete_others_pprwph', 'upload_files' => 'upload_files', 'manage_terms' => 'manage_pprwph_category', 'edit_terms' => 'edit_pprwph_category', 'delete_terms' => 'delete_pprwph_category', 'assign_terms' => 'assign_pprwph_category', 'manage_options' => 'manage_pprwph_options', ]);
		define('PPRWPH_ONE_ROLE_CAPABILITIES', ['edit_post' => 'edit_wph_white', 'edit_posts' => 'edit_pprwph', 'edit_private_posts' => 'edit_private_pprwph', 'edit_published_posts' => 'edit_published_pprwph', 'edit_others_posts' => 'edit_other_pprwph', 'publish_posts' => 'publish_pprwph', 'read_post' => 'read_wph_white', 'read_private_posts' => 'read_private_pprwph', 'delete_post' => 'delete_wph_white', 'delete_posts' => 'delete_pprwph', 'delete_private_posts' => 'delete_private_pprwph', 'delete_published_posts' => 'delete_published_pprwph', 'delete_others_posts' => 'delete_others_pprwph', 'upload_files' => 'upload_files', 'manage_terms' => 'manage_pprwph_category', 'edit_terms' => 'edit_pprwph_category', 'delete_terms' => 'delete_pprwph_category', 'assign_terms' => 'assign_pprwph_category', 'manage_options' => 'manage_pprwph_options', ]);

		define('PPRWPH_KSES', ['div' => ['id' => [], 'class' => [], 'data-pprwph-section-id' => [], ], 'span' => ['id' => [], 'class' => [], ], 'p' => ['id' => [], 'class' => [], ], 'ul' => ['id' => [], 'class' => [], ], 'ol' => ['id' => [], 'class' => [], ], 'li' => ['id' => [], 'class' => [], 'data-pprwph-section-id' => [], 'data-pprwph-type' => [], ], 'small' => ['id' => [], 'class' => [], ], 'a' => ['id' => [], 'class' => [], 'href' => [], 'title' => [], 'target' => [], ], 'form' => ['id' => [], 'class' => [], 'action' => [], 'method' => [], ], 'input' => ['name' => [], 'id' => [], 'class' => [], 'type' => [], 'checked' => [], 'multiple' => [], 'disabled' => [], 'value' => [], 'placeholder' => [], 'data-pprwph-parent' => [], 'data-pprwph-parent-option' => [], 'data-pprwph-parent-option' => [], 'data-pprwph-type' => [], 'data-pprwph-subtype' => [], 'data-pprwph-user-id' => [], 'data-pprwph-post-id' => [],], 'select' => ['name' => [], 'id' => [], 'class' => [], 'type' => [], 'checked' => [], 'multiple' => [], 'disabled' => [], 'value' => [], 'placeholder' => [], 'data-placeholder' => [], 'data-pprwph-parent' => [], 'data-pprwph-parent-option' => [], ], 'option' => ['name' => [], 'id' => [], 'class' => [], 'disabled' => [], 'selected' => [], 'value' => [], 'placeholder' => [], ], 'textarea' => ['name' => [], 'id' => [], 'class' => [], 'type' => [], 'multiple' => [], 'disabled' => [], 'value' => [], 'placeholder' => [], 'data-pprwph-parent' => [], 'data-pprwph-parent-option' => [], ], 'label' => ['id' => [], 'class' => [], 'for' => [], ], 'i' => ['id' => [], 'class' => [], 'title' => [], ], 'br' => [], 'em' => [], 'strong' => [], 'h1' => ['id' => [], 'class' => [], ], 'h2' => ['id' => [], 'class' => [], ], 'h3' => ['id' => [], 'class' => [], ], 'h4' => ['id' => [], 'class' => [], ], 'h5' => ['id' => [], 'class' => [], ], 'h6' => ['id' => [], 'class' => [], ], 'img' => ['id' => [], 'class' => [], 'src' => [], 'alt' => [], 'title' => [], ], ]);
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 * - PPRWPH_Loader. Orchestrates the hooks of the plugin.
	 * - PPRWPH_i18n. Defines internationalization functionality.
	 * - PPRWPH_Common. Defines hooks used accross both, admin and public side.
	 * - PPRWPH_Admin. Defines all hooks for the admin area.
	 * - PPRWPH_Public. Defines all hooks for the public side of the site.
	 * - PPRWPH_Post_Type_Whitepaper section. Defines Whitepaper section custom post type.
	 * - PPRWPH_Taxonomies_Whitepaper section. Defines Whitepaper section taxonomies.
	 * - PPRWPH_Templates. Load plugin templates.
	 * - PPRWPH_Data. Load main usefull data.
	 * - PPRWPH_Functions_Post. Posts management functions.
	 * - PPRWPH_Functions_Attachment. Attachments management functions.
	 * - PPRWPH_Functions_Menus. Define menus.
	 * - PPRWPH_Functions_Forms. Forms management functions.
	 * - PPRWPH_Functions_Ajax. Ajax functions.
	 * - PPRWPH_Functions_Ajax_Nopriv. Ajax No Private functions.
	 * - PPRWPH_Functions_Shortcodes. Define all shortcodes for the platform.
	 *
	 * Create an instance of the loader which will be used to register the hooks with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the core plugin.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-loader.php';

		/**
		 * The class responsible for defining internationalization functionality of the plugin.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-i18n.php';

		/**
		 * The class responsible for defining all actions that occur both in the admin area and in the public-facing side of the site.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-common.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once PPRWPH_DIR . 'includes/admin/class-pprwph-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing side of the site.
		 */
		require_once PPRWPH_DIR . 'includes/public/class-pprwph-public.php';

		/**
		 * The class responsible for create the Project custom post type.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-post-type-white.php';

		/**
		 * The class responsible for create the Project custom taxonomies.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-taxonomies-white.php';

		/**
		 * The class responsible for plugin templates.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-templates.php';

		/**
		 * The class getting key data of the platform.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-data.php';

		/**
		 * The class defining posts management functions.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-functions-post.php';

		/**
		 * The class defining users management functions.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-functions-user.php';

		/**
		 * The class defining attahcments management functions.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-functions-attachment.php';

		/**
		 * The class defining menus.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-menus.php';

		/**
		 * The class defining form management.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-forms.php';

		/**
		 * The class defining ajax functions.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-ajax.php';

		/**
		 * The class defining no private ajax functions.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-ajax-nopriv.php';

		/**
		 * The class defining shortcodes.
		 */
		require_once PPRWPH_DIR . 'includes/class-pprwph-shortcodes.php';

		$this->loader = new PPRWPH_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the PPRWPH_i18n class in order to set the domain and to register the hook with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_i18n() {
		$plugin_i18n = new PPRWPH_i18n();
		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

		if (class_exists('Polylang')) {
			$this->loader->add_filter('pll_get_post_types', $plugin_i18n, 'pprwph_pll_get_post_types', 10, 2);
    }
	}

	/**
	 * Register all of the hooks related to the main functionalities of the plugin, common to public and admin faces.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_common_hooks() {
		$plugin_common = new PPRWPH_Common($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action('wp_enqueue_scripts', $plugin_common, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_common, 'enqueue_scripts');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_common, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_common, 'enqueue_scripts');
		$this->loader->add_filter('body_class', $plugin_common, 'pprwph_body_classes');

		$plugin_forms = new PPRWPH_Forms($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action('pprwph_form_save', $plugin_forms, 'pprwph_form_save', 3, 999);
	}

	/**
	 * Register all of the hooks related to the admin area functionality of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new PPRWPH_Admin($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
	}

	/**
	 * Register all of the hooks related to the public-facing functionality of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new PPRWPH_Public($this->get_plugin_name(), $this->get_version());
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
	}

	/**
	 * Register all Post Types with meta boxes and templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_post_types() {
		$plugin_white = new PPRWPH_Post_Type_Whitepaper_Section();
		$this->loader->add_action('init', $plugin_white, 'register_post_type');
		$this->loader->add_action('admin_init', $plugin_white, 'add_meta_box');
		$this->loader->add_action('save_post_pprwph_white', $plugin_white, 'save_post', 10, 3);
		$this->loader->add_action('activated_plugin', $plugin_white, 'activated_plugin');
		$this->loader->add_action('pre_get_posts', $plugin_white, 'pprwph_pre_get_posts');
		$this->loader->add_filter('archive_template', $plugin_white, 'archive_template', 10, 3);
		$this->loader->add_filter('the_content', $plugin_white, 'pprwph_content_extra', 10, 3);
	}

	/**
	 * Register all of the hooks related to Taxonomies.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_taxonomies() {
		$plugin_taxonomies_white = new PPRWPH_Taxonomies_Whitepaper_Section();
		$this->loader->add_action('init', $plugin_taxonomies_white, 'register_taxonomies');
	}

	/**
	 * Load most common data used on the platform.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_data() {
		$plugin_data = new PPRWPH_Data();

		if (is_admin()) {
			$this->loader->add_action('init', $plugin_data, 'load_plugin_data');
		}else{
			$this->loader->add_action('wp_footer', $plugin_data, 'load_plugin_data');
		}

		$this->loader->add_action('wp_footer', $plugin_data, 'flush_rewrite_rules');
		$this->loader->add_action('admin_footer', $plugin_data, 'flush_rewrite_rules');
	}

	/**
	 * Register templates.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_templates() {
		if (!defined('DOING_AJAX')) {
			$plugin_templates = new PPRWPH_Templates();
			$this->loader->add_action('wp_footer', $plugin_templates, 'load_plugin_templates');
			$this->loader->add_action('admin_footer', $plugin_templates, 'load_plugin_templates');
			$this->loader->add_action('admin_init', $plugin_templates, 'load_plugin_templates');
		}
	}

	/**
	 * Register menus.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_menus() {
		$plugin_menus = new PPRWPH_Menus();
		$this->loader->add_action('admin_menu', $plugin_menus, 'pprwph_admin_menu');
	}

	/**
	 * Load ajax functions.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_ajax() {
		$plugin_ajax = new PPRWPH_Ajax();
		$this->loader->add_action('wp_ajax_pprwph_ajax', $plugin_ajax, 'pprwph_ajax_server');
	}

	/**
	 * Load no private ajax functions.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_ajax_nopriv() {
		$plugin_ajax_nopriv = new PPRWPH_Ajax_Nopriv();
		$this->loader->add_action('wp_ajax_pprwph_ajax_nopriv', $plugin_ajax_nopriv, 'pprwph_ajax_nopriv_server');
		$this->loader->add_action('wp_ajax_nopriv_pprwph_ajax_nopriv', $plugin_ajax_nopriv, 'pprwph_ajax_nopriv_server');
	}

	/**
	 * Register shortcodes of the platform.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_shortcodes() {
		$plugin_shortcodes = new PPRWPH_Shortcodes();

		$plugin_white = new PPRWPH_Post_Type_Whitepaper_Section();
		$this->loader->add_shortcode('pprwph-options-block', $plugin_white, 'pprwph_options_block');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress. Then it flushes the rewrite rules if needed.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    PPRWPH_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}