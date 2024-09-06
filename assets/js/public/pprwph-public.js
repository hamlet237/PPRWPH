(function($) {
	'use strict';

  window.pprwph_timer = function (step) {
		var step_timer = $('.pprwph-player-step[data-pprwph-step="' + step + '"] .pprwph-player-timer');
		var step_icon = $('.pprwph-player-step[data-pprwph-step="' + step + '"] .pprwph-player-timer-icon');
		
		if (!step_timer.hasClass('timing')) {
			step_timer.addClass('timing');

      setInterval(function() {
      	step_icon.fadeOut('fast').fadeIn('slow').fadeOut('fast').fadeIn('slow');
      }, 5000);

      setInterval(function() {
      	step_timer.text(Math.max(0, parseInt(step_timer.text()) - 1)).fadeOut('fast').fadeIn('slow').fadeOut('fast').fadeIn('slow');
      }, 60000);
		}
	}

  window.pprwph_navigation_in = function (){
    var side_percentage = ($(window).width() >= 768) ? '-40%' : '-100%';
    
    $('.pprwph-navigation-switch i').fadeOut('fast');
    $('.pprwph-navigation-switch i').text('keyboard_arrow_left');
    $('.pprwph-navigation-switch i').fadeIn('slow');

    $('#pprwph-body-overlay').fadeIn('fast');

    $('.pprwph-navigation-menu').addClass('active');
    $('.pprwph-navigation-menu').fadeIn('fast');

    $('.pprwph-navigation-menu').css('left', side_percentage);

    $('.pprwph-navigation-menu').animate({
      'left': '0%', 
    }, 500);
  }

  window.pprwph_navigation_out = function (){
    var side_percentage = ($(window).width() >= 768) ? '-40%' : '-100%';
    
    $('.pprwph-navigation-switch i').fadeOut('fast');
    $('.pprwph-navigation-switch i').text('keyboard_arrow_right');
    $('.pprwph-navigation-switch i').fadeIn('slow');

    $('#pprwph-body-overlay').fadeOut('fast');

    $('.pprwph-navigation-menu').removeClass('active');
    $('.pprwph-navigation-menu').css('left', '0%');
    $('.pprwph-navigation-menu').animate({
      'left': side_percentage, 
    }, 500);

    setTimeout(function() {$('.pprwph-navigation-menu').fadeOut('slow');}, 500);
  }

  $(document).ready(function() {
    $(document).on('click', '.pprwph-navigation-switch', function(e) {
      e.preventDefault();

      if ($('.pprwph-navigation-menu').hasClass('active')) {
        pprwph_navigation_out();
      }else{
        pprwph_navigation_in();
      }
    });

    $(document).on('click', '#pprwph-body-overlay', function(e) {
      e.preventDefault();

      pprwph_navigation_out();
    });

    $('.pprwph-navigation-list').sortable({handle: '.pprwph-white-drag'});
    $(document).on('sortstop', '.pprwph-navigation-list', function(event, ui){
      var item = $(this);
      var ajaxurl = pprwph_ajax.ajax_url;
      var data = {
        action: 'pprwph_ajax',
        pprwph_ajax_type: 'pprwph_ajax_section_order',
        order: [],
      };

      var pprwph_list = item.closest('.pprwph-navigation-list-wrapper');
      
      pprwph_list.find('.pprwph-navigation-element').each(function(index, element) {
        var pprwph_parent = $(this);
        var section_id = $(this).attr('data-pprwph-section-id');
        var parent_section_id = $(this).attr('data-pprwph-parent-section-id');

        data.order[index] = {
          section_id: section_id,
          parent_section_id: parent_section_id,
        };
      });

      $.post(ajaxurl, data, function(response) {
        console.log('data');console.log(data);console.log('response');console.log(response);
        if ($.parseJSON(response)['error_key'] != '') {
          pprwph_get_main_message(pprwph_i18n.an_error_has_occurred);
        }else {
          $('.pprwph-navigation-list').html($.parseJSON(response)['html']);
          pprwph_get_main_message(pprwph_i18n.order_updated);
        }
      });
    });

    window.pprwph_form_update = function () {
      $('.pprwph-field[data-pprwph-parent-option]').closest('.pprwph-input-wrapper').addClass('pprwph-display-none');

      $('.pprwph-field[data-pprwph-parent~="this"]').each(function(index_parent, element_parent) {
        var parent_this = $(this);

        $('.pprwph-field[data-pprwph-parent~=' + parent_this.attr('id') + ']').each(function(index, element) {
          if (parent_this.hasClass('pprwph-checkbox')) {
            if (parent_this.is(':checked') && $(this).attr('data-pprwph-parent-option') == 'on') {
              $(this).closest('.pprwph-input-wrapper').removeClass('pprwph-display-none');
            }
          }else{
            if (parent_this.val() == $(this).attr('data-pprwph-parent-option')) {
              $(this).closest('.pprwph-input-wrapper').removeClass('pprwph-display-none');
            }
          }
        });
      });
    }

    pprwph_form_update();

    $(document).on('change', '.pprwph-field[data-pprwph-parent~="this"]', function(e) {
      pprwph_form_update();
    });
  });
})(jQuery);
