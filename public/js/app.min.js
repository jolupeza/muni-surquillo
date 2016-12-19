'use strict';

var j = jQuery.noConflict();

(function($){
  var $win = j(window);
  var $doc = j(document);
  var $animationElements = j('.animation-element');
  var body = j('body');
  var gallery;

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

    // Gallery Surquillo
    if(j('.Gallery').length) {
      // widthBxSlider = parseInt(j('.Carousel--class').width());
      // widthBxSlider = (widthBxSlider * 42) / 100;

      gallery = j('.Gallery-list').bxSlider({
        auto: true,
        autoHover: true,
        minSlides: 1,
        maxSlides: 5,
        moveSlides: 1,
        slideWidth: 375,
        slideMargin: 0,
        nextText: '',
        prevText: '',
        pager: false,
        onSliderLoad: function() {
          j('.bx-controls-direction a').on('click', function(){
            var i = $(this).attr('data-slide-index');
              gallery.goToSlide(i);
              gallery.stopAuto();
              gallery.startAuto();
              return false;
          });
        }
      });
    }

    j('#js-modal-gallery').on('show.bs.modal', function (e) {
      var $this = $(e.relatedTarget),
          image = $this.data('image'),
          modal = $(this);

      modal.find('.Modal-figure img').attr('src', image);
      gallery.stopAuto();
    });

    j('#js-modal-gallery').on('hidden.bs.modal', function (e) {
      var $this = $(e.relatedTarget),
          modal = $(this);

      modal.find('.Modal-figure img').attr('src', '');
      gallery.startAuto();
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
