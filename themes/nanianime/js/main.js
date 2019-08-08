(function ($) {
	
	/*------ 01. jQuery Mobile MeanMenu ------*/
	jQuery('#mobile-nav').meanmenu();
	
	/*------ 02. Slider Active ------*/
	$('.slider-active').owlCarousel({
		items:1,
		margin:0,
		autoHeight:true
	});	
	
	/*------ 03. Counter Up ------*/
	$('.counter').counterUp({
		delay: 10,
		time: 1000
	});
	
	/*------ 04. Tailer Home Two Owl Active ------*/
	$('.recent-upload-active').owlCarousel({
	  loop: false,
	  margin: 30,
	  autoplay: false,
	  nav: true,
	  dots:false,
	  navText:["<i class='icofont-simple-left'></i>","<i class='icofont-simple-right'></i>"],
	  responsive: {
		0: {
		  items: 2
		},
		480:{
			items:2
		},
		600: {
		  items: 2
		},
		768:{
			items:3
		},
		1000: {
		  items: 5
		}
	  }
	})
	
	/*------ 05. Recent Upload-active  Home Two Owl Active ------*/
	$('.recent-additios').owlCarousel({
	  loop: false,
	  margin: 30,
	  autoplay: false,
	  nav: true,
	  dots:false,
	  navText:["<i class='icofont-simple-left'></i>","<i class='icofont-simple-right'></i>"],
	  responsive: {
		0: {
		  items: 2
		},
		480:{
			items:2
		},
		600: {
		  items: 2
		},
		768:{
			items:3
		},
		1000: {
		  items: 4
		}
	  }
	})	
	
	/*------ 15. Magnific Popup For Video ------*/
	$('.popup-youtube').magnificPopup({
		type: 'iframe'
	});
	
})(jQuery);