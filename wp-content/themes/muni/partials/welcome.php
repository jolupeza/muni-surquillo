<?php
  $args = array(
    'posts_per_page' => 1,
    'post_type' => 'page',
    'name' => 'bienvenido-a-surquillo'
  );

  $the_query = new WP_Query($args);
  if ($the_query->have_posts()) :
    while ($the_query->have_posts()) :
      $the_query->the_post();
?>
      <div class="article About-item">
        <h2 class="Title text--blue h1"><?php the_title(); ?></h2>
        <?php the_content(); ?>
      </div><!-- end About-item -->
<?php endwhile; ?>
<?php endif; ?>
