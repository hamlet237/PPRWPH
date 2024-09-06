<?php
/**
 * Load the plugin no private Ajax functions.
 *
 * Load the plugin no private Ajax functions to be executed in background.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    PPRWPH
 * @subpackage PPRWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class PPRWPH_Ajax_Nopriv {
	/**
	 * Load the plugin templates.
	 *
	 * @since    1.0.0
	 */
	public function pprwph_ajax_nopriv_server() {
    if (array_key_exists('pprwph_ajax_nopriv_type', $_POST)) {
      if (array_key_exists('ajax_nonce', $_POST) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ajax_nonce'])), 'pprwph-nonce')) {
        echo wp_json_encode(['error_key' => 'pprwph_nonce_error', ]);exit();
      }

      $pprwph_ajax_nopriv_type = PPRWPH_Forms::sanitizer(wp_unslash($_POST['pprwph_ajax_nopriv_type']));
      $pprwph_ajax_nopriv_subtype = PPRWPH_Forms::sanitizer(wp_unslash($_POST['pprwph_ajax_nopriv_subtype']));
      $ajax_keys = $_POST['ajax_keys'];
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

      switch ($pprwph_ajax_nopriv_type) {
        case 'pprwph_form_save':
          $pprwph_form_type = PPRWPH_Forms::sanitizer(wp_unslash($_POST['pprwph_form_type']));

          if (!empty($key_value) && !empty($pprwph_form_type)) {
            $pprwph_form_id = PPRWPH_Forms::sanitizer(wp_unslash($_POST['pprwph_form_id']));
            $pprwph_form_subtype = PPRWPH_Forms::sanitizer(wp_unslash($_POST['pprwph_form_subtype']));
            $user_id = PPRWPH_Forms::sanitizer(wp_unslash($_POST['pprwph_form_user_id']));
            $post_id = PPRWPH_Forms::sanitizer(wp_unslash($_POST['pprwph_form_post_id']));

            if (!is_user_logged_in()) {
              session_start();

              $_SESSION['wph_form'] = [];
              $_SESSION['wph_form'][$pprwph_form_id] = [];
              $_SESSION['wph_form'][$pprwph_form_id]['form_type'] = $pprwph_form_type;
              $_SESSION['wph_form'][$pprwph_form_id]['values'] = $key_value;

              if (!empty($post_id)) {
                $_SESSION['wph_form'][$pprwph_form_id]['post_id'] = $post_id;
              }

              echo wp_json_encode(['error_key' => 'pprwph_form_save_error_unlogged', ]);exit();
            }else{
              switch ($pprwph_form_type) {
                case 'user':
                  if (empty($user_id)) {
                    if (PPRWPH_Functions_User::is_user_admin(get_current_user_id())) {
                      $user_login = PPRWPH_Forms::sanitizer(wp_unslash($_POST['user_login']));
                      $user_password = PPRWPH_Forms::sanitizer(wp_unslash($_POST['user_password']));
                      $user_email = PPRWPH_Forms::sanitizer(wp_unslash($_POST['user_email']));

                      $user_id = PPRWPH_Functions_Post::insert_user($user_login, $user_password, $user_email);
                    }
                  }

                  foreach ($key_value as $key => $value) {
                    update_user_meta($user_id, $key, $value);
                  }

                  break;
                case 'post':
                  if (empty($post_id)) {
                    if (PPRWPH_Functions_User::is_user_admin(get_current_user_id())) {
                      $post_id = PPRWPH_Functions_Post::insert_post($title, '', '', sanitize_title($title), $post_type, 'publish', get_current_user_id());
                    }
                  }

                  foreach ($key_value as $key => $value) {
                    update_post_meta($post_id, $key, $value);
                  }

                  break;
                case 'option':
                  if (PPRWPH_Functions_User::is_user_admin(get_current_user_id())) {
                    foreach ($key_value as $key => $value) {
                      update_option($key, $value);
                    }
                  }

                  break;
              }

              if ($pprwph_form_type == 'option') {
                update_option('pprwph_form_changed', true);
              }

              switch ($pprwph_form_type) {
                case 'user':
                  do_action('pprwph_form_save', $user_id, $key_value, $pprwph_form_type, $pprwph_form_subtype);
                  break;
                case 'post':
                  do_action('pprwph_form_save', $post_id, $key_value, $pprwph_form_type, $pprwph_form_subtype);
                  break;
                case 'option':
                  do_action('pprwph_form_save', 0, $key_value, $pprwph_form_type, $pprwph_form_subtype);
                  break;
              }

              echo wp_json_encode(['error_key' => '', ]);exit();
            }
          }else{
            echo wp_json_encode(['error_key' => 'pprwph_form_save_error', ]);exit();
          }
          break;
      }

      echo wp_json_encode(['error_key' => '', ]);exit();
  	}
  }
}