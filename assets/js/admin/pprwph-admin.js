(function($) {
	'use strict';

	$(document).on('click', '.wph-tab-links', function(e){
    e.preventDefault();
    var tab_link = $(this);
    var tab_wrapper = $(this).closest('.wph-tabs-wrapper');
    
    tab_wrapper.find('.wph-tab-links').each(function(index, element) {
      $(this).removeClass('active');
      $($(this).attr('data-wph-id')).addClass('wph-display-none');
    });

    tab_wrapper.find('.wph-tab-content').each(function(index, element) {
      $(this).addClass('wph-display-none');
    });
    
    tab_link.addClass('active');
    tab_wrapper.find('#' + tab_link.attr('data-wph-id')).removeClass('wph-display-none');
  });

  $(document).on('click', '.pprwph-options-save-btn', function(e){
    e.preventDefault();
    var pprwph_btn = $(this);
    pprwph_btn.addClass('pprwph-link-disabled').siblings('.pprwph-waiting').fadeIn('slow');

    var ajax_url = pprwph_ajax.ajax_url;

    var data = {
      action: 'pprwph_ajax',
      ajax_nonce: pprwph_ajax.ajax_nonce,
      pprwph_ajax_type: 'pprwph_options_save',
      ajax_keys: [],
    };

    if (!(typeof window['pprwph_window_vars'] !== 'undefined')) {
      window['pprwph_window_vars'] = [];
    }

    $('.pprwph-options-fields input:not([type="submit"]), .pprwph-options-fields select, .pprwph-options-fields textarea').each(function(index, element) {
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
      if ($.parseJSON(response)['error_key'] != '') {
        pprwph_get_main_message(pprwph_i18n.an_error_has_occurred);
      }else {
        pprwph_get_main_message(pprwph_i18n.saved_successfully);
      }

      pprwph_btn.removeClass('pprwph-link-disabled').siblings('.pprwph-waiting').fadeOut('slow');
    });

    delete window['pprwph_window_vars'];
  });
})(jQuery);