(function() {



jQuery(function(){

	// Menu fixed code

	jQuery(window).scroll(function(){
	  var sticky = jQuery('.ind-custom-menu'),
	      scroll = jQuery(window).scrollTop();

	  if (scroll >= 100){
	  	sticky.addClass('fixed');
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
		    // startDragging: bmoved,
		    // afterMove: amoved	
		    // afterInit: checkfirstlast
		});

		// function bmoved(){
		// 	jQuery('.banner-row .owl-pagination').addClass('hidden');
		// }
		// function amoved(){
		// 	jQuery('.banner-row .owl-pagination').removeClass('hidden');
		// }

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


		// jQuery('#menu-left-menu li a').click(function(){
		// 	event.preventDefault();
		// 	var a = jQuery(this).parent().index();
		// 	jQuery(this).addClass('active').parent().siblings().children().removeClass('active');
		// 	jQuery('html, body').animate({
	 //         scrollTop: jQuery('.scroll-'+a).offset().top - 110
	 //     }, 2000);
		// });
	
		// jQuery(window).scroll(function (event) {
		//     var scroll = jQuery(window).scrollTop();
		//     jQuery('#menu-left-menu li').each(function(){
		//     	var a = jQuery(this).parent().index();
		// 	    jQuery(this).toggleClass('ok',
		// 	      scroll >= jQuery('.scroll-'+a).offset().top
		// 	    );
		//     });
		// });

		// jQuery(window).scroll();


		// Custom menu click and scroll to particular ID


			var topMenu = jQuery(".custom-menu-class"),
                offset = 40,
                topMenuHeight = topMenu.outerHeight()+offset,
                // All list items
                menuItems =  topMenu.find('a[href*="#"]'),
                // Anchors corresponding to menu items
                scrollItems = menuItems.map(function(){
                  var href = jQuery(this).attr("href"),
                  id = href.substring(href.indexOf('#')),
                  item = jQuery(id);
                  //console.log(item)
                  if (item.length) { return item; }
                });

            // so we can get a fancy scroll animation
            menuItems.click(function(e){
              var href = jQuery(this).attr("href"),
                id = href.substring(href.indexOf('#'));
                  offsetTop = href === "#" ? 0 : jQuery(id).offset().top-topMenuHeight+1;
              jQuery('html, body').stop().animate({ 
                  scrollTop: offsetTop
              }, 1000);
              e.preventDefault();
            });

            // Bind to scroll
            jQuery(window).scroll(function(){
               // Get container scroll position
               var fromTop = jQuery(this).scrollTop()+topMenuHeight;

               // Get id of current scroll item
               var cur = scrollItems.map(function(){
                 if (jQuery(this).offset().top < fromTop)
                   return this;
               });

               // Get the id of the current element
               cur = cur[cur.length-1];
               var id = cur && cur.length ? cur[0].id : "";               
               
               menuItems.removeClass("active");
               if(id){
                    menuItems.parent().end().filter("[href*='#"+id+"']").addClass("active");
               }
               
            });

            jQuery('.link-register').click(function(){
				function wait(){
					jQuery('.simplemodal-container').addClass('register-stuff');	
				}
				setTimeout(wait, 500);
            });

});




}).call(this);

jQuery(document).ready(function() {
jQuery("#toggleButton").click( function(event){
     event.preventDefault();
     if (jQuery(this).hasClass("isDown") ) {
     // jQuery( ".navbar-fixed-top" ).animate({ "margin-top": "-62px" }, "fast" );
     jQuery( ".hb-sidebar" ).animate({ "left": "0px" }, "fast" );
     jQuery(this).removeClass("isDown");
     } else {
     // jQuery( ".navbar-fixed-top" ).animate({ "margin-top": "0px" }, "fast" );
     jQuery( ".hb-sidebar" ).animate({ "left": "-780px" }, "fast" );
     jQuery(this).addClass("isDown");
     }
     return false;
     });   
});
