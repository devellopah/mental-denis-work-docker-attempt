;(function($) {
    "use strict";

    if (document.documentMode || /Edge/.test(navigator.userAgent)) {
      $('body').addClass('browser-edge');
    }

    var fullScreen = function() {
      if (!$.fullscreen.isNativelySupported()) {
        $('.js-fscreen').attr('title', 'Ваш браузер не поддерживает полноэкранный режим');
      }
      $('.js-fscreen').click(function() {
        if ($(this).hasClass('active')){
           $(this).removeClass('active');
           $.fullscreen.exit();
        }
        else{
           $(this).addClass('active');
           $('html').fullscreen();
        }
        return false;
      });
    };

    var hamburger = function() {
      $('.hamburger').click(function (e) {
         e.preventDefault();
         if ($(this).hasClass('is-active')){
            $(this).removeClass('is-active');
            $('.nav:visible').fadeOut('fast');
            $('body').removeClass('ovh');
         }
         else{
            $(this).addClass('is-active');
            $('.nav:hidden').fadeIn('fast');
            $('body').addClass('ovh');
         }
       });
    };

    var scrollable = function() {
	    var ww = $(window).width();
      if ( $('.js-scroll').length && ww>1024) {
        $('.js-scroll').slimScroll({
						width: '100%',
						height: '100%',
						size: '5px',
						position: 'right',
						color: '#C4952C',
						alwaysVisible: true,
						railVisible: true,
						railColor: '#EBD6A7',
						railOpacity: 1,
						allowPageScroll: false,
						disableFadeOut: false
				});
      }
    }

    var slickGallery = function() {
      if ( $('.js-mobile-slider').length ) {
        $('.js-mobile-slider').slick({
           mobileFirst: true,
           dots: true,
           arrows: false,
           variableWidth: true,
           useTransform:false,
           centerMode: true,
           responsive: [
             {
               breakpoint: 1023,
               settings: 'unslick'
             }
           ]
        });
      }
    };

    var customSelect = function() {
      if ( $('.js-select').length ) {
        $('.js-select').select2({
          minimumResultsForSearch: Infinity
        });
      }
    };

    var navToggle = function() {
       $('.js-nav-toggle').on('click', function() {
         if ($('body').hasClass('nav-toggled')){
            $('body').removeClass('nav-toggled');
            setTimeout(function(){
              $('.header').fadeIn();
            }, 100);
            $('.nav__link').removeAttr('tooltip');
         }
         else{
            $('body').addClass('nav-toggled');
            $('.header').hide();

            $('.nav__in .nav__link').each(function(){
              $(this).attr('tooltip', $(this).text());
            });
         }
         return false;
       });
    };

    var plusMinus = function() {
       $('.js-plus').on('click', function() {
           var $parent = $(this).parents('.field-num'),
               $inp = $parent.find('.js-field'),
               val = parseInt($inp.val());

           val += 1;
           $inp.val(val);
       });

       $('.js-minus').on('click', function() {
         var $parent = $(this).parents('.field-num'),
             $inp = $parent.find('.js-field'),
             val = parseInt($inp.val());

           val -= 1;
           $inp.val(val);
       });
    };

    var passToggle = function() {
      $('body').on('click', '.js-pass-toggle', function(){
        var $this = $(this),
            $inp = $this.parents('.pos-rel').find('input');

        if ($inp.attr('type') == 'password'){
          $this.addClass('visible');
          $inp.attr('type', 'text');
        } else {
          $this.removeClass('visible');
          $inp.attr('type', 'password');
        }
      });
    };

    var upDown = function() {
      $('.js-toggle').on('click', function() {
          var $block = $(this).parents().find('.js-toggle-block');

          if ($(this).hasClass('active')){
             $(this).removeClass('active');
             $block.slideUp();
          }
          else{
             $(this).addClass('active');
             $block.slideDown();
          }
          return false;
      });
    };

    var phoneMask = function() {
      $("input[type='tel']").mask("+7 (999) 999-99-99");
    };

    $(function() {
      fullScreen();
      hamburger();
      scrollable();
      slickGallery();
      customSelect(); 
      navToggle();
      plusMinus();
      passToggle();
      upDown();
      phoneMask();
    });
})(jQuery);
