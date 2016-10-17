'use strict';

var j = jQuery.noConflict();

(function($){
  var $win = j(window);
  var $doc = j(document);
  var $animationElements = j('.animation-element');
  var $sliders = j('.Sliders');
  var $formSubs = j('.Course-subs');
  var $sidebar = j('.Sidebar');
  var body = j('body');
  var $header = j('.header');
  var $footer = j('.Footer');

  function affixHeader() {
    if ($sliders.length) {
      j('#affixHeader').affix({
        offset: {
          top: function() {
            return ($sliders.outerHeight(true) / 2) - 80;
          }
        }
      });
    }
  }

  function affixMenuCepuch() {
    var cepuch = j('#js-cepuch');

    if (cepuch.length) {
      j('#affixMenuCepuch').affix({
        offset: {
          top: function() {
            return (cepuch.outerHeight(true) - 80);
          }
        }
      });
    }
  }

  function affixFormSubs() {
    if ($formSubs.length) {
      j('#affixFormSubs').affix({
        offset: {
          top: function() {
            return $header.outerHeight(true) + 40;
          },
          bottom: function() {
            return (this.bottom = $footer.outerHeight(true) + 100);
          }
        }
      });
    }
  }

  function checkPositionFormSubs() {
    if ($formSubs.length) {
      j('.Course-tabs li a[data-toggle="tab"]').on('show.bs.tab', function(e){
        j('#affixFormSubs').removeClass('bug');
      });

      j('#affixFormSubs').on('affix-bottom.bs.affix', function(e){
        if (j('.Course-tabs-content').height() < 500) {
          j(e.target).addClass('bug');
        } else {
          j(e.target).removeClass('bug');
        }
      });
    }
  }

  function affixSidebar() {
    if ($sidebar.length) {
      j('#affixSidebar').affix({
        offset: {
          top: function() {
            return $header.outerHeight(true) + 40;
          },
          bottom: function() {
            return (this.bottom = $footer.outerHeight(true) + 120);
          }
        }
      });
    }
  }

  function scrollHeader() {
    var logoNormal = j('#js-logo-normal'),
      logoScroll = j('#js-logo-scroll');

    if ($sliders.length) {
      var limit = ($sliders.outerHeight(true) / 2) - 80;

      if ($win.scrollTop() > limit) {
        logoNormal.removeClass('active');
        logoScroll.addClass('active');
      } else {
        logoNormal.addClass('active');
        logoScroll.removeClass('active');
      }
    }
  }

  function loaderEffect() {
    j("#loader").delay(500).fadeOut();
    j(".LoaderWrapper").delay(1000).fadeOut("slow");
  }

  function changeLogoHeader() {
    if (!$sliders.length) {
      var logoNormal = j('#js-logo-normal'),
        logoScroll = j('#js-logo-scroll');

      logoNormal.removeClass('active');
      logoScroll.addClass('active');
    }
  }

  function loadingProcess() {
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
  }

  function initTestimonials() {
    if (j('.Carousel-multiple').length) {
      j('.Carousel-multiple .item').each(function(){
        var itemToClone = j(this);

        for (var i = 1; i < 3; i++) {
          itemToClone = itemToClone.next();

          // wrap around if at end of item collection
          if (!itemToClone.length) {
            itemToClone = $(this).siblings(':first');
          }

          // grab item, clone, add marker class, add to collection
          itemToClone.children(':first-child').clone()
            .addClass("cloneditem-"+(i))
            .appendTo(j(this));
        }
      });
    }
  }

  $win.on('load', function(){
    loaderEffect();

    changeLogoHeader();
  });

  $win.on('scroll', function(event){
    if(j(this).scrollTop() > 150) {
      j('.ArrowTop').fadeIn();
    } else {
      j('.ArrowTop').fadeOut();
    }

    if ($win.width() > 991) {
      scrollHeader();
    }
  });

  $win.on('resize', function(){
    affixHeader();
    affixFormSubs();
    checkPositionFormSubs();
    affixSidebar();
    affixMenuCepuch();
  });

  j(document).on('ready', function(){
    loadingProcess();

    initTestimonials();

    affixHeader();
    affixFormSubs();
    checkPositionFormSubs();
    affixSidebar();
    affixMenuCepuch();

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

    j('.Card a').on('click', function(e){
      var menu = j('#affixMenuCepuch');

      var $this = j(this),
        $target = j(this.hash);

      e.preventDefault();

      if (menu.hasClass('affix-top')) {
        return false;
      } else {
        j('html, body').stop().animate({
          'scrollTop': $target.offset().top + 2
        }, 2000, 'easeInOutExpo');
      }
    });

    body.on('click', '.Submenu-more', function(ev){
      ev.preventDefault();
      var $this = j(this),
        parent = Boolean($this.data('parent')),
        status = Boolean($this.data('status'));

      if (parent) {
        j('.Submenu-more').each(function(index) {
          var $t = j(this);
          $t.next().hide();
          $t.removeClass('minus').addClass('plus').data('status', false);
        });

      } else {
        $this.parent().parent().find('.sub-menu').hide();
        $this.parent().parent().find('.Submenu-more').removeClass('minus').addClass('plus').data('status', false);
      }

      if (!status) {
        $this.next().show();
        $this.removeClass('plus').addClass('minus');
      } else {
        $this.next().hide();
        $this.removeClass('minus').addClass('plus');
      }

      status = !status;
      $this.data('status', status);
    });

    // Mobile Slidebars
    // j.slidebars();

    // Swipe carousel bootstrap
    j(".carousel").swipe({
      swipe: function(event, direction, distance, duration, fingerCount, fingerData) {
        if (direction == 'left') $(this).carousel('next');
        if (direction == 'right') $(this).carousel('prev');
      },
      allowPageScroll:"vertical"
    });

    j('.carousel-showmanymoveone .item').each(function(){
      var itemToClone = j(this);

      for (var i = 1; i < 4; i++) {
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
