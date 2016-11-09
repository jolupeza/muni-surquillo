'use strict';

var j = jQuery.noConflict();

(function($){
  var $win = j(window);
  var $doc = j(document);
  var $animationElements = j('.animation-element');
  // var $sliders = j('.Sliders');
  // var $formSubs = j('.Course-subs');
  // var $sidebar = j('.Sidebar');
  // var body = j('body');
  // var $header = j('.header');
  // var $footer = j('.Footer');

  // function loaderEffect() {
  //   j("#loader").delay(500).fadeOut();
  //   j(".LoaderWrapper").delay(1000).fadeOut("slow");
  // }

  /*function loadingProcess() {
    var loadedimages = 0;
    var loadedpercent = 0;

    body.imagesLoaded()
    .always( function( instance ) {
      //console.log('loading images');
    })
    .fail( function() {
      //console.log('all images loaded, at least one is broken');
    })
    .done( function( instance ) {

    })
    .progress( function( instance, image ) {
      var totalimage = instance.images.length;
      var result = image.isLoaded ? 'loaded' : 'broken';
      if(result==='loaded'){
        loadedimages++;
      }
      loadedpercent = Math.round((loadedimages/totalimage)*100);
      jQuery('#loadingbar').css('width', loadedpercent+'%');
      //console.log( 'image is ' + result + ' for ' + image.img.src );
    });
  }*/

  $win.on('load', function(){
    // loaderEffect();
  });

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
    // loadingProcess();

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

    // Mobile Slidebars
    // j.slidebars();

    // Swipe carousel bootstrap
    // j(".carousel").swipe({
    //   swipe: function(event, direction, distance, duration, fingerCount, fingerData) {
    //     if (direction === 'left') $(this).carousel('next');
    //     if (direction === 'right') $(this).carousel('prev');
    //   },
    //   allowPageScroll:"vertical"
    // });

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
