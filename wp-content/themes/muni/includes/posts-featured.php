<?php
  $sticky = get_option('sticky_posts');
  if (count($sticky)) :
    $args = array(
      'posts_per_page' => -1,
      'post__in' => $sticky,
      'ignore_sticky_posts' => 1,
      'post_status' => 'publish'
    );
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) :
      $i = 0; $j = 0;
?>

<section id="carousel-novedades" class="carousel slide Carousel Carousel--novedades" data-ride="carousel">
  <?php if ($the_query->post_count > 1) : ?>
    <ol class="carousel-indicators">
      <?php while ($the_query->have_posts()) : ?>
        <?php $the_query->the_post(); ?>
        <?php $active = ($i === 0) ? 'active' : ''; ?>
        <li data-target="#carousel-novedades" data-slide-to="<?php echo $i; ?>" class="<?php echo $active; ?>"></li>
        <?php $i++; ?>
      <?php endwhile; ?>
      <li data-target="#carousel-novedades" data-slide-to="1"></li>
    </ol><!-- end Carousel-indicators -->
  <?php endif; ?>

  <div class="carousel-inner" role="listbox">
    <?php while ($the_query->have_posts()) : ?>
      <?php $the_query->the_post(); ?>
      <?php $active = ($j === 0) ? 'active' : ''; ?>
      <?php $category = get_the_category(); ?>

      <?php if (has_post_thumbnail()) : ?>
        <div class="item <?php echo $active; ?>">
          <?php the_post_thumbnail('full', array('class' => 'img-responsive center-block')); ?>
          <div class="carousel-caption">
            <h3 class="Carousel-category text--white text-uppercase"><?php echo $category[0]->name; ?></h3>
            <h2 class="Carousel-captionTitle text-uppercase"><?php the_title(); ?></h2>
            <p><a href="<?php the_permalink(); ?>" class="Button Button--transp Button--white text-uppercase">Seguir leyendo ></a></p>
          </div><!-- end Carousel-caption -->
        </div><!-- end Carousel-item -->
      <?php endif; ?>
      <?php $j++; ?>
    <?php endwhile; ?>
  </div><!-- end Carousel-inner -->
</section><!-- end Carousel -->
  <?php endif; ?>
<?php endif; wp_reset_postdata(); ?>
