<?php
/**
 * Fired from activate() function.
 *
 * This class defines all post types necessary to run during the plugin's life cycle.
 *
 * @link       wordpress-heroes.com/
 * @since      1.0.0
 * @package    PPRWPH
 * @subpackage PPRWPH/includes
 * @author     wordpress-heroes <info@wordpress-heroes.com>
 */
class PPRWPH_Forms {
	/**
	 * Plaform forms.
	 *
	 * @since    1.0.0
	 */

  public static function input_builder($pprwph_input, $pprwph_type, $pprwph_id = 0, $pprwph_disabled_fields = false, $pprwph_meta_array = false, $pprwph_array_index = 0) {
    if ($pprwph_meta_array) {
      switch ($pprwph_type) {
        case 'user':
          $user_meta = get_user_meta($pprwph_id, $pprwph_input['id'], true);

          if (is_array($user_meta) && array_key_exists($pprwph_array_index, $user_meta) && !empty($user_meta[$pprwph_array_index])) {
            $pprwph_value = $user_meta[$pprwph_array_index];
          }else{
            if (array_key_exists('value', $pprwph_input)) {
              $pprwph_value = $pprwph_input['value'];
            }else{
              $pprwph_value = '';
            }
          }
          break;
        case 'post':
          $post_meta = get_post_meta($pprwph_id, $pprwph_input['id'], true);

          if (is_array($post_meta) && array_key_exists($pprwph_array_index, $post_meta) && !empty($post_meta[$pprwph_array_index])) {
            $pprwph_value = $post_meta[$pprwph_array_index];
          }else{
            if (array_key_exists('value', $pprwph_input)) {
              $pprwph_value = $pprwph_input['value'];
            }else{
              $pprwph_value = '';
            }
          }
          break;
        case 'option':
          $option = get_option($pprwph_input['id']);

          if (is_array($option) && array_key_exists($pprwph_array_index, $option) && !empty($option[$pprwph_array_index])) {
            $pprwph_value = $option[$pprwph_array_index];
          }else{
            if (array_key_exists('value', $pprwph_input)) {
              $pprwph_value = $pprwph_input['value'];
            }else{
              $pprwph_value = '';
            }
          }
          break;
      }
    }else{
      switch ($pprwph_type) {
        case 'user':
          $user_meta = get_user_meta($pprwph_id, $pprwph_input['id'], true);

          if ($user_meta != '') {
            $pprwph_value = $user_meta;
          }else{
            if (array_key_exists('value', $pprwph_input)) {
              $pprwph_value = $pprwph_input['value'];
            }else{
              $pprwph_value = '';
            }
          }
          break;
        case 'post':
          $post_meta = get_post_meta($pprwph_id, $pprwph_input['id'], true);

          if ($post_meta != '') {
            $pprwph_value = $post_meta;
          }else{
            if (array_key_exists('value', $pprwph_input)) {
              $pprwph_value = $pprwph_input['value'];
            }else{
              $pprwph_value = '';
            }
          }
          break;
        case 'option':
          $option = get_option($pprwph_input['id']);

          if ($option != '') {
            $pprwph_value = $option;
          }else{
            if (array_key_exists('value', $pprwph_input)) {
              $pprwph_value = $pprwph_input['value'];
            }else{
              $pprwph_value = '';
            }
          }
          break;
      }
    }

    $pprwph_parent_block = (!empty($pprwph_input['parent']) ? 'data-pprwph-parent="' . $pprwph_input['parent'] . '"' : '') . ' ' . (!empty($pprwph_input['parent_option']) ? 'data-pprwph-parent-option="' . $pprwph_input['parent_option'] . '"' : '');

    switch ($pprwph_input['input']) {
      case 'input':
        switch ($pprwph_input['type']) {
          case 'file':
            ?>
              <?php if (empty($pprwph_value)): ?>
                <p class="pprwph-m-10"><?php esc_html_e('No file found', 'wph'); ?></p>
              <?php else: ?>
                <p class="pprwph-m-10">
                  <a href="<?php echo esc_url(get_post_meta($pprwph_id, $pprwph_input['id'], true)['url']); ?>" target="_blank"><?php echo esc_html(basename(get_post_meta($pprwph_id, $pprwph_input['id'], true)['url'])); ?></a>
                </p>
              <?php endif ?>
            <?php
            break;
          case 'checkbox':
            ?>
              <label class="pprwph-switch">
                <input id="<?php echo esc_attr($pprwph_input['id']); ?>" name="<?php echo esc_attr($pprwph_input['id']); ?>" class="<?php echo array_key_exists('class', $pprwph_input) ? esc_attr($pprwph_input['class']) : ''; ?> pprwph-checkbox pprwph-checkbox-switch pprwph-field" type="<?php echo esc_attr($pprwph_input['type']); ?>" <?php echo $pprwph_value == 'on' ? 'checked="checked"' : ''; ?> <?php echo (((array_key_exists('disabled', $pprwph_input) && $pprwph_input['disabled'] == 'true') || $pprwph_disabled_fields) ? 'disabled' : ''); ?> <?php echo ((array_key_exists('required', $pprwph_input) && $pprwph_input['required'] == 'true') ? 'required' : ''); ?> <?php echo wp_kses_post($pprwph_parent_block); ?>>
                <span class="pprwph-slider pprwph-round"></span>
              </label>
            <?php
            break;
          case 'range':
            ?>
              <div class="pprwph-input-range-wrapper">
                <div class="pprwph-width-100-percent">
                  <?php if (!empty($pprwph_input['pprwph_label_min'])): ?>
                    <p class="pprwph-input-range-label-min"><?php echo esc_html($pprwph_input['pprwph_label_min']); ?></p>
                  <?php endif ?>

                  <?php if (!empty($pprwph_input['pprwph_label_max'])): ?>
                    <p class="pprwph-input-range-label-max"><?php echo esc_html($pprwph_input['pprwph_label_max']); ?></p>
                  <?php endif ?>
                </div>

                <input type="<?php echo esc_attr($pprwph_input['type']); ?>" id="<?php echo esc_attr($pprwph_input['id']) . ((array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? '[]' : ''); ?>" name="<?php echo esc_attr($pprwph_input['id']); ?>" class="pprwph-input-range <?php echo array_key_exists('class', $pprwph_input) ? esc_attr($pprwph_input['class']) : ''; ?>" <?php echo ((array_key_exists('required', $pprwph_input) && $pprwph_input['required'] == 'true') ? 'required' : ''); ?> <?php echo (((array_key_exists('disabled', $pprwph_input) && $pprwph_input['disabled'] == 'true') || $pprwph_disabled_fields) ? 'disabled' : ''); ?> <?php echo (isset($pprwph_input['pprwph_max']) ? 'max=' . esc_attr($pprwph_input['pprwph_max']) : ''); ?> <?php echo (isset($pprwph_input['pprwph_min']) ? 'min=' . esc_attr($pprwph_input['pprwph_min']) : ''); ?> <?php echo (((array_key_exists('step', $pprwph_input) && $pprwph_input['step'] != '')) ? 'step="' . esc_attr($pprwph_input['step']) . '"' : ''); ?> <?php echo (array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple'] ? 'multiple' : ''); ?> value="<?php echo (!empty($pprwph_input['button_text']) ? esc_html($pprwph_input['button_text']) : esc_html($pprwph_value)); ?>"/>
                <h3 class="pprwph-input-range-output"></h3>
              </div>
            <?php
            break;
          case 'stars':
            $pprwph_stars = !empty($pprwph_input['stars_number']) ? $pprwph_input['stars_number'] : 5;
            ?>
              <div class="pprwph-input-stars-wrapper">
                <div class="pprwph-width-100-percent">
                  <?php if (!empty($pprwph_input['pprwph_label_min'])): ?>
                    <p class="pprwph-input-stars-label-min"><?php echo esc_html($pprwph_input['pprwph_label_min']); ?></p>
                  <?php endif ?>

                  <?php if (!empty($pprwph_input['pprwph_label_max'])): ?>
                    <p class="pprwph-input-stars-label-max"><?php echo esc_html($pprwph_input['pprwph_label_max']); ?></p>
                  <?php endif ?>
                </div>

                <div class="pprwph-input-stars pprwph-text-align-center pprwph-pt-20">
                  <?php foreach (range(1, $pprwph_stars) as $index => $star): ?>
                    <i class="material-icons-outlined pprwph-input-star">star_outlined</i>
                  <?php endforeach ?>
                </div>

                <input type="number" <?php echo ((array_key_exists('required', $pprwph_input) && $pprwph_input['required'] == 'true') ? 'required' : ''); ?> <?php echo ((array_key_exists('disabled', $pprwph_input) && $pprwph_input['disabled'] == 'true') ? 'disabled' : ''); ?> id="<?php echo esc_attr($pprwph_input['id']) . ((array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? '[]' : ''); ?>" name="<?php echo esc_attr($pprwph_input['id']); ?>" class="pprwph-input-hidden-stars <?php echo array_key_exists('class', $pprwph_input) ? esc_attr($pprwph_input['class']) : ''; ?>" min="1" max="<?php echo esc_attr($pprwph_stars) ?>">
              </div>
            <?php
            break;
          case 'submit':
            ?>
              <div class="pprwph-text-align-right">
                <input type="submit" value="<?php echo esc_attr($pprwph_input['value']); ?>" name="<?php echo esc_attr($pprwph_input['id']); ?>" id="<?php echo esc_attr($pprwph_input['id']); ?>" class="pprwph-btn" data-pprwph-type="<?php echo esc_attr($pprwph_type); ?>" data-pprwph-subtype="<?php echo ((array_key_exists('subtype', $pprwph_input)) ? esc_attr($pprwph_input['subtype']) : ''); ?>" data-pprwph-user-id="<?php echo esc_attr($pprwph_id); ?>" data-pprwph-post-id="<?php echo esc_attr(get_the_ID()); ?>"/><img class="pprwph-waiting pprwph-display-none-soft" src="<?php echo esc_url(PPRWPH_URL . 'assets/media/ajax-loader.gif'); ?>" alt="<?php esc_html_e('Loading...', 'pprwph'); ?>">
              </div>
            <?php
            break;
          case 'hidden':
            ?>
              <input type="hidden" id="<?php echo esc_attr($pprwph_input['id']); ?>" name="<?php echo esc_attr($pprwph_input['id']); ?>" value="<?php echo esc_attr($pprwph_value); ?>">
            <?php
            break;
          case 'nonce':
            ?>
              <input type="hidden" id="<?php echo esc_attr($pprwph_input['id']); ?>" name="<?php echo esc_attr($pprwph_input['id']); ?>" value="<?php echo esc_attr(wp_create_nonce('pprwph-nonce')); ?>">
            <?php
            break;
          default:
            ?>
              <input id="<?php echo esc_attr($pprwph_input['id']) . ((array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? '[]' : ''); ?>" name="<?php echo esc_attr($pprwph_input['id']) . ((array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? '[]' : ''); ?>" <?php echo (array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple'] ? 'multiple' : ''); ?> class="pprwph-field <?php echo array_key_exists('class', $pprwph_input) ? esc_attr($pprwph_input['class']) : ''; ?>" type="<?php echo esc_attr($pprwph_input['type']); ?>" <?php echo ((array_key_exists('required', $pprwph_input) && $pprwph_input['required'] == 'true') ? 'required' : ''); ?> <?php echo (((array_key_exists('disabled', $pprwph_input) && $pprwph_input['disabled'] == 'true') || $pprwph_disabled_fields) ? 'disabled' : ''); ?> <?php echo (((array_key_exists('step', $pprwph_input) && $pprwph_input['step'] != '')) ? 'step="' . esc_attr($pprwph_input['step']) . '"' : ''); ?> <?php echo (isset($pprwph_input['max']) ? 'max=' . esc_attr($pprwph_input['max']) : ''); ?> <?php echo (isset($pprwph_input['min']) ? 'min=' . esc_attr($pprwph_input['min']) : ''); ?> value="<?php echo (!empty($pprwph_input['button_text']) ? esc_html($pprwph_input['button_text']) : esc_html($pprwph_value)); ?>" placeholder="<?php echo (array_key_exists('placeholder', $pprwph_input) ? esc_html($pprwph_input['placeholder']) : ''); ?>" <?php echo wp_kses_post($pprwph_parent_block); ?>/>
            <?php
            break;
        }
        break;
      case 'select':
        ?>
          <select <?php echo ((array_key_exists('required', $pprwph_input) && $pprwph_input['required'] == 'true') ? 'required' : ''); ?> <?php echo (((array_key_exists('disabled', $pprwph_input) && $pprwph_input['disabled'] == 'true') || $pprwph_disabled_fields) ? 'disabled' : ''); ?> <?php echo (array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple'] ? 'multiple' : ''); ?> id="<?php echo esc_attr($pprwph_input['id']) . ((array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? '[]' : ''); ?>" name="<?php echo esc_attr($pprwph_input['id']) . ((array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? '[]' : ''); ?>" class="pprwph-field <?php echo array_key_exists('class', $pprwph_input) ? esc_attr($pprwph_input['class']) : ''; ?>" placeholder="<?php echo (array_key_exists('placeholder', $pprwph_input) ? esc_attr($pprwph_input['placeholder']) : ''); ?>" data-placeholder="<?php echo (array_key_exists('placeholder', $pprwph_input) ? esc_attr($pprwph_input['placeholder']) : ''); ?>" <?php echo wp_kses_post($pprwph_parent_block); ?>>

            <?php if (array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']): ?>
              <?php 
                switch ($pprwph_type) {
                  case 'user':
                    $pprwph_selected_values = !empty(get_user_meta($pprwph_id, $pprwph_input['id'], true)) ? get_user_meta($pprwph_id, $pprwph_input['id'], true) : [];
                    break;
                  case 'post':
                    $pprwph_selected_values = !empty(get_post_meta($pprwph_id, $pprwph_input['id'], true)) ? get_post_meta($pprwph_id, $pprwph_input['id'], true) : [];
                    break;
                  case 'option':
                    $pprwph_selected_values = !empty(get_option($pprwph_input['id'])) ? get_option($pprwph_input['id']) : [];
                    break;
                }
              ?>
              
              <?php foreach ($pprwph_input['options'] as $pprwph_input_option_key => $pprwph_input_option_value): ?>
                <option value="<?php echo esc_attr($pprwph_input_option_key); ?>" <?php echo ((array_key_exists('all_selected', $pprwph_input) && $pprwph_input['all_selected'] == 'true') || (is_array($pprwph_selected_values) && in_array($pprwph_input_option_key, $pprwph_selected_values)) ? 'selected' : ''); ?>><?php echo esc_html($pprwph_input_option_value) ?></option>
              <?php endforeach ?>
            <?php else: ?>
              <option value="" <?php echo $pprwph_value == '' ? 'selected' : '';?>><?php esc_html_e('Select an option', 'wph'); ?></option>
              
              <?php foreach ($pprwph_input['options'] as $pprwph_input_option_key => $pprwph_input_option_value): ?>
                <option value="<?php echo esc_attr($pprwph_input_option_key); ?>" <?php echo ((array_key_exists('all_selected', $pprwph_input) && $pprwph_input['all_selected'] == 'true') || ($pprwph_value != '' && $pprwph_input_option_key == $pprwph_value) ? 'selected' : ''); ?>><?php echo esc_html($pprwph_input_option_value); ?></option>
              <?php endforeach ?>
            <?php endif ?>
          </select>
        <?php
        break;
      case 'textarea':
        ?>
          <textarea id="<?php echo esc_attr($pprwph_input['id']) . ((array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? '[]' : ''); ?>" name="<?php echo esc_attr($pprwph_input['id']) . ((array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? '[]' : ''); ?>" <?php echo wp_kses_post($pprwph_parent_block); ?> class="pprwph-field <?php echo array_key_exists('class', $pprwph_input) ? esc_attr($pprwph_input['class']) : ''; ?>" <?php echo ((array_key_exists('required', $pprwph_input) && $pprwph_input['required'] == 'true') ? 'required' : ''); ?> <?php echo (((array_key_exists('disabled', $pprwph_input) && $pprwph_input['disabled'] == 'true') || $pprwph_disabled_fields) ? 'disabled' : ''); ?> <?php echo (array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple'] ? 'multiple' : ''); ?> placeholder="<?php echo (array_key_exists('placeholder', $pprwph_input) ? esc_attr($pprwph_input['placeholder']) : ''); ?>"><?php echo esc_html($pprwph_value); ?></textarea>
        <?php
        break;
      case 'image':
        ?>
          <div class="pprwph-field pprwph-images-block" <?php echo wp_kses_post($pprwph_parent_block); ?> data-pprwph-multiple="<?php echo (array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? 'true' : 'false'; ?>">
            <?php if (!empty($pprwph_value)): ?>
              <div class="pprwph-images">
                <?php foreach (explode(',', $pprwph_value) as $pprwph_image): ?>
                  <?php echo wp_get_attachment_image($pprwph_image, 'medium'); ?>
                <?php endforeach ?>
              </div>

              <div class="pprwph-text-align-center pprwph-position-relative"><a href="#" class="pprwph-btn pprwph-btn-mini pprwph-image-btn"><?php echo (array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? esc_html(__('Edit images', 'wph')) : esc_html(__('Edit image', 'wph')); ?></a></div>
            <?php else: ?>
              <div class="pprwph-images"></div>

              <div class="pprwph-text-align-center pprwph-position-relative"><a href="#" class="pprwph-btn pprwph-btn-mini pprwph-image-btn"><?php echo (array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? esc_html(__('Add images', 'wph')) : esc_html(__('Add image', 'wph')); ?></a></div>
            <?php endif ?>

            <input name="<?php echo esc_attr($pprwph_input['id']); ?>" id="<?php echo esc_attr($pprwph_input['id']); ?>" class="pprwph-display-none pprwph-image-input" type="text" value="<?php echo esc_attr($pprwph_value); ?>"/>
          </div>
        <?php
        break;
      case 'video':
        ?>
        <div class="pprwph-field pprwph-videos-block" <?php echo wp_kses_post($pprwph_parent_block); ?>>
            <?php if (!empty($pprwph_value)): ?>
              <div class="pprwph-videos">
                <?php foreach (explode(',', $pprwph_value) as $pprwph_video): ?>
                  <div class="pprwph-video pprwph-tooltip" title="<?php echo esc_html(get_the_title($pprwph_video)); ?>"><i class="dashicons dashicons-media-video"></i></div>
                <?php endforeach ?>
              </div>

              <div class="pprwph-text-align-center pprwph-position-relative"><a href="#" class="pprwph-btn pprwph-video-btn"><?php echo (array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? esc_html(__('Edit videos', 'wph')) : esc_html(__('Edit video', 'wph')); ?></a></div>
            <?php else: ?>
              <div class="pprwph-videos"></div>

              <div class="pprwph-text-align-center pprwph-position-relative"><a href="#" class="pprwph-btn pprwph-video-btn"><?php echo (array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? esc_html(__('Add videos', 'wph')) : esc_html(__('Add video', 'wph')); ?></a></div>
            <?php endif ?>

            <input name="<?php echo esc_attr($pprwph_input['id']); ?>" id="<?php echo esc_attr($pprwph_input['id']); ?>" class="pprwph-display-none pprwph-video-input" type="text" value="<?php echo esc_attr($pprwph_value); ?>"/>
          </div>
        <?php
        break;
      case 'audio':
        ?>
          <div class="pprwph-field pprwph-audios-block" <?php echo wp_kses_post($pprwph_parent_block); ?>>
            <?php if (!empty($pprwph_value)): ?>
              <div class="pprwph-audios">
                <?php foreach (explode(',', $pprwph_value) as $pprwph_audio): ?>
                  <div class="pprwph-audio pprwph-tooltip" title="<?php echo esc_html(get_the_title($pprwph_audio)); ?>"><i class="dashicons dashicons-media-audio"></i></div>
                <?php endforeach ?>
              </div>

              <div class="pprwph-text-align-center pprwph-position-relative"><a href="#" class="pprwph-btn pprwph-btn-mini pprwph-audio-btn"><?php echo (array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? esc_html(__('Edit audios', 'wph')) : esc_html(__('Edit audio', 'wph')); ?></a></div>
            <?php else: ?>
              <div class="pprwph-audios"></div>

              <div class="pprwph-text-align-center pprwph-position-relative"><a href="#" class="pprwph-btn pprwph-btn-mini pprwph-audio-btn"><?php echo (array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? esc_html(__('Add audios', 'wph')) : esc_html(__('Add audio', 'wph')); ?></a></div>
            <?php endif ?>

            <input name="<?php echo esc_attr($pprwph_input['id']); ?>" id="<?php echo esc_attr($pprwph_input['id']); ?>" class="pprwph-display-none pprwph-audio-input" type="text" value="<?php echo esc_attr($pprwph_value); ?>"/>
          </div>
        <?php
        break;
      case 'file':
        ?>
          <div class="pprwph-field pprwph-files-block" <?php echo wp_kses_post($pprwph_parent_block); ?>>
            <?php if (!empty($pprwph_value)): ?>
              <div class="pprwph-files pprwph-text-align-center">
                <?php foreach (explode(',', $pprwph_value) as $pprwph_file): ?>
                  <embed src="<?php echo esc_url(wp_get_attachment_url($pprwph_file)); ?>" type="application/pdf" class="pprwph-embed-file"/>
                <?php endforeach ?>
              </div>

              <div class="pprwph-text-align-center pprwph-position-relative"><a href="#" class="pprwph-btn pprwph-btn-mini pprwph-file-btn"><?php echo (array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? esc_html(__('Edit files', 'wph')) : esc_html(__('Edit file', 'wph')); ?></a></div>
            <?php else: ?>
              <div class="pprwph-files"></div>

              <div class="pprwph-text-align-center pprwph-position-relative"><a href="#" class="pprwph-btn pprwph-btn-mini pprwph-btn-mini pprwph-file-btn"><?php echo (array_key_exists('multiple', $pprwph_input) && $pprwph_input['multiple']) ? esc_html(__('Add files', 'wph')) : esc_html(__('Add file', 'wph')); ?></a></div>
            <?php endif ?>

            <input name="<?php echo esc_attr($pprwph_input['id']); ?>" id="<?php echo esc_attr($pprwph_input['id']); ?>" class="pprwph-display-none pprwph-file-input pprwph-btn-mini" type="text" value="<?php echo esc_attr($pprwph_value); ?>"/>
          </div>
        <?php
        break;
      case 'editor':
        ?>
          <div class="pprwph-field" <?php echo wp_kses_post($pprwph_parent_block); ?>>
            <textarea id="<?php echo esc_attr($pprwph_input['id']); ?>" name="<?php echo esc_attr($pprwph_input['id']); ?>" class="pprwph-input pprwph-width-100-percent pprwph-wysiwyg"><?php echo ((empty($pprwph_value)) ? (array_key_exists('placeholder', $pprwph_input) ? esc_attr($pprwph_input['placeholder']) : '') : esc_html($pprwph_value)); ?></textarea>
          </div>
        <?php
        break;
      case 'html':
        ?>
          <div class="pprwph-field" <?php echo wp_kses_post($pprwph_parent_block); ?>>
            <?php echo !empty($pprwph_input['html_content']) ? wp_kses_post(html_entity_decode(do_shortcode($pprwph_input['html_content']))) : ''; ?>
          </div>
        <?php
        break;
      case 'html_multi':
        switch ($pprwph_type) {
          case 'user':
            $html_multi_fields_length = !empty(get_user_meta($pprwph_id, $pprwph_input['html_multi_fields'][0]['id'], true)) ? count(get_user_meta($pprwph_id, $pprwph_input['html_multi_fields'][0]['id'], true)) : 0;
            break;
          case 'post':
            $html_multi_fields_length = !empty(get_post_meta($pprwph_id, $pprwph_input['html_multi_fields'][0]['id'], true)) ? count(get_post_meta($pprwph_id, $pprwph_input['html_multi_fields'][0]['id'], true)) : 0;
            break;
          case 'option':
            $html_multi_fields_length = !empty(get_option($pprwph_input['html_multi_fields'][0]['id'])) ? count(get_option($pprwph_input['html_multi_fields'][0]['id'])) : 0;
        }

        ?>
          <div class="pprwph-html-multi-wrapper pprwph-mb-50" <?php echo wp_kses_post($pprwph_parent_block); ?>>
            <?php if ($html_multi_fields_length): ?>
              <?php foreach (range(0, ($html_multi_fields_length - 1)) as $length_index): ?>
                <div class="pprwph-html-multi-group pprwph-display-table pprwph-width-100-percent pprwph-mb-30">
                  <div class="pprwph-display-inline-table pprwph-width-90-percent">
                    <?php foreach ($pprwph_input['html_multi_fields'] as $index => $html_multi_field): ?>
                      <?php self::input_builder($html_multi_field, $pprwph_type, $pprwph_id, false, true, $length_index); ?>
                    <?php endforeach ?>
                  </div>
                  <div class="pprwph-display-inline-table pprwph-width-10-percent pprwph-text-align-center">
                    <i class="material-icons-outlined pprwph-cursor-move pprwph-multi-sorting pprwph-vertical-align-super pprwph-tooltip" title="<?php esc_html_e('Order element', 'pprwph'); ?>">drag_handle</i>
                  </div>

                  <div class="pprwph-text-align-right">
                    <a href="#" class="pprwph-html-multi-remove-btn"><i class="material-icons-outlined pprwph-cursor-pointer pprwph-tooltip" title="<?php esc_html_e('Remove element', 'wph'); ?>">remove</i></a>
                  </div>
                </div>
              <?php endforeach ?>
            <?php else: ?>
              <div class="pprwph-html-multi-group pprwph-mb-50">
                <div class="pprwph-display-inline-table pprwph-width-90-percent">
                  <?php foreach ($pprwph_input['html_multi_fields'] as $html_multi_field): ?>
                    <?php self::input_builder($html_multi_field, $pprwph_type); ?>
                  <?php endforeach ?>
                </div>
                <div class="pprwph-display-inline-table pprwph-width-10-percent pprwph-text-align-center">
                  <i class="material-icons-outlined pprwph-cursor-move pprwph-multi-sorting pprwph-vertical-align-super pprwph-tooltip" title="<?php esc_html_e('Order element', 'pprwph'); ?>">drag_handle</i>
                </div>

                <div class="pprwph-text-align-right">
                  <a href="#" class="pprwph-html-multi-remove-btn pprwph-tooltip" title="<?php esc_html_e('Remove element', 'wph'); ?>"><i class="material-icons-outlined pprwph-cursor-pointer">remove</i></a>
                </div>
              </div>
            <?php endif ?>

            <div class="pprwph-text-align-right">
              <a href="#" class="pprwph-html-multi-add-btn pprwph-tooltip" title="<?php esc_html_e('Add element', 'wph'); ?>"><i class="material-icons-outlined pprwph-cursor-pointer pprwph-font-size-40">add</i></a>
            </div>
          </div>
        <?php
        break;
    }
  }

  public static function input_wrapper_builder($input_array, $type, $pprwph_id = 0, $pprwph_format = 'half'){
    ?>
      <?php if (array_key_exists('section', $input_array) && !empty($input_array['section'])): ?>      
        <?php if ($input_array['section'] == 'start'): ?>
          <div class="pprwph-toggle-wrapper pprwph-position-relative pprwph-mb-30">
            <?php if (array_key_exists('description', $input_array) && !empty($input_array['description'])): ?>
              <i class="material-icons-outlined pprwph-section-helper pprwph-color-main-0 pprwph-tooltip" title="<?php echo esc_attr($input_array['description']); ?>">help</i>
            <?php endif ?>

            <a href="#" class="pprwph-toggle pprwph-width-100-percent pprwph-text-decoration-none">
              <div class="pprwph-display-table pprwph-width-100-percent">
                <div class="pprwph-display-inline-table pprwph-width-90-percent">
                  <label class="pprwph-cursor-pointer pprwph-toggle pprwph-mb-20"><?php echo esc_html($input_array['label']); ?></label>
                </div>
                <div class="pprwph-display-inline-table pprwph-width-10-percent pprwph-text-align-right">
                  <i class="material-icons-outlined pprwph-cursor-pointer pprwph-color-main-0">add</i>
                </div>
              </div>
            </a>

            <div class="pprwph-content pprwph-pl-10 pprwph-toggle-content pprwph-mb-20 pprwph-display-none-soft">
        <?php elseif ($input_array['section'] == 'end'): ?>
            </div>
          </div>
        <?php endif ?>
      <?php else: ?>
        <div class="pprwph-input-wrapper <?php echo esc_attr($input_array['id']); ?> <?php echo !empty($input_array['tabs']) ? 'pprwph-input-tabbed' : ''; ?> pprwph-input-field-<?php echo esc_attr($input_array['input']); ?> <?php echo (!empty($input_array['required']) && $input_array['required'] == 'true') ? 'pprwph-input-field-required' : ''; ?>">
          <?php if (array_key_exists('label', $input_array) && !empty($input_array['label'])): ?>
            <div class="pprwph-display-inline-table <?php echo (($pprwph_format == 'half' && !(array_key_exists('type', $input_array) && $input_array['type'] == 'submit')) ? 'pprwph-width-40-percent' : 'pprwph-width-100-percent'); ?> pprwph-tablet-display-block pprwph-tablet-width-100-percent pprwph-vertical-align-top">
              <div class="pprwph-p-10 <?php echo (array_key_exists('parent', $input_array) && !empty($input_array['parent']) && $input_array['parent'] != 'this') ? 'pprwph-pl-30' : ''; ?>">
                <label class="pprwph-font-size-16 pprwph-vertical-align-middle pprwph-display-block <?php echo (array_key_exists('description', $input_array) && !empty($input_array['description'])) ? 'pprwph-toggle' : ''; ?>" for="<?php echo esc_attr($input_array['id']); ?>"><?php echo esc_attr($input_array['label']); ?> <?php echo (array_key_exists('required', $input_array) && !empty($input_array['required']) && $input_array['required'] == 'true') ? '<span class="pprwph-tooltip" title="' . esc_html(__('Required field', 'wph')) . '">*</span>' : ''; ?><?php echo (array_key_exists('description', $input_array) && !empty($input_array['description'])) ? '<i class="material-icons-outlined pprwph-cursor-pointer pprwph-float-right">add</i>' : ''; ?></label>

                <?php if (array_key_exists('description', $input_array) && !empty($input_array['description'])): ?>
                  <div class="pprwph-toggle-content pprwph-display-none-soft">
                    <small><?php echo wp_kses_post(wp_specialchars_decode($input_array['description'])); ?></small>
                  </div>
                <?php endif ?>
              </div>
            </div>
          <?php endif ?>

          <div class="pprwph-display-inline-table <?php echo ((array_key_exists('label', $input_array) && empty($input_array['label'])) ? 'pprwph-width-100-percent' : (($pprwph_format == 'half' && !(array_key_exists('type', $input_array) && $input_array['type'] == 'submit')) ? 'pprwph-width-60-percent' : 'pprwph-width-100-percent')); ?> pprwph-tablet-display-block pprwph-tablet-width-100-percent pprwph-vertical-align-top">
            <div class="pprwph-p-10 <?php echo (array_key_exists('parent', $input_array) && !empty($input_array['parent']) && $input_array['parent'] != 'this') ? 'pprwph-pl-30' : ''; ?>">
              <div class="pprwph-input-field"><?php self::input_builder($input_array, $type, $pprwph_id); ?></div>
            </div>
          </div>
        </div>
      <?php endif ?>
    <?php
  }

  public static function sanitizer($value, $node = '', $type = '') {
    switch (strtolower($node)) {
      case 'input':
        switch (strtolower($type)) {
          case 'text':
            return sanitize_text_field($value);
          case 'email':
            return sanitize_email($value);
          case 'url':
            return sanitize_url($value);
          case 'color':
            return sanitize_hex_color($value);
          default:
            return sanitize_text_field($value);
        }
      case 'select':
        switch ($type) {
          case 'select-multiple':
            foreach ($value as $key => $values) {
              $value[$key] = sanitize_key($values);
            }

            return $value;
          default:
            return sanitize_key($value);
        }
      case 'textarea':
        return wp_kses_post($value);
      case 'editor':
        return wp_kses_post($value);
      default:
        return sanitize_text_field($value);
    }
  }

  public function pprwph_form_save($element_id, $key_value, $pprwph_form_type, $pprwph_form_subtype) {
    switch ($pprwph_form_subtype) {
      case 'section_creation':
        $plugin_white = new PPRWPH_Post_Type_Whitepaper_Section();

        if (get_post_meta($element_id, 'pprwph_section_parent_check', true) == 'on' && !empty(get_post_meta($element_id, 'pprwph_section_parent', true))) {
          wp_update_post(['ID' => $element_id, 'post_parent' => get_post_meta($element_id, 'pprwph_section_parent', true),]);
        }else{
          wp_update_post(['ID' => $element_id, 'post_parent' => 0,]);
        }

        if (get_post_meta($element_id, 'pprwph_section_publish', true) == 'on') {
          wp_update_post(['ID' => $element_id, 'post_status' => 'publish',]);
        }else{
          wp_update_post(['ID' => $element_id, 'post_status' => 'draft',]);
        }

        $pprwph_sections = get_posts(['fields' => 'ids', 'numberposts' => -1, 'post_type' => 'pprwph_white', 'post_status' => 'any', 'orderby' => 'menu_order', 'order' => 'ASC', 'post_parent' => 0, ]);
        echo wp_json_encode(['error_key' => '', 'response' => 'section_creation_success', 'html' => $plugin_white->pprwph_get_navigation_list($pprwph_sections), ]);exit();
        break;
      default:
        switch ($pprwph_form_type) {
          case 'user':
            break;
          case 'post':
            break;
          case 'option':
            break;
          default:
            break;
        }
        break;
    }
  }
}