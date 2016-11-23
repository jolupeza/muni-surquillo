
<?php
  $backgroundImage = '';
  if (has_post_thumbnail()) {
    $backgroundImage = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()), 'full')[0];
  }
?>
<section class="Page Page--gray Page--details Page--flex Page--nopadding">
  <figure class="Page-flex50">
    <img class="img-responsive" src="<?php echo $backgroundImage; ?>" />
  </figure>
  <article class="Page-flex40">
    <h2 class="Title text--blue h1 text-right"><?php the_title(); ?></h2>
    <?php the_content(); ?>

    <p class="text-right text--nimportant">
      <a href="" class="Button Button--transp Button--blue">Ver reseña histórica ></a>
    </p>
  </article><!-- end Page-flex50 -->
</section><!-- end Page -->
