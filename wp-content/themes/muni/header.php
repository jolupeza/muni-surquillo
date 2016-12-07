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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Script required for extra functionality on the comment form -->
    <?php if (is_singular()) wp_enqueue_script( 'comment-reply' ); ?>

    <!-- Api Youtube -->
    <script>
      var tag = document.createElement('script');

      tag.src = "https://www.youtube.com/iframe_api";
      var firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

      var playerInfoList = [];
    </script>

    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <?php $options = get_option('muni_custom_settings'); ?>
    <header class="Header">
      <nav class="Header-navTop text-right hidden-xs hidden-sm">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <?php
                $args = [
                  'theme_location' => 'top-menu',
                  'container' => 'nav',
                  'container_class' => 'Menu-top-wrapper',
                  'menu_class' => 'Menu-top list-inline',
                ];
                wp_nav_menu( $args );
              ?>
              <?php if (isset($options['display_social_link']) && $options['display_social_link']) : ?>
                <nav class="Menu-social-wrapper">
                  <ul class="Menu-social list-inline">
                    <?php if (!empty($options['facebook'])) : ?>
                      <li><a href="<?php echo $options['facebook']; ?>" title="Síguenos en Facebook" target="_blank" rel="noopener noreferrer"><i class="icons icon-facebook"></i></a></li>
                    <?php endif; ?>
                    <?php if (!empty($options['linkedin'])) : ?>
                      <li><a href="<?php echo $options['linkedin']; ?>" title="Síguenos en Linkedin" target="_blank" rel="noopener noreferrer"><i class="icons icon-linkedin"></i></a></li>
                    <?php endif; ?>
                    <?php if (!empty($options['youtube'])) : ?>
                      <li><a href="<?php echo $options['youtube']; ?>" title="Síguenos en Youtube" target="_blank" rel="noopener noreferrer"><i class="icons icon-youtube"></i></a></li>
                    <?php endif; ?>
                  </ul><!-- end Menu-social -->
                </nav><!-- end Menu-social-wrapper -->
              <?php endif; ?>

              <button type="button" class="Header-buttonSearch" id="js-display-search">
                <i class="icons icon-search"></i>
              </button>

              <div class="Header-search">
                <form class="Search text-center" action="<?php echo home_url(); ?>" method="get">
                  <input name="s" id="s" type="text" class="form-control Search-input" placeholder="Escribe el término a buscar" autocomplete="off" />

                  <button class="Search-button" type="submit">
                    <i class="icons icon-search"></i>
                  </button>
                  <button class="Search-button" type="button" id="js-close-search">
                    <span class="glyphicon glyphicon-remove"></span>
                  </button>
                </form><!-- end Search -->
              </div><!-- end Header-search -->
            </div><!-- end col-md-12 -->
          </div><!-- end row -->
        </div><!-- end container -->
      </nav><!-- end Header-navTop -->

      <div class="container">
        <button class="Header-navToggle js-toggle-slidebar">
          <i class="Icon Icon--navToggle"></i>
        </button>

        <div class="row">
          <div class="col-sm-2 col-sm-push-10 col-md-5 col-md-push-0">
            <?php
              $custom_logo_id = get_theme_mod('custom_logo');
              $logo = wp_get_attachment_image_src($custom_logo_id, 'full');
              $logoMovil = (isset($options['logo_movil']) && !empty($options['logo_movil'])) ? $options['logo_movil'] : IMAGES . '/logo-escudo.png';
            ?>
            <h1 class="Header-logo">
              <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
                <picture>
                  <source media="(min-width: 992px)" srcset="<?php echo $logo[0]; ?>">
                  <img src="<?php echo $logoMovil; ?>" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
                </picture>
              </a>
            </h1>
          </div><!-- end col-md-5 -->
          <?php if (!empty($options['phone']) || !empty($options['phone_alert'])) : ?>
            <div class="hidden-xs col-sm-10 col-sm-pull-2 col-md-7 col-md-pull-0">
              <div class="Header-central-wrapper text-right">
                <?php if (!empty($options['phone'])) : ?>
                  <aside class="Header-central">
                    <i class="Header-central-icon icons icon-phone text--red"></i>
                    <span>Central Telefónica <b><?php echo $options['phone']; ?></b></span>
                  </aside>
                <?php endif; ?>

                <?php if (!empty($options['phone_alert'])) : ?>
                  <aside class="Header-central">
                    <i class="Header-central-icon icons icon-phone text--green"></i>
                    <span>Seguridad Ciudadana <b><?php echo $options['phone_alert']; ?></b></span>
                  </aside>
                <?php endif; ?>
              </div><!-- end Header-central-wrapper -->
            </div><!-- end col-md-7 -->
          <?php endif; ?>
        </div><!-- end row -->
      </div><!-- end container -->

      <div class="container hidden-xs hidden-sm">
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

    <section class="Slidebar">
      <aside class="Slidebar-close js-toggle-slidebar">
        <i class="glyphicon glyphicon-remove"></i>
      </aside><!-- end Slidebar-close -->

      <?php
        $args = [
          'theme_location' => 'main-menu',
          'container' => 'nav',
          'container_class' => 'Slidebar-nav',
          'menu_class' => 'Slidebar-list',
        ];
        wp_nav_menu( $args );
      ?>

      <?php
        $args = [
          'theme_location' => 'top-menu',
          'container' => 'nav',
          'container_class' => 'Menu-top-wrapper text-center',
          'menu_class' => 'Menu-top list-inline',
        ];
        wp_nav_menu( $args );
      ?>

      <?php if (isset($options['display_social_link']) && $options['display_social_link']) : ?>
        <nav class="Menu-social-wrapper text-center">
          <ul class="Menu-social list-inline">
            <?php if (!empty($options['facebook'])) : ?>
              <li><a href="<?php echo $options['facebook']; ?>" title="Síguenos en Facebook" target="_blank" rel="noopener noreferrer"><i class="icons icon-facebook"></i></a></li>
            <?php endif; ?>
            <?php if (!empty($options['linkedin'])) : ?>
              <li><a href="<?php echo $options['linkedin']; ?>" title="Síguenos en Linkedin" target="_blank" rel="noopener noreferrer"><i class="icons icon-linkedin"></i></a></li>
            <?php endif; ?>
            <?php if (!empty($options['youtube'])) : ?>
              <li><a href="<?php echo $options['youtube']; ?>" title="Síguenos en Youtube" target="_blank" rel="noopener noreferrer"><i class="icons icon-youtube"></i></a></li>
            <?php endif; ?>
          </ul><!-- end Menu-social -->
        </nav><!-- end Menu-social-wrapper -->
      <?php endif; ?>

      <?php if (!empty($options['phone']) || !empty($options['phone_alert'])) : ?>
        <div class="Header-central-wrapper text-center">
          <?php if (!empty($options['phone'])) : ?>
            <aside class="Header-central">
              <i class="Header-central-icon icons icon-phone text--red"></i>
              <span>Central Telefónica <b><?php echo $options['phone']; ?></b></span>
            </aside>
          <?php endif; ?>

          <?php if (!empty($options['phone_alert'])) : ?>
            <aside class="Header-central">
              <i class="Header-central-icon icons icon-phone text--green"></i>
              <span>Seguridad Ciudadana <b><?php echo $options['phone_alert']; ?></b></span>
            </aside>
          <?php endif; ?>
        </div><!-- end Header-central-wrapper -->
      <?php endif; ?>
    </section><!-- end Slidebar -->
