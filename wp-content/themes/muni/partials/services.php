<?php
  $pageParent = get_page_by_title('Servicios Municipales');

  $args = array(
    'posts_per_page' => 5,
    'post_type' => 'page',
    'post_parent' => $pageParent->ID,
    'order' => 'ASC',
    'orderby' => 'menu_order'
  );
  $the_query = new WP_Query($args);
  if ($the_query->have_posts()) :
?>
  <section class="Page Page--blue Page--girl">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="Title text--white h1">Servicios Municipales</h2>
        </div><!-- end col-xs-12 -->
      </div><!-- end row -->

      <section class="Cards">
        <?php while ($the_query->have_posts()) : ?>
          <?php $the_query->the_post(); ?>
          <article class="Card-item">
            <h3 class="Card-title Title text--white"><?php the_title(); ?></h3>
            <?php the_content(''); ?>
            <p><a href="<?php the_permalink(); ?>">Ver servicio</a></p>
          </article>
        <?php endwhile; ?>
      </section>

      <p class="text-center"><a href="" class="Button Button--transp Button--white">Ver más servicios ></a></p>
    </div><!-- end container -->
  </section><!-- end Page -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>
