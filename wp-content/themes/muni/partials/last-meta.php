<?php
  $pageParent = get_page_by_title('Metas Municipales');

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
  <div class="article About-item">
    <section class="About--flex">
      <?php
        $values = get_post_custom(get_the_id());
        $responsive = isset( $values['mb_responsive'] ) ? esc_attr($values['mb_responsive'][0]) : '';
      ?>
      <?php if (has_post_thumbnail()) : ?>
        <figure class="Figure">
          <img src="<?php echo $responsive; ?>" alt="" class="img-responsive center-block" />
        </figure>
      <?php endif; ?>
      <article class="About-info">
        <h3 class="Subtitle text--blue text-center"><?php the_title(); ?></h3>
        <?php the_content(''); ?>

        <p class="text-center"><a href="<?php the_permalink(); ?>" class="Button Button--transp Button--blue">Ver metas</a></p>
      </article>
    </section>
  </div><!-- end About-item -->

<?php endwhile; ?>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
