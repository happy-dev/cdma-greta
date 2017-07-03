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

  var Sage = {
    // All pages
    'common': {

      // JavaScript to be fired on all pages
      init: function() {          
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
    'single_formations': {
      init : function() {},
      finalize : function() {
	// Coordo email to form
        var ce     	= $("#coordo-email");// Coordo Email
        var cb     	= $(".contact-btn");// Contact Buttons
        var cdtb   	= $(".btn-candidate");// Candidate Buttons
        var href   	= cb.attr("href");
        var cdt_href  = cdtb.attr("href");

        href += "?email="+ encodeURIComponent( ce.html() );
        cdt_href += "?email="+ encodeURIComponent( ce.html() );


	// Formation title to form
        var ft    = $("#formation-title");// Formation Title

        href += "&formation="+ encodeURIComponent( ft.html() );
        cdt_href += "&formation="+ encodeURIComponent( ft.html() );

        cb.attr("href", href);
        cdtb.attr("href", cdt_href);


	// Breadcrumbs
	var ls_href = localStorage.getItem("domain_href");
	var ls_html = localStorage.getItem("domain_html");

	if (ls_href !== "undefined" && ls_html !== "undefined") {
	  $("#breadcrumb .breadcrumb-item.active").before('<li class="breadcrumb-item"><a href="'+ ls_href +'">'+ ls_html +'</a></li>');
	}


	// Multi Sessions
        $('#sessions-tabs a').click(function (e) {
          e.preventDefault();

            $('.tab-panel').tab('hide');
          $(this).tab('show');
            
            //$id = $(this).attr('ID'); alert('#tab-'+$id);
          //$('#tab-'+$id).addClass('active');
          $('#sessions-tabs a.active').removeClass('active');
          // $(this).addClass('active')
        })

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
	  if (typeof playerTemoignage !== 'undefined') {
            playerTemoignage.pauseVideo();                                           
	  }
        });
      },
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
console.log("Actualités");
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
      finalize : function() {
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
        var email = getParameterByName("email");
	if (email) {
          $("#email-input").val( decodeURIComponent(email) );
	}


	// Formation title
        var ft = getParameterByName("formation");


	if (ft) {
	  $("#formation-title-input").prop("readonly", true).val( decodeURIComponent(ft) );
	  $("#domains-select").prop("disabled", true).parent().hide();
	}
	else {
	  $("#formation-title-input").parent().hide();
	}


        // Fill email input & domain input
        var ds = $("#domains-select");
        ds.change(function(e) {
          var val     = ds.val();
          var array   = val.split('+!+');
          var domain  = array[0];
          var email   = array[1];
          

          $('#domain-input').val(domain);
          $('#email-input').val(email);
        });
      },
    },

    'candidater': {
      init : function() {},
      finalize : function() {
	// Coordo email
        var email = getParameterByName("email");
	if (email) {
          $("#email-input").val( decodeURIComponent(email) );
	}


	// Numbers only
	$(".numbers-only").on("keypress", function(e) {
	  return (e.charCode >= 48 && e.charCode <= 57) || e.charCode == 8 || e.charCode == 46 || e.key == "Backspace";
	});


	// Datepickers
	$(".datepicker").datepicker({ language: 'fr' });


	// Formation title
        var ft = getParameterByName("formation");

	if (ft) {
	  $("#formation-title-input").val( decodeURIComponent(ft) ).prop("readonly", true);
	  $("#domains-select").prop("disabled", true).parent().hide();
	}
	else {
	  $("#formation-title-input").parent().hide();
	}


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
