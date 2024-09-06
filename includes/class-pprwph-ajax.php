<?php
/**
 * Load the plugin Ajax functions.
 *
 * Load the plugin Ajax functions to be executed in background.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    PPRWPH
 * @subpackage PPRWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class PPRWPH_Ajax {
	/**
	 * Load ajax functions.
	 *
	 * @since    1.0.0
	 */
	public function pprwph_ajax_server() {
    if (array_key_exists('pprwph_ajax_type', $_POST)) {
      if (array_key_exists('ajax_nonce', $_POST) && !wp_verify_nonce(PPRWPH_Forms::sanitizer(wp_unslash($_POST['ajax_nonce'])), 'pprwph-nonce')) {
        echo wp_json_encode(['error_key' => 'pprwph_nonce_error', ]);exit();
      }

      $pprwph_ajax_type = !empty($_POST['pprwph_ajax_type']) ? PPRWPH_Forms::sanitizer(wp_unslash($_POST['pprwph_ajax_type'])) : '';
  		$pprwph_ajax_subtype = !empty($_POST['pprwph_ajax_subtype']) ? PPRWPH_Forms::sanitizer(wp_unslash($_POST['pprwph_ajax_subtype'])) : '';
      $ajax_keys = !empty($_POST['ajax_keys']) ? PPRWPH_Forms::sanitizer(wp_unslash($_POST['ajax_keys'])) : '';
      $key_value = [];

      if (!empty($ajax_keys)) {
        foreach ($ajax_keys as $key) {
          if (strpos($key['id'], '[]') !== false) {
            $clear_key = str_replace('[]', '', $key['id']);
            ${$clear_key} = $key_value[$clear_key] = [];

            if (!empty($_POST[$clear_key])) {
              foreach ($_POST[$clear_key] as $multi_key => $multi_value) {
                ${$clear_key}[$multi_key] = PPRWPH_Forms::sanitizer(wp_unslash($_POST[$clear_key][$multi_key]), $key['node'], $key['type']);
                $key_value[$clear_key][$multi_key] = PPRWPH_Forms::sanitizer(wp_unslash($_POST[$clear_key][$multi_key]), $key['node'], $key['type']);
              }
            }else{
              ${$clear_key} = '';
              $key_value[$clear_key][$multi_key] = '';
            }
          }else{
            ${$key['id']} = PPRWPH_Forms::sanitizer(wp_unslash($_POST[$key['id']]), $key['node'], $key['type']);
            $key_value[$key['id']] = PPRWPH_Forms::sanitizer(wp_unslash($_POST[$key['id']]), $key['node'], $key['type']);
          }
        }
      }

      $plugin_white = new PPRWPH_Post_Type_Whitepaper_Section();

      switch ($pprwph_ajax_type) {
        case 'pprwph_options_save':
          if (!empty($key_value)) {
            foreach ($key_value as $key => $value) {
              if (!in_array($key, ['action', 'pprwph_ajax_type'])) {
                update_option($key, $value);
              }
            }

            update_option('pprwph_options_changed', true);
            echo wp_json_encode(['error_key' => '', ]);exit();
          }else{
            echo wp_json_encode(['error_key' => 'pprwph_options_save_error', ]);exit();
          }
          break;
        case 'pprwph_ajax_section_order':
          $order = PPRWPH_Forms::sanitizer(wp_unslash($_POST['order']));

          if (!empty($order)) {
            $order_counter = $order_child_counter = 0;

            foreach ($order as $section_id) {
              if (!empty($section_id['parent_section_id'])) {
                wp_update_post(['ID' => $section_id['section_id'], 'menu_order' => $order_child_counter, 'post_parent' => $section_id['parent_section_id']]);
                $order_child_counter++;
              }else{
                wp_update_post(['ID' => $section_id['section_id'], 'menu_order' => $order_counter, 'post_parent' => 0, ]);
                $order_child_counter = 0;
              }

              $order_counter++;
            }

            $pprwph_sections = get_posts(['fields' => 'ids', 'numberposts' => -1, 'post_type' => 'pprwph_white', 'post_status' => 'any', 'orderby' => 'menu_order', 'order' => 'ASC', 'post_parent' => 0, ]);

            echo wp_json_encode(['error_key' => '', 'html' => $plugin_white->pprwph_get_navigation_list($pprwph_sections), ]);exit();
          }else{
            echo wp_json_encode(['error_key' => 'empty', ]);exit();
          }
          break;
        case 'pprwph_popup_section_add':
          $section_id = PPRWPH_Forms::sanitizer(wp_unslash($_POST['section_id']));
          
          echo wp_kses($plugin_white->pprwph_popup_section_add($section_id), PPRWPH_KSES);exit();
        case 'pprwph_popup_section_remove':
          $section_id = PPRWPH_Forms::sanitizer(wp_unslash($_POST['section_id']));

          if (!empty($section_id)) {
            echo wp_kses($plugin_white->pprwph_popup_section_remove($section_id), PPRWPH_KSES);exit();
          }else{
            echo 'pprwph_popup_section_remove_error';exit();
          }
          break;
        case 'pprwph_ajax_section_remove':
          $section_id = PPRWPH_Forms::sanitizer(wp_unslash($_POST['section_id']));

          if (!empty($section_id)) {
            $page_children = get_children(['fields' => 'ids', 'post_parent' => $section_id, 'post_type' => 'pprwph_white', 'post_status' => 'any', 'orderby' => 'menu_order', 'order' => 'ASC',]);

            if (!empty($page_children)) {
              foreach ($page_children as $section_child_id) {
                wp_update_post(['ID' => $section_child_id, 'menu_order' => 0, 'post_parent' => 0]);
              }
            }else{
              wp_delete_post($section_id, true);
            }

            $pprwph_sections = get_posts(['fields' => 'ids', 'numberposts' => -1, 'post_type' => 'pprwph_white', 'post_status' => 'any', 'orderby' => 'menu_order', 'order' => 'ASC', 'post_parent' => 0, ]);

            echo wp_json_encode(['error_key' => '', 'html' => $plugin_white->pprwph_get_navigation_list($pprwph_sections), ]);exit();
          }else{
            echo wp_json_encode(['error_key' => 'empty', ]);exit();
          }
          break;
      }

      echo wp_json_encode(['error_key' => 'pprwph_save_error', ]);exit();
    }
	}
}