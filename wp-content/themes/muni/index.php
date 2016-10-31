<?php get_header(); ?>

<?php
  if (file_exists(TEMPLATEPATH . '/partials/sliders.php')) {
    include TEMPLATEPATH . '/partials/sliders.php';
  }
?>

<div class="container">
  <section class="About" id="about">
    <?php
      $filepath = TEMPLATEPATH . '/partials/welcome.php';
      if (file_exists($filepath)) {
        include $filepath;
      }
    ?>

    <?php
      $filepath = TEMPLATEPATH . '/partials/last-meta.php';
      if (file_exists($filepath)) {
        include $filepath;
      }
    ?>

    <?php
      $filepath = TEMPLATEPATH . '/partials/programas-eventos.php';
      if (file_exists($filepath)) {
        include $filepath;
      }
    ?>
  </section><!-- end About -->
</div><!-- end container -->

<?php
  $filepath = TEMPLATEPATH . '/partials/services.php';
  if (file_exists($filepath)) {
    include $filepath;
  }
?>

<?php
  $filepath = TEMPLATEPATH . '/partials/last-posts.php';
  if (file_exists($filepath)) {
    include $filepath;
  }
?>

<?php get_footer(); ?>
