
<?php
  $backgroundImage = '';
  if (has_post_thumbnail()) {
    $backgroundImage = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()), 'full')[0];
  }
?>
<section class="Page Page--gray Page--details Page--bg" style="background-image: url('<?php echo $backgroundImage; ?>');">
  <div class="container">
    <div class="row">
      <div class="col-md-6">

      </div><!-- end col-md-6 -->
      <div class="col-md-6">
        <h2 class="Title text--blue h1 text-right"><?php the_title(); ?></h2>
        <?php the_content(); ?>

        <p class="text-right text--nimportant">
          <a href="" class="Button Button--transp Button--blue">Ver reseña histórica ></a>
        </p>
      </div><!-- end col-md-4 -->
    </div><!-- end row -->
  </div><!-- end container -->
</section><!-- end Page -->
