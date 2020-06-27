(function() {


jQuery(function(){


	jQuery("html").easeScroll();  


	// Menu fixed code

	jQuery(window).scroll(function(){
	  var sticky = jQuery('.ind-custom-menu'),
	      scroll = jQuery(window).scrollTop();

	  if (scroll >= 150){
	  	sticky.addClass('fixed');
	  	jQuery('.header-sep').addClass('fixedAdd');
	  	jQuery('#hb-page-title').addClass('fixedAdd');
	  	// jQuery('#main-content').addClass('fixed-added');
	  } 
	  else{
		sticky.removeClass('fixed');
		jQuery('.header-sep').removeClass('fixedAdd');
		jQuery('#hb-page-title').removeClass('fixedAdd');
		// jQuery('#main-content').removeClass('fixed-added');
	  }
	  
	});

	// var $navBar = jQuery('.ind-custom-menu');

	// // find original navigation bar position
	// var navPos = $navBar.offset().top;

	// // on scroll
	// jQuery(window).scroll(function() {

	//     // get scroll position from top of the page
	//     var scrollPos = jQuery(this).scrollTop();

	//     // check if scroll position is >= the nav position
	//     if (scrollPos >= navPos) {
	//         $navBar.addClass('fixed');
	//     } else {
	//         $navBar.removeClass('fixed');
	//     }

	// });


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
		    autoPlay : true,
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
		    paginationNumbers: true,
		    // startDragging: bmoved,
		    afterMove: amoved	
		    // afterInit: checkfirstlast
		});

		function amoved(){
			// var slideText = jQuery('.owl-page.active .owl-numbers').text();
			// if(slideText == 2){
			// 	jQuery('.banner-caption .msg').text('Hand selected boutique Australian wines');
			// }
			// else
			// {
			// 	jQuery('.banner-caption .msg').text('Purveyors of hand selected boutique Australian wines');	
			// }
			var activeText = jQuery('.owl-carousel .owl-item.active img').attr("data-text");
			jQuery('.banner-caption .msg').text(activeText);
		}

	}

  jQuery(document).ready(function($) {
    slideCarousel();
  });
    

	// setTimeout(slideCarousel, 1000);




	jQuery('.product_desc').readmore({
	   speed: 25,
	   collapsedHeight: 230,
	   moreLink: '<a href="#" class="more">Show More <i class="fa fa-angle-down" aria-hidden="true"></i></a>',
	   lessLink: '<a href="#">Less <i class="fa fa-angle-up" aria-hidden="true"></i></a>'
	 });


	// Menu height checking
	jQuery(window).load(function(){ 
		if (jQuery(window).width() > 992) {
		  	var menu_height = jQuery('.ind-custom-menu').outerHeight();
			jQuery('.header-sep').css('margin-top',menu_height);
		}
	})

	// featured product scroll

	jQuery(".featured-product .down").click(function() {
	    jQuery('html, body').animate({
	        scrollTop: jQuery(".featuredRow").offset().top - 150
	    }, 2000);
	});


	// mobile menu

	jQuery('.o-menu').click(function(){
	    jQuery('.cols .bottom,.head-overlay').addClass('active');
	    jQuery('body').addClass('blocked');
	});

	jQuery('.m-close,.custom-menu-class a').click(function(){
	    jQuery('.cols .bottom,.head-overlay').removeClass('active');
	    jQuery('body').removeClass('blocked');
	});


	// My account action mobile

	jQuery('.account-action').click(function(){
		jQuery('.woocommerce-MyAccount-navigation').toggleClass('active');
		jQuery('body').toggleClass('of-hidden');
		jQuery(this).find('.fa').toggleClass('fa-bars fa-times');
		jQuery('#hb-header').toggleClass('active-index');
	});


	// Cart why subscribe alert
   
    jQuery(document).on('click', '.close-sub-box', function(event) {
      jQuery(this).parent('.why-subscribe').addClass('hidden');
     });

	// remove extra clear class from product listing

	jQuery('.hb-equal-col-height .products-4 .clear').remove();


	// click outside hide

	jQuery(document).mouseup(function(e) {
	  var Click_todo;
	  Click_todo = jQuery('.cols .bottom');
	  if (!Click_todo.is(e.target) && Click_todo.has(e.target).length === 0) {
	    jQuery('.cols .bottom,.head-overlay').removeClass('active');
	    jQuery('body').removeClass('blocked');
	  }
	});


	// Subscribe overlay

	if (jQuery('.subscribe-overlay').hasClass("active")) {
		setTimeout(bodyClass, 1200);
	}

	function bodyClass(){
		jQuery('body').addClass('subscribe-activated');	
		jQuery(this).removeClass('hidden');
	}

	jQuery('.close-Sub_overlay').click(function(){
		jQuery('body').removeClass('subscribe-activated');
		jQuery('.subscribe-overlay').addClass('hidden');
	});


	// Trigered cart icon to actual cart click

	// jQuery('.add-To-Cart').click(function(){
	// 	jQuery(this).parent().parent().parent('.hb-product-meta-wrapper').siblings('.hb-woo-image-wrap').find('.add_to_cart_button').trigger("click");
	// });

jQuery(".orderby option[value='date']").text('Sort by newest first');


	jQuery('.discount').addClass('active');	

	jQuery('.site-offer .close').click(function(){
	    jQuery('.discount').hide();
	});


	// Checking if product tabs are empty

	jQuery('.woocommerce-tabs li a').each(function(){

		var check = jQuery(this);
		
	  	if( check.text() === '' ){
	    	jQuery(this).parent().addClass('not-active');
	  	}

	  	if(jQuery('.woocommerce-tabs li:first-child()').hasClass('not-active')){
	  		jQuery('.woocommerce-tabs li:nth-child(2)').addClass('active').siblings().removeClass('active');
	  	}
	  	else{
	  		jQuery('.woocommerce-tabs li:first-child()').addClass('active').siblings().removeClass('active');	
	  	}
	  	var active_id = jQuery('.woocommerce-tabs li.active a').attr("href");
	  	jQuery('.woocommerce-tabs .wc-tab').hide()
	  	jQuery(active_id).show();

	});



	/*jQuery("#subscription-check").click(function () {

	    if (jQuery(this).is(":checked")) {

	        jQuery("html, body").animate({ scrollTop: 0 }, "slow");


	    } else {
	        jQuery("html, body").animate({ scrollTop: 0 }, "slow");
  			
	    }

	})*/


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

});




}).call(this);

jQuery(document).ready(function() {


		// Readmore

  setTimeout(function() {
    jQuery('.about-details').readmore({
       speed: 25,
       collapsedHeight: 235,
       moreLink: '<a href="#" class="more">Show More <i class="fa fa-angle-down" aria-hidden="true"></i></a>',
       lessLink: '<a href="#">Less <i class="fa fa-angle-up" aria-hidden="true"></i></a>'
     });

  }, 300);
  

	jQuery("#toggleButton").click( function(event){
	     event.preventDefault();

	     if (jQuery(this).hasClass("isDown") ) {
	     	jQuery( ".hb-sidebar" ).animate({ "left": "0px" }, "fast" );
	     	jQuery(this).removeClass("isDown");
	     	jQuery('body').addClass('blocked');
	     } else {
	     	jQuery( ".hb-sidebar" ).animate({ "left": "-780px" }, "fast" );
	     	jQuery(this).addClass("isDown");
	     	jQuery('body').removeClass('blocked');
	     }
	     jQuery('#hb-header').toggleClass('active-index');

     });   


  jQuery('.sub-unsubscribe').click(function(event) {
    var txt;

    var r = confirm("Are you sure, Do you Want to Unsubscribe the orders ?");
    if (r == true) {
      
       jQuery.post(cart_qty_ajax.siteapiurl+'unsubscribe_orders', {id: jQuery('#subid').val() }, function(data, textStatus, xhr) {
        window.location='/my-account/subscription/';
       });

    } 
   
  });

  // Price-list email

  jQuery('.pricelist .link').click(function(event) {
        event.preventDefault();

        var data = {
            action: 'is_user_logged_in'
        };

        jQuery.post(ajaxurl, data, function(response) {
            if (response == 'yes') {
            	jQuery('.price-loader').removeClass('hidden');
                jQuery.post(cart_qty_ajax.siteapiurl + 'tradelist_email',{email:users.email}, function(data, textStatus, xhr) {
                  jQuery('.hb-notif-box').removeClass('hidden');
                  setTimeout(function() {
                    jQuery('.hb-notif-box').addClass('hidden');
                    jQuery('.pricelist .price-loader').addClass('hidden');
                  }, 3500);
                });
            }
            else{
               // window.location='/wp-login.php?';
               jQuery('#PriceList-modal').parent().addClass('hb-visible-modal');
               jQuery('#PriceList-modal').addClass('animate-modal');

            }
        });
  });

	setTimeout(function(){
		if(getCookie('hide_subscribe_box') != 'true'){
			jQuery('#signup-box').show();
		}
	},6000);
	jQuery('#signup-box .close_box').click(function(){
		jQuery('#signup-box').hide();
		setCookie('hide_subscribe_box', 'true', 1);
	});
	jQuery(".signup-link").click(function(){
		jQuery('#signup-box').show();
	});

	jQuery(".view-panel .view-options").click(function(e){
		e.preventDefault();
		jQuery(".view-panel .view-options").removeClass('view-options-active');
		jQuery(this).addClass('view-options-active');
		setParam('view', jQuery(this).attr('data-type'));
		jQuery(".row.products").css({'opacity': 0});
		jQuery(".basel-products-loader").show();

		var result = jQuery.ajax({
            url: jQuery(this).attr('href'),
            type: 'GET',
            data: {
                action: 'change_product_view',
                category: jQuery(".row.products").attr('data-cat'),
                min_price: jQuery(".row.products").attr('data-min'),
                max_price: jQuery(".row.products").attr('data-max'),
                page: jQuery(".row.products").attr('data-page'),
                orderby: jQuery(".woocommerce-ordering .orderby").val(),
                product_view_option: jQuery(this).attr('data-type'),
            },
            dataType:'json',
        });

		result.success( function( data ) {
			jQuery(".basel-products-loader").hide();
			jQuery(".row.products").css({'opacity': 1});
		    category = jQuery(".row.products").attr('data-cat');
            min_price = jQuery(".row.products").attr('data-min');
            max_price = jQuery(".row.products").attr('data-max');
            page = jQuery(".row.products").attr('data-page');
            jQuery(".row.products").replaceWith(data.products);
            category = jQuery(".row.products").attr('data-cat', category);
            min_price = jQuery(".row.products").attr('data-min', min_price);
            max_price = jQuery(".row.products").attr('data-max', max_price);
            page = jQuery(".row.products").attr('data-page', page);
            window.scroll({
		  		top: document.documentElement.scrollTop + 1,
		  		behavior: 'smooth'
			});
        });
        result.fail( function( jqXHR, textStatus ) {
            console.log( textStatus );
        });
	})
});


jQuery(document).ready(function() {
              
  jQuery('#preferred_date').datetimepicker({ 
    timepicker:false, 
    minDate:'+1970/01/02', // to disabled today 
    format:'d/m/Y',
    disabledWeekDays:[0, 6]
  }
  );

});



function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function switch_checkbox(){
	if(jQuery("#createaccount_radio_yes").attr("checked") == "checked"){
		// Check
		jQuery("#createaccount").attr("checked", true);
		jQuery( '#account_password' ).val( '' ).change();
		jQuery( 'div.create-account' ).slideDown();
	}
	else{
		// Uncheck
		jQuery("#createaccount").attr("checked", false);
		jQuery( 'div.create-account' ).hide();
	}
}

function setParam(param, mode = ''){
	var url = new URL(location.href);
	if(mode){
		url.searchParams.set(param, mode);
	}
	else{
		url.searchParams.delete(param);
	}
	url.search = url.searchParams.toString();
	var new_url = url.toString(); 
	window.history.pushState('page2', 'Title', new_url);
}



