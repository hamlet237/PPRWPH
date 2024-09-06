(function($) {
	'use strict';

  $(document).ready(function() {
    if($('.pprwph-tooltip').length) {
      $('.pprwph-tooltip').tooltipster({maxWidth: 300, delayTouch:[0, 4000]});
    }

    if ($('.pprwph-select').length) {
      $('.pprwph-select').each(function(index) {
        console.log($(this).children('option').length);
        if ($(this).children('option').length < 7) {
          $(this).select2({minimumResultsForSearch: -1, allowClear: true});
        }else{
          $(this).select2({allowClear: true});
        }
      });
    }

    $.trumbowyg.svgPath = pprwph_trumbowyg.path;
    $('.pprwph-wysiwyg').each(function(index, element) {
      $(this).trumbowyg();
    });

    $.fancybox.defaults.touch = false;
  });
})(jQuery);
