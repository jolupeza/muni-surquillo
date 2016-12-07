<?php
  /*
  Template Name: Service Locals Page
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
      $bg = isset( $values['mb_bg'] ) ? esc_attr($values['mb_bg'][0]) : '';
      $locales = isset($values['mb_locales']) ? $values['mb_locales'][0] : '';
    ?>
    <?php if (has_post_thumbnail()) : ?>
      <figure class="Page-image Page-image--full">
        <picture>
          <?php if (!empty($responsive)) : ?>
              <source class="img-responsive center-block" media="(max-width: 767px)" srcset="<?php echo $responsive; ?>">
            <?php endif; ?>
            <?php the_post_thumbnail('full', array('class' => 'img-responsive center-block')); ?>
        </picture>
        <div class="Page-image-title">
          <h2 class="text--white Title h1">
            <?php if (has_excerpt()) : ?>
              <?php echo get_the_excerpt(); ?>
            <?php else : ?>
              <?php the_title(); ?>
            <?php endif; ?>
          </h2>
        </div>
      </figure>
    <?php endif; ?>

    <section class="Page Page--details Page--locals" style="background-image: url('<?php echo $bg; ?>');">
      <div class="container">
        <ul class="Page-breadcrumbs">
          <li><a href="<?php echo home_url(); ?>">Inicio</a></li>
          <li><a href="<?php echo home_url('servicios-y-tramites'); ?>">Servicios y trámites</a></li>
          <li><?php the_title(); ?></li>
        </ul>

        <div class="row">
          <div class="col-md-8">
            <article class="Page-locals">
              <h2 class="Title text--blue h1">Sobre el servicio o trámite</h2>
              <?php the_content(); ?>
            </article><!-- end Page-services -->
          </div><!-- end col-md-8 -->

          <div class="col-md-4"></div>
        </div><!-- end row -->
      </div><!-- end container -->
    </section><!-- end Page -->

    <?php if (!empty($locales)) : ?>
      <?php
        $locales = unserialize($locales);
      ?>
      <section class="Page-medium Page-locals">
        <div class="container Page-medium-wrapper">
          <h2 class="h1 Title text-center text--white">Nuestros Locales</h2>

          <section class="Page-body Page-body--noMinHeight Flex Flex--box">
            <?php
              foreach ($locales as $local => $value) :
                $args = array(
                  'post_type' => 'locales',
                  'p' => $local,
                  'posts_per_page' => 1,
                  'order' => 'ASC',
                  'orderby' => 'menu_order',
                );
                $the_query = new WP_Query($args);
                if ($the_query->have_posts()) :
                  while ($the_query->have_posts()) :
                    $the_query->the_post();

                    $idLocal = get_the_ID();
                    $values = get_post_custom($idLocal);
                    $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
                    $address = isset($values['mb_address']) ? esc_attr($values['mb_address'][0]) : '';
            ?>
                  <article class="Flex-item Flex-25 text-center">
                    <?php if (has_post_thumbnail()) : ?>
                      <figure class="Local-figure">
                        <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block']); ?>
                      </figure><!-- end Local-figure -->
                    <?php endif; ?>
                    <h3 class="Title-bold text-center text--white"><?php the_title(); ?></h3>

                    <div class="panel-group Panels Panels--locals" id="accordion-locals<?php echo $idLocal; ?>" role="tablist" aria-multiselectable="true">
                      <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading-<?php echo $idLocal; ?>-1">
                          <h4 class="panel-title Title-bold">
                            <a role="button" data-toggle="collapse" data-parent="#accordion-locals<?php echo $idLocal; ?>" href="#collapse-<?php echo $idLocal; ?>-1" aria-expanded="true" aria-controls="collapse-<?php echo $idLocal; ?>-1">Horarios</a>
                          </h4>
                        </div>
                        <div id="collapse-<?php echo $idLocal; ?>-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $idLocal; ?>1">
                          <div class="panel-body text-center">
                            <?php the_content(); ?>
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading-<?php echo $idLocal; ?>-2">
                          <h4 class="panel-title Title-bold">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-locals<?php echo $idLocal; ?>" href="#collapse-<?php echo $idLocal; ?>-2" aria-expanded="false" aria-controls="collapse-<?php echo $idLocal; ?>-2">
                              Central Telefónica
                            </a>
                          </h4>
                        </div>
                        <div id="collapse-<?php echo $idLocal; ?>-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php echo $idLocal; ?>-2">
                          <div class="panel-body text-center">
                            <?php if (!empty($phone)) : ?>
                              <p><?php echo $phone; ?></p>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading-<?php echo $idLocal; ?>-3">
                          <h4 class="panel-title Title-bold">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion-locals<?php echo $idLocal; ?>" href="#collapse-<?php echo $idLocal; ?>-3" aria-expanded="false" aria-controls="collapse-<?php echo $idLocal; ?>-3">
                              Dirección
                            </a>
                          </h4>
                        </div>
                        <div id="collapse-<?php echo $idLocal; ?>-3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php echo $idLocal; ?>-3">
                          <div class="panel-body text-center">
                            <?php if (!empty($address)) : ?>
                              <p><?php echo $address; ?></p>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </article>
                <?php endwhile; ?>
              <?php endif; ?>
              <?php wp_reset_postdata(); ?>
          <?php endforeach; ?>
          </section>
        </div>
      </section>
    <?php endif; ?>

  <?php endwhile; ?>
<?php endif; ?>

<?php
  $filepath = TEMPLATEPATH . '/includes/services-contact.php';
  if (file_exists($filepath)) {
    include $filepath;
  }
?>

<?php get_footer(); ?>
