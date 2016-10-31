<?php
  $pageParent = get_page_by_title('Metas');

  $args = array(
    'posts_per_page' => 1,
    'post_type' => 'page',
    'post_parent' => $pageParent->ID,
  );
  $the_query = new WP_Query($args);
  if ($the_query->have_posts()) :
    while ($the_query->have_posts()) :
      $the_query->the_post();
?>
  <div class="article About-item">
    <figure class="Figure">
      <img src="http://placehold.it/380x217/0054A6/fff/" alt="" class="img-responsive center-block">
    </figure>
    <h3 class="Subtitle text--blue text-center"><?php the_title(); ?></h3>
    <?php the_content(''); ?>
    <p class="text-center"><a href="<?php the_permalink(); ?>" class="Button Button--transp Button--blue">Ver metas</a></p>
  </div><!-- end About-item -->

<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
