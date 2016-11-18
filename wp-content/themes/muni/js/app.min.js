'use strict';

var j = jQuery.noConflict();

(function($){
  var $win = j(window);
  var $doc = j(document);
  var $animationElements = j('.animation-element');
  // var body = j('body');
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

    j('.Header-MainMenu-list-item a').on('click', function(e){
      var $this = j(this),
        redirect = Boolean($this.data('redirect')),
        $target = j(this.hash);

      if (!redirect) {
        e.preventDefault();

        j('html, body').stop().animate({
          'scrollTop': $target.offset().top + 2
        }, 2000, 'easeInOutExpo');
      } else {
        $this.submit();
      }
    });

    j('.carousel-showmanymoveone .item').each(function(){
      var itemToClone = j(this);

      for (var i = 1; i < 2; i++) {
        itemToClone = itemToClone.next();

        // wrap around if at end of item collection
        if (!itemToClone.length) {
          itemToClone = j(this).siblings(':first');
        }

        // grab item, clone, add marker class, add to collection
        itemToClone.children(':first-child').clone()
          .addClass("cloneditem-"+(i))
          .appendTo(j(this));
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
