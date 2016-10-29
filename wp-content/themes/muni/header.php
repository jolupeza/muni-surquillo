<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />

    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
      <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>

    <script>
      // Picture element HTML5 shiv
      // document.createElement( "picture" );
    </script>
    <!-- <script src="lib/picturefill/dist/picturefill.js" async></script> -->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Script required for extra functionality on the comment form -->
    <?php if (is_singular()) wp_enqueue_script( 'comment-reply' ); ?>

    <?php wp_head(); ?>
  </head>
  <body>
    <?php $options = get_option('muni_custom_settings'); ?>
    <!-- <div class="LoaderWrapper">
      <div id="loader" class="animated bounce infinite"></div>
      <div id="loadingbar"></div>
    </div> --><!-- end LoaderWrapper -->

    <header class="Header">
      <nav class="Header-navTop text-right">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <?php
                $args = [
                  'theme_location' => 'top-menu',
                  // 'container' => 'nav',
                  // 'container_class' => 'Header-mainMenu text-center',
                  'menu_class' => 'Menu-top list-inline',
                ];
                wp_nav_menu( $args );
              ?>
              <ul class="Menu-social list-inline">
                <li class="Menu-social-fb"><a href="">f</a></li>
                <li class="Menu-social-lnk"><a href="">in</a></li>
                <li class="Menu-social-you"><a href="">y</a></li>
              </ul><!-- end Menu-social -->
            </div><!-- end col-md-12 -->
          </div><!-- end row -->
        </div><!-- end container -->
      </nav><!-- end Header-navTop -->

      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <?php
              $custom_logo_id = get_theme_mod('custom_logo');
              $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            ?>
            <h1 class="Header-logo">
              <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
                <img src="<?php echo $logo[0]; ?>" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
              </a>
            </h1>
          </div><!-- end col-md-6 -->
          <?php if (!empty($options['phone'])) : ?>
            <div class="col-md-6">
              <aside class="Header-central">
                <i class="Header-central-icon Icon Icon--phone"></i>
                <span>Central Telefónica <b><?php echo $options['phone']; ?></b></span>
              </aside>
            </div><!-- end col-md-6 -->
          <?php endif; ?>
        </div><!-- end row -->
      </div><!-- end container -->

      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <?php
              $args = [
                'theme_location' => 'main-menu',
                'container' => 'nav',
                'container_class' => 'Header-mainMenu text-center',
                'menu_class' => 'Menu-main list-inline',
              ];
              wp_nav_menu( $args );
            ?>
          </div><!-- end col-md-12 -->
        </div><!-- end row -->
      </div><!-- end container -->
    </header><!-- end Header -->
