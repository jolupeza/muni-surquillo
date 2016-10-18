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
    <!-- <div class="LoaderWrapper">
      <div id="loader" class="animated bounce infinite"></div>
      <div id="loadingbar"></div>
    </div> --><!-- end LoaderWrapper -->

    <header class="Header">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <?php
              $custom_logo_id = get_theme_mod('custom_logo');
              $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
            ?>
            <h1 class="Header-logo">
              <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
                <img src="<?php echo $logo[0]; ?>" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
              </a>
            </h1>
          </div><!-- end col-md-3 -->
          <div class="col-md-9">
            <?php
              $args = array(
                'theme_location' => 'main-menu',
                'container' => 'nav',
                'container_class' => 'Header-nav text-center',
                'menu_class' => 'Header-menu list-inline',
              );
              wp_nav_menu( $args );
            ?>
          </div><!-- end col-md-9 -->
        </div><!-- end row -->
      </div><!-- end container -->
    </header><!-- end Header -->
