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
?>
  <nav aria-label="Page navigation" class="Page-navigation Page-navigation--white text-center" id="js-nav-services">
    <?php
      echo paginate_links(array(
        'base'      =>    '/' . $service,
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
