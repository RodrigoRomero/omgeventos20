function showMap(initWhat) {

		var script 		= document.createElement('script');

		script.type 	= 'text/javascript';

		script.src 		= 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&callback='+initWhat;

		document.body.appendChild(script);

	}

    

$(document).ready(function() {
	 if(exists(('#frm_edad'))) {
     $("#frm_edad").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
 }



var _scrollSpeed			= 1000;  

// GOOGLE MAP

   

        var e = $("#gmap");

        $googlemap_latitude  = e.attr('data-lat');

        $googlemap_longitude = e.attr('data-lng');

        $googlemap_zoom			= 13,

  



// set header height!

window.navHeight 		= $("#header").height();  



/**	01. SCROLL TO

*************************************************** **/

	jQuery("a.scrollTo").bind("click", function(e) {

		e.preventDefault();



		var href = jQuery(this).attr('href');

		if(href != '#') {

			jQuery('html,body').stop().animate({scrollTop: jQuery(href).offset().top - window.navHeight}, _scrollSpeed, 'easeInOutExpo');

		}

	});



	jQuery("a.toTop").bind("click", function(e) {

		e.preventDefault();

		jQuery('html,body').stop().animate({scrollTop: 0}, 1000, 'easeInOutExpo');

	});

            



/**	02. SLIDER

*************************************************** **/

// $(window).load(function() {



	// Home Slider (top)

	if($("#slider").length > 0) {

		$("#slider").superslides({

			animation: "fade", 		// slide|fade

			pagination: true, 		// true|false

			play: false,	 		// false to disable autoplay -OR- miliseconds (eg.: 1000 = 1s)

			animation_speed: 600,	// animation transition



			elements: {

			  preserve: '.preserve',

			  nav: '.slides-navigation',

			  container: '.slides-container',

			  pagination: '.slides-pagination'

			}



		});

	}



	/* 

	// Stop on mouse over ! 

	$('#slides').on('mouseenter', function() {

		$(this).superslides('stop');

		// console.log('Stopped')

	});

	$('#slides').on('mouseleave', function() {

		$(this).superslides('start');

		// console.log('Started')

	});

	*/



// });





/**	03. FITVIDS

*************************************************** **/

	if(jQuery().fitVids) {

		jQuery("body").fitVids();

	}

	    



/**	05. ELEMENTS ANIMATION

*************************************************** **/

	$('.animate_from_top').each(function () {

		$(this).appear(function() {

			$(this).delay(150).animate({opacity:1,top:"0px"},1000);

		});	

	});



	$('.animate_from_bottom').each(function () {

		$(this).appear(function() {

			$(this).delay(150).animate({opacity:1,bottom:"0px"},1000);

		});	

	});





	$('.animate_from_left').each(function () {

		$(this).appear(function() {

			$(this).delay(150).animate({opacity:1,left:"0px"},1000);

		});	

	});





	$('.animate_from_right').each(function () {

		$(this).appear(function() {

			$(this).delay(150).animate({opacity:1,right:"0px"},1000);

		});	

	});



	$('.animate_fade_in').each(function () {

		$(this).appear(function() {

			$(this).delay(150).animate({opacity:1,right:"0px"},1000);

		});	

	});



	/**	@ANIMATE ELEMENTS **/

	if($().appear) {

		$('*').each(function() {

			if($(this).attr('data-animation')) {

				var $animationName = $(this).attr('data-animation');

				$(this).appear(function() {

					$(this).addClass('animated').addClass($animationName);

				});

			}

		});

	}







    // INIT CONTACT, NLY IF #contactMap EXISRS

	if(jQuery("#gmap").length > 0) {

		showMap('contactMap');

	}

/**	12. MAGNIFIC POPUP

*************************************************** **/

	function _popups() {

		if(jQuery().magnificPopup) {



			jQuery('.popup, .popup-image').magnificPopup({ 

				type: 'image',

				fixedContentPos: 	false,

				fixedBgPos: 		false,

				mainClass: 			'mfp-no-margins mfp-with-zoom',

				image: {

					verticalFit: 	true

				},

				zoom: {

					enabled: 		true,

					duration: 		300

				}

			});



			// Magnific Popup for videos and google maps

			jQuery('.popup-video, .popup-gmap').magnificPopup({

				disableOn: 			700,

				type: 				'iframe',

				fixedContentPos: 	false,

				fixedBgPos: 		false,

				mainClass: 			'mfp-fade',

				removalDelay: 		160,

				preloader: 			false

			});



			// Magnific Popup for a normal inline element

			jQuery('.popup-inline').magnificPopup({

				type: 		'inline'

			});



			// Magnific Popup for a project with rich content

			jQuery('.popup-project').magnificPopup({

				type: 		'inline',

				alignTop: 	true

			});



			// Magnific Popup for an ajax popup without rich content

			jQuery('.popup-ajax').magnificPopup({

				type: 		'ajax',

				alignTop:	 true

			});



		}

	}	_popups();

    

/**	13. PORTFOLIO

*************************************************** **/

	jQuery(window).load(function() {

		jQuery(".masonry-list").each(function() {



			var $container = jQuery(this);



			$container.waitForImages(function() {



				$container.masonry({

					itemSelector: '.masonry-item'

				});



			});



		});

	});





	jQuery("ul.isotope-filter").each(function() {



		var source = jQuery(this);

		var destination = jQuery("ul.sort-destination[data-sort-id=" + jQuery(this).attr("data-sort-id") + "]");



		if(destination.get(0)) {



			jQuery(window).load(function() {



				destination.isotope({

					itemSelector: "li",

					layoutMode: 'sloppyMasonry'

				});



				source.find("a").click(function(e) {



					e.preventDefault();



					var $this = jQuery(this),

						sortId = $this.parents(".sort-source").attr("data-sort-id"),

						filter = $this.parent().attr("data-option-value");



					source.find("li.active").removeClass("active");

					$this.parent().addClass("active");



					destination.isotope({

						filter: filter

					});



					// self.location = "#" + filter.replace(".","");



					jQuery(".sort-source-title[data-sort-id=" + sortId + "] strong").html($this.html());



					return false;



				});





				/*

					jQuery(window).bind("hashchange", function(e) {



						var hashFilter = "." + location.hash.replace("#",""),

							hash = (hashFilter == "." || hashFilter == ".*" ? "*" : hashFilter);



						source.find("li.active").removeClass("active");

						source.find("li[data-option-value='" + hash + "']").addClass("active");



						destination.isotope({

							filter: hash

						});



					});

					var hashFilter = "." + (location.hash.replace("#","") || "*");





					var initFilterEl = source.find("li[data-option-value='" + hashFilter + "'] a");



					if(initFilterEl.get(0)) {

						source.find("li[data-option-value='" + hashFilter + "'] a").click();

					} else {

						source.find("li:first-child a").click();

					}

				*/





			});



		}



	});





	

	// External Portfolio

	jQuery("a.ajax-project").bind("click", function(e) {

		e.preventDefault();



		var href = jQuery(this).attr('href');



		$.ajax({

			url: 	href,

			data: 	{ajax:"true"},

			type: 	"get",

			error: 	function(XMLHttpRequest, textStatus, errorThrown) {



				alert('Server Internal Error'); // usualy on headers 404



			},



			success: function(data) {

				jQuery('body').append('<div id="ajax_modal">' + data + '</div>');

				jQuery("#ajax_modal").fadeIn(300, function() {

					jQuery("body").fitVids();			// fitvids

					owlCarouselInit(".owl-carousel");	// carousel

					_popups();



					// close modal

					jQuery("button.close-modal").bind("click", function(e) {

						jQuery("#ajax_modal").fadeOut(300, function() {

							jQuery('html,body').css({"overflow-y":"auto"});

							jQuery(this).remove();

						});

					});



					// Esc key

					jQuery(document).keydown(function(e){

						var code = e.keyCode ? e.keyCode : e.which;

						if(code === 27) {

							jQuery("#ajax_modal").fadeOut(300, function() {

								jQuery('html,body').css({"overflow-y":"auto"});

								jQuery(this).remove();

							});

						}

					});



				});



				// hide page scroll

				jQuery('html,body').css({"overflow-y":"hidden"});

			}

		});

		

	});

    

    

/**	14. STICKY TOP NAV

*************************************************** **/

	// -----------------------------------------------------------------------------------

		// Fullscreen Height - keep it here to avoid sticky menu bug!

		if($(".full-screen").length > 0) {

			_fullscreen();



			$(window).resize(function() {

				_fullscreen();

			});

		}

		function _fullscreen() {



			var _screenHeight = $(window).height();

			$(".full-screen, .full-screen ul, .full-screen li").height(_screenHeight);



		}

	// -----------------------------------------------------------------------------------



	if($("#home").length > 0) {



		window.isOnTop 		= true;

		window.homeHeight 	= $("#home").height() - window.navHeight;

		 /*

			window.isOnTop = avoid bad actions on each scroll

			Benefits: no unseen $ actions, faster rendering

		 */

		$(window).scroll(function() {

			if($(document).scrollTop() > window.homeHeight) {

				if(window.isOnTop === true) {

					$('#header').addClass('fixed');

					window.isOnTop = false;

				}

			} else {

				if(window.isOnTop === false) {

					$('#header').removeClass('fixed');

					window.isOnTop = true;

				}

			}

		});



		$(window).resize(function() {

			window.homeHeight = $("#home").height() - window.navHeight;

		});



	}



	// mobile - hide on click!

	$(document).bind("click", function() {

		if($("div.navbar-collapse").hasClass('in')) {

			$("#mobileMenu").trigger('click');

		}

	});

    

    

    

    

/**	15. FULLSCREEN

 *************************************************** **/

	if(navigator.userAgent.indexOf("MSIE") > 0) {

		/* ie */

	} else { 

		$("a.btn-fullscreen").show(); 

	}



	$("a.btn-fullscreen").bind("click", function(e) {

		e.preventDefault();



		if (!document.fullscreenElement && /* alternative standard method */ !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods



			if (document.documentElement.requestFullscreen) {

				document.documentElement.requestFullscreen();

			} else if (document.documentElement.mozRequestFullScreen) {

				document.documentElement.mozRequestFullScreen();

			} else if (document.documentElement.webkitRequestFullscreen) {

				document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);

			}



		} else {



			if (document.cancelFullScreen) {

				document.cancelFullScreen();

			} else if (document.mozCancelFullScreen) {

				document.mozCancelFullScreen();

			} else if (document.webkitCancelFullScreen) {

				document.webkitCancelFullScreen();

			}



		}

	});



/** MISC

*************************************************** **/	



	// easing - only needed

	jQuery.extend( jQuery.easing,{

		easeInOutExpo: function (x, t, b, c, d) {

			if (t==0) return b;

			if (t==d) return b+c;

			if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;

			return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;

		},

	});

    

    // Hover Effect - opacity effect

	jQuery('#portfolio li, #quick-blog .quick-hover').hover(function(){

		jQuery(this).siblings().addClass('faded');

	}, function(){

		jQuery(this).siblings().removeClass('faded');

	});

    

    

    // WIZARD

			$('#MyWizard').on('change', function(e, data) {

				console.log('change');

				if(data.step===3 && data.direction==='next') {

					// return e.preventDefault();

				}

			});

			$('#MyWizard').on('changed', function(e, data) {

				console.log('changed');

			});

			$('#MyWizard').on('finished', function(e, data) {

				console.log('finished');

			});

			$('#btnWizardPrev').on('click', function() {

				$('#MyWizard').wizard('previous');

			});

			$('#btnWizardNext').on('click', function() {

				$('#MyWizard').wizard('next','foo');

			});

			$('#btnWizardStep').on('click', function() {

				var item = $('#MyWizard').wizard('selectedItem');

				console.log(item.step);

			});

			$('#btnWizardSetStep4').on('click', function() {

				var step = 4;

				$('#MyWizard').wizard('selectedItem', {step:step});

			});

			$('#MyWizard').on('stepclick', function(e, data) {

				console.log('step' + data.step + ' clicked');

				if(data.step===1) {

					// return e.preventDefault();

				}

			});

	



});



/**	11. GOOGLE MAP

*************************************************** **/

	function contactMap() {

/*

		var styles = [

			{

				featureType: 'landscape.natural',

				elementType: 'all',

				stylers: [

					{ hue: '#22272d' },

					{ saturation: -7 },

					{ lightness: -84 },

					{ visibility: 'on' }

				]

			},{

				featureType: 'water',

				elementType: 'geometry',

				stylers: [

					{ hue: '#e1675a' },

					{ saturation: 44 },

					{ lightness: -19 },

					{ visibility: 'on' }

				]

			},{

				featureType: 'road',

				elementType: 'labels',

				stylers: [

					{ visibility: 'off' }

				]

			},{

				featureType: 'road.local',

				elementType: 'geometry',

				stylers: [

					{ hue: '#F73F69' },

					{ saturation: -46 },

					{ lightness: -44 },

					{ visibility: 'on' }

				]

			},{

				featureType: 'poi',

				elementType: 'geometry',

				stylers: [

					{ hue: '#F73F69' },

					{ saturation: 19 },

					{ lightness: -29 },

					{ visibility: 'on' }

				]

			},{

				featureType: 'road.highway',

				elementType: 'geometry',

				stylers: [

					{ hue: '#666666' },

					{ saturation: -100 },

					{ lightness: -37 },

					{ visibility: 'on' }

				]

			},{

				featureType: 'road.arterial',

				elementType: 'geometry',

				stylers: [

					{ hue: '#666666' },

					{ saturation: -100 },

					{ lightness: -48 },

					{ visibility: 'on' }

				]

			},{

				featureType: 'administrative',

				elementType: 'labels',

				stylers: [

					{ visibility: 'off' }

				]

			}

		];

*/



		var latLang = new google.maps.LatLng($googlemap_latitude,$googlemap_longitude);



		var mapOptions = {

			zoom:$googlemap_zoom,

			center: latLang,

			disableDefaultUI: false,

			navigationControl: false,

			mapTypeControl: false,

			scrollwheel: false,

			// styles: styles,

			mapTypeId: google.maps.MapTypeId.ROADMAP

		};



		var map = new google.maps.Map(document.getElementById('gmap'), mapOptions);

		google.maps.event.trigger(map, 'resize');

		map.setZoom( map.getZoom() );



		var marker = new google.maps.Marker({

			icon: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACcAAAArCAYAAAD7YZFOAAAACXBIWXMAAAsTAAALEwEAmpwYAAAKT2lDQ1BQaG90b3Nob3AgSUNDIHByb2ZpbGUAAHjanVNnVFPpFj333vRCS4iAlEtvUhUIIFJCi4AUkSYqIQkQSoghodkVUcERRUUEG8igiAOOjoCMFVEsDIoK2AfkIaKOg6OIisr74Xuja9a89+bN/rXXPues852zzwfACAyWSDNRNYAMqUIeEeCDx8TG4eQuQIEKJHAAEAizZCFz/SMBAPh+PDwrIsAHvgABeNMLCADATZvAMByH/w/qQplcAYCEAcB0kThLCIAUAEB6jkKmAEBGAYCdmCZTAKAEAGDLY2LjAFAtAGAnf+bTAICd+Jl7AQBblCEVAaCRACATZYhEAGg7AKzPVopFAFgwABRmS8Q5ANgtADBJV2ZIALC3AMDOEAuyAAgMADBRiIUpAAR7AGDIIyN4AISZABRG8lc88SuuEOcqAAB4mbI8uSQ5RYFbCC1xB1dXLh4ozkkXKxQ2YQJhmkAuwnmZGTKBNA/g88wAAKCRFRHgg/P9eM4Ors7ONo62Dl8t6r8G/yJiYuP+5c+rcEAAAOF0ftH+LC+zGoA7BoBt/qIl7gRoXgugdfeLZrIPQLUAoOnaV/Nw+H48PEWhkLnZ2eXk5NhKxEJbYcpXff5nwl/AV/1s+X48/Pf14L7iJIEyXYFHBPjgwsz0TKUcz5IJhGLc5o9H/LcL//wd0yLESWK5WCoU41EScY5EmozzMqUiiUKSKcUl0v9k4t8s+wM+3zUAsGo+AXuRLahdYwP2SycQWHTA4vcAAPK7b8HUKAgDgGiD4c93/+8//UegJQCAZkmScQAAXkQkLlTKsz/HCAAARKCBKrBBG/TBGCzABhzBBdzBC/xgNoRCJMTCQhBCCmSAHHJgKayCQiiGzbAdKmAv1EAdNMBRaIaTcA4uwlW4Dj1wD/phCJ7BKLyBCQRByAgTYSHaiAFiilgjjggXmYX4IcFIBBKLJCDJiBRRIkuRNUgxUopUIFVIHfI9cgI5h1xGupE7yAAygvyGvEcxlIGyUT3UDLVDuag3GoRGogvQZHQxmo8WoJvQcrQaPYw2oefQq2gP2o8+Q8cwwOgYBzPEbDAuxsNCsTgsCZNjy7EirAyrxhqwVqwDu4n1Y8+xdwQSgUXACTYEd0IgYR5BSFhMWE7YSKggHCQ0EdoJNwkDhFHCJyKTqEu0JroR+cQYYjIxh1hILCPWEo8TLxB7iEPENyQSiUMyJ7mQAkmxpFTSEtJG0m5SI+ksqZs0SBojk8naZGuyBzmULCAryIXkneTD5DPkG+Qh8lsKnWJAcaT4U+IoUspqShnlEOU05QZlmDJBVaOaUt2ooVQRNY9aQq2htlKvUYeoEzR1mjnNgxZJS6WtopXTGmgXaPdpr+h0uhHdlR5Ol9BX0svpR+iX6AP0dwwNhhWDx4hnKBmbGAcYZxl3GK+YTKYZ04sZx1QwNzHrmOeZD5lvVVgqtip8FZHKCpVKlSaVGyovVKmqpqreqgtV81XLVI+pXlN9rkZVM1PjqQnUlqtVqp1Q61MbU2epO6iHqmeob1Q/pH5Z/YkGWcNMw09DpFGgsV/jvMYgC2MZs3gsIWsNq4Z1gTXEJrHN2Xx2KruY/R27iz2qqaE5QzNKM1ezUvOUZj8H45hx+Jx0TgnnKKeX836K3hTvKeIpG6Y0TLkxZVxrqpaXllirSKtRq0frvTau7aedpr1Fu1n7gQ5Bx0onXCdHZ4/OBZ3nU9lT3acKpxZNPTr1ri6qa6UbobtEd79up+6Ynr5egJ5Mb6feeb3n+hx9L/1U/W36p/VHDFgGswwkBtsMzhg8xTVxbzwdL8fb8VFDXcNAQ6VhlWGX4YSRudE8o9VGjUYPjGnGXOMk423GbcajJgYmISZLTepN7ppSTbmmKaY7TDtMx83MzaLN1pk1mz0x1zLnm+eb15vft2BaeFostqi2uGVJsuRaplnutrxuhVo5WaVYVVpds0atna0l1rutu6cRp7lOk06rntZnw7Dxtsm2qbcZsOXYBtuutm22fWFnYhdnt8Wuw+6TvZN9un2N/T0HDYfZDqsdWh1+c7RyFDpWOt6azpzuP33F9JbpL2dYzxDP2DPjthPLKcRpnVOb00dnF2e5c4PziIuJS4LLLpc+Lpsbxt3IveRKdPVxXeF60vWdm7Obwu2o26/uNu5p7ofcn8w0nymeWTNz0MPIQ+BR5dE/C5+VMGvfrH5PQ0+BZ7XnIy9jL5FXrdewt6V3qvdh7xc+9j5yn+M+4zw33jLeWV/MN8C3yLfLT8Nvnl+F30N/I/9k/3r/0QCngCUBZwOJgUGBWwL7+Hp8Ib+OPzrbZfay2e1BjKC5QRVBj4KtguXBrSFoyOyQrSH355jOkc5pDoVQfujW0Adh5mGLw34MJ4WHhVeGP45wiFga0TGXNXfR3ENz30T6RJZE3ptnMU85ry1KNSo+qi5qPNo3ujS6P8YuZlnM1VidWElsSxw5LiquNm5svt/87fOH4p3iC+N7F5gvyF1weaHOwvSFpxapLhIsOpZATIhOOJTwQRAqqBaMJfITdyWOCnnCHcJnIi/RNtGI2ENcKh5O8kgqTXqS7JG8NXkkxTOlLOW5hCepkLxMDUzdmzqeFpp2IG0yPTq9MYOSkZBxQqohTZO2Z+pn5mZ2y6xlhbL+xW6Lty8elQfJa7OQrAVZLQq2QqboVFoo1yoHsmdlV2a/zYnKOZarnivN7cyzytuQN5zvn//tEsIS4ZK2pYZLVy0dWOa9rGo5sjxxedsK4xUFK4ZWBqw8uIq2Km3VT6vtV5eufr0mek1rgV7ByoLBtQFr6wtVCuWFfevc1+1dT1gvWd+1YfqGnRs+FYmKrhTbF5cVf9go3HjlG4dvyr+Z3JS0qavEuWTPZtJm6ebeLZ5bDpaql+aXDm4N2dq0Dd9WtO319kXbL5fNKNu7g7ZDuaO/PLi8ZafJzs07P1SkVPRU+lQ27tLdtWHX+G7R7ht7vPY07NXbW7z3/T7JvttVAVVN1WbVZftJ+7P3P66Jqun4lvttXa1ObXHtxwPSA/0HIw6217nU1R3SPVRSj9Yr60cOxx++/p3vdy0NNg1VjZzG4iNwRHnk6fcJ3/ceDTradox7rOEH0x92HWcdL2pCmvKaRptTmvtbYlu6T8w+0dbq3nr8R9sfD5w0PFl5SvNUyWna6YLTk2fyz4ydlZ19fi753GDborZ752PO32oPb++6EHTh0kX/i+c7vDvOXPK4dPKy2+UTV7hXmq86X23qdOo8/pPTT8e7nLuarrlca7nuer21e2b36RueN87d9L158Rb/1tWeOT3dvfN6b/fF9/XfFt1+cif9zsu72Xcn7q28T7xf9EDtQdlD3YfVP1v+3Njv3H9qwHeg89HcR/cGhYPP/pH1jw9DBY+Zj8uGDYbrnjg+OTniP3L96fynQ89kzyaeF/6i/suuFxYvfvjV69fO0ZjRoZfyl5O/bXyl/erA6xmv28bCxh6+yXgzMV70VvvtwXfcdx3vo98PT+R8IH8o/2j5sfVT0Kf7kxmTk/8EA5jz/GMzLdsAAAAgY0hSTQAAeiUAAICDAAD5/wAAgOkAAHUwAADqYAAAOpgAABdvkl/FRgAABONJREFUeNrEmMFvG0UUh7+13dI0Ng0pVEJIEJCQcgmEI1zo7pEDyh+A1JY7EhUnTglIvSG1cEGIQ3JBAg5VwglBWW9JSQWFkoCsxFjJOgpWtlXjNE6dOl57h8vbauV61/baEU8aRfaMZ7/83pvfzKymlCIqDMOYBM4Bk8DZNkMs4DowBxSj5jJNk15CC4MzDOMsMB0CFBYWcBFYHgRcIgTsMpDtEQwZ/ycwwwAi1QI1IlCTfc47DbwAXOhnklblBgHmx3lgdiBwkspBgQUB34/7Y00p5Rd/tovxy1L0e8ApYAoY6+J3LwLFXhdEKlAjnVbhhTZWcVEWQSfVp+PUX0J8LGpVzpmmqZumWYwAf018Liq9Y3Fq7lxE/7xpmt3+xxfC/E1iKg5clGoXe5wvavybceAmI9JZ7HE+K0K9sdhW0iZWYjqAFfL95CDhlmPC7Q3KJKPgxvifIwru1ZhzhhV+MQ7c/TBvkoNALzEWsfpjwYXV1kiMffFyRF9R07SE9ngQ1hIdCn/aMIzzYZ3ZbFaTllBKvRtltJ7n5YDjwBPSjsv2mRKRtHZ76/UOCs0ahjFmmuZMEEomTExMTIyOjo5+omnaO1GSViqVW0AaUIEG0AQa0pqA5/dpuq6PALtdpKwIzHuet9hsNveVUqeTyeTbyWTyLTmhhIZSasuyrNcD6mgCoAlQE6gDh9I8QPlHpjhH8q6j0Wh8s7i4+AFwTBRPtaTRA1ygCjzwAX0rWThKv2o2mwvAAfBQFEsBQ8BJaWlR/0n5PgloPtzcEbIVl5aWvhVFHggksihOAsOBlpbvE49M2DTN+8D8EcHN67ruF71fU0og0oE2HADTWneIT48ILjivJik90aKYD6YFVq1KBC68VhwX76QaUBTrSYlCzwBPi8n7qp0QNatATeAe21s/GiSZUuqzbDZ7TGrrNPA88BLwHPAUkJE+gH3ZSmuPfK71dYRhGPYgTiRKqUXLsqbk4aeAM8CzAumvyIZAbQHrQEnU8x678QfUm+0XznGcr4BXBGxUlEoHvM4H2wX+Be4ErCb8RU6/6tVqtX9u3rz5uSg0FNhPE/JwV1K4CeQBWz43gnCJkJR83I9qtm2vAuOB+jojBjssyj2UFOZlEe61goXCWZY1p5S6EQdsZ2en6DhOXWprRKDSUnuaKFQA/gY2JK1uK1jkSbher1+KsU256+vrm7IK0/LX97AG4AA5eU223i6VHeGUUmppaSnruu7VXuC2t7e3q9VqMuD4Q6JWRdS6Bfwhqaz4ZhvnDtGwbftDpVS1G7CDg4OHhUJhR6BOymHSBe7KNfMX4LbYRrUTWCc4VSqVnN3d3SvdwBUKhXuBlalJkeeBG3Kg/QvYlo3f6+v2pZTygNrKyspsrVbLR01SKpX2y+WyJ75ZE4u4BfwE/CyQ5bDCj6McUqxl27ZnPM87bDfg8PCwadv2gTz4jqTwR+B74FcB3dd1vdELWEc4Ua/qOM5vjuN83W7M2tranuu6O8CavIBcAK6JVdwFDnVd9+LYUqqbUzZwL5/Pf5nJZN7IZDIv+x2bm5uVcrmcl3q6LarZUm9uXKhu0+qrdwDYq6url+r1elVWZ21jY+Ma8B1wVdTKATtAvV+wbpXzr2+71Wr190Kh8MX4+Ph7uVxuAfhBfGtLjuCuruuKAcV/AwDnrxMM7gFGVQAAAABJRU5ErkJggg==',

			position: latLang,

			map: map,

			title: ""

		});



		marker.setMap(map);

		google.maps.event.addListener(marker, "mouseover", function() {

		  $('#address_box').addClass('destacar');

			// Add optionally an action for when the marker is clicked

		});

        google.maps.event.addListener(marker, "mouseout", function() {

            $('#address_box').removeClass('destacar');

		//  alert('aca esta el IAE')

			// Add optionally an action for when the marker is clicked

		});

		// kepp googlemap responsive - center on resize

		google.maps.event.addDomListener(window, 'resize', function() {

			map.setCenter(latLang);

		});



	}

    

    function exists(el) {

    return ($(el).length > 0) ? true : false;

}





