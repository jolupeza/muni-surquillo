<?php
  /*
  Template Name: Service Page
  */
?>
<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <?php
      $idPage = get_the_id();
      $values = get_post_custom($idPage);

      $responsive = isset( $values['mb_responsive'] ) ? esc_attr($values['mb_responsive'][0]) : '';
    ?>
    <?php if (has_post_thumbnail()) : ?>
      <figure class="Page-image Page-image--full">
        <picture>
          <?php if (!empty($responsive)) : ?>
              <source class="img-responsive center-block" media="(max-width: 767px)" srcset="<?php echo $responsive; ?>">
            <?php endif; ?>
            <?php the_post_thumbnail('full', array('class' => 'img-responsive center-block')); ?>
        </picture>
      </figure>
    <?php endif; ?>

      <section class="Page Page--blue">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <?php the_content(); ?>
            </div><!-- end col-md-12 -->
          </div><!-- end row -->
  <?php endwhile; ?>
<?php endif; ?>

          <?php
            $firstService = 0;
            global $wpdb;

            $services = $wpdb->get_results("SELECT tt.term_taxonomy_id, t.term_id, t.name FROM $wpdb->term_taxonomy tt INNER JOIN $wpdb->terms t ON tt.term_id = t.term_id WHERE tt.taxonomy = 'services' ORDER BY t.term_id DESC");
            if (count($services)) :
              $i = 0;
          ?>
            <nav class="Page-nav Page-nav--box text-center">
              <ul>
                <?php foreach ($services as $service) : ?>
                  <?php
                    $active = ($i === 0) ? 'active' : '';
                    $firstService = ($i === 0) ? $service->term_id : $firstService;
                  ?>
                  <li class="<?php echo $active; ?> js-menu-services">
                    <a href="" data-id="<?php echo $service->term_id; ?>"><?php echo $service->name; ?></a>
                  </li>
                  <?php $i++; ?>
                <?php endforeach; ?>
              </ul>
            </nav><!-- end Page-nav -->

            <section class="Page-body Page-body--services">
              <div class="Page-body-loader text-center hidden">
                <span class="glyphicon glyphicon-repeat animated rotateIn" aria-hidden="true"></span>
              </div>

              <?php
                if ($firstService > 0) :
                  $args = [
                    'post_type' => 'page',
                    'posts_per_page' => 6,
                    'tax_query' => array(
                      array(
                        'taxonomy' => 'services',
                        'terms' => $firstService
                      )
                    ),
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                  ];
                  $the_query = new WP_Query($args);
                  if ($the_query->have_posts()) :
              ?>
                    <section class="Cards-wrapper">
                      <section class="Cards">
                        <?php while ($the_query->have_posts()) : ?>
                          <?php
                            $the_query->the_post();
                            $values = get_post_custom(get_the_id());
                            $icon = isset($values['mb_icon']) ? esc_attr($values['mb_icon'][0]) : '';
                          ?>
                          <article class="Card-item">
                            <?php if (!empty($icon)) : ?>
                              <i class="icons <?php echo $icon; ?>"></i>
                            <?php endif; ?>

                            <h3 class="Card-title Title text--white"><?php the_title(); ?></h3>
                            <?php the_content(''); ?>
                            <p><a href="<?php the_permalink(); ?>">Ver más</a></p>
                          </article>
                        <?php endwhile; ?>
                      </section><!-- end Cards -->

                      <?php
                        $total = $the_query->max_num_pages;
                        if ($total > 1) :
                          $format = '';
                          $page = 1;
                      ?>
                        <nav aria-label="Page navigation" class="Page-navigation Page-navigation--white text-center" id="js-nav-services">
                          <?php
                            echo paginate_links(array(
                              'base'      =>    '/' . $firstService,
                              'format'    =>    $format,
                              'current'   =>    $page,
                              'prev_next' =>    True,
                              'prev_text' =>    '&laquo;',
                              'next_text' =>    '&raquo;',
                              'total'     =>    $total,
                              'show_all'  =>    TRUE,
                              'type'      =>    'list'
                            ));
                          ?>
                        </nav>
                      <?php endif; ?>
                    </section><!-- end Cards-wrapper -->
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
              <?php endif; ?>
            </section><!-- end Page-body -->
          <?php endif; ?>
        </div><!-- end container -->
      </section><!-- end Page -->

      <section class="Page Page--details Page--girl Page--girl--small">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2 class="Title text--blue h1">Contáctanos</h2>
              <p>Si tienes alguna consulta, duda o reclamo escríbenos para poder ayudarte</p>

              <p>
                <a href="<?php echo home_url('contacto'); ?>" class="Button Button--transp Button--blue Button--full">Deseo ingresar mi consulta</a>
              </p>
            </div><!-- end col-md-8 -->
          </div><!-- end row -->
        </div><!-- end container -->
      </section><!-- end Page -->

<?php get_footer(); ?>
