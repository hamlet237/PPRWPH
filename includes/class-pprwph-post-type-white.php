<?php
/**
 * Whitepaper creator.
 *
 * This class defines Whitepaper options, menus and templates.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    PPRWPH
 * @subpackage PPRWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class PPRWPH_Post_Type_Whitepaper_Section {
  public function get_fields($section_id = 0) {
    global $post;
    $pprwph_sections = get_posts(['fields' => 'ids', 'numberposts' => -1, 'post_type' => 'pprwph_white', 'post_status' => 'any', 'orderby' => 'menu_order', 'order' => 'ASC', 'post_parent' => 0, ]);
        
    $pprwph_sections_options = [];
    if (!empty($pprwph_sections)) {
      foreach ($pprwph_sections as $pprwph_section) {
        $pprwph_sections_options[$pprwph_section] = get_the_title($pprwph_section);
      }
    }

    $pprwph_white_fields = [];
      if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) {
        $pprwph_white_fields['title'] = [
          'id' => 'title',
          'class' => 'pprwph-input pprwph-vertical-align-top pprwph-width-100-percent',
          'input' => 'input',
          'type' => 'text',
          'required' => true,
          'disabled' => !empty(get_the_title($section_id)),
          'value' => get_the_title($section_id),
          'label' => __('Section title', 'pprwph'),
          'placeholder' => __('Section title', 'pprwph'),
        ];
        $pprwph_white_fields['post_type'] = [
          'id' => 'post_type',
          'input' => 'input',
          'type' => 'hidden',
          'value' => 'pprwph_white',
        ];
        $pprwph_white_fields['pprwph_section_parent_check'] = [
          'id' => 'pprwph_section_parent_check',
          'class' => 'pprwph-input pprwph-vertical-align-top pprwph-width-100-percent',
          'input' => 'input',
          'type' => 'checkbox',
          'parent' => 'this',
          'label' => __('It is a child section', 'pprwph'),
          'placeholder' => __('It is a child section', 'pprwph'),
        ];
        $pprwph_white_fields['pprwph_section_parent'] = [
          'id' => 'pprwph_section_parent',
          'class' => 'pprwph-select pprwph-vertical-align-top pprwph-width-100-percent',
          'input' => 'select',
          'options' => $pprwph_sections_options,
          'parent' => 'pprwph_section_parent_check',
          'parent_option' => 'on',
          'label' => __('Parent section', 'pprwph'),
          'placeholder' => __('Parent section', 'pprwph'),
        ];
        $pprwph_white_fields['pprwph_section_publish'] = [
          'id' => 'pprwph_section_publish',
          'input' => 'input',
          'type' => 'checkbox',
          'label' => __('Section published?', 'pprwph'),
          'placeholder' => __('Publish section?', 'pprwph'),
        ];
      }

      $pprwph_white_fields['pprwph_section_link_check'] = [
        'id' => 'pprwph_section_link_check',
        'input' => 'input',
        'type' => 'checkbox',
        'parent' => 'this',
        'label' => __('Section is an external link', 'pprwph'),
        'placeholder' => __('Section is an external link', 'pprwph'),
      ];
        $pprwph_white_fields['pprwph_section_link'] = [
          'id' => 'pprwph_section_link',
          'class' => 'pprwph-input pprwph-vertical-align-top pprwph-width-100-percent',
          'input' => 'input',
          'type' => 'url',
          'parent' => 'pprwph_section_link_check',
          'parent_option' => 'on',
          'label' => __('Section link', 'pprwph'),
          'placeholder' => __('Section link', 'pprwph'),
        ];
      $pprwph_white_fields['pprwph_nonce'] = [
        'id' => 'pprwph_nonce',
        'input' => 'input',
        'type' => 'nonce',
      ];

      if (!is_admin() || (defined('DOING_AJAX') && DOING_AJAX)) {
        $pprwph_white_fields['pprwph_section_submit'] = [
          'id' => 'pprwph_section_submit',
          'input' => 'input',
          'type' => 'submit',
          'subtype' => 'section_creation',
          'value' => (!empty($section_id)) ? __('Edit section', 'pprwph') : __('Create section', 'pprwph'),
        ];
      }

    return $pprwph_white_fields;
  }

	/**
	 * Register Whitepaper_section.
	 *
	 * @since    1.0.0
	 */
	public function register_post_type() {
		$labels = [
      'name'                => _x('Whitepaper section', 'Post Type general name', 'pprwph'),
      'singular_name'       => _x('Whitepaper section', 'Post Type singular name', 'pprwph'),
      'menu_name'           => esc_html(__('Whitepaper sections', 'pprwph')),
      'parent_item_colon'   => esc_html(__('Parent Whitepaper section', 'pprwph')),
      'all_items'           => esc_html(__('All Whitepaper sections', 'pprwph')),
      'view_item'           => esc_html(__('View Whitepaper section', 'pprwph')),
      'add_new_item'        => esc_html(__('Add new Whitepaper section', 'pprwph')),
      'add_new'             => esc_html(__('Add New', 'pprwph')),
      'edit_item'           => esc_html(__('Edit Whitepaper section', 'pprwph')),
      'update_item'         => esc_html(__('Update Whitepaper section', 'pprwph')),
      'search_items'        => esc_html(__('Search Whitepaper sections', 'pprwph')),
      'not_found'           => esc_html(__('Not Whitepaper found', 'pprwph')),
      'not_found_in_trash'  => esc_html(__('Not Whitepaper found in Trash', 'pprwph')),
    ];

    $args = [
      'labels'              => $labels,
      'rewrite'             => ['slug' => (!empty(get_option('pprwph_slug')) ? get_option('pprwph_slug') : 'whitepaper'), 'with_front' => false],
      'label'               => esc_html(__('Whitepaper section', 'pprwph')),
      'description'         => esc_html(__('Whitepaper description', 'pprwph')),
      'supports'            => ['title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'page-attributes'],
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
      'taxonomies'          => PPRWPH_WHITE_ROLE_CAPABILITIES,
      'show_in_rest'        => true, /* REST API */
    ];

		register_post_type('pprwph_white', $args);
    add_theme_support('post-thumbnails', ['page', 'pprwph_white']);
	}

  /**
   * Defines archive template for Whitepaper_section.
   *
   * @since    1.0.0
   */
  public function archive_template($archive) {
    if (get_post_type() == 'pprwph_white') {
      if (file_exists(PPRWPH_DIR . 'templates/public/archive-pprwph_white.php')) {
        return PPRWPH_DIR . 'templates/public/archive-pprwph_white.php';
      }
    }

    return $archive;
  }

  public function pprwph_pre_get_posts($query) {
    if ($query->is_main_query() && $query->is_archive('pprwph_white')) {
      $query->set('post_parent', 0);
      $query->set('orderby', 'menu_order');
      $query->set('order', 'asc');
    }
  }

  /**
   * Add Whitepaper section dashboard metabox.
   *
   * @since    1.0.0
   */
  public function add_meta_box() {
    add_meta_box('pprwph_meta_box', esc_html(__('Whitepaper section details', 'pprwph')), [$this, 'pprwph_meta_box_function'], 'pprwph_white', 'normal', 'high', ['__block_editor_compatible_meta_box' => true,]);
  }

  /**
   * Defines Whitepaper section dashboard contents.
   *
   * @since    1.0.0
   */
  public function pprwph_meta_box_function($post) {
    foreach ($this->get_fields($post->ID) as $wph_field) {
      PPRWPH_Forms::input_wrapper_builder($wph_field, 'post', $post->ID);
    }
  }

  public function activated_plugin($plugin) {
    if($plugin == 'pprwph/pprwph.php') {
      wp_redirect(home_url((!empty(get_option('pprwph_slug')) ? get_option('pprwph_slug') : 'whitepaper')));exit();
    }
  }

  public function save_post($post_id, $cpt, $update) {
    if (array_key_exists('pprwph_nonce', $_POST) && !wp_verify_nonce(PPRWPH_Forms::sanitizer(wp_unslash($_POST['pprwph_nonce'])), 'pprwph-nonce')) {
      echo wp_json_encode(['error_key' => 'pprwph_nonce_error', ]);exit();
    }

    foreach ($this->get_fields($post_id) as $wph_field) {
      $wph_input = array_key_exists('input', $wph_field) ? $wph_field['input'] : '';

      if (array_key_exists($wph_field['id'], $_POST) || $wph_input == 'html_multi') {
        $wph_value = array_key_exists($wph_field['id'], $_POST) ? PPRWPH_Forms::sanitizer(wp_unslash($_POST[$wph_field['id']]), $wph_field['input'], !empty($wph_field['type']) ? $wph_field['type'] : '') : '';

        if (!empty($wph_input)) {
          switch ($wph_input) {
            case 'input':
              if (array_key_exists('type', $wph_field) && $wph_field['type'] == 'checkbox') {
                if (isset($_POST[$wph_field['id']])) {
                  update_post_meta($post_id, $wph_field['id'], $wph_value);
                }else{
                  update_post_meta($post_id, $wph_field['id'], '');
                }
              }else{
                update_post_meta($post_id, $wph_field['id'], $wph_value);
              }

              break;
            case 'select':
              if (array_key_exists('multiple', $wph_field) && $wph_field['multiple']) {
                $multi_array = [];
                $empty = true;

                foreach ($_POST[$wph_field['id']] as $multi_value) {
                  $multi_array[] = PPRWPH_Forms::sanitizer($multi_value, $wph_field['input'], !empty($wph_field['type']) ? $wph_field['type'] : '');
                }

                update_post_meta($post_id, $wph_field['id'], $multi_array);
              }else{
                update_post_meta($post_id, $wph_field['id'], $wph_value);
              }
              
              break;
            case 'html_multi':
              foreach ($wph_field['html_multi_fields'] as $wph_multi_field) {
                if (array_key_exists($wph_multi_field['id'], $_POST)) {
                  $multi_array = [];
                  $empty = true;

                  foreach (PPRWPH_Forms::sanitizer($_POST[$wph_multi_field['id']]) as $multi_value) {
                    if (!empty($multi_value)) {
                      $empty = false;
                    }

                    $multi_array[] = PPRWPH_Forms::sanitizer($multi_value, $wph_multi_field['input'], !empty($wph_multi_field['type']) ? $wph_multi_field['type'] : '');
                  }

                  if (!$empty) {
                    update_post_meta($post_id, $wph_multi_field['id'], $multi_array);
                  }else{
                    update_post_meta($post_id, $wph_multi_field['id'], '');
                  }
                }
              }

              break;
            default:
              update_post_meta($post_id, $wph_field['id'], $wph_value);
              break;
          }
        }
      }else{
        update_post_meta($post_id, $wph_field['id'], '');
      }
    }
  }

  public function pprwph_navigation() {
    global $post;
    $section_id = $post->ID;
    $previous_subsection = $next_subsection = $previous_section = $next_section = '';
    $post_status = (current_user_can('administrator') || current_user_can('pprwph_manager')) ? 'any' : 'publish';

    $pprwph_sections = get_posts(['fields' => 'ids', 'numberposts' => -1, 'post_type' => 'pprwph_white', 'post_status' => $post_status, 'orderby' => 'menu_order', 'order' => 'ASC', 'post_parent' => 0, ]);

    if (has_post_parent($section_id)) {
      $is_subsection = true;
      $section_child_id = $section_id;
      $section_id = get_post_parent($section_child_id)->ID;

      $page_children = get_children(['fields' => 'ids', 'post_parent' => $section_id, 'post_type' => 'pprwph_white', 'post_status' => $post_status, 'orderby' => 'menu_order', 'order' => 'ASC',]);

      if (!empty($page_children[array_search($section_child_id, $page_children) - 1])) {
        $previous_subsection = $page_children[array_search($section_child_id, $page_children) - 1];
      }

      if (!empty($page_children[array_search($section_child_id, $page_children) + 1])) {
        $next_subsection = $page_children[array_search($section_child_id, $page_children) + 1];
      }
    }else{
      $is_subsection = false;
      $page_children = get_children(['fields' => 'ids', 'post_parent' => $section_id, 'post_type' => 'pprwph_white', 'post_status' => $post_status, 'orderby' => 'menu_order', 'order' => 'ASC',]);

      $section_child_id = !empty($page_children) ? $page_children[0] : 0;

      if (!empty($page_children[array_search($section_child_id, $page_children)])) {
        $next_subsection = $page_children[array_search($section_child_id, $page_children)];
      }
    }

    if (!empty($pprwph_sections[array_search($section_id, $pprwph_sections) - 1])) {
      $previous_section = $pprwph_sections[array_search($section_id, $pprwph_sections) - 1];
    }

    if (!empty($pprwph_sections[array_search($section_id, $pprwph_sections) + 1])) {
      $next_section = $pprwph_sections[array_search($section_id, $pprwph_sections) + 1];
    }

    ob_start();
    ?>
      <div class="pprwph-navigation pprwph-mt-50 pprwph-mb-100">
        <div class="pprwph-display-table pprwph-width-100-percent">
          <div class="pprwph-display-inline-table pprwph-width-50-percent pprwph-tablet-display-block pprwph-tablet-width-100-percent">
            <a href="<?php echo esc_url(get_post_type_archive_link('pprwph_white')); ?>"><i class="material-icons-outlined pprwph-vertical-align-middle pprwph-mr-10 pprwph-font-size-20">keyboard_arrow_left</i> <?php esc_html_e('Back to main', 'pprwph'); ?></a>
          </div>
          <div class="pprwph-display-inline-table pprwph-width-50-percent pprwph-tablet-display-block pprwph-tablet-width-100-percent">
            <?php if (current_user_can('administrator') || current_user_can('pprwph_manager')): ?>
              <div class="pprwph-width-100-percent pprwph-text-align-right pprwph-mb-50">
                <a href="<?php echo esc_url(admin_url('post.php?post=' . $section_id . '&action=edit')); ?>" class="pprwph-btn pprwph-tooltip" title="<?php esc_html_e('Edit section', 'pprwph'); ?>"><i class="material-icons-outlined pprwph-vertical-align-middle pprwph-font-size-20">edit</i></a>
              </div>
            <?php endif ?>
          </div>
        </div>
        
        <div class="pprwph-navigation-subsections">
          <div class="pprwph-display-table pprwph-width-100-percent">
            <div class="pprwph-display-inline-table pprwph-width-33-percent pprwph-tablet-display-block pprwph-tablet-width-100-percent pprwph-mb-20 pprwph-text-align-left">
              <div class="pprwph-pl-50">
                <?php if (!empty($previous_subsection)): ?>
                  <a href="<?php echo esc_url(get_permalink($previous_subsection)); ?>">
                    <p><i class="material-icons-outlined pprwph-vertical-align-middle pprwph-font-size-20">keyboard_arrow_left</i> <?php esc_html_e('Previous subsection', 'pprwph'); ?></p>
                    <h4><?php echo esc_html(get_the_title($previous_subsection)); ?></h4>
                  </a>
                <?php endif ?>
              </div>
            </div>

            <div class="pprwph-display-inline-table pprwph-width-33-percent pprwph-tablet-display-block pprwph-tablet-width-100-percent pprwph-mb-20 pprwph-text-align-center">
              <?php if ($is_subsection): ?>
                <p><?php esc_html_e('Current subsection', 'pprwph'); ?></p>
                <h4><?php echo esc_html(get_the_title($section_child_id)); ?></h4>
              <?php endif ?>
            </div>

            <div class="pprwph-display-inline-table pprwph-width-33-percent pprwph-tablet-display-block pprwph-tablet-width-100-percent pprwph-mb-20 pprwph-text-align-right">
              <div class="pprwph-pr-50">
                <?php if (!empty($next_subsection)): ?>
                  <a href="<?php echo esc_url(get_permalink($next_subsection)); ?>">
                    <p><?php esc_html_e('Next subsection', 'pprwph'); ?> <i class="material-icons-outlined pprwph-vertical-align-middle pprwph-font-size-20">keyboard_arrow_right</i></p>
                    <h4><?php echo esc_html(get_the_title($next_subsection)); ?></h4>
                  </a>
                <?php endif ?>
              </div>
            </div>
          </div>
        </div>

        <div class="pprwph-navigation-sections">
          <div class="pprwph-display-table pprwph-width-100-percent">
            <div class="pprwph-display-inline-table pprwph-width-33-percent pprwph-tablet-display-block pprwph-tablet-width-100-percent pprwph-mb-20 pprwph-text-align-left">
              <?php if (!empty($previous_section)): ?>
                <a href="<?php echo esc_url(get_permalink($previous_section)); ?>">
                  <p><i class="material-icons-outlined pprwph-vertical-align-middle pprwph-font-size-30">keyboard_arrow_left</i> <?php esc_html_e('Previous section', 'pprwph'); ?></p>
                  <h4><?php echo esc_html(get_the_title($previous_section)); ?></h4>
                </a>
              <?php endif ?>
            </div>

            <div class="pprwph-display-inline-table pprwph-width-33-percent pprwph-tablet-display-block pprwph-tablet-width-100-percent pprwph-mb-20 pprwph-text-align-center">
              <?php if ($is_subsection): ?>
                <a href="<?php echo esc_url(get_permalink($section_id)); ?>">
                  <p><?php esc_html_e('Current section', 'pprwph'); ?></p>
                  <h4><?php echo esc_html(get_the_title($section_id)); ?></h4>
                </a>
              <?php else: ?>
                <p><?php esc_html_e('Current section', 'pprwph'); ?></p>
                <h4><?php echo esc_html(get_the_title($section_id)); ?></h4>
              <?php endif ?>
            </div>

            <div class="pprwph-display-inline-table pprwph-width-33-percent pprwph-tablet-display-block pprwph-tablet-width-100-percent pprwph-mb-20 pprwph-text-align-right">
              <?php if (!empty($next_section)): ?>
                <a href="<?php echo esc_url(get_permalink($next_section)); ?>">
                  <p><?php esc_html_e('Next section', 'pprwph'); ?> <i class="material-icons-outlined pprwph-vertical-align-middle pprwph-font-size-30">keyboard_arrow_right</i></p>
                  <h4><?php echo esc_html(get_the_title($next_section)); ?></h4>
                </a>
              <?php endif ?>
            </div>
          </div>
        </div>
      </div>
    <?php
    $pprwph_return_string = ob_get_contents(); 
    ob_end_clean(); 
    return $pprwph_return_string;
  }

  public function pprwph_content_extra($content) {
    global $post;
    $post_id = $post->ID;
    $section_id = $post_id;
    $content_before = $content_after = '';

    if ($post->post_type == 'pprwph_white') {
      $content_after = self::pprwph_navigation();

      if (!empty($content) && (current_user_can('administrator') || current_user_can('pprwph_manager'))) {
        ob_start();
        ?>
          <div class="pprwph-display-table pprwph-width-100-percent">
            <div class="pprwph-display-inline-table pprwph-width-50-percent pprwph-tablet-display-block pprwph-tablet-width-100-percent">
              <a href="<?php echo esc_url(get_post_type_archive_link('pprwph_white')); ?>"><i class="material-icons-outlined pprwph-vertical-align-middle pprwph-mr-10 pprwph-font-size-20">keyboard_arrow_left</i> <?php esc_html_e('Back to main', 'pprwph'); ?></a>
            </div>
            <div class="pprwph-display-inline-table pprwph-width-50-percent pprwph-tablet-display-block pprwph-tablet-width-100-percent">
              <?php if (current_user_can('administrator') || current_user_can('pprwph_manager')): ?>
                <div class="pprwph-width-100-percent pprwph-text-align-right pprwph-mb-50">
                  <a href="<?php echo esc_url(admin_url('post.php?post=' . $section_id . '&action=edit')); ?>" class="pprwph-btn pprwph-tooltip" title="<?php esc_html_e('Edit section', 'pprwph'); ?>"><i class="material-icons-outlined pprwph-vertical-align-middle pprwph-font-size-20">edit</i></a>
                </div>
              <?php endif ?>
            </div>
          </div>
        <?php
        $content_before = ob_get_contents(); 
        ob_end_clean(); 
      }
    }

    return $content_before . $content . $content_after;
  }

  public function pprwph_navigation_menu($pprwph_sections) {
    ob_start();
    ?>
      <div class="pprwph-navigation-menu-wrapper">
        <div class="pprwph-navigation-header pprwph-mb-30">
          <h3 class="pprwph-mb-0 pprwph-font-size-25"><?php echo (!empty(get_option('pprwph_title')) ? esc_html(get_option('pprwph_title')) : 'Whitepaper') ?></h3>
          <p class="pprwph-text-align-right pprwph-font-size-13 pprwph-color-grey"><?php esc_html_e('Version', 'pprwph'); ?> <?php echo !empty(get_option('pprwph_version')) ? esc_html(get_option('pprwph_version')) : '1.0.0'; ?></p>
        </div>

        <div class="pprwph-navigation-list-wrapper">
          <?php if (!empty($pprwph_sections)): ?>
            <ul class="pprwph-navigation-list pprwph-mb-30 pprwph-ml-0">
              <?php echo wp_kses(self::pprwph_get_navigation_list($pprwph_sections), PPRWPH_KSES); ?>
            </ul>
          <?php else: ?>
            <ul class="pprwph-navigation-list pprwph-mb-30 pprwph-ml-0">
              <p class="pprwph-mb-30 pprwph-color-white"><?php esc_html_e('This Whitepaper has no sections yet.', 'pprwph'); ?></p>
            </ul>
          <?php endif ?>
        </div>

        <div class="pprwph-navigation-new pprwph-text-align-right pprwph-mb-50">
          <?php if (current_user_can('administrator') || current_user_can('pprwph_manager')): ?>
            <a href="#" class="pprwph-white-new-btn pprwph-color-white pprwph-popup-add-btn pprwph-text-decoration-none pprwph-section-new"><span><?php esc_html_e('New section', 'pprwph'); ?></span> <i class="material-icons-outlined pprwph-white-add pprwph-vertical-align-middle">add</i></a>
          <?php endif ?>
        </div>

        <div class="pprwph-navigation-footer pprwph-mb-100">
          <p class="pprwph-text-align-right pprwph-font-size-13 pprwph-color-grey"><?php esc_html_e('Last update', 'pprwph'); ?> <?php echo esc_html(self::pprwph_section_get_last_update()); ?></p>
        </div>

        <div id="pprwph-popup-section-remove" class="pprwph-popup pprwph-display-none-soft">
          <div class="pprwph-popup-content">
            <div class="pprwph-text-align-center"><div class="pprwph-loader-circle"><div></div><div></div><div></div><div></div></div></div>
          </div>
        </div>

        <div id="pprwph-popup-section-add" class="pprwph-popup pprwph-display-none-soft">
          <div class="pprwph-popup-content">
            <div class="pprwph-text-align-center"><div class="pprwph-loader-circle"><div></div><div></div><div></div><div></div></div></div>
          </div>
        </div>
      </div>
    <?php
    $pprwph_return_string = ob_get_contents(); 
    ob_end_clean(); 
    return $pprwph_return_string;
  }

  public function pprwph_popup_section_add($section_id = 0) {
    ob_start();
    ?>
      <form action="" method="post" id="pprwph-add-fields" class="pprwph-form" data-pprwph-section-id="<?php echo esc_attr($section_id); ?>">
        <?php foreach ($this->get_fields($section_id) as $pprwph_field): ?>
          <?php PPRWPH_Forms::input_wrapper_builder($pprwph_field, 'post', $section_id); ?>
        <?php endforeach ?>
      </form>
    <?php
    $pprwph_return_string = ob_get_contents(); 
    ob_end_clean(); 
    return $pprwph_return_string;
  }

  public function pprwph_popup_section_remove($section_id) {
    ob_start();
    ?>
      <div class="pprwph-popup-section-remove pprwph-text-align-center" data-pprwph-section-id="<?php echo esc_attr($section_id); ?>">
        <p><?php esc_html_e('The section will be permanently removed.', 'pprwph'); ?></p>

        <div class="pprwph-display-table pprwph-width-100-percent">
          <div class="pprwph-display-inline-table pprwph-width-50-percent pprwph-tablet-display-block pprwph-tablet-width-100-percent">
            <a href="#" class="pprwph-popup-close pprwph-text-decoration-none pprwph-font-size-13"><?php esc_html_e('Cancel', 'pprwph'); ?></a>
          </div>

          <div class="pprwph-display-inline-table pprwph-width-50-percent pprwph-tablet-display-block pprwph-tablet-width-100-percent">
            <a href="#" class="pprwph-btn pprwph-btn-mini pprwph-section-remove-btn"><?php esc_html_e('Remove section', 'pprwph'); ?></a><img class="pprwph-waiting pprwph-display-none-soft" src="<?php echo esc_url(plugin_dir_url(__FILE__) . 'assets/ajax-loader.gif'); ?>" alt="<?php esc_html_e('Loading...', 'pprwph'); ?>">
          </div>
        </div>
      </div>
    <?php
    $pprwph_return_string = ob_get_contents(); 
    ob_end_clean(); 
    return $pprwph_return_string;
  }

  public function pprwph_get_navigation_list($pprwph_sections) {
    global $post;
    $current_section_id = !empty($post) ? $post->ID : 0;

    ob_start();
    ?>
      <?php foreach ($pprwph_sections as $section_id): ?>
        <?php $page_children = get_children(['fields' => 'ids', 'post_parent' => $section_id, 'post_type' => 'pprwph_white', 'post_status' => 'any', 'orderby' => 'menu_order', 'order' => 'ASC',]); ?>
        <?php $section_status = get_post($section_id)->post_status; ?>

        <?php if ($section_status == 'publish' || current_user_can('administrator') || current_user_can('pprwph_manager')): ?>
          <?php 
            $pprwph_section_link_check = get_post_meta($section_id, 'pprwph_section_link_check', true);
            $pprwph_section_link = get_post_meta($section_id, 'pprwph_section_link', true);
            $pprwph_section_parent_check = get_post_meta($section_id, 'pprwph_section_parent_check', true);
            $pprwph_section_parent = get_post_meta($section_id, 'pprwph_section_parent', true);
          ?>

          <li class="pprwph-navigation-element pprwph-transition pprwph-position-relative pprwph-mb-10 <?php echo ($pprwph_section_parent_check == 'on' && !empty($pprwph_section_parent)) ? 'pprwph-ml-20' : ''; ?>" data-pprwph-section-id="<?php echo esc_attr($section_id); ?>" data-pprwph-type="<?php echo esc_attr(get_post_meta($section_id, 'type', true)); ?>">
            <?php if (current_user_can('administrator') || current_user_can('pprwph_manager')): ?>
              <div class="pprwph-section-status pprwph-transition <?php echo esc_attr($section_status); ?>">
                <span class="pprwph-tablet-display-none"><?php echo esc_html(ucfirst($section_status)); ?></span>
              </div>

              <i class="material-icons-outlined pprwph-white-drag pprwph-cursor-move pprwph-vertical-align-middle pprwph-tooltip" title="<?php esc_html_e('Reorder section', 'pprwph'); ?>">drag_handle</i>
            <?php endif ?>

            <a href="<?php echo ($pprwph_section_link_check == 'on' && !empty($pprwph_section_link)) ? esc_url($pprwph_section_link) : esc_url(get_permalink($section_id)); ?>" target="<?php echo ($pprwph_section_link_check == 'on') ? '_blank' : '_self'; ?>" class="<?php echo (!is_post_type_archive() && $section_id == $current_section_id) ? 'pprwph-text-decoration-underline' : ''; ?>"><?php echo esc_html(get_the_title($section_id)); ?><?php echo ($pprwph_section_link_check == 'on') ? '<i class="material-icons-outlined pprwph-vertical-align-middle pprwph-font-size-15 pprwph-ml-20 pprwph-tooltip" title="' . esc_html(__('It opens in new tab', 'pprwph')) . '">open_in_new</i>' : ''; ?></a>

            <?php if (current_user_can('administrator') || current_user_can('pprwph_manager')): ?>
              <?php echo wp_kses(self::pprwph_section_tools($section_id), PPRWPH_KSES); ?>
            <?php endif ?>

            <?php if (!empty($page_children)): ?>
              <ul class="pprwph-navigation-list pprwph-list-style-none pprwph-pl-20 pprwph-pt-10">
                <?php foreach ($page_children as $section_child_id): ?>
                  <?php 
                    $children_section_status = get_post($section_child_id)->post_status;
                    $pprwph_section_link_check = get_post_meta($section_child_id, 'pprwph_section_link_check', true);
                    $pprwph_section_link = get_post_meta($section_child_id, 'pprwph_section_link', true);
                  ?>

                  <?php if ($children_section_status == 'publish' || current_user_can('administrator') || current_user_can('pprwph_manager')): ?>
                    <li class="pprwph-navigation-element pprwph-position-relative pprwph-mb-10" data-pprwph-section-id="<?php echo esc_attr($section_child_id); ?>" data-pprwph-parent-section-id="<?php echo esc_attr($section_id); ?>" data-pprwph-type="<?php echo esc_attr(get_post_meta($section_child_id, 'type', true)); ?>">
                      <?php if (current_user_can('administrator') || current_user_can('pprwph_manager')): ?>
                        <div class="pprwph-section-status pprwph-transition <?php echo esc_attr($children_section_status); ?>">
                          <span class="pprwph-tablet-display-none"><?php echo esc_html(ucfirst($children_section_status)); ?></span>
                        </div>

                        <i class="material-icons-outlined pprwph-white-drag pprwph-cursor-move pprwph-vertical-align-middle pprwph-tooltip" title="<?php esc_html_e('Reorder section', 'pprwph'); ?>">drag_handle</i>
                      <?php endif ?>

                      <a href="<?php echo ($pprwph_section_link_check == 'on') ? esc_url($pprwph_section_link) : esc_url(get_permalink($section_child_id)); ?>" target="<?php echo ($pprwph_section_link_check == 'on') ? '_blank' : '_self'; ?>"><?php echo esc_html(get_the_title($section_child_id)); ?><?php echo ($pprwph_section_link_check == 'on') ? '<i class="material-icons-outlined pprwph-vertical-align-middle pprwph-font-size-15 pprwph-ml-20 pprwph-tooltip" title="' . esc_html(__('It opens in new tab', 'pprwph')) . '">open_in_new</i>' : ''; ?></a>

                      <?php if (current_user_can('administrator') || current_user_can('pprwph_manager')): ?>
                        <?php echo wp_kses(self::pprwph_section_tools($section_child_id), PPRWPH_KSES); ?>
                      <?php endif ?>
                    </li>
                  <?php endif ?>
                <?php endforeach ?>
              </ul>
            <?php endif ?>
          </li>
        <?php endif ?>
      <?php endforeach ?>
    <?php
    $pprwph_return_string = ob_get_contents(); 
    ob_end_clean(); 
    return $pprwph_return_string;
  }

  public function pprwph_section_tools($section_id) {
    ob_start();
    ?>
      <div class="pprwph-section-tools pprwph-transition">
        <a href="<?php echo esc_url(admin_url('post.php?post=' . $section_id . '&action=edit')); ?>">
          <i class="material-icons-outlined pprwph-vertical-align-middle pprwph-tooltip pprwph-color-grey" title="<?php esc_html_e('Edit section', 'pprwph'); ?> <?php echo esc_html(get_the_title($section_id)); ?>">edit</i>
        </a>

        <a href="#" class="pprwph-popup-add-btn">
          <i class="material-icons-outlined pprwph-vertical-align-middle pprwph-tooltip pprwph-color-grey" title="<?php esc_html_e('Configure section', 'pprwph'); ?> <?php echo esc_html(get_the_title($section_id)); ?>">settings</i>
        </a>

        <a href="#" class="pprwph-popup-remove-btn">
          <i class="material-icons-outlined pprwph-vertical-align-middle pprwph-tooltip pprwph-color-grey" title="<?php esc_html_e('Remove section', 'pprwph'); ?> <?php echo esc_html(get_the_title($section_id)); ?>">delete_outline</i>
        </a>
      </div>
    <?php
    $pprwph_return_string = ob_get_contents(); 
    ob_end_clean(); 
    return $pprwph_return_string;
  }

  public function pprwph_section_get_last_update() {
    $last_update = 'never yet';

    $pprwph_sections = get_posts(['fields' => 'ids', 'numberposts' => -1, 'post_type' => 'pprwph_white', 'post_status' => 'any', 'orderby' => 'ID', 'order' => 'ASC', ]);

    if (!empty($pprwph_sections)) {
      foreach ($pprwph_sections as $section_id) {
        $date_modified = get_post($section_id)->post_modified;
        if (strtotime($date_modified) > strtotime($last_update)) {
          $last_update = date_i18n(get_option('date_format'), strtotime(get_post($section_id)->post_modified)) . ' ' . date_i18n(get_option('time_format'), strtotime(get_post($section_id)->post_modified));
        }
      }
    }

    return $last_update;
  }

  public function pprwph_section_get_last_order_id($parent_id) {
    $last_order_id = 0;
    $pprwph_sections = get_posts(['fields' => 'ids', 'numberposts' => -1, 'post_type' => 'pprwph_white', 'post_status' => 'any', 'orderby' => 'ID', 'order' => 'ASC', 'post_parent' => $parent_id]);

    if (!empty($pprwph_sections)) {
      foreach ($pprwph_sections as $section_id) {
        $last_order_id = max(get_post($section_id)->menu_order, $last_order_id);
      }
    }

    return $last_order_id;
  }
}