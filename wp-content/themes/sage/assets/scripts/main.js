/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {
  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.

  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
      },
      finalize: function() {
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    'single_formations': {
      init : function() {},
      finalize : function() {
        var BODY = $("body");
        if (BODY.hasClass("single-formations")) {
          var ce    = $("#coordo-email");// Coordo Email
          var bc    = $(".candidate");// Btn Candidate
          var href  = bc.attr("href");

          href += href +"?email="+ ce.html();

          bc.attr("href", href);
        }
      },
    },
    'nous_contacter': {
      init : function() {},
      finalize : function() {
        function getParameterByName(name, url) {
          if (!url) {
            url = window.location.href;
          }
          name = name.replace(/[\[\]]/g, "\\$&");
          var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
              results = regex.exec(url);
          if (!results) return null;
          if (!results[2]) return '';
          return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        var email = getParameterByName("email");
        $("#coordo-email-input").val(email);
      },
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);
    

    //Offcanvas
    $(document).ready(function () {
      $('[data-toggle="offcanvas"]').click(function () {
        $('.row-offcanvas').toggleClass('active');
      });
    });

    
})(jQuery); // Fully reference jQuery after this point.

var $ = jQuery.noConflict();

ScrollToTop=function() {
    var s = $(window).scrollTop();

    if (s > 250) {
        var h = $(document).height();
        var wh = $(window).height();
        
        $('.scroll-up').fadeIn();
        if ((s + wh) > (h - 388)) {
            $bottom = (((s + wh) - (h - 388)) + 50);
            $('.scroll-up').css('bottom', $bottom);
        }
        else {
            $('.scroll-up').css('bottom', 50);
        }
    } else {
    $('.scroll-up').fadeOut();
    }

    $('.scroll-up').click(function () {
    $("html, body").animate({ scrollTop: 0 }, 900);
    return false;
    });
    }
 
StopAnimation=function() {
  $("html, body").bind("scroll mousedown DOMMouseScroll mousewheel keyup", function(){
    $('html, body').stop();
  });
}
 
 
$(window).scroll(function() {
  ScrollToTop();
  StopAnimation();
});

