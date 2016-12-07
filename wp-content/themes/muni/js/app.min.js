'use strict';

var j = jQuery.noConflict();

(function($){
  var $win = j(window);
  var $doc = j(document);
  var $animationElements = j('.animation-element');
  var body = j('body');
  // var $header = j('.header');
  // var $footer = j('.Footer');

  $win.on('scroll', function(){
    if(j(this).scrollTop() > 150) {
      j('.ArrowTop').fadeIn();
    } else {
      j('.ArrowTop').fadeOut();
    }
  });

  $win.on('resize', function(){
  });

  $doc.on('ready', function(){
    j('.js-move-scroll').on('click', function(event) {
      event.preventDefault();

      var $this = j(this);
      var dest = $this.attr('href');

      dest = (dest.charAt(0) === '#') ? dest : '#' + dest;

      j('html, body').stop().animate({
        scrollTop: j(dest).offset().top
      }, 2000, 'easeInOutExpo');
    });

    j('.ArrowTop').on('click', function(ev){
      ev.preventDefault();
      j('html, body').animate({scrollTop: 0}, 800);
    });

    j('#accordion-metas, div[id^="accordion-locals"]').on('show.bs.collapse', function(ev) {
      var panelCollapse = j(ev.target),
          panelHeading = panelCollapse.prev(),
          panelHeadings = panelCollapse.parent().parent().find('.panel-heading');

      panelHeadings.each(function(index, el) {
        j(this).removeClass('active');
      });
      panelHeading.addClass('active');
    });

    j('#accordion-metas, div[id^="accordion-locals"]').on('hide.bs.collapse', function(ev) {
      var panelCollapse = j(ev.target),
          panelHeading = panelCollapse.prev();

      if (panelCollapse.hasClass('in')) {
        panelHeading.removeClass('active');
      }
    });

    j('#js-display-search').on('click', function() {
      var $this = j(this),
          searchWrapper = j('.Header-search');

      searchWrapper.slideDown().find('.Search input[name="s"]').focus();
    });

    j('#js-close-search').on('click', function() {
      var $this = j(this),
          searchWrapper = j('.Header-search');

      searchWrapper.slideUp();
    });

    j('.js-toggle-slidebar').on('click', function(ev) {
      ev.preventDefault();
      var slidebar = j('.Slidebar');

      if (slidebar.hasClass('active')) {
        slidebar.removeClass('active');
      } else {
        slidebar.addClass('active');
      }
    });

    j('.Slidebar-list li').each(function(index, el) {
      var $this = j(this);

      if ($this.hasClass('js-more')) {
        $this.append('<i class="icons icon-more js-slidebar-nav-more"></i>');
      }
    });

    body.on('click', '.js-slidebar-nav-more', function(){
      var $this = j(this);

      if ($this.hasClass('active')) {
        $this.removeClass('icon-minus active').addClass('icon-more').prev().removeClass('active');
      } else {
        $this.removeClass('icon-more').addClass('icon-minus active').prev().addClass('active');
      }
    });
  });

  function checkIfInView() {
    var windowHeight = $win.height();
    var windowTopPosition = $win.scrollTop();
    var windowBottomPosition = (windowTopPosition + windowHeight);

    j.each($animationElements, function(){
      var element = j(this);
      var animation = element.data('animation');
      var elementHeight = element.outerHeight();
      var elementTopPosition = element.offset().top;
      var elementBottomPosition = (elementTopPosition + elementHeight);

      if ((elementBottomPosition >= windowTopPosition) && (elementTopPosition <= windowBottomPosition)) {
        element.addClass(animation);
      } else {
        element.removeClass(animation);
      }
    });
  }

  $win.on('scroll resize', checkIfInView);
  $win.trigger('scroll');
})(jQuery);
