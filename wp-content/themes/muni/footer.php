<?php $options = get_option('muni_custom_settings'); ?>

    <section class="Prefooter">
      <div class="container">
        <div class="row">
          <?php if (!empty($options['address']) || !empty($options['phone'])) : ?>
            <div class="col-md-3">
              <aside class="Prefooter-sidebar">
                <h3 class="h5 text-uppercase Page-title t-black">Municipalidad</h3>
                <?php if (!empty($options['address'])) : ?>
                  <p><span class="t-legend">Dirección:</span> <?php echo $options['address']; ?></p>
                <?php endif; ?>

                <?php if (!empty($options['phone'])) : ?>
                  <p><span class="t-legend">Central Telefónica:</span> <?php echo $options['phone']; ?></p>
                <?php endif; ?>
              </aside>
            </div>
          <?php endif; ?>
          <div class="col-md-3">
            <aside class="Prefooter-sidebar">
              <h3 class="h5 text-uppercase Page-title t-black">Enlaces</h3>

              <?php
                $args = array(
                  'theme_location' => 'links-menu',
                );
                wp_nav_menu( $args );
              ?>
            </aside>
          </div>
          <div class="col-md-3">
            <aside class="Prefooter-sidebar">
              <h3 class="h5 text-uppercase Page-title t-black">Últimas noticias</h3>
              <ul class="Widget-LastPosts">
                <li>
                  <h4><a href="">Recuerdan 75 años de la inmolación del héroe Capitán Alfredo Novoa Cava</a></h4>
                  <p class="Widget-LastPosts-time">12 Sep 2016</p>
                </li>
                <li>
                  <h4><a href="">Ciento treinta vecinos brigadistas ecológicos juramentan en Lince</a></h4>
                  <p class="Widget-LastPosts-time">08 Sep 2016</p>
                </li>
                <li>
                  <h4><a href="">Charla de cómo armonizar el trabajo y la familia</a></h4>
                  <p class="Widget-LastPosts-time">08 Sep 2016</p>
                </li>
                <li>
                  <h4><a href="">A la vuelta de la Esquina - Reportaje de nuestro Distrito de Lince</a></h4>
                  <p class="Widget-LastPosts-time">06 Sep 2016</p>
                </li>
              </ul>
            </aside>
          </div>
          <div class="col-md-3">
            <aside class="Prefooter-sidebar">
              <h3 class="h5 text-uppercase Page-title t-black">Módulos Web</h3>
              <?php
                $args = array(
                  'theme_location' => 'module-menu',
                );
                wp_nav_menu( $args );
              ?>
            </aside>
          </div>
        </div>
      </div>
    </section><!-- end Prefooter -->

    <footer class="Footer">
      <p class="text-center t-white t-s">Todos los Derechos Reservados &copy; Municipalida de Surquillo</p>
    </footer>

    <!-- <button class="ArrowTop text-hide">Ir a arriba</button> -->

    <script>
      var _root_ = '<?php echo home_url(); ?>'
    </script>

    <?php wp_footer(); ?>
  </body>
</html>
