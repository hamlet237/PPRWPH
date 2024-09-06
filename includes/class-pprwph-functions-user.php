<?php
/**
 * Define the users management functionality.
 *
 * Loads and defines the users management files for this plugin so that it is ready for user creation, edition or removal.
 *  
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    pprwph
 * @subpackage pprwph/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class PPRWPH_Functions_User {
  public static function get_user_name($user_id) {
    if (!empty($user_id)) {
      $user_info = get_userdata($user_id);

      if (!empty($user_info->first_name)) {
        return $user_info->first_name;
      }else if (!empty($user_info->last_name)) {
        return $user_info->last_name;
      }else if (!empty($user_info->user_nicename)){
        return $user_info->user_nicename;
      }else{
        return $user_info->user_email;
      }
    }
  }

  public static function is_user_admin($user_id) {
    return user_can($user_id, 'administrator');
  }

  public function insert_user($pprwph_user_login, $pprwph_user_password, $pprwph_user_email = '', $pprwph_first_name = '', $pprwph_last_name = '', $pprwph_display_name = '', $pprwph_user_nicename = '', $pprwph_user_nickname = '', $pprwph_user_description = '', $pprwph_user_role = [], $pprwph_array_usermeta = [/*['pprwph_key' => 'pprwph_value'], */]) {
    /* $this->pprwph_insert_user($pprwph_user_login, $pprwph_user_password, $pprwph_user_email = '', $pprwph_first_name = '', $pprwph_last_name = '', $pprwph_display_name = '', $pprwph_user_nicename = '', $pprwph_user_nickname = '', $pprwph_user_description = '', $pprwph_user_role = [], $pprwph_array_usermeta = [['pprwph_key' => 'pprwph_value'], ], ); */

    $pprwph_user_array = [
      'first_name' => $pprwph_first_name,
      'last_name' => $pprwph_last_name,
      'display_name' => $pprwph_display_name,
      'user_nicename' => $pprwph_user_nicename,
      'nickname' => $pprwph_user_nickname,
      'description' => $pprwph_user_description,
    ];

    if (!empty($pprwph_user_email)) {
      if (!email_exists($pprwph_user_email)) {
        if (username_exists($pprwph_user_login)) {
          $user_id = wp_create_user($pprwph_user_email, $pprwph_user_password, $pprwph_user_email);
        }else{
          $user_id = wp_create_user($pprwph_user_login, $pprwph_user_password, $pprwph_user_email);
        }
      }else{
        $user_id = get_user_by('email', $pprwph_user_email)->ID;
      }
    }else{
      if (!username_exists($pprwph_user_login)) {
        $user_id = wp_create_user($pprwph_user_login, $pprwph_user_password);
      }else{
        $user_id = get_user_by('login', $pprwph_user_login)->ID;
      }
    }

    if ($user_id && !is_wp_error($user_id)) {
      wp_update_user(array_merge(['ID' => $user_id], $pprwph_user_array));
    }else{
      return false;
    }

    $user = new WP_User($user_id);
    if (!empty($pprwph_user_role)) {
      foreach ($pprwph_user_role as $new_role) {
        $user->add_role($new_role);
      }
    }

    if (!empty($pprwph_array_usermeta)) {
      foreach ($pprwph_array_usermeta as $pprwph_usermeta) {
        foreach ($pprwph_usermeta as $meta_key => $meta_value) {
          if ((!empty($meta_value) || !empty(get_user_meta($user_id, $meta_key, true))) && !is_null($meta_value)) {
            update_user_meta($user_id, $meta_key, $meta_value);
          }
        }
      }
    }

    return $user_id;
  }
}