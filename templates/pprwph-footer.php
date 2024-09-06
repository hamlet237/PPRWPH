<?php
/**
 * Provide a common footer area view for the plugin
 *
 * This file is used to markup the common footer facing aspects of the plugin.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 *
 * @package    PPRWPH
 * @subpackage PPRWPH/common/templates
 */

  if (!defined('ABSPATH')) exit; // Exit if accessed directly
  
  global $wp_query;
  $pprwph_data = $GLOBALS['pprwph_data'];
?>

<div id="pprwph-main-message" class="pprwph-main-message pprwph-display-none-soft pprwph-z-index-top" data-user-id="<?php echo esc_attr($pprwph_data['user_id']); ?>" data-post-id="<?php echo esc_attr($pprwph_data['post_id']); ?>">
  <span id="pprwph-main-message-span"></span><i class="material-icons-outlined pprwph-vertical-align-bottom pprwph-ml-20 pprwph-cursor-pointer pprwph-color-white pprwph-close-icon">close</i>

  <div id="pprwph-bar-wrapper">
  	<div id="pprwph-bar"></div>
  </div>
</div>

<?php if (!is_admin() && $wp_query->query['post_type'] == 'pprwph_white'): ?>
  <?php 
    $plugin_white = new PPRWPH_Post_Type_Whitepaper_Section();
    $pprwph_sections = get_posts(['fields' => 'ids', 'numberposts' => -1, 'post_type' => 'pprwph_white', 'post_status' => 'any', 'orderby' => 'menu_order', 'order' => 'ASC', 'post_parent' => 0, ]);
  ?>
  
  <div id="pprwph-navigation">
    <div id="pprwph-body-overlay"></div>

    <div class="pprwph-navigation-switch pprwph-cursor-pointer pprwph-z-index-top">
      <div class="pprwph-navigation-switch-text"><?php echo (!empty(get_option('pprwph_title')) ? esc_html(get_option('pprwph_title')) : 'Whitepaper') ?></div>
      <i class="material-icons-outlined">keyboard_arrow_right</i>
    </div>

    <div class="pprwph-navigation-menu pprwph-z-index-9999 pprwph-display-none-soft">
      <?php echo wp_kses($plugin_white->pprwph_navigation_menu($pprwph_sections), PPRWPH_KSES); ?>
    </div>
  </div>
<?php endif ?>