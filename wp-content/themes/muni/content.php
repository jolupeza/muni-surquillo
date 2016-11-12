<?php
/***********************************************************************************************/
/* Template for the default post format */
/***********************************************************************************************/
?>
<?php
  $style = '';
  $withBg = '';
  if (has_post_thumbnail()) {
    $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()), 'post-thumb')[0];
    $style = 'style="background-image: url(' . $image . '); background-size: cover; background-repeat: no-repeat;"';
    $withBg = 'Box--white';
  }
?>
<article class="Box Box--50 <?php echo $withBg; ?>" <?php echo $style; ?>>
  <p><span></span><?php the_time('F j, Y'); ?></p>
  <h4 class="Box-title"><?php the_title(); ?></h4>
  <?php the_content(''); ?>
  <p class="text-uppercase"><a href="<?php the_permalink(); ?>">Seguir leyendo</a></p>
</article>
