var isMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i);
	},
	BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i);
	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	},
	Opera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
	},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
	},
	any: function() {
		return isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows();
	},
};

var home = {
	init: function() {
		// this.tabs();
		this.home_slide();
		this.svg();
		this.menu();

		// $('.selectpicker').selectpicker();
		 $('select').selectpicker();
		
	},
	svg:function(){
		$('img.svg').each(function(){
			var $img = $(this);
			var imgID = $img.attr('id');
			var imgClass = $img.attr('class');
			var imgURL = $img.attr('src');
	
			$.get(imgURL, function(data) {
				// Get the SVG tag, ignore the rest
				var $svg = $(data).find('svg');
	
				// Add replaced image's ID to the new SVG
				if(typeof imgID !== 'undefined') {
					$svg = $svg.attr('id', imgID);
				}
				// Add replaced image's classes to the new SVG
				if(typeof imgClass !== 'undefined') {
					$svg = $svg.attr('class', imgClass+' replaced-svg');
				}
	
				// Remove any invalid XML tags as per http://validator.w3.org
				$svg = $svg.removeAttr('xmlns:a');
	
				// Check if the viewport is set, else we gonna set it if we can.
				if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
					$svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
				}
	
				// Replace image with new SVG
				$img.replaceWith($svg);
	
			}, 'xml');
	
		});
	},
	menu:function(){
		$('.menu-toggle').on('click','a',function(){
		  $('#header').toggleClass('show');
		  $('#header  .header-nav').toggleClass('show');
		  $(this).toggleClass('closed');
		});
		$('.btnFooterMobile').on('click',function(){
			 $('#footer').toggleClass('show');
		});

		$('#footer .btnClose').on('click',function(){
			 $('#footer').removeClass('show');
		});
	},
	home_slide: function(){
		$('.home-special-offers').slick({
		  infinite: false,
		  slidesToShow: 3,
		  slidesToScroll: 3,
		  responsive: [
		    {
		      breakpoint: 768,
		      settings: {
		        arrows: true,
		        slidesToShow: 2,
		        slidesToScroll: 2
		      }
		    },
		    {
		      breakpoint: 520,
		      settings: {
		        arrows: true,
		        slidesToShow: 1,
		        slidesToScroll: 1
		      }
		    }
		  ]
				
		});

		$('.slide_destionations').slick({
		  infinite: false,
		  slidesToShow: 5,
		  slidesToScroll: 5,
		  arrows: true,
		  responsive: [
		  {
		      breakpoint: 990,
		      settings: {
		        arrows: true,
		        slidesToShow: 3,
		        slidesToScroll: 3
		      }
		    },
		    {
		      breakpoint: 768,
		      settings: {
		        arrows: true,
		        slidesToShow: 2,
		        slidesToScroll: 2
		      }
		    },
		    {
		      breakpoint: 520,
		      settings: {
		        arrows: true,
		        slidesToShow: 1,
		        slidesToScroll: 1
		      }
		    }
		  ]
				
		});
		
	}
}





$(document).ready(function() {
	home.init();
	// core.popupThank();
	 // core.popupAlert('xxxxxx');
});



