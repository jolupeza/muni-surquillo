<?php get_header(); ?>

<?php
  if (file_exists(TEMPLATEPATH . '/partials/sliders.php')) {
    include TEMPLATEPATH . '/partials/sliders.php';
  }
?>

<div class="container">
  <section class="About">
    <?php
      $filepath = TEMPLATEPATH . '/partials/welcome.php';
      if (file_exists($filepath)) {
        include $filepath;
      }
    ?>

    <div class="article About-item">
      <figure class="Figure">
        <img src="http://placehold.it/380x217/0054A6/fff/" alt="" class="img-responsive center-block">
      </figure>
      <h3 class="Subtitle text--blue text-center">Metas período 2016 - II</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione neque quo praesentium odit aspernatur aliquam quisquam nemo quaerat voluptatem sit ipsam repudiandae voluptate vero, excepturi, esse totam! Officiis, beatae quae?</p>
      <p class="text-center"><a href="" class="Button Button--transp Button--blue">Ver metas</a></p>
    </div><!-- end About-item -->
    <div class="article About-item About-item--skyblue">
      <h3 class="Subtitle text--white text-center">Programas y eventos</h3>
      <figure class="Figure">
        <img src="http://placehold.it/380x217/85a71e/fff/" alt="" class="img-responsive center-block">
      </figure>
      <h4 class="Subtitle text--white">Programa Ponte Pilas</h4>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde aut, corrupti incidunt architecto earum praesentium iste accusantium nemo tempora dolorem, distinctio officiis tenetur harum optio suscipit atque. Alias, magnam esse?</p>
      <p><a href="">ver programa</a></p>
    </div><!-- end About-item -->
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
