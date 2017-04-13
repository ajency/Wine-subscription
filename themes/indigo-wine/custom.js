(function() {



jQuery(function(){

	// Menu fixed code

	jQuery(window).scroll(function(){
	  var sticky = jQuery('.ind-custom-menu'),
	      scroll = jQuery(window).scrollTop();
	      imgSrc = 'img/logo-half.png';

	  if (scroll >= 100){
	  	sticky.addClass('fixed');
	  	// jQuery('.ind-custom-menu #logo img').attr('src',imgSrc);
	  } 
	  else{
		sticky.removeClass('fixed');
	  }
	  
	});

	// Destroy default init

	if(jQuery('.owl-carousel').length){
	    var owl = jQuery('.owl-carousel').data('owlCarousel');
		owl.destroy();
	}


	function slideCarousel(){
		var owl = jQuery('.owl-carousel').data('owlCarousel');
		
		jQuery('.owl-carousel').owlCarousel({
	     	//Basic Speeds
		    slideSpeed : 200,
		    paginationSpeed : 800,
		 
		    //Autoplay
		    autoPlay : false,
		    goToFirst : true,
		    goToFirstSpeed : 1000,
		    items : 1,
		    autoHeight: true,
		    itemsDesktop : [1199,1],
	    	itemsDesktopSmall : [980,1],
		    itemsTablet: [768,1],
	    	itemsMobile : [479,1],
	    	addClassActive : true,
	    	// rewindNav: false,
		 
		    // Navigation
		    navigation : true,
		    navigationText : ["",""],
		    pagination : true,
		    // paginationNumbers: true,
		    // afterAction: moved	
		    // afterInit: checkfirstlast
		});
	}

	setTimeout(slideCarousel, 1000);




	// Readmore

	jQuery('.about-details').readmore({
	   speed: 25,
	   collapsedHeight: 210,
	   moreLink: '<a href="#" class="more">Show More <i class="fa fa-angle-down" aria-hidden="true"></i></a>',
	   lessLink: '<a href="#">Less <i class="fa fa-angle-up" aria-hidden="true"></i></a>'
	 });

	// mobile menu

	jQuery('.o-menu').click(function(){
	    jQuery('.cols .bottom,.head-overlay').addClass('active');
	    jQuery('body').addClass('blocked');
	});

	jQuery('.m-close').click(function(){
	    jQuery('.cols .bottom,.head-overlay').removeClass('active');
	    jQuery('body').removeClass('blocked');
	});

	// Menu click scroll

	jQuery('#menu-left-menu li:nth-child(2n) a').click(function(){
		event.preventDefault();
		jQuery(this).addClass('active').parent().siblings().children().removeClass('active');
	    jQuery('html, body').animate({
	        scrollTop: jQuery(".about-row").offset().top - 110
	    }, 2000);
	});
	jQuery('#menu-left-menu li:nth-child(3n) a').click(function(){
		event.preventDefault();
		jQuery(this).addClass('active').parent().siblings().children().removeClass('active');
	    jQuery('html, body').animate({
	        scrollTop: jQuery(".why-indigo-row").offset().top - 110
	    }, 2000);
	});

});




}).call(this);

jQuery(document).ready(function() {
jQuery("#toggleButton").click( function(event){
     event.preventDefault();
     if (jQuery(this).hasClass("isDown") ) {
     // $( ".navbar-fixed-top" ).animate({ "margin-top": "-62px" }, "fast" );
     jQuery( ".hb-sidebar" ).animate({ "left": "0px" }, "fast" );
     jQuery(this).removeClass("isDown");
     } else {
     // $( ".navbar-fixed-top" ).animate({ "margin-top": "0px" }, "fast" );
     jQuery( ".hb-sidebar" ).animate({ "left": "-780px" }, "fast" );
     jQuery(this).addClass("isDown");
     }
     return false;
     });   
});
