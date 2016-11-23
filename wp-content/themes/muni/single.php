<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>

    <?php if (has_post_thumbnail()) : ?>
      <?php $category = get_the_category(); ?>

      <figure class="Single-figure">
        <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block']); ?>

        <h4 class="Single-category Button Button--blueBg text-uppercase"><?php echo $category[0]->name; ?></h4>
      </figure><!-- end Single-figure -->
    <?php endif; ?>

    <section class="Page Page--nopadding">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
              <article class="Single">
                  <h2 class="Title text--blue h2"><?php the_title(); ?></h2>

                  <?php the_content(); ?>

              </article>
  <?php endwhile; ?>
<?php endif; ?>

          <?php
            $filePostsRelated = TEMPLATEPATH . '/includes/posts-related.php';
            if (file_exists($filePostsRelated)) {
              include $filePostsRelated;
            }
          ?>

          </div><!-- end col-md-8 -->
      <div class="col-md-4">
        <aside class="Sidebar Sidebar--gray">

          <?php get_sidebar('main-sidebar'); ?>

        </aside><!-- end Sidebar -->

        <aside class="Sidebar">
          <article class="Sidebar-widget Sidebar-widget--noMargin">
            <ul class="Sidebar-widget-links">
              <li><a href=""><img class="img-responsive center-block" src="images/resources/link1-widget.jpg" alt=""></a></li>
              <li><a href=""><img class="img-responsive center-block" src="images/resources/link2-widget.jpg" alt=""></a></li>
            </ul>
          </article><!-- end Sidebar-widget -->
        </aside><!-- end Sidebar -->

        <?php
          $filePath = TEMPLATEPATH . '/includes/last-programs.php';
          if (file_exists($filePath)) {
            include $filePath;
          }
        ?>
      </div>
    </div>
  </div><!-- end container -->
</section><!-- end Page -->

<?php get_footer(); ?>
