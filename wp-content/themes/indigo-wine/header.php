<?php
/**
 * @package WordPress
 * @subpackage Highend
 */
 ?>
<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>

  <!-- START head -->
  <head>
  <?php global $theme_focus_color; ?>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="theme-color" content="<?php echo $theme_focus_color; ?>">
  <meta name="google-site-verification" content="viP5DO51kJHH0ImuczPU2BvIH0aZIs5tLUpAbF0dyGc" />
  <?php if ( hb_options('hb_responsive') ) { ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <?php } ?>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

  <?php if (hb_options('hb_apple_icon_144')) { ?>
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo hb_options('hb_apple_icon_144'); ?>" />
  <?php } ?>
  <?php if (hb_options('hb_apple_icon_114')) { ?>
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo hb_options('hb_apple_icon_114') ?>" />
  <?php } ?>
  <?php if (hb_options('hb_apple_icon_72')) { ?>
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo hb_options('hb_apple_icon_72') ?>" />
  <?php } ?>
  <?php if (hb_options('hb_apple_icon')) { ?>
  <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo hb_options('hb_apple_icon'); ?>" />
  <?php } ?>

  <?php if ( hb_options('hb_ios_bookmark_title') && hb_options('hb_ios_bookmark_title') != "") { ?>
    <meta name="apple-mobile-web-app-title" content="<?php echo hb_options('hb_ios_bookmark_title'); ?>" />
  <?php } ?>

  <?php
  if ( !hb_seo_plugin_installed() ) {
    $og_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'single-post-thumbnail' );
    if($og_image !== false) { ?>
      <meta property="og:image" content="<?php echo $og_image[0]; ?>" />
    <?php }
  } ?>

  <!--[if lte IE 8]>
  <script src="<?php echo get_template_directory_uri(); ?>/scripts/html5shiv.js" type="text/javascript"></script>
  <![endif]-->

  <?php wp_head(); ?>

  <!-- Theme Options Font Settings -->
  <?php /*if( is_front_page() )*/ { ?>
    <style type="text/css">
      @media (min-width: 767px){
        *, html, body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, form, label, fieldset, input, p, blockquote, th, td{
          outline: 0;
            vertical-align: baseline;
            background: transparent;
            margin: 0;
            padding: 0;
        }

        body, .team-position, .hb-single-next-prev .text-inside, .hb-dropdown-box.cart-dropdown .buttons a, input[type=text], textarea, input[type=email], input[type=password], input[type=tel], #fancy-search input[type=text], #fancy-search .ui-autocomplete li .search-title, .quote-post-format .quote-post-wrapper blockquote, table th, .hb-button, .woocommerce #payment #place_order, .woocommerce-page #payment #place_order, input[type=submit], a.read-more, blockquote.pullquote, blockquote, .hb-skill-meter .hb-skill-meter-title, .hb-tabs-wrapper .nav-tabs li a, #main-wrapper .coupon-code input.button, #main-wrapper .form-row input.button, #main-wrapper input.checkout-button, #main-wrapper input.hb-update-cart, .woocommerce-page #main-wrapper .shipping-calculator-form-hb button.button, .hb-accordion-pane, .hb-accordion-tab{
          font-family: "Lato",sans-serif;
            font-size: 14px;
            line-height: 22px;
            letter-spacing: 0;
        }
        body{
          font-weight: 600 !important;
        }

        ol, ul, li{
          list-style: none;
          list-style-position: outside !important;
        }
        .vc_col-lg-1, .vc_col-lg-10, .vc_col-lg-11, .vc_col-lg-12, .vc_col-lg-2, .vc_col-lg-3, .vc_col-lg-4, .vc_col-lg-5, .vc_col-lg-6, .vc_col-lg-7, .vc_col-lg-8, .vc_col-lg-9, .vc_col-md-1, .vc_col-md-10, .vc_col-md-11, .vc_col-md-12, .vc_col-md-2, .vc_col-md-3, .vc_col-md-4, .vc_col-md-5, .vc_col-md-6, .vc_col-md-7, .vc_col-md-8, .vc_col-md-9, .vc_col-sm-1, .vc_col-sm-10, .vc_col-sm-11, .vc_col-sm-12, .vc_col-sm-2, .vc_col-sm-3, .vc_col-sm-4, .vc_col-sm-5, .vc_col-sm-6, .vc_col-sm-7, .vc_col-sm-8, .vc_col-sm-9, .vc_col-xs-1, .vc_col-xs-10, .vc_col-xs-11, .vc_col-xs-12, .vc_col-xs-2, .vc_col-xs-3, .vc_col-xs-4, .vc_col-xs-5, .vc_col-xs-6, .vc_col-xs-7, .vc_col-xs-8, .vc_col-xs-9 {
            position: relative;
            min-height: 1px;
            padding-left: 15px;
            padding-right: 15px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .container, .hb-circle-frame, .hb-separator, .hb-process-steps ul li, .hb-process-steps, .hb-image-banner:before, .hb-image-banner-content, .hb-box-frame, #header-bar, .tab-content, .small-contaner, .hb-progress-bar, .hb-box-cont-header, .hb-box-cont-body, #fancy-search .ui-autocomplete, .hb-accordion, .hb-toggle, .hb-accordion-bar, .fw-gallery-wrap, #maintenance-footer, .elastic-item, .timeRef, .form-col, .header-inner-bg, #maintenance-logo, .container-wide, #copyright-wrapper, #main-nav li a, .mejs-container, .mejs-mediaelement, .mejs-container .mejs-controls, #main-nav ul.sub-menu li, #main-nav ul.sub-menu, .cart-dropdown .buttons a, input, textarea, .hb-button, .content-box, .hb-flexslider, .row, .extra-wide-container, #hb-blog-posts, .hb-blog-classic article, .hb-pricing-item, .hb-pricing-table-wrapper, ul.testimonial-slider, ul.testimonial-slider li, .hb-client-list li, .hb-client-list, .portfolio-related-item, .hb-testimonial, .hb-stream ul li, #fancy-search, .hb-image-banner-content, .hb-bag-buttons a, .woocommerce-page #content input.button, .hb-item-product-details, .item-figure, #main-content .hb-woo-wrapper ul.sort-count li ul, .hb-fw-element, #fancy-search .ui-autocomplete, .woo-cat-details {
            box-sizing: border-box;
        }

        .clearfix, .row, .hb-field-content .hb-row, .container, .container-wide, ul.cart_list.product_list_widget li, #respond, .small-contaner, .spacer, .tagcloud {
            zoom: 1;
        }

        #header-inner{
          line-height: 80px;
        }


        .ind-custom-menu{
          position: fixed;
          left: 0;
          right: 0;
          top: 0;
          display: flex;
          justify-content: center;
          align-items: flex-end;
            padding: 1.5em 15px .3em 15px;
            background-size: 5%;
            background-image: url(//n91b049m8w02ekn18iv126rm-wpengine.netdna-ssl.com/wp-content/themes/indigo-wine/img/bg-repeat.jpg);
            background-position: 13.3% 2px;
            background-color: #002b4e;
        }
        #main-content img{
          max-width: 100%;
          height: auto;
        }

        .col {
            position: relative;
            display: block;
            float: left;
            width: 100%;
        }

        .ind-custom-menu .col {
            flex: 1 0 38%;
        }

        .ind-custom-menu .col-left {
            display: flex;
            justify-content: flex-end;
            padding-right: 1em;
        }

        .ind-custom-menu .col-center{
          flex: 1 0 23% !important;
          text-align: center;
        }

        .ind-custom-menu .col-right{
          display: flex;
        }

        #logo a {
            display: block;
            height: 100%;
            vertical-align: middle;
            text-align: center;
        }

        .ind-custom-menu #logo {
            max-width: initial !important;
            height: auto !important;
            float: none;
            display: inline-block;
            position: relative;
            top: -10px;
            z-index: 99991;
            line-height: 80px;
        }

        #logo .hb-visible-logo img.default {
            display: none !important;
        }
        #logo .hb-visible-logo img.retina, #logo img.alternative-retina {
            display: inline-block !important;
            max-width: 100%;
            height: auto;
            width: 100%;
            vertical-align: middle;
            text-align: center;
        }
        #logo img.default, #logo img.retina {
            display: none !important;
        }
        #logo img {
            max-height: 55%;
        }

        .ind-custom-menu .col ul{
          display: flex;
          position: relative;
          top: 7px;
        }
        .ind-custom-menu .col ul li{
          position: relative;
          padding: 0 .7em;
        }
        .ind-custom-menu .col ul li a {
            font-size: .95em;
            color: #d1b57c;
            text-decoration: none;
        }

        .ind-custom-menu .col ul li .sub-menu{
          display: none;
        }
        .user-detail.user-detail .drop.sub-menu, .indigo-m-menu, #fancy-search{
          display: none;
        }

        .owl-carousel{
          position: relative;
          width: 100%;
        }
        .owl-controls{
          display: none;
        }
        .owl-carousel .owl-wrapper{
          position: relative;
        }
        .owl-carousel .owl-item {
            float: left;
        }
        .owl-carousel .owl-item {
            float: left;
        }
        .owl-carousel .owl-wrapper-outer{
          overflow: visible !important;
          position: relative;
            width: 100%;
        }
        .owl-theme .owl-controls .owl-page span.owl-numbers {
            height: auto;
            width: auto;
            color: #FFF;
            padding: 2px 10px;
            font-size: 12px;
            -webkit-border-radius: 30px;
            -moz-border-radius: 30px;
            border-radius: 30px;
        }
        .banner-row .owl-controls .owl-pagination .owl-page.owl-page span {
            position: relative;
            display: inline-block;
            margin: 0 5px;
            background-color: #ba9346;
            width: 12px;
            height: 8px;
            border-radius: inherit;
            padding: 0;
            font-size: inherit;
            text-indent: -1000px;
        }
        .banner-row .owl-controls .owl-pagination .owl-page.owl-page span:before {
            width: inherit;
            height: inherit;
            background-color: inherit;
            content: "";
            position: absolute;
            left: 0;
            -webkit-transform: rotate(-60deg);
            -ms-transform: rotate(-60deg);
            transform: rotate(-60deg);
        }
        .banner-caption {
            position: absolute;
            bottom: -6em;
            width: 420px;
            text-align: left;
            left: 6em;
            background-color: #d1b57c;
            padding: 1.5em;
            padding-bottom: 4em;
        }
        .banner-caption .msg {
            color: #fff;
            font-size: 2.2em;
            font-family: 'gotham_lightregular';
            font-weight: 600;
            line-height: 1.3;
        }
        .social-link .title {
            color: #fff;
            font-weight: 600;
            font-size: 1.1em;
            padding-left: .5em;
            margin-bottom: .5em;
            font-family: 'gotham_mediumregular';
            line-height: 22px;
            letter-spacing: 0;
        }
        .social-link .socialIcons {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .social-link .socialIcons .data .fa {
            font-size: 1.4em;
            color: #fff;
            font: normal normal normal 14px/1 FontAwesome;
        }
        .fa-facebook-f:before, .fa-facebook:before {
            content: "\f09a";
        }
        .fa-instagram:before {
            content: "\f16d";
        }

        .site-title {
            font-size: 2em;
            font-weight: 600;
            font-family: 'gotham_lightregular';
            color: #022c4c;
            letter-spacing: 1.5px;
            margin-bottom: .6em;
        }
        .about-us .about-data {
            font-size: 1.4em;
            font-weight: 600;
            font-family: 'gotham_lightregular';
            line-height: 1.4;
            color: #d1b57c;
        }
        .about-us .about-data b {
            font-family: 'gotham_mediumregular';
        }

        #header-inner{
          position: relative;
          width: 100%;
          height: auto !important;
        }
        #header-inner-bg{
          border: 0;
          background-color: transparent;
          position: relative;
          left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .hidden.container{
          display: none;
        }
        .social-link {
            position: absolute;
            bottom: 1em;
            right: 9em;
        }
        .social-link .socialIcons a {
            text-align: center;
        }
        .social-link .socialIcons .data {
            background-color: #d1b57c;
            padding: .6em;
            border-radius: 5px;
            margin: 0 .4em;
            min-width: 28px;
        }
        .social-link .socialIcons .data .fa {
            font-size: 1.4em;
            color: #fff;
        }
        #main-content {
            padding-top: 0;
            min-height: 62vh;
            overflow: hidden;
            position: relative;
            z-index: 997;
        }

        .container, .small-contaner {
            position: relative;
            margin-left: auto;
            margin-right: auto;
            padding-left: 50px;
            padding-right: 50px;
            display: block;
        }

        .fw-section {
            width: 100%;
            position: relative;
            z-index: 0;
            min-height: 1px;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            right: -1px;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .fw-section.fw-columns {
            margin-left: auto !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            right: 0 !important;
        }
        .row.banner-entry+.without-border {
            z-index: 1;
          height: 460px;
        }

        .row, .row-special {
            width: auto;
            max-width: none;
            min-width: 0;
            margin: 0 -15px;
        }
        .vc_row.element-row.row {
            position: relative;
        }

        #main-wrapper .fw-columns .row.fw-content-wrap, #main-wrapper .fw-columns .row.video-content {
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding: 0 !important;
        }

        .banner-row .vc_col-sm-12 {
            padding: 0;
        }

        .row.pattern-bg {
            background-image: url(//n91b049m8w02ekn18iv126rm-wpengine.netdna-ssl.com/wp-content/themes/indigo-wine/img/transperent-bg.png);
            min-height: 155px;
            margin-top: -3em;
            margin-bottom: -2em;
            background-size: 22%;
        }
        .row.about-row {
            margin-top: 3em;
            margin-bottom: 1em;
        }

        .row.row-gap {
            margin: 6em 0 4em;
        }
        .mobile-menu-wrap, #mobile-menu{
          display: none;
        }

        @font-face {
            font-family: 'gotham_bookregular';
            src: url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-book-webfont.eot);
            src: url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-book-webfont.eot?#iefix) format('embedded-opentype'),url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-book-webfont.woff) format('woff'),url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-book-webfont.ttf) format('truetype'),url(//n91b049m8w02ekn18iv126rm-wpengine.netdna-ssl.com/wp-content/themes/indigo-wine/fonts/gotham-book-webfont.svg#gotham_bookregular) format('svg');
            font-weight: normal;
            font-style: normal
        }

        @font-face {
            font-family: 'gotham_lightregular';
            src: url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-light-webfont.eot);
            src: url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-light-webfont.eot?#iefix) format('embedded-opentype'),url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-light-webfont.woff) format('woff'),url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-light-webfont.ttf) format('truetype'),url(//n91b049m8w02ekn18iv126rm-wpengine.netdna-ssl.com/wp-content/themes/indigo-wine/fonts/gotham-light-webfont.svg#gotham_lightregular) format('svg');
            font-weight: normal;
            font-style: normal
        }

        @font-face {
            font-family: 'gotham_mediumregular';
            src: url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-medium-webfont.eot);
            src: url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-medium-webfont.eot?#iefix) format('embedded-opentype'),url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-medium-webfont.woff) format('woff'),url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-medium-webfont.ttf) format('truetype'),url(//n91b049m8w02ekn18iv126rm-wpengine.netdna-ssl.com/wp-content/themes/indigo-wine/fonts/gotham-medium-webfont.svg#gotham_mediumregular) format('svg');
            font-weight: normal;
            font-style: normal
        }

        @font-face {
            font-family: 'gotham_thinregular';
            src: url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-thin-webfont.eot);
            src: url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-thin-webfont.eot?#iefix) format('embedded-opentype'),url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-thin-webfont.woff) format('woff'),url(//indigowineco.com/wp-content/themes/indigo-wine/fonts/gotham-thin-webfont.ttf) format('truetype'),url(//n91b049m8w02ekn18iv126rm-wpengine.netdna-ssl.com/wp-content/themes/indigo-wine/fonts/gotham-thin-webfont.svg#gotham_thinregular) format('svg');
            font-weight: normal;
            font-style: normal
        }

        #hb-page-title .hb-image-bg-wrap {
            background-image: none !important;
            background-color: #c8cfd7;
        }
        #hb-page-title {
            padding-top: 65px;
            padding-bottom: 30px;
            color: #333;
            border-bottom: solid 1px #ebebeb;
            background-color: #fff;
            position: relative;
            margin-top: -35px;
            overflow: hidden;
                padding: 1em 0;
            margin-top: 0;
        }
        .dark-text {
            color: #111 !important;
            color: rgba(17,17,17,1) !important;
        }

        .breadcrumbs-wrapper {
            position: absolute;
            right: 50px;
            top: 50%;
            margin-top: -10px;
            display: inline-block;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
            font-size: 13px;
            -ms-word-wrap: break-word;
            word-wrap: break-word;
                width: 45%;
            text-align: right;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .hb-page-title.simple-title+.breadcrumbs-wrapper.breadcrumbs-wrapper span, .hb-page-title.light-text+.breadcrumbs-wrapper.breadcrumbs-wrapper span, .hb-page-title.simple-title+.breadcrumbs-wrapper.breadcrumbs-wrapper a, .hb-page-title.light-text+.breadcrumbs-wrapper.breadcrumbs-wrapper a{
                color: #022c4c !important;
            opacity: 1;
            font-family: 'gotham_mediumregular' !important;
            font-size: 1.05em;
            font-weight: 400;
        }

        #main-content .left-sidebar .hb-main-content.col-9 {
            float: right !important;
            padding-right: 0 !important;
            margin-right: 0 !important;
            position: relative;
            margin-left: -1px !important;
            left: 0 !important;
            padding-left: 30px !important;
            border-right: 0 !important;
            border-left: solid 1px #ebebeb;
            margin-top: -40px !important;
            padding-top: 1em;
        }

        #main-content .left-sidebar .hb-sidebar.col-3 {
            float: left !important;
            border-left: 0;
            padding-left: 0;
            margin-left: 0;
            margin-right: 0;
            right: -1px !important;
            padding-right: 30px;
            border-right: solid 1px #ebebeb;
            margin-top: -40px !important;
            padding-top: 1em;
            padding-left: 1em;
        }

        .res-count .count-store {
            text-transform: uppercase;
            font-family: gotham_bookregular;
            color: #022c4c;
            font-size: 1.05em;
        }
        .row .col-1, .row .col-2, .row .col-3, .row .col-4, .row .col-5, .row .col-6, .row .col-7, .row .col-8, .row .col-9, .row .col-10, .row .col-11, .row .col-12{
            float: left;
            min-height: 1px;
            padding: 0 15px;
           box-sizing: border-box;
            position: relative;
            margin-bottom: 20px;
        backface-visibility: hidden;
        }

        .vc_col-sm-12, .col-12 {
            float: none !important;
        }

        .row .col-12 {
            width: 100%;
        }

        input[type=text], textarea, input[type=email], input[type=password], input[type=tel], input[type=url], input[type=date], input[type=search], select {
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            padding: 12px 12px 10px !important;
            width: 100%;
            border: solid 1px #e3e3e3;
            color: #777;
            background-color: rgba(0,0,0,0.05);
            transition: all .2s linear;
            -moz-transition: all .2s linear;
            -webkit-transition: all .2s linear;
            -o-transition: all .2s linear;
            outline: 0;
        }

        .woocommerce-ordering .orderby {
            background-repeat: no-repeat;
            background-position: 100% 50%;
            background-size: 28px;
            cursor: pointer;
            font-family: gotham_lightregular;
            color: #022c4c;
            background-color: #fff;
            border: 1px solid #e1e1e1;
            border-color: #022c4c;
            font-weight: 600;
        }

        .left-sidebar .sort-count {
            display: none;
        }
        #main-content .col-9.hb-main-content {
            margin-bottom: 0 !important;
            padding-bottom: 70px;
            min-height: 470px;
            width: 71% !important;
        }

        .row .col-3 {
            width: 25%;
        }
        .hb-equal-col-height .hb-woo-product {
            margin-bottom: 25px !important;
            padding-bottom: 15px;
            -webkit-animation: none !important;
            animation: none !important;
        }

        #main-wrapper .hb-woo-product .hb-woo-image-wrap {
            overflow: hidden;
            position: relative;
            margin-bottom: 20px;
            margin-bottom: 0;
            padding: .5em;
        }
        .sub-cat {
            margin-bottom: .3em;
            color: #d1b57c;
            font-family: gotham_bookregular;
            font-size: .95em;
            min-height: 44px;
        }

        .hb-woo-product .hb-buy-button, .hb-more-details {
            position: absolute;
            bottom: -50px;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 700;
            line-height: 20px;
            letter-spacing: .5px;
            background: rgba(0,0,0,.6);
            display: block;
            width: 80%;
            left: 10%;
            padding: 8px 0;
            color: #FFF !important;
            text-align: center;
            z-index: 9999;
            opacity: 0;
            -webkit-backface-visibility: hidden;
            -moz-backface-visibility: hidden;
            -ms-backface-visibility: hidden;
        }

        .hb-product-meta-wrapper .hb-woo-product-details .woocommerce-loop-product__title {
            font-weight: 600;
            font-size: 1em;
            color: #022c4c;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-family: 'gotham_bookregular';
            margin: 0 0 .5em 0;
            -webkit-transition: all .5s ease;
            transition: all .5s ease;
            padding: 0;
            line-height: 18px;
        }

        .row.left-sidebar, .row.right-sidebar {
            margin-left: 0;
            margin-right: 0;
        }

        #main-content .left-sidebar .hb-woo-wrapper .hb-sidebar .widget-item {
            margin-bottom: 25px;
        }

        #main-content .left-sidebar .hb-sidebar .widget-item {
            padding-left: 0 !important;
        }

        .woocommerce span.onsale{display: none}

        .left-sidebar .widget-item.widget-item .product-categories li a, .left-sidebar .widget-item.widget-item .product-categories li .count {
            font-family: 'gotham_bookregular';
            font-weight: 600;
            font-size: .95em;
            color: #022c4c;
        }

        .left-sidebar .widget-item h4 {
            font-size: 14px;
            font-weight: 800;
            color: #d1b57c;
            width: 100%;
        }

        .woocommerce .price_slider_amount.price_slider_amount button.button {
            background-color: #022c4c !important;
            color: #fff !important;
            font-family: 'gotham_lightregular';
            border: 0 !important;
            padding: .5em 1.5em !important;
        }

        .filter-title .reset {
            text-decoration: underline;
            color: #022c4c;
            font-family: 'gotham_lightregular';
            font-size: 1.05em;
        }

        #main-wrapper .hb-woo-product .price, .hb-woo-shop-cats, .hb-woo-shop-cats a {
            color: #999;
        }
        .hb-product-meta .woo-cats .hb-woo-shop-cats a {
            font-size: 0.95em;
            padding-right: 0.5em;
        }

        .hb-product-meta .like-holder {
            display: none;
        }

        #slider-section {
            display: block;
            width: 100%;
            height: auto;
            position: relative;
            margin-top: -1px;
            background: #323436;
            background-repeat: no-repeat;
            background-size: cover;
            z-index: 99;
            overflow: hidden;
            height: 0;
        }

        .clearfix::before, .row::before, .hb-field-content .hb-row::before, .hb-field-content .hb-row::after, #respond::before, #respond::after, .container::before, .small-container::before, .spacer::before, .spacer::after, .small-contaner::after, .clearfix::after, .row::after, .container::after, .container-wide::before, .container-wide::after, ul.cart_list.product_list_widget li::before, ul.cart_list.product_list_widget li::after, .tagcloud::before, .tagcloud::after {
            content: '\0020';
            display: block;
            overflow: hidden;
            visibility: hidden;
            width: 0;
            height: 0;
        }
        .clearfix::after, .hb-field-content .hb-row::after, .row::after, .spacer::after, .container::after, .container-wide::after, ul.cart_list.product_list_widget li::after, #respond::after, .small-contaner::after, .tagcloud::after {
            clear: both;
        }
        #main-wrapper.hb-boxed-layout, .container {
            width: 1240px;
        }
        @media only screen and (min-width: 1920px){
          #main-wrapper.hb-boxed-layout, .container {
              width: 1360px;
          }
        }

        .owl-carousel-home-banner{
         visibility: hidden;
        }

        .owl-carousel-home-banner.owl-theme{
         visibility: visible
        }


        .mobile-menu-wrap,  #mobile-menu {
            display: none;
        }
        #header-inner {
            line-height: 80px;
            position: relative;
            width: 100%;
            height: auto !important;
        }
        #header-inner-bg {
            border: 0px;
            background-color: transparent;
            position: relative;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .ind-custom-menu .col ul {
            display: flex;
            position: relative;
            top: 7px;
        }
        .ind-custom-menu .col ul li {
            position: relative;
            padding: 0px 0.7em;
        }
        .ind-custom-menu .col ul li a {
            font-size: 0.95em;
            color: rgb(209,  181,  124);
            text-decoration: none;
        }
        .ind-custom-menu #logo {
            float: none;
            display: inline-block;
            position: relative;
            top: -10px;
            z-index: 99991;
            line-height: 80px;
            max-width: initial !important;
            height: auto !important;
        }

        #logo .hb-visible-logo img.default {
            display: none !important;
        }
        #logo img.default,  #logo img.retina {
            display: none !important;
        }
        #logo img {
            max-height: 55%;
        }
        #logo .hb-visible-logo img.retina,  #logo img.alternative-retina {
            max-width: 100%;
            height: auto;
            width: 100%;
            vertical-align: middle;
            text-align: center;
            display: inline-block !important;
        }

        #main-wrapper.hb-boxed-layout,  .container {
            width: 1240px;
        }
        input[type="text"],  textarea,  input[type="email"],  input[type="password"],  input[type="tel"],  input[type="url"],  input[type="date"],  input[type="search"],  select {
            border-radius: 0px;
            width: 100%;
            border: 1px solid rgb(227,  227,  227);
            color: rgb(119,  119,  119);
            background-color: rgba(0,  0,  0,  0.05);
            transition: all 0.2s linear;
            outline: 0px;
            padding: 12px 12px 10px !important;
        }
        #hb-page-title {
            color: rgb(51,  51,  51);
            border-bottom: 1px solid rgb(235,  235,  235);
            background-color: rgb(255,  255,  255);
            position: relative;
            overflow: hidden;
            padding: 1em 0px;
            margin-top: 0px;
        }
        #hb-page-title .hb-image-bg-wrap {
            background-color: rgb(200,  207,  215);
            background-image: none !important;
        }
        .dark-text {
            color: rgb(17,  17,  17) !important;
        }

        .hb-page-title.simple-title + .breadcrumbs-wrapper.breadcrumbs-wrapper span,  .hb-page-title.light-text + .breadcrumbs-wrapper.breadcrumbs-wrapper span,  .hb-page-title.simple-title + .breadcrumbs-wrapper.breadcrumbs-wrapper a,  .hb-page-title.light-text + .breadcrumbs-wrapper.breadcrumbs-wrapper a {
            opacity: 1;
            font-size: 1.05em;
            font-weight: 400;
            color: rgb(2,  44,  76) !important;
            font-family: gotham_mediumregular !important;
        }
        #slider-section {
            display: block;
            width: 100%;
            position: relative;
            margin-top: -1px;
            background: 0% 0% / cover no-repeat rgb(50,  52,  54);
            z-index: 99;
            overflow: hidden;
            height: 0px;
        }
        #main-content {
            padding-top: 0px;
            min-height: 62vh;
            overflow: hidden;
            position: relative;
            z-index: 997;
        }
        .row,  .row-special {
            width: auto;
            max-width: none;
            min-width: 0px;
            margin: 0px -15px;
        }

        .fw-section {
            width: 100%;
            position: relative;
            z-index: 0;
            min-height: 1px;
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            right: -1px;
            backface-visibility: hidden;
        }
        .vc_row.element-row.row {
            position: relative;
        }

        #main-content img {
            max-width: 100%;
            height: auto;
        }
        .woocommerce span.onsale {
            display: none;
        }
        .hb-product-meta .like-holder {
            display: none;
        }
      }
    </style>
  <?php } ?>
  <style type="text/css">
  <?php

    $font_weight = "400";
    $font_style = "normal";
    $font_subsets = hb_options('hb_font_body_subsets');


    // Disable Content Area if selected in Metabox settings
    if ( vp_metabox('layout_settings.hb_content_area') == 'hide' && ( !is_search() && !is_archive() )){
      echo '#main-content { display:none; }
      #slider-section { top:0px; }';
    }

    // Body Font
    if ( hb_options('hb_font_body') == 'hb_font_custom' ){
      $font_face = hb_options('hb_font_body_face');
      $font_weight = hb_options('hb_font_body_weight');
      VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
      echo 'body, .team-position, .hb-single-next-prev .text-inside, .hb-dropdown-box.cart-dropdown .buttons a, input[type=text], textarea, input[type=email], input[type=password], input[type=tel], #fancy-search input[type=text], #fancy-search .ui-autocomplete li .search-title, .quote-post-format .quote-post-wrapper blockquote, table th, .hb-button, .woocommerce #payment #place_order, .woocommerce-page #payment #place_order, input[type=submit], a.read-more, blockquote.pullquote, blockquote, .hb-skill-meter .hb-skill-meter-title, .hb-tabs-wrapper .nav-tabs li a, #main-wrapper .coupon-code input.button,#main-wrapper .form-row input.button,#main-wrapper input.checkout-button,#main-wrapper input.hb-update-cart,.woocommerce-page #main-wrapper .shipping-calculator-form-hb button.button, .hb-accordion-pane, .hb-accordion-tab {
        font-family: "' . $font_face . '", sans-serif;
        font-size: '. hb_options('hb_font_body_size') .'px;
        line-height: '. hb_options('hb_font_body_line_height') .'px;
        letter-spacing: '. hb_options('hb_font_body_letter_spacing') .'px;
        font-weight: '.$font_weight.';
      }';

      echo 'a.read-more, input[type=submit], .hb-caption-layer .hb-button, .hb-push-button-text, #pre-footer-area .hb-button, .hb-button, .hb-single-next-prev .text-inside, #main-wrapper .coupon-code input.button,#main-wrapper .form-row input.button,#main-wrapper input.checkout-button,#main-wrapper input.hb-update-cart,.woocommerce-page #main-wrapper .shipping-calculator-form-hb button.button { font-weight: 700; letter-spacing: 1px }';
    }

    // Navigation Font
    if ( hb_options('hb_font_navigation') == 'hb_font_custom' ){
      $font_subsets = hb_options('hb_font_nav_subsets');
      $font_face = hb_options('hb_font_navigation_face');
      $font_weight = hb_options('hb_font_nav_weight');
      $text_transform = "none";

      if (hb_options('hb_font_navigation_transform')){
        $text_transform = "uppercase";
      }

      VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
      echo '#hb-side-menu li a, #main-nav ul.sub-menu li a, #main-nav ul.sub-menu ul li a, #main-nav, #main-nav li a, .light-menu-dropdown #main-nav > li.megamenu > ul.sub-menu > li > a, #main-nav > li.megamenu > ul.sub-menu > li > a {
        font-family: "' . $font_face . '", sans-serif;
        font-size: '. hb_options('hb_font_navigation_size') .'px;
        letter-spacing: '. hb_options('hb_font_navigation_letter_spacing') .'px;
        font-weight: '.$font_weight.';
        text-transform: '.$text_transform.';
      }';
    }

    // Navigation Dropdown Font
    if ( hb_options('hb_font_navigation_dropdown') == 'hb_font_custom' ){
      $font_subsets = hb_options('hb_font_nav_subsets_dropdown');
      $font_face = hb_options('hb_font_navigation_face_dropdown');
      $font_weight = hb_options('hb_font_nav_weight_dropdown');
      $text_transform = "none";

      if (hb_options('hb_font_navigation_transform_dropdown')){
        $text_transform = "uppercase";
      }

      VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
      echo '#main-nav ul.sub-menu li a, #hb-side-menu ul.sub-menu li a, #main-nav ul.sub-menu ul li a, ul.sub-menu .widget-item h4, #main-nav > li.megamenu > ul.sub-menu > li > a #main-nav > li.megamenu > ul.sub-menu > li > a, #main-nav > li.megamenu > ul.sub-menu > li > a {
        font-family: "' . $font_face . '", sans-serif;
        font-size: '. hb_options('hb_font_navigation_size_dropdown') .'px;
        letter-spacing: '. hb_options('hb_font_navigation_letter_spacing_dropdown') .'px;
        font-weight: '.$font_weight.';
        text-transform: '.$text_transform.';
      }';
    }

    // Copyright Font
    if ( hb_options('hb_font_copyright') == 'hb_font_custom' ){
      $font_subsets = hb_options('hb_font_copyright_subsets');
      $font_face = hb_options('hb_font_copyright_face');
      $font_weight = hb_options('hb_font_copyright_weight');
      VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
      echo '#copyright-wrapper, #copyright-wrapper a {
        font-family: "' . $font_face . '", sans-serif;
        font-size: '. hb_options('hb_font_copyright_size') .'px;
        line-height: '. hb_options('hb_font_copyright_line_height') .'px;
        letter-spacing: '. hb_options('hb_font_copyright_letter_spacing') .'px;
        font-weight: '.$font_weight.';
      }';
    }

    // Heading 1
    if ( hb_options('hb_font_h1') == 'hb_font_custom' ){
      $font_subsets = hb_options('hb_font_h1_subsets');
      $font_face = hb_options('hb_font_h1_face');
      $font_weight = hb_options('hb_font_h1_weight');
      VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
      echo 'h1, article.single h1.title, #hb-page-title .light-text h1, #hb-page-title .dark-text h1 {
        font-family: "' . $font_face . '", sans-serif;
        font-size: '. hb_options('hb_font_h1_size') .'px;
        line-height: '. hb_options('hb_font_h1_line_height') .'px;
        letter-spacing: '. hb_options('hb_font_h1_letter_spacing') .'px;
        font-weight: '.$font_weight.';
      }';
    }

    // Heading 2
    if ( hb_options('hb_font_h2') == 'hb_font_custom' ){
      $font_subsets = hb_options('hb_font_h2_subsets');
      $font_face = hb_options('hb_font_h2_face');
      $font_weight = hb_options('hb_font_h2_weight');
      VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
      echo 'h2, #hb-page-title h2, .post-content h2.title {
        font-family: "' . $font_face . '", sans-serif;
        font-size: '. hb_options('hb_font_h2_size') .'px;
        line-height: '. hb_options('hb_font_h2_line_height') .'px;
        letter-spacing: '. hb_options('hb_font_h2_letter_spacing') .'px;
        font-weight: '.$font_weight.';
      }';
    }

    // Heading 3
    if ( hb_options('hb_font_h3') == 'hb_font_custom' ){
      $font_subsets = hb_options('hb_font_h3_subsets');
      $font_face = hb_options('hb_font_h3_face');
      $font_weight = hb_options('hb_font_h3_weight');
      VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
      echo 'h3, h3.title-class, .hb-callout-box h3, .hb-gal-standard-description h3 {
        font-family: "' . $font_face . '", sans-serif;
        font-size: '. hb_options('hb_font_h3_size') .'px;
        line-height: '. hb_options('hb_font_h3_line_height') .'px;
        letter-spacing: '. hb_options('hb_font_h3_letter_spacing') .'px;
        font-weight: '.$font_weight.';
      }';
    }

    // Heading 4
    if ( hb_options('hb_font_h4') == 'hb_font_custom' ){
      $font_subsets = hb_options('hb_font_h4_subsets');
      $font_face = hb_options('hb_font_h4_face');
      $font_weight = hb_options('hb_font_h4_weight');
      VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
      echo 'h4, .widget-item h4, #respond h3, .content-box h4, .feature-box h4.bold {
        font-family: "' . $font_face . '", sans-serif;
        font-size: '. hb_options('hb_font_h4_size') .'px;
        line-height: '. hb_options('hb_font_h4_line_height') .'px;
        letter-spacing: '. hb_options('hb_font_h4_letter_spacing') .'px;
        font-weight: '.$font_weight.';
      }';
    }

    // Heading 5
    if ( hb_options('hb_font_h5') == 'hb_font_custom' ){
      $font_subsets = hb_options('hb_font_h5_subsets');
      $font_face = hb_options('hb_font_h5_face');
      $font_weight = hb_options('hb_font_h5_weight');
      VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
      echo 'h5, #comments h5, #respond h5, .testimonial-author h5 {
        font-family: "' . $font_face . '", sans-serif;
        font-size: '. hb_options('hb_font_h5_size') .'px;
        line-height: '. hb_options('hb_font_h5_line_height') .'px;
        letter-spacing: '. hb_options('hb_font_h5_letter_spacing') .'px;
        font-weight: '.$font_weight.';
      }';
    }

    // Heading 6
    if ( hb_options('hb_font_h6') == 'hb_font_custom' ){
      $font_subsets = hb_options('hb_font_h6_subsets');
      $font_face = hb_options('hb_font_h6_face');
      $font_weight = hb_options('hb_font_h6_weight');
      VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
      echo 'h6, h6.special {
        font-family: "' . $font_face . '", sans-serif;
        font-size: '. hb_options('hb_font_h6_size') .'px;
        line-height: '. hb_options('hb_font_h6_line_height') .'px;
        letter-spacing: '. hb_options('hb_font_h6_letter_spacing') .'px;
        font-weight: '.$font_weight.';
      }';
    }

    // Pre-Footer Callout
    if ( hb_options('hb_pre_footer_font') == 'hb_font_custom' ){
      $font_subsets = hb_options('hb_font_pre_footer_subsets');
      $font_face = hb_options('hb_pre_footer_font_face');
      $font_weight = hb_options('hb_font_pre_footer_weight');
      VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
      echo '#pre-footer-area {
        font-family: "' . $font_face . '", sans-serif;
        font-size: '. hb_options('hb_pre_footer_font_size') .'px;
        line-height: '. hb_options('hb_pre_footer_line_height') .'px;
        letter-spacing: '. hb_options('hb_pre_footer_letter_spacing') .'px;
        font-weight: '.$font_weight.';
      }';
    }

    // Modern Title
    if ( hb_options('hb_font_modern_title') == 'hb_font_custom' ){
      $font_subsets = hb_options('hb_font_modern_title_subsets');
      $font_face = hb_options('hb_font_modern_title_face');
      $font_weight = hb_options('hb_font_modern_title_weight');
      $text_transform = "none";
      if (hb_options('hb_font_modern_title_transform')){
        $text_transform = "uppercase";
      }
      VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style, $font_subsets);
      echo 'h1.modern,h2.modern,h3.modern,h4.modern,h5.modern,h6.modern {
        font-family: "' . $font_face . '", sans-serif;
        letter-spacing: '. hb_options('hb_font_modern_title_letter_spacing') .'px;
        font-weight: '.$font_weight.';
        text-transform: '.$text_transform.';
      }';
    }

    VP_Site_GoogleWebFont::instance()->register_and_enqueue();
  ?>
  </style>

  </head>
  <!-- END head -->

  <?php

    global $woocommerce;

        $cart_count=$cart_url="";
        if ( class_exists('Woocommerce') ){
            global $woocommerce;
            $cart_url = $woocommerce->cart->get_cart_url();
            $cart_count = $woocommerce->cart->cart_contents_count;
        }

        $search_in_header = ' data-search-header=0';
        if ( hb_options('hb_search_in_menu') ){
            $search_in_header = ' data-search-header=1';
        }

    $hb_layout_class = hb_options('hb_global_layout');
    if ( vp_metabox('misc_settings.hb_boxed_stretched_page') == 'hb-boxed-layout' ) {
      $hb_layout_class = 'hb-boxed-layout';
    } else if ( vp_metabox('misc_settings.hb_boxed_stretched_page') == 'hb-stretched-layout' ){
      $hb_layout_class = 'hb-stretched-layout';
    }


    $fixed_footer_data = hb_options('hb_fixed_footer_effect');
    $fixed_footer_class = ' data-fixed-footer="0"';

    if ( $fixed_footer_data ){
      $fixed_footer_class = ' data-fixed-footer="1"';
    }


    $bg_image_render = "";

    if ( hb_options('hb_global_layout') == 'hb-boxed-layout' || vp_metabox('misc_settings.hb_boxed_stretched_page') == 'hb-boxed-layout' || ( isset($_GET['layout']) && $_GET['layout'] == 'boxed') ){
      $bg_url = hb_options('hb_default_background_image');
      $bg_repeat = ' background-repeat: ' . hb_options('hb_background_repeat') . ';';
      $bg_attachment = ' background-attachment: ' . hb_options('hb_background_attachment') . ';';
      $bg_position = ' background-position: ' . hb_options('hb_background_position') . ';';
      $bg_size = ' background-size: auto auto;';

      if ( hb_options('hb_background_stretch') ){
        $bg_size = " background-size: cover;";
      }

      if( hb_options('hb_default_background_image') && hb_options('hb_upload_or_predefined_image') == 'upload-image' ) {
        $bg_url = hb_options('hb_default_background_image');
        $bg_image_render = ' style="background-image: url('. $bg_url .');' . $bg_repeat . $bg_attachment . $bg_position . $bg_size . '"';
      }

      if ( hb_options('hb_upload_or_predefined_image') == 'predefined-texture' ) {
        $bg_image_render = ' style="background-image: url('. hb_options('hb_predefined_bg_texure') .'); background-repeat:repeat; background-position: center center; background-attachment:scroll; background-size:initial;"';
      }

      if ( vp_metabox('background_settings.hb_background_page_settings') == "image" && vp_metabox('background_settings.hb_page_background_image') ) {
        $bg_url = vp_metabox('background_settings.hb_page_background_image');
        $bg_image_render = ' style="background-image: url('. $bg_url .');' . $bg_repeat . $bg_attachment . $bg_position . $bg_size . '"';
      }

      if ( vp_metabox('background_settings.hb_background_page_settings') == "color" ) {
        $bg_image_render = ' style="background-color: ' . vp_metabox('background_settings.hb_page_background_color') . ';';
      }
    }

    $extra_body_class = vp_metabox('misc_settings.hb_page_extra_class');
    if ( hb_options('hb_queryloader') == 'ytube-like' ){
      $extra_body_class .= ' hb-preloader';
    }

    if ( vp_metabox('misc_settings.hb_special_header_style') ){
      $extra_body_class .= ' hb-special-header-style';
    }

    if ( hb_options('hb_header_layout_style') == "left-panel" ) {
      $extra_body_class .= ' hb-side-navigation';
    }

    if ( hb_options('hb_side_section') ) {
      $extra_body_class .= ' has-side-section';
    }

    // Check if transparent side menu is selected
    if ( hb_options('hb_side_nav_style') == 'hb-side-transparent' ){
      $extra_body_class .= ' transparent-side-navigation';
    }

    // Check if animation for side menu is selected
    if (hb_options('hb_side_nav_with_animation')){
      $extra_body_class .= ' side-navigation-with-animation';
    }

    // Check if alternative sidebar
    if (hb_options('hb_sidebar_style') == 'hb-alt-sidebar')
      $extra_body_class .= ' hb-alt-sidebar';

    // Check sidebar size
    if ( hb_options('hb_sidebar_size') == 'hb-sidebar-20' )
      $extra_body_class .= ' hb-sidebar-20';

    // Check if modern search
    if ( hb_options('hb_search_style') == 'hb-modern-search')
      $extra_body_class .= ' hb-modern-search';

    if ( hb_module_enabled ('hb_module_prettyphoto') )
      {
        $extra_body_class .= ' highend-prettyphoto';
      } else {
        $extra_body_class .= ' disable-native-prettyphoto';
      }

    $extra_body_class .= ' ' . $hb_layout_class;

  ?>

  <!-- START body -->
  <body <?php body_class($extra_body_class); echo $fixed_footer_class; echo $bg_image_render; ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">

<!--google analytics code start -->
   <script>
   (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
   (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
   m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
   })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

   ga('create', 'UA-106147638-1', 'auto');
   ga('send', 'pageview');

  </script>
 <!--google analytics code end -->
  <?php
  if ( hb_options('hb_queryloader') == 'circle-spinner' ) { ?>
    <!-- <div id="hb-preloader"> -->

      <!--<div class="spinner"></div>-->
      <!-- <span class="default-loading-icon"></span> -->

    <!-- </div> -->

    <!-- Hex loader -->

    <div class="spin-wrap" id="hb-preloader">
      <div class="hex">
        <div class="hex-spinner"></div>
        <div class="hex-inner"></div>
      </div>
      <svg width="0" height="0">
        <defs>
          <clipPath id="clip-shape" clipPathUnits="objectBoundingBox">
            <polygon points="0.5 0, 1.0 0.25, 1.0 0.75, 0.5 1.0, 0 0.75, 0 0.25" />
          </clipPath>
        </defs>
      </svg>
    </div>

  <?php } ?>

  <?php
  // MAP UTILS
    global $hb_gmap;
    $hb_gmap = null;

    // Check if options are ok
    $hb_gmap = array();

    $hb_gmap[1]['lat'] = hb_options('hb_map_1_latitude');
    $hb_gmap[1]['lng'] = hb_options('hb_map_1_longitude');
    $hb_gmap[1]['ibx'] = hb_options('hb_location_1_info');

    $count = 1;
    for($i = 2; $i <= 10; $i++){
        if( hb_options('hb_enable_location_' . $i) ) {
            $count++;
            $hb_gmap[$count]['lat'] = hb_options('hb_map_' . $i . '_latitude');
            $hb_gmap[$count]['lng'] = hb_options('hb_map_' . $i . '_longitude');
            $hb_gmap[$count]['ibx'] = hb_options('hb_location_' . $i . '_info');
        }
    }

    function json_hb_map() {
        global $hb_gmap;
        return $hb_gmap;
    }

    wp_localize_script( 'hb_map', 'hb_gmap', json_hb_map() );
  ?>

  <?php

    $page_global_layout = vp_metabox('misc_settings.hb_boxed_stretched_page');
    if ( $page_global_layout != "default" && $page_global_layout && !is_search() && !is_archive() ) {
      $hb_layout_class = $page_global_layout;
    }

    if ( isset($_GET['layout']) && $_GET['layout'] == 'boxed' ){
      $hb_layout_class = 'hb-boxed-layout';
    }

    $hb_shadow_class = "no-shadow";
    if ( hb_options('hb_boxed_shadow') ){
      $hb_shadow_class = "with-shadow";
    }

    $hb_content_width = "width-1140";
    if ( hb_options('hb_content_width') == '940px' ){
      $hb_content_width = "width-940";
    } else if ( hb_options('hb_content_width') == 'fw-100' ) {
      $hb_content_width = "fw-100";
    }

    $hb_logo_alignment = "";
    if ( hb_options('hb_header_layout_style') != "nav-type-2 centered-nav" )
      $hb_logo_alignment = hb_options('hb_logo_alignment');

    $sticky_shop_button = "";
    if ( hb_options('hb_enable_sticky_shop_button') && class_exists('Woocommerce') ){
      $sticky_shop_button = " with-shop-button";
    }

    $hb_resp = "";
    if ( hb_options('hb_responsive') ) {
      $hb_resp = " hb-responsive";
    }

    $hb_logo_alignment = hb_options('hb_logo_alignment');

    $footer_separator = "";
    if ( hb_options('hb_enable_footer_separators') ) {
      $footer_separator = " with-footer-separators";
    }

  ?>

  <?php
    if (hb_options('hb_responsive')){
      echo hb_mobile_menu();
    }
  ?>


  <?php if ( hb_options('hb_header_layout_style') == "left-panel" &&  !is_page_template('page-blank.php') ) {
    get_template_part('includes/header' , 'side-nav');
  } ?>


  <!-- BEGIN #hb-wrap -->
  <div id="hb-wrap">

  <!-- BEGIN #main-wrapper -->
  <div id="main-wrapper" class="<?php if ( vp_metabox('misc_settings.hb_onepage') ) { echo 'hb-one-page '; } echo $hb_layout_class; echo $footer_separator; echo ' ' . hb_options('hb_boxed_layout_type'); echo $hb_logo_alignment; echo ' ' . $hb_shadow_class; echo $hb_logo_alignment; echo ' ' . $hb_content_width; echo $sticky_shop_button . $hb_resp; echo ' ' . hb_options('hb_header_layout_style'); ?>" data-cart-url="<?php echo $cart_url; ?>" data-cart-count="<?php echo $cart_count; ?>" <?php echo $search_in_header; ?>>

    <?php
    $additional_class = "";
    if ( hb_options('hb_header_layout_style') == "nav-type-1 nav-type-4" ) {
        $additional_class .= "special-header";
    }
    if ( !hb_options('hb_top_header_bar') ) {
      $additional_class .= " without-top-bar";
    }
    ?>

    <?php if ( !is_page_template('page-blank.php') ) {
      if ( hb_options('hb_header_layout_style') != "left-panel" ) { ?>
        <!-- BEGIN #hb-header -->
        <header id="hb-header" class="<?php echo $additional_class; ?>">

          <?php get_template_part( 'includes/header' , 'top-bar' ); ?>
          <?php get_template_part( 'includes/header' , 'navigation' ); ?>

        </header>
        <!-- END #hb-header -->

        <?php get_template_part ( 'includes/header' , 'page-title' );
      } ?>
      <?php get_template_part( 'includes/header' , 'slider-section'); ?>
    <?php } ?>