<?php
/**
 * Plugin menus manager.
 *
 * This class defines plugin menus, both in dashboard or in front-end.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    PPRWPH
 * @subpackage PPRWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class PPRWPH_Menus {
  public function get_options() {
    $pprwph_options = [];
    $pprwph_options['pprwph_slug'] = [
      'id' => 'pprwph_slug',
      'class' => 'pprwph-input pprwph-width-100-percent',
      'input' => 'input',
      'type' => 'text',
      'label' => __('Whitepaper slug', 'pprwph'),
      'placeholder' => __('Whitepaper slug', 'pprwph'),
      'description' => __('This option sets the slug of the main whitepaper archive page, and the whitepaper pages. By default they will be:', 'pprwph') . '<br><a href="' . esc_url(home_url('/whitepaper')) . '" target="_blank">' . esc_url(home_url('/whitepaper')) . '</a><br>' . esc_url(home_url('/whitepaper/section')),
    ];
    $pprwph_options['pprwph_title'] = [
      'id' => 'pprwph_title',
      'class' => 'pprwph-input pprwph-width-100-percent',
      'input' => 'input',
      'type' => 'text',
      'label' => __('Whitepaper title', 'pprwph'),
      'placeholder' => __('Whitepaper title', 'pprwph'),
      'description' => __('This option sets the title of the main whitepaper archive page, whitepaper pages and navigation menus. By default they will be Whitepaper'),
    ];
    $pprwph_options['pprwph_version'] = [
      'id' => 'pprwph_version',
      'class' => 'pprwph-input pprwph-width-100-percent',
      'input' => 'input',
      'type' => 'text',
      'label' => __('Plugin version', 'pprwph'),
      'description' => __('Set the plugin version that will be shown in the Whitepaper documents.', 'pprwph'),
    ];
    $pprwph_options['pprwph_options_remove'] = [
      'id' => 'pprwph_options_remove',
      'class' => 'pprwph-input pprwph-width-100-percent',
      'input' => 'input',
      'type' => 'checkbox',
      'label' => __('Remove plugin options on deactivation', 'pprwph'),
      'description' => __('If you activate this option the plugin will remove all options on deactivation. Please, be careful. This process cannot be undone.', 'pprwph'),
    ];
    $pprwph_options['pprwph_nonce'] = [
      'id' => 'pprwph_nonce',
      'input' => 'input',
      'type' => 'hidden',
    ];
    $pprwph_options['pprwph_submit'] = [
      'id' => 'pprwph_submit',
      'input' => 'input',
      'type' => 'submit',
      'value' => __('Save options', 'pprwph'),
    ];

    return $pprwph_options;
  }

	/**
	 * Administrator menu.
	 *
	 * @since    1.0.0
	 */
	public function pprwph_admin_menu() {
		add_submenu_page('edit.php?post_type=pprwph_white', esc_html(__('Settings', 'pprwph')), esc_html(__('Settings', 'pprwph')), 'manage_pprwph_options', 'pprwph-options', [$this, 'pprwph_options'], );
	}

	public function pprwph_options() {
	  ?>
	    <div class="pprwph-options pprwph-max-width-1000 pprwph-margin-auto pprwph-mt-50 pprwph-mb-50">
        <h1 class="pprwph-mb-30"><?php esc_html_e('Whitepaper Manager - WPH Options', 'pprwph'); ?></h1>
        <div class="pprwph-options-fields pprwph-mb-30">
          <form action="" method="post" id="pprwph_form" class="pprwph-form">
            <?php foreach ($this->get_options() as $pprwph_option): ?>
              <?php PPRWPH_Forms::input_wrapper_builder($pprwph_option, 'option', 0, 'half'); ?>
            <?php endforeach ?>
          </form> 
        </div>
      </div>
	  <?php
	}		
}