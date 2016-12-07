<?php
  $pageParent = get_page_by_title('Contacto');

  $args = array(
    'posts_per_page' => 1,
    'post_type' => 'page',
    'p' => $pageParent->ID
  );
  $the_query = new WP_Query($args);
  if ($the_query->have_posts()) :
    while ($the_query->have_posts()) :
      $the_query->the_post();
?>
      <section class="Page Page--details Page--girl Page--girl--small Page--gray">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2 class="Title text--blue h1"><?php the_title(); ?></h2>
              <?php if (has_excerpt()) : ?>
                <?php the_excerpt(); ?>
              <?php endif; ?>

              <p>
                <a href="<?php the_permalink(); ?>" class="Button Button--transp Button--blue Button--full">Deseo ingresar mi consulta</a>
              </p>
            </div><!-- end col-md-8 -->
          </div><!-- end row -->
        </div><!-- end container -->
      </section><!-- end Page -->
  <?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
