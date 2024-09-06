<?php 
/**
 * Provide an archive page for Whitepaper sections
 *
 * This file is used to provide an archive page for Whitepaper section CPTs
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 *
 * @package    PPRWPH
 * @subpackage PPRWPH/common/templates
 */

	if (!defined('ABSPATH')) exit; // Exit if accessed directly

	get_header();
	if(wp_is_block_theme()) {
	  block_template_part('header');
	}

	$pprwph_white = new PPRWPH_Post_Type_Whitepaper_Section();
  $pprwph_sections = get_posts(['fields' => 'ids', 'numberposts' => -1, 'post_type' => 'pprwph_white', 'post_status' => 'any', 'orderby' => 'menu_order', 'order' => 'ASC', 'post_parent' => 0, ]);
?>

<div class="pprwph-archive pprwph-p-20">
  <?php echo wp_kses($pprwph_white->pprwph_navigation_menu($pprwph_sections), PPRWPH_KSES); ?>
</div>

<?php 
	get_footer();
	if(wp_is_block_theme()) {
	  block_template_part('footer');
	}
?>