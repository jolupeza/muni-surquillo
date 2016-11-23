<?php
  $prevPost = get_previous_post(true);
  $nextPost = get_next_post(true);

  if (!empty($prevPost) || !empty($nextPost)) :
?>

  <h3 class="Title text--blue"><span>Noticias relacionadas</span></h3>
  <section class="Boxes Boxes--wrap">
    <?php
      // Posts previous
      if (!empty($prevPost)) :
        $permalink = get_permalink($prevPost->ID);
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($prevPost->ID), 'post-thumb')[0];

        $style = '';
        $withBg = '';

        if ($image) {
          $style = 'style="background-image: url(' . $image . '); background-size: cover; background-repeat: no-repeat;"';
          $withBg = 'Box--white';
        }
      ?>
        <article class="Box Box--50 <?php echo $withBg; ?>" <?php echo $style; ?>>
          <p><span></span><?php echo get_the_time('F j, Y', $prevPost); ?></p>
          <h4 class="Box-title"><?php echo $prevPost->post_title; ?></h4>
          <p><?php echo getSubString($prevPost->post_content, 200); ?></p>
          <p class="text-uppercase"><a href="<?php echo $permalink; ?>">Seguir leyendo</a></p>
        </article><!-- end Single-related-item -->
    <?php endif; ?>

    <?php
      // Posts next
      if (!empty($nextPost)) :
        $permalink = get_permalink($nextPost->ID);
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($nextPost->ID), 'post-thumb')[0];

        $style = '';
        $withBg = '';

        if ($image) {
          $style = 'style="background-image: url(' . $image . '); background-size: cover; background-repeat: no-repeat;"';
          $withBg = 'Box--white';
        }
    ?>
        <article class="Box Box--50 <?php echo $withBg; ?>" <?php echo $style; ?>>
          <p><span></span><?php echo get_the_time('F j, Y', $nextPost); ?></p>
          <h4 class="Box-title"><?php echo $nextPost->post_title; ?></h4>
          <p><?php echo getSubString($nextPost->post_content, 200); ?></p>
          <p class="text-uppercase"><a href="<?php echo $permalink; ?>">Seguir leyendo</a></p>
        </article><!-- end Single-related-item -->
    <?php endif; ?>

  </section><!-- end Boxes -->
<?php endif; ?>
