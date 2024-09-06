(function($) {
	'use strict';

  $(document).ready(function() {
    $(document).on('mouseover', '.pprwph-input-star', function(e){
      if (!$(this).closest('.pprwph-input-stars').hasClass('clicked')) {
        $(this).text('star');
        $(this).prevAll('.pprwph-input-star').text('star');
      }
    });

    $(document).on('mouseout', '.pprwph-input-stars', function(e){
      if (!$(this).hasClass('clicked')) {
        $(this).find('.pprwph-input-star').text('star_outlined');
      }
    });

    $(document).on('click', '.pprwph-input-star', function(e){
      e.preventDefault();
      $(this).closest('.pprwph-input-stars').addClass('clicked');
      $(this).closest('.pprwph-input-stars').find('.pprwph-input-star').text('star_outlined');
      $(this).text('star');
      $(this).prevAll('.pprwph-input-star').text('star');
      $(this).closest('.pprwph-input-stars').siblings('.pprwph-input-hidden-stars').val($(this).prevAll('.pprwph-input-star').length + 1);
    });

    $(document).on('change', '.pprwph-input-hidden-stars', function(e){
      $(this).siblings('.pprwph-input-stars').find('.pprwph-input-star').text('star_outlined');
      $(this).siblings('.pprwph-input-stars').find('.pprwph-input-star').slice(0, $(this).val()).text('star');
    });

    if ($('.pprwph-field[data-pprwph-parent]').length) {
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
    }

    if ($('.pprwph-html-multi-group').length) {
      $(document).on('click', '.pprwph-html-multi-remove-btn', function(e) {
        e.preventDefault();
        var pprwph_users_btn = $(this);

        if (pprwph_users_btn.closest('.pprwph-html-multi-wrapper').find('.pprwph-html-multi-group').length > 1) {
          $(this).closest('.pprwph-html-multi-group').remove();
        }else{
          $(this).closest('.pprwph-html-multi-group').find('input, select, textarea').val('');
        }
      });

      $(document).on('click', '.pprwph-html-multi-add-btn', function(e) {
        e.preventDefault();

        $(this).closest('.pprwph-html-multi-wrapper').find('.pprwph-html-multi-group:first').clone().insertAfter($(this).closest('.pprwph-html-multi-wrapper').find('.pprwph-html-multi-group:last'));
        $(this).closest('.pprwph-html-multi-wrapper').find('.pprwph-html-multi-group:last').find('input, select, textarea').val('');

        $(this).closest('.pprwph-html-multi-wrapper').find('.pprwph-input-range').each(function(index, element) {
          $(this).siblings('.pprwph-input-range-output').html($(this).val());
        });
      });

      $('.pprwph-html-multi-wrapper').sortable({handle: '.pprwph-multi-sorting'});
      $(document).on('sortstop', '.pprwph-html-multi-wrapper', function(event, ui){
        pprwph_get_main_message(pprwph_i18n.ordered_element);
      });
    }

    if ($('.pprwph-input-range').length) {
      $('.pprwph-input-range').each(function(index, element) {
        $(this).siblings('.pprwph-input-range-output').html($(this).val());
      });

      $(document).on('input', '.pprwph-input-range', function(e) {
        $(this).siblings('.pprwph-input-range-output').html($(this).val());
      });
    }

    if ($('.pprwph-image-btn').length) {
      var image_frame;

      $(document).on('click', '.pprwph-image-btn', function(e){
        e.preventDefault();

        if (image_frame){
          image_frame.open();
          return;
        }

        var pprwph_input_btn = $(this);
        var pprwph_images_block = pprwph_input_btn.closest('.pprwph-images-block').find('.pprwph-images');
        var pprwph_images_input = pprwph_input_btn.closest('.pprwph-images-block').find('.pprwph-image-input');

        var image_frame = wp.media({
          title: (pprwph_images_block.attr('data-pprwph-multiple') == 'true') ? pprwph_i18n.select_images : pprwph_i18n.select_image,
          library: {
            type: 'image'
          },
          multiple: (pprwph_images_block.attr('data-pprwph-multiple') == 'true') ? 'true' : 'false',
        });

        image_frame.states.add([
          new wp.media.controller.Library({
            id: 'post-gallery',
            title: (pprwph_images_block.attr('data-pprwph-multiple') == 'true') ? pprwph_i18n.edit_images : pprwph_i18n.edit_image,
            priority: 20,
            toolbar: 'main-gallery',
            filterable: 'uploaded',
            library: wp.media.query(image_frame.options.library),
            multiple: (pprwph_images_block.attr('data-pprwph-multiple') == 'true') ? 'true' : 'false',
            editable: true,
            allowLocalEdits: true,
            displaySettings: true,
            displayUserSettings: true
          })
        ]);

        image_frame.open();

        image_frame.on('select', function() {
          var ids = '', attachments_arr = [];

          attachments_arr = image_frame.state().get('selection').toJSON();
          pprwph_images_block.html('');

          $(attachments_arr).each(function(e){
            sep = (e != (attachments_arr.length - 1))  ? ',' : '';
            ids += $(this)[0].id + sep;
            pprwph_images_block.append('<img src="' + $(this)[0].url + '" class="">');
          });

          pprwph_input_btn.text((pprwph_images_block.attr('data-pprwph-multiple') == 'true') ? pprwph_i18n.select_images : pprwph_i18n.select_image);
          pprwph_images_input.val(ids);
        });
      });
    }

    if ($('.pprwph-audio-btn').length) {
      var audio_frame;

      $(document).on('click', '.pprwph-audio-btn', function(e){
        e.preventDefault();

        if (audio_frame){
          audio_frame.open();
          return;
        }

        var pprwph_input_btn = $(this);
        var pprwph_audios_block = pprwph_input_btn.closest('.pprwph-audios-block').find('.pprwph-audios');
        var pprwph_audios_input = pprwph_input_btn.closest('.pprwph-audios-block').find('.pprwph-audio-input');

        var audio_frame = wp.media({
          title: (pprwph_audios_block.attr('data-pprwph-multiple') == 'true') ? pprwph_i18n.select_audios : pprwph_i18n.select_audio,
          library : {
            type : 'audio'
          },
          multiple: (pprwph_audios_block.attr('data-pprwph-multiple') == 'true') ? 'true' : 'false',
        });

        audio_frame.states.add([
          new wp.media.controller.Library({
            id: 'post-gallery',
            title: (pprwph_audios_block.attr('data-pprwph-multiple') == 'true') ? pprwph_i18n.select_audios : pprwph_i18n.select_audio,
            priority: 20,
            toolbar: 'main-gallery',
            filterable: 'uploaded',
            library: wp.media.query(audio_frame.options.library),
            multiple: (pprwph_audios_block.attr('data-pprwph-multiple') == 'true') ? 'true' : 'false',
            editable: true,
            allowLocalEdits: true,
            displaySettings: true,
            displayUserSettings: true
          })
        ]);

        audio_frame.open();

        audio_frame.on('select', function() {
          var ids = '', attachments_arr = [];

          attachments_arr = audio_frame.state().get('selection').toJSON();
          pprwph_audios_block.html('');

          $(attachments_arr).each(function(e){
            sep = (e != (attachments_arr.length - 1))  ? ',' : '';
            ids += $(this)[0].id + sep;
            pprwph_audios_block.append('<div class="pprwph-audio pprwph-tooltip" title="' + $(this)[0].title + '"><i class="dashicons dashicons-media-audio"></i></div>');
          });

          $('.pprwph-tooltip').tooltipster({maxWidth: 300,delayTouch:[0, 4000]});
          pprwph_input_btn.text((pprwph_audios_block.attr('data-pprwph-multiple') == 'true') ? pprwph_i18n.select_audios : pprwph_i18n.select_audio);
          pprwph_audios_input.val(ids);
        });
      });
    }

    if ($('.pprwph-video-btn').length) {
      var video_frame;

      $(document).on('click', '.pprwph-video-btn', function(e){
        e.preventDefault();

        if (video_frame){
          video_frame.open();
          return;
        }

        var pprwph_input_btn = $(this);
        var pprwph_videos_block = pprwph_input_btn.closest('.pprwph-videos-block').find('.pprwph-videos');
        var pprwph_videos_input = pprwph_input_btn.closest('.pprwph-videos-block').find('.pprwph-video-input');

        var video_frame = wp.media({
          title: (pprwph_videos_block.attr('data-pprwph-multiple') == 'true') ? pprwph_i18n.select_videos : pprwph_i18n.select_video,
          library : {
            type : 'video'
          },
          multiple: (pprwph_videos_block.attr('data-pprwph-multiple') == 'true') ? 'true' : 'false',
        });

        video_frame.states.add([
          new wp.media.controller.Library({
            id: 'post-gallery',
            title: (pprwph_videos_block.attr('data-pprwph-multiple') == 'true') ? pprwph_i18n.select_videos : pprwph_i18n.select_video,
            priority: 20,
            toolbar: 'main-gallery',
            filterable: 'uploaded',
            library: wp.media.query(video_frame.options.library),
            multiple: (pprwph_videos_block.attr('data-pprwph-multiple') == 'true') ? 'true' : 'false',
            editable: true,
            allowLocalEdits: true,
            displaySettings: true,
            displayUserSettings: true
          })
        ]);

        video_frame.open();

        video_frame.on('select', function() {
          var ids = '', attachments_arr = [];

          attachments_arr = video_frame.state().get('selection').toJSON();
          pprwph_videos_block.html('');

          $(attachments_arr).each(function(e){
            sep = (e != (attachments_arr.length - 1))  ? ',' : '';
            ids += $(this)[0].id + sep;
            pprwph_videos_block.append('<div class="pprwph-video pprwph-tooltip" title="' + $(this)[0].title + '"><i class="dashicons dashicons-media-video"></i></div>');
          });

          $('.pprwph-tooltip').tooltipster({maxWidth: 300,delayTouch:[0, 4000]});
          pprwph_input_btn.text((pprwph_videos_block.attr('data-pprwph-multiple') == 'true') ? pprwph_i18n.select_videos : pprwph_i18n.select_video);
          pprwph_videos_input.val(ids);
        });
      });
    }

    if ($('.pprwph-file-btn').length) {
      var file_frame;

      $(document).on('click', '.pprwph-file-btn', function(e){
        e.preventDefault();

        if (file_frame){
          file_frame.open();
          return;
        }

        var pprwph_input_btn = $(this);
        var pprwph_files_block = pprwph_input_btn.closest('.pprwph-files-block').find('.pprwph-files');
        var pprwph_files_input = pprwph_input_btn.closest('.pprwph-files-block').find('.pprwph-file-input');

        var file_frame = wp.media({
          title: (pprwph_files_block.attr('data-pprwph-multiple') == 'true') ? pprwph_i18n.select_files : pprwph_i18n.select_file,
          multiple: (pprwph_files_block.attr('data-pprwph-multiple') == 'true') ? 'true' : 'false',
        });

        file_frame.states.add([
          new wp.media.controller.Library({
            id: 'post-gallery',
            title: (pprwph_files_block.attr('data-pprwph-multiple') == 'true') ? pprwph_i18n.select_files : pprwph_i18n.select_file,
            priority: 20,
            toolbar: 'main-gallery',
            filterable: 'uploaded',
            library: wp.media.query(file_frame.options.library),
            multiple: (pprwph_files_block.attr('data-pprwph-multiple') == 'true') ? 'true' : 'false',
            editable: true,
            allowLocalEdits: true,
            displaySettings: true,
            displayUserSettings: true
          })
        ]);

        file_frame.open();

        file_frame.on('select', function() {
          var ids = '', attachments_arr = [];

          attachments_arr = file_frame.state().get('selection').toJSON();
          pprwph_files_block.html('');

          $(attachments_arr).each(function(e){
            sep = (e != (attachments_arr.length - 1))  ? ',' : '';
            ids += $(this)[0].id + sep;
            pprwph_files_block.append('<embed src="' + $(this)[0].url + '" type="application/pdf" class="pprwph-embed-file"/>');
          });

          pprwph_input_btn.text((pprwph_files_block.attr('data-pprwph-multiple') == 'true') ? pprwph_i18n.edit_files : pprwph_i18n.edit_file);
          pprwph_files_input.val(ids);
        });
      });
    }
  });
})(jQuery);
