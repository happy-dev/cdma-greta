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

  // Grab a giver GET parameter
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

  var contactFinalize = function() {
	var ei = $("#email-input");

	// Disable scroll zooming
	$('#map').addClass('scrolloff');// set the mouse events to none when doc is ready
        
        $('#overlay').on("mouseup",function(){          // lock it when mouse up
            $('#map').addClass('scrolloff'); 
        });
        $('#overlay').on("mousedown",function(){// when mouse down, set the mouse events free
            $('#map').removeClass('scrolloff');
        });
        $("#map").mouseleave(function () {// becuase the mouse up doesn't work... 
            $('#map').addClass('scrolloff');// set the pointer events to none when mouse leaves the map area
        });
	

	// Coordo email
        var email_addresses = $("#formation-email-addresses").html();
	if (email_addresses)
          $("#email-input").val( email_addresses );


	// Formation title
        var ft = $("#formation-title").html();
	if (ft)
          $("#formation-title-input").val( ft ).prop("readonly", true);                            


	// Domain title
        var domainName = $("#domain-name").html();
	if (domainName)
          $("#domain-input").val( domainName ).prop("readonly", true);                            


	// Code AF                                                                     
        $("#code-af-input").val( $("#code-af").data("codeaf") );


        // Fill email input & domain input
        var ds = $("#topics-select");
        ds.change(function(e) {
          ei.val(ds.val());
        });


	// Switch to a dedicated page on submit to track in Matomo
	document.addEventListener( 'wpcf7mailsent', function( event ) {
	    window.location.href = CDMA.siteurl + "/formulaire-bien-envoye";
	}, false );
      };

  var Sage = {
    // All pages
    'common': {

      // JavaScript to be fired on all pages
      init: function() {          
	// Grab a given GET parameter
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

	var facade 	= $('#search-bar-select-facade');
	var taxonomy 	= getParameterByName('taxonomy');

	facade.html( $("#search-bar-select option[value='"+ taxonomy +"']").prop("selected", true).html() );

        $('#search-bar-select').change(
          function () {
            $this = $(this);
            var str = '';
            $( "#search-bar-select option:selected" ).each(function() {
              str = $( this ).text();
            });
            facade.html(str);
          }
        );


	var pna = document.location.pathname.split("/");// Path Name Array
	if (pna.indexOf("domaine-offres") == -1 && pna.indexOf("fiches") == -1) {
	  localStorage.setItem("domain_href", undefined);
	  localStorage.setItem("domain_html", undefined);
	}
	if (pna.indexOf("actualite") == -1 && $("#single-article-page").length == 0) {
	  localStorage.setItem("category_href", undefined);
	  localStorage.setItem("category_html", undefined);
	}

	// Newsletter 
	$("#confirm-newsletter-submit").click(function() {
		$("#privacy-agreement-newsletter input").prop("checked", true);
		$("footer .wpcf7-form").submit();
	});
      },
      finalize: function() {
      }
    },
    // Home page
    'home': {
      init: function() {
	var taxonomy = $("#taxonomy-input");
	var fdi      = $("#fd-checkbox");// Formation Diplomante Input
	var feaci    = $("#feac-checkbox");// Formation Eligible Au CPF Input

	$(document).change("#fd-checkbox, #feac-checkbox", function(e) {
	  if (fdi.prop("checked") && feaci.prop("checked")) {
            taxonomy.val("formation-diplomantes-cpf");
	  }
	  else {
	    if (fdi.prop("checked")) {
              taxonomy.val("formation-diplomante");
	    }
	    else if (feaci.prop("checked")) {
              taxonomy.val("formation-eligible-au-cpf");
	    }
	    else {
              taxonomy.val("toute-formation");
     	    }
	  }
	});

        $("#modalVideoPresentation").on("hide.bs.modal", function(e) {               
          playerPresentation.pauseVideo();                                           
        });
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    'fiches': {
      init : function() {
	// Breadcrumbs
	$("#breadcrumb").append($("#formation-breadcrumb").contents());

	function modifyPrint() {
	  var printBtn = $("#at4-share a.at-svc-print");

	  if (printBtn.length > 0) {
	    printBtn.removeClass("at-share-btn at-svc-print")
	    	    .on("click", function(e) {
		var href = $("#pdf-file").attr("href");
		window.open(href, "_self");
	    });
	  }
	  else {
	    setTimeout(function() {
	      modifyPrint();
	    }, 250);
	  }
	}
	modifyPrint();


	// Pausing video on modal close (actually destroying and cloning it)
        $("#modalVideoFormation").on("hide.bs.modal", function(e) {               
          $("#formation-video-wrapper").empty();
	  $("#video-clone").clone().appendTo("#formation-video-wrapper");
	});


	// Pausing Temoignages video on modal close
        $("#modalVideoTemoignage").on("hide.bs.modal", function(e) {               
	  //if (typeof playerTemoignage !== 'undefined') {
          //  playerTemoignage.pauseVideo();                                           
	  //}
          $("#temoignage-video-wrapper").empty();
	  $("#tem-video-clone").clone().appendTo("#temoignage-video-wrapper");
        });
      },
      finalize : function() {},
    },
    'single_domaines': {
      init : function() {
	var domain = $("#sidebar li.current a");
	var href   = domain.attr("href");
	var html   = domain.html();

	localStorage.setItem("domain_href", href);
	localStorage.setItem("domain_html", html);

        $("#modalVideoDomaine").on("hide.bs.modal", function(e) {               
          playerDomaine.pauseVideo();                                           
        });
      },
      finalize : function() {}
    },
    'single' : {
      init : function() {
	// Breadcrumbs
	var ls_href = localStorage.getItem("category_href");
	var ls_html = localStorage.getItem("category_html");

	if (ls_href != "undefined" && ls_href != null) {
	  $("#breadcrumb .breadcrumb-item.active").before('<li class="breadcrumb-item"><a href="'+ ls_href +'">'+ ls_html +'</a></li>');
	}

	if (ls_html == "undefined" || ls_html == null || ls_html == 'A la une') {
	  ls_html = $("#single-article-category").html();
	}


	$("#sidebar a").each(function(idx) {
	  var el = $(this);

	  if (el.html() == ls_html) {
	    el.parent().addClass("current-cat");
	  }
	});
      },
      finalize : function() {}
    },
    'category': {
      init : function() {
	var category 	= $("#sidebar li.current-cat a");
	var href   	= category.attr("href");
	var html   	= category.html();

	localStorage.setItem("category_href", href);
	localStorage.setItem("category_html", html);
      },
      finalize : function() {}
    },
    'nous_contacter': {
      init : function() {},
      finalize : contactFinalize,
    },

    'plus_information': {
      finalize : contactFinalize,
    },

    'candidater': {
      init : function() {},
      finalize : function() {
	// Numbers only
	$(".numbers-only").on("keypress", function(e) {
	  return (e.charCode >= 48 && e.charCode <= 57) || e.charCode == 8 || e.charCode == 46 || e.key == "Backspace";
	});


	// Emails
        $("#email-input").val( $("#formation-email-addresses").html() );


	// Datepickers
	$(".datepicker").datepicker({ language: 'fr' });


	// Formation title                                                                     
        $("#formation-title-input").val( $("#formation-title").html() ).prop("readonly", true);                            
        $(".row.row-intro p").hide();


	// Code AF                                                                     
        $("#code-af-input").val( $("#code-af").data("codeaf") );
        
	// Switch to a dedicated page on submit to track in Matomo
	document.addEventListener( 'wpcf7mailsent', function( event ) {
	    window.location.href = CDMA.siteurl + "/message-bien-envoye";
	}, false );


        var si  = $("#salarie-input");// Salarie Input
        var nsi	= $("#non-salarie-input");// Non-Salarie Input
        var se 	= $("#sans-emploi-input");// Sans Emploi Input
        var dv 	= "";// Default Value

        si.change(function(e) {
          if (si.val() != dv) {
            nsi.prop("disabled", true);
            se.prop("disabled", true);
          }
	  else {
            nsi.prop("disabled", false);
            se.prop("disabled", false);
	  }
        });

        nsi.change(function(e) {
          if (nsi.val() != dv) {
            si.prop("disabled", true);
            se.prop("disabled", true);
          }
	  else {
            si.prop("disabled", false);
            se.prop("disabled", false);
	  }
        });

        se.change(function(e) {
          if (se.val() != dv) {
            si.prop("disabled", true);
            nsi.prop("disabled", true);
          }
	  else {
            si.prop("disabled", false);
            nsi.prop("disabled", false);
	  }
        });
	      
	// Wordaround Contact Form 7 bug
	$("input[type=checkbox]").addClass("wpcf7-form-control");
      },
    },

    
    'publier_un_stage': {
      init: function() {
	// Numbers only
	$(".numbers-only").on("keypress", function(e) {
	  return (e.charCode >= 48 && e.charCode <= 57) || e.charCode == 8 || e.charCode == 46;
	});


	// Datepickers
	$(".datepicker").datepicker({ language: 'fr' });


	// Inserting privacy agreement label
	$("label[for=privacy-agreement]").append( $("#privacy-agreement-content").html() );
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
        
        $('[data-toggle="offcanvasmobile"]').click(function () {
            $('.row-offcanvas-mobile').toggleClass('active');
          });
        
        
        
        $(window).scroll(function () {
            if ($(this).scrollTop() > 250) {
                $('.scroll-up').fadeIn();
            } else {
                $('.scroll-up').fadeOut();
            }
        });

        $('.scroll-up').click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, 600);
            return false;
        });

        
        
    });
    
})(jQuery); // Fully reference jQuery after this point.
