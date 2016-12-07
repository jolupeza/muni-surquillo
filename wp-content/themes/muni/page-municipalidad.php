<?php
/*
  Template Name: Municipalidad Page
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

    <?php
      $args = [
        'post_type' => 'page',
        'post_parent' => $idPage,
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'posts_per_page' => -1
      ];
      $mainQuery = new WP_Query($args);

      if ($mainQuery->have_posts()) :
        $i = 0;
    ?>
    <section class="Flex Flex--page">
      <?php while ($mainQuery->have_posts()) : ?>
        <?php $mainQuery->the_post(); ?>
        <?php $color = ($i === 0) ? 'Flex-gray' : 'Flex-skyBlue'; ?>
        <article class="Flex-item Flex-50 <?php echo $color; ?>">
          <h2 class="h1 Title"><?php the_title(); ?></h2>
          <?php the_content(); ?>
        </article>
        <?php $i++; ?>
      <?php endwhile; ?>
    </section>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>

    <?php
      $args = [
        'post_type' => 'authorities',
        'posts_per_page' => 1,
        'meta_query' => array(
          array(
            'key' => 'mb_job',
            'value' => 'Alcalde'
          )
        )
      ];
      $the_query = new WP_Query($args);
      if ($the_query->have_posts()) :
        while ($the_query->have_posts()) :
          $the_query->the_post();
    ?>
          <section class="Page Page--details">
            <div class="container">
              <div class="row">
                <div class="col-md-12">
                  <h2 class="Title text--blue h1">Nuestro Alcalde</h2>
                  <div class="row">
                    <div class="col-md-6">
                      <?php if (has_post_thumbnail()) : ?>
                        <figure>
                          <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block']); ?>
                        </figure>
                      <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                      <?php the_content(); ?>
                    </div>
                  </div>
                </div><!-- end col-md-8 -->
              </div><!-- end row -->
            </div><!-- end container -->
          </section><!-- end Page -->
      <?php endwhile; ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>

    <section class="Page Page--blue1">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <?php
              $firstRole = 0;
              global $wpdb;

              $roles = $wpdb->get_results("SELECT tt.term_taxonomy_id, t.term_id, t.name FROM $wpdb->term_taxonomy tt INNER JOIN $wpdb->terms t ON tt.term_id = t.term_id WHERE tt.taxonomy = 'roles' ORDER BY t.term_id DESC");
              if (count($roles)) :
                $i = 0;
            ?>
              <nav class="Page-nav text-center">
                <ul>
                  <?php foreach ($roles as $rol) : ?>
                    <?php
                      $active = ($i === 0) ? 'active' : '';
                      $firstRole = ($i === 0) ? $rol->term_id : $firstRole;
                    ?>
                    <li class="<?php echo $active; ?> js-menu-authorities">
                      <a href="" data-id="<?php echo $rol->term_id; ?>"><?php echo $rol->name; ?></a>
                    </li>
                    <?php $i++; ?>
                  <?php endforeach; ?>
                </ul>
              </nav><!-- end Page-nav -->

              <section class="Page-body Page-body--minHeight">
                <div class="Page-body-loader text-center hidden">
                  <span class="glyphicon glyphicon-repeat animated rotateIn" aria-hidden="true"></span>
                </div>

                <?php
                  if ($firstRole > 0) :
                    $args = [
                      'post_type' => 'authorities',
                      'posts_per_page' => 4,
                      'tax_query' => array(
                        array(
                          'taxonomy' => 'roles',
                          'terms' => $firstRole
                        )
                      ),
                      'orderby' => 'menu_order',
                      'order' => 'ASC'
                    ];
                    $the_query = new WP_Query($args);
                    if ($the_query->have_posts()) :
                ?>
                    <section class="Page-authorities">
                      <section class="Flex Flex--box">
                        <?php while ($the_query->have_posts()) : ?>
                          <?php $the_query->the_post(); ?>
                          <?php
                            $values = get_post_custom( get_the_ID() );
                            $job = isset($values['mb_job']) ? esc_attr($values['mb_job'][0]) : '';
                            $email = isset($values['mb_email']) ?  $values['mb_email'][0]  :  '';
                            $phone = isset($values['mb_phone']) ?  $values['mb_phone'][0]  :  '';
                            $address = isset($values['mb_address']) ?  $values['mb_address'][0]  :  '';
                          ?>
                          <article class="Flex-item Flex-25 text-center">
                            <?php if (has_post_thumbnail()) : ?>
                              <figure class="Flex-figure">
                                <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block']); ?>
                              </figure>
                            <?php endif; ?>
                            <h3 class="Title-semi text--white"><?php the_title(); ?></h3>
                            <?php if (!empty($job)) : ?>
                              <p class="text--white text--n"><?php echo $job; ?></p>
                            <?php endif; ?>
                            <?php if (!empty($email)) : ?>
                              <p class="text--white text--n">
                                <a class="text--white" href="mailto:<?php echo $email; ?>"><i class="icon icon-contacto"></i> <?php echo $email; ?></a>
                              </p>
                            <?php endif; ?>
                            <?php if (!empty($phone)) : ?>
                              <p class="text--white text--n">Teléfono: <?php echo $phone; ?></p>
                            <?php endif; ?>
                            <?php if (!empty($address)) : ?>
                              <p class="text--white text--n">Dirección: <?php echo $address; ?></p>
                            <?php endif; ?>
                          </article>
                        <?php endwhile; ?>
                      </section>

                      <?php
                        $total = $the_query->max_num_pages;
                        if ($total > 1) :
                          $format = '';
                          $page = 1;
                      ?>
                          <nav aria-label="Page navigation" class="Page-navigation Page-navigation--white text-center" id="js-nav-authorities">
                            <?php
                              echo paginate_links(array(
                                'base'      =>    '/' . $firstRole,
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
                    </section><!-- end Page-authorities -->
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>
                <?php endif; ?>
              </section><!-- end Page-body -->
            <?php endif; ?>
          </div><!-- end col-md-12 -->
        </div><!-- end row -->
      </div><!-- end container -->
    </section><!-- end Page -->

  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
