<?php
/**
 * The-global functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to enqueue the-global stylesheet and JavaScript.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    PPRWPH
 * @subpackage PPRWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class PPRWPH_Common {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		if (!wp_style_is($this->plugin_name . '-material-icons-outlined', 'enqueued')) {
			wp_enqueue_style($this->plugin_name . '-material-icons-outlined', PPRWPH_URL . 'assets/css/material-icons-outlined.min.css', array(), $this->version, 'all');
    }

    if (!wp_style_is($this->plugin_name . '-select2', 'enqueued')) {
			wp_enqueue_style($this->plugin_name . '-select2', PPRWPH_URL . 'assets/css/select2.min.css', array(), $this->version, 'all');
    }

    if (!wp_style_is($this->plugin_name . '-trumbowyg', 'enqueued')) {
			wp_enqueue_style($this->plugin_name . '-trumbowyg', PPRWPH_URL . 'assets/css/trumbowyg.min.css', array(), $this->version, 'all');
    }

    if (!wp_style_is($this->plugin_name . '-fancybox', 'enqueued')) {
			wp_enqueue_style($this->plugin_name . '-fancybox', PPRWPH_URL . 'assets/css/fancybox.min.css', array(), $this->version, 'all');
    }

    if (!wp_style_is($this->plugin_name . '-tooltipster', 'enqueued')) {
			wp_enqueue_style($this->plugin_name . '-tooltipster', PPRWPH_URL . 'assets/css/tooltipster.min.css', array(), $this->version, 'all');
    }

		wp_enqueue_style($this->plugin_name, PPRWPH_URL . 'assets/css/pprwph.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if(!wp_script_is('jquery-ui-sortable', 'enqueued')) {
			wp_enqueue_script('jquery-ui-sortable');
    }

    if(!wp_script_is($this->plugin_name . '-select2', 'enqueued')) {
			wp_enqueue_script($this->plugin_name . '-select2', PPRWPH_URL . 'assets/js/select2.min.js', ['jquery'], $this->version, false);
    }

    if(!wp_script_is($this->plugin_name . '-trumbowyg', 'enqueued')) {
			wp_enqueue_script($this->plugin_name . '-trumbowyg', PPRWPH_URL . 'assets/js/trumbowyg.min.js', ['jquery'], $this->version, false);
    }

    if(!wp_script_is($this->plugin_name . '-fancybox', 'enqueued')) {
			wp_enqueue_script($this->plugin_name . '-fancybox', PPRWPH_URL . 'assets/js/fancybox.min.js', ['jquery'], $this->version, false);
    }

    if(!wp_script_is($this->plugin_name . '-tooltipster', 'enqueued')) {
			wp_enqueue_script($this->plugin_name . '-tooltipster', PPRWPH_URL . 'assets/js/tooltipster.min.js', ['jquery'], $this->version, false);
    }

		wp_enqueue_script($this->plugin_name, PPRWPH_URL . 'assets/js/pprwph.js', ['jquery'], $this->version, false);
		wp_enqueue_script($this->plugin_name . '-ajax', PPRWPH_URL . 'assets/js/pprwph-ajax.js', ['jquery'], $this->version, false);
		wp_enqueue_script($this->plugin_name . '-aux', PPRWPH_URL . 'assets/js/pprwph-aux.js', ['jquery'], $this->version, false);
		wp_enqueue_script($this->plugin_name . '-forms', PPRWPH_URL . 'assets/js/pprwph-forms.js', ['jquery'], $this->version, false);

		wp_localize_script($this->plugin_name, 'pprwph_ajax', [
			'ajax_url' => admin_url('admin-ajax.php'),
			'ajax_nonce' => wp_create_nonce('pprwph-nonce'),
		]);

		wp_localize_script($this->plugin_name, 'pprwph_path', [
			'main' => PPRWPH_URL,
			'assets' => PPRWPH_URL . 'assets/',
			'css' => PPRWPH_URL . 'assets/css/',
			'js' => PPRWPH_URL . 'assets/js/',
			'media' => PPRWPH_URL . 'assets/media/',
		]);

		wp_localize_script($this->plugin_name, 'pprwph_trumbowyg', [
			'path' => PPRWPH_URL . 'assets/media/trumbowyg-icons.svg',
		]);

		wp_localize_script($this->plugin_name, 'pprwph_i18n', [
			'an_error_has_occurred' => esc_html(__('An error has occurred. Please try again in a few minutes.', 'pprwph')),
			'user_unlogged' => esc_html(__('Please create a new user or login to save the information.', 'pprwph')),
			'saved_successfully' => esc_html(__('Saved successfully', 'pprwph')),
			'edit_image' => esc_html(__('Edit image', 'pprwph')),
			'edit_images' => esc_html(__('Edit images', 'pprwph')),
			'select_image' => esc_html(__('Select image', 'pprwph')),
			'select_images' => esc_html(__('Select images', 'pprwph')),
			'edit_video' => esc_html(__('Edit video', 'pprwph')),
			'edit_videos' => esc_html(__('Edit videos', 'pprwph')),
			'select_video' => esc_html(__('Select video', 'pprwph')),
			'select_videos' => esc_html(__('Select videos', 'pprwph')),
			'edit_audio' => esc_html(__('Edit audio', 'pprwph')),
			'edit_audios' => esc_html(__('Edit audios', 'pprwph')),
			'select_audio' => esc_html(__('Select audio', 'pprwph')),
			'select_audios' => esc_html(__('Select audios', 'pprwph')),
			'edit_file' => esc_html(__('Edit file', 'pprwph')),
			'edit_files' => esc_html(__('Edit files', 'pprwph')),
			'select_file' => esc_html(__('Select file', 'pprwph')),
			'select_files' => esc_html(__('Select files', 'pprwph')),
			'ordered_element' => esc_html(__('Ordered element', 'pprwph')),
			'section_created' => esc_html(__('Section created successfully', 'pprwph')),
			'section_added' => esc_html(__('Section added successfully', 'pprwph')),
			'section_removed' => esc_html(__('Section removed successfully', 'pprwph')),
			'section_updated' => esc_html(__('Section updated successfully', 'pprwph')),
			'order_updated' => esc_html(__('Order updated successfully', 'pprwph')),
			'provide_link' => esc_html(__('Please provide a valid link for this section', 'pprwph')),
			'provide_parent_page' => esc_html(__('Please provide a valid parent page for this section', 'pprwph')),
		]);
	}

  public function pprwph_body_classes($classes) {
	  $classes[] = 'pprwph-body';

	  if (is_user_logged_in()) {
	  	$classes[] = 'pprwph-user-logged-in';
	  }else{
	  	$classes[] = 'pprwph-user-unlogged';
	  }

	  return $classes;
  }
}
