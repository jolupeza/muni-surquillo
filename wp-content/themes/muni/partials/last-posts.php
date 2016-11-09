<?php
  $args = array(
    'posts_per_page' => 3,
    'category_name' => 'novedades'
  );
  $the_query = new WP_Query($args);
  if ($the_query->have_posts()) :
?>
  <section class="Page">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="Title text--blue h1">Últimas noticias</h2>
        </div><!-- end col-xs-12 -->
      </div><!-- end row -->

      <section class="Boxes">
        <?php while ($the_query->have_posts()) : ?>
          <?php $the_query->the_post(); ?>
          <article class="Box">
            <p><span></span><?php the_time('F j, Y'); ?></p>
            <h4 class="Box-title"><?php the_title(); ?></h4>
            <?php the_content(''); ?>
            <p class="text-uppercase"><a href="<?php the_permalink(); ?>">Seguir leyendo</a></p>
          </article><!-- end Box -->
        <?php endwhile; ?>
      </section><!-- end Boxes -->

      <p class="text-center"><a href="<?php echo home_url('novedades'); ?>" class="Button Button--transp Button--blue">Ver más noticias</a></p>
    </div><!-- end container -->
  </section><!-- end Page -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>
