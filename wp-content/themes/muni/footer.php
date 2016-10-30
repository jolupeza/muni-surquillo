<?php $options = get_option('muni_custom_settings'); ?>

    <footer class="Footer">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <?php
              $logo = (!empty($options['logo'])) ? $options['logo'] : IMAGES . '/logo-footer.png';
            ?>
            <h3 class="Footer-logo text-center">
              <a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
                <img class="img-responsive center-block" src="<?php echo $logo; ?>" alt="<?php bloginfo('name'); ?> | <?php bloginfo('description'); ?>">
              </a>
            </h3><!-- end Footer-logo -->

            <?php if (!empty($options['desc'])) : ?>
              <p class="text--white"><?php echo $options['desc']; ?></p>
            <?php endif; ?>
          </div><!-- end col-md-4 -->
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-6">
                <h3 class="text--white Title">Enlaces</h3>
                <?php
                  $args = [
                    'theme_location' => 'footer-link-menu',
                    'menu_class' => 'Footer-list',
                  ];
                  wp_nav_menu( $args );
                ?>
              </div>
              <div class="col-md-6">
                <h3 class="text--white Title">Servicios</h3>
                <?php
                  $args = [
                    'theme_location' => 'footer-service-menu',
                    'menu_class' => 'Footer-list',
                  ];
                  wp_nav_menu( $args );
                ?>
              </div>
            </div>
          </div><!-- end col-md-4 -->
          <div class="col-md-4">
            <h3 class="text--white Title">Suscríbete</h3>
            <p class="text--white">Suscríbete y entérate de las últimas novedades, eventos, actividades y nuevas ordenanzas.</p>

            <form class="Form" id="js-form-subs" method="POST">
              <div class="Footer-loader text-center hidden" id="js-form-subs-loader">
                <span class="animated infinite glyphicon glyphicon-refresh text--white" aria-hidden="true"></span>
              </div>
              <p class="text-center text--white" id="js-form-subs-msg"></p>

              <div class="form-group">
                <label for="email" class="sr-only">Correo electrónico</label>
                <div class="input-group">
                  <input type="email" name="email" id="email" class="form-control" placeholder="Ingresa tu correo electrónico" aria-describedby="basic-email" required>
                  <span class="input-group-addon" id="basic-email"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></span>
                </div>
              </div><!-- end form-group -->

              <p class="text-center">
                <button type="submit" class="Button Button--transp Button--white text-uppercase">Suscribirme</button>
              </p>
            </form>
          </div><!-- end col-md-4 -->
        </div><!-- end row -->
      </div><!-- end container -->

      <div class="Footer-copy">
        <div class="container">
          <p class="text-center text--white text--s">Copyright &copy; 2009 - <?php echo date('Y'); ?>. All rights reserved.</p>
        </div>
      </div>
    </footer><!-- end Footer -->

    <!-- <button class="ArrowTop text-hide">Ir a arriba</button> -->

    <script>
      var _root_ = '<?php echo home_url(); ?>'
    </script>

    <?php wp_footer(); ?>
  </body>
</html>
