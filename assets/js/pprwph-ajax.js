(function($) {
	'use strict';

  $(document).ready(function() {
    $(document).on('submit', '.pprwph-form', function(e){
      var pprwph_form = $(this);
      var pprwph_btn = pprwph_form.find('input[type="submit"]');
      pprwph_btn.addClass('pprwph-link-disabled').siblings('.pprwph-waiting').fadeIn('slow');

      var ajax_url = pprwph_ajax.ajax_url;
      var data = {
        action: 'pprwph_ajax_nopriv',
        ajax_nonce: pprwph_ajax.ajax_nonce,
        pprwph_ajax_nopriv_type: 'pprwph_form_save',
        pprwph_form_id: pprwph_form.attr('id'),
        pprwph_form_type: pprwph_btn.attr('data-pprwph-type'),
        pprwph_form_subtype: pprwph_btn.attr('data-pprwph-subtype'),
        pprwph_form_user_id: pprwph_btn.attr('data-pprwph-user-id'),
        pprwph_form_post_id: pprwph_btn.attr('data-pprwph-post-id'),
        ajax_keys: [],
      };

      if (!(typeof window['pprwph_window_vars'] !== 'undefined')) {
        window['pprwph_window_vars'] = [];
      }

      $(pprwph_form.find('input:not([type="submit"]), select, textarea')).each(function(index, element) {
        if ($(this).attr('multiple') && $(this).parents('.pprwph-html-multi-group').length) {
          if (!(typeof window['pprwph_window_vars']['form_field_' + element.id] !== 'undefined')) {
            window['pprwph_window_vars']['form_field_' + element.id] = [];
          }

          window['pprwph_window_vars']['form_field_' + element.id].push($(element).val());

          data[element.id] = window['pprwph_window_vars']['form_field_' + element.id];
        }else{
          if ($(this).is(':checkbox') || $(this).is(':radio')) {
            if ($(this).is(':checked')) {
              data[element.id] = $(element).val();
            }else{
              data[element.id] = '';
            }
          }else{
            data[element.id] = $(element).val();
          }
        }

        data.ajax_keys.push({
          id: element.id,
          node: element.nodeName,
          type: element.type,
        });
      });

      $.post(ajax_url, data, function(response) {
        console.log('data');console.log(data);console.log('response');console.log(response);
        if ($.parseJSON(response)['error_key'] == 'pprwph_form_save_error_unlogged') {
          if (!$('.users-wph-profile-wrapper .user-unlogged').length) {
            $('.users-wph-profile-wrapper').prepend('<div class="users-wph-alert users-wph-alert-warning user-unlogged">' + pprwph_i18n.user_unlogged + '</div>');
          }

          $.fancybox.open($('#users-wph-profile-popup'), {touch: false});
          $('#users-wph-login input#user_login').focus();
          pprwph_get_main_message(pprwph_i18n.user_unlogged);
        } else if ($.parseJSON(response)['error_key'] == 'pprwph_form_save_error') {
          pprwph_get_main_message(pprwph_i18n.an_error_has_occurred);
        } else if ($.parseJSON(response)['response'] == 'section_creation_success') {
          $.fancybox.close();
          $('.pprwph-navigation-list').html($.parseJSON(response)['html']);
          pprwph_get_main_message(pprwph_i18n.saved_successfully);
        } else {
          pprwph_get_main_message(pprwph_i18n.saved_successfully);
        }

        pprwph_btn.removeClass('pprwph-link-disabled').siblings('.pprwph-waiting').fadeOut('slow');
      });

      delete window['pprwph_window_vars'];
      return false;
    });

    $(document).on('click', '.pprwph-popup-add-btn', function(e) {
      e.preventDefault();

      var pprwph_element = $(this);
      var section_id = (pprwph_element.hasClass('pprwph-section-new')) ? 0 : pprwph_element.closest('.pprwph-navigation-element').attr('data-pprwph-section-id');

      $.fancybox.open($('#pprwph-popup-section-add'), {
        touch: false,
        beforeShow: function(instance, current, e) {
          var ajaxurl = pprwph_ajax.ajax_url;
          var data = {
            action: 'pprwph_ajax',
            pprwph_ajax_type: 'pprwph_popup_section_add',
            section_id: section_id,
          };

          $.post(ajaxurl, data, function(response) {
            console.log('data');console.log(data);console.log('response');console.log(response);
            if (response.indexOf('pprwph_popup_section_add_error') != -1) {
              pprwph_get_main_message(pprwph_i18n.an_error_has_occurred);
            }else{
              $.getScript(pprwph_path.js + 'pprwph-forms.js');
              $.getScript(pprwph_path.js + 'pprwph-aux.js');
              
              $('#pprwph-popup-section-add .pprwph-popup-content').html(response);
            }
          });
        },
        afterClose: function(instance, current, e) {
          $('#pprwph-popup-section-add .pprwph-popup-content').html('<div class="pprwph-text-align-center"><div class="pprwph-loader-circle"><div></div><div></div><div></div><div></div></div></div>');
        },
      },);
    });

    $(document).on('click', '.pprwph-section-add-btn', function(e) {
      e.preventDefault();

      var pprwph_btn = $(this);
      pprwph_btn.addClass('pprwph-link-disabled');
      pprwph_btn.siblings('.pprwph-waiting').fadeIn('slow');

      var ajaxurl = pprwph_ajax.ajax_url;
      var data = {
        action: 'pprwph_ajax',
        pprwph_ajax_type: 'pprwph_ajax_section_add',
        section_id: section_id,
      };

      $.post(ajaxurl, data, function(response) {
        console.log('data');console.log(data);console.log('response');console.log(response);
        if ($.parseJSON(response)['error_key'] != '') {
          pprwph_get_main_message(pprwph_i18n.an_error_has_occurred);
        }else {
          $.fancybox.close();
          $('.pprwph-navigation-list').html($.parseJSON(response)['html']);
          pprwph_get_main_message(pprwph_i18n.section_added);
        }
      });
    });

    $(document).on('click', '.pprwph-popup-remove-btn', function(e) {
      e.preventDefault();

      var pprwph_element = $(this);
      var section_id = pprwph_element.closest('.pprwph-navigation-element').attr('data-pprwph-section-id');

      $.fancybox.open($('#pprwph-popup-section-remove'), {
        touch: false,
        beforeShow: function(instance, current, e) {
          var ajaxurl = pprwph_ajax.ajax_url;
          var data = {
            action: 'pprwph_ajax',
            pprwph_ajax_type: 'pprwph_popup_section_remove',
            section_id: section_id,
          };

          $.post(ajaxurl, data, function(response) {
            console.log('data');console.log(data);console.log('response');console.log(response);
            if (response.indexOf('pprwph_popup_section_remove_error') != -1) {
              pprwph_get_main_message(pprwph_i18n.an_error_has_occurred);
            }else{
              $('#pprwph-popup-section-remove .pprwph-popup-content').html(response);
            }
          });
        },
        afterClose: function(instance, current, e) {
          $('#pprwph-popup-section-remove .pprwph-popup-content').html('<div class="pprwph-text-align-center"><div class="pprwph-loader-circle"><div></div><div></div><div></div><div></div></div></div>');
        },
      },);
    });

    $(document).on('click', '.pprwph-section-remove-btn', function(e) {
      e.preventDefault();

      var pprwph_btn = $(this);
      pprwph_btn.addClass('pprwph-link-disabled');
      pprwph_btn.siblings('.pprwph-waiting').fadeIn('slow');
      var section_id = $(this).closest('.pprwph-popup-section-remove').attr('data-pprwph-section-id');

      var ajaxurl = pprwph_ajax.ajax_url;
      var data = {
        action: 'pprwph_ajax',
        pprwph_ajax_type: 'pprwph_ajax_section_remove',
        section_id: section_id,
      };

      $.post(ajaxurl, data, function(response) {
        console.log('data');console.log(data);console.log('response');console.log(response);
        if ($.parseJSON(response)['error_key'] != '') {
          pprwph_get_main_message(pprwph_i18n.an_error_has_occurred);
        }else {
          $.fancybox.close();
          $('.pprwph-navigation-list').html($.parseJSON(response)['html']);
          pprwph_get_main_message(pprwph_i18n.section_removed);
        }
      });
    });
  });
})(jQuery);
