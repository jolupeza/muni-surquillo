<?php
/***********************************************************************************************/
/* Template for the default post format */
/***********************************************************************************************/
?>
<article class="Box Box--50">
  <p><span></span><?php the_time('F j, Y'); ?></p>
  <h4 class="Box-title"><?php the_title(); ?></h4>
  <?php the_content(''); ?>
  <p class="text-uppercase"><a href="<?php the_permalink(); ?>">Seguir leyendo</a></p>
</article>
