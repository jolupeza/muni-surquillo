<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>

    <?php
      $values = get_post_custom(get_the_id());
      $responsive = isset( $values['mb_responsive'] ) ? esc_attr($values['mb_responsive'][0]) : '';
    ?>

    <?php if (has_post_thumbnail()) : ?>
      <?php $category = get_the_category(); ?>

      <figure class="Single-figure">
        <picture>
            <?php if (!empty($responsive)) : ?>
                <source class="img-responsive center-block" media="(max-width: 767px)" srcset="<?php echo $responsive; ?>">
              <?php endif; ?>
              <?php the_post_thumbnail('full', array('class' => 'img-responsive center-block')); ?>
          </picture>

        <h4 class="Single-category Button Button--blueBg text-uppercase"><?php echo $category[0]->name; ?></h4>
      </figure><!-- end Single-figure -->
    <?php endif; ?>

    <section class="Page Page--nopadding">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
              <article class="Single">
                  <h2 class="Title text--blue h2"><?php the_title(); ?></h2>

                  <?php
                    $values = get_post_custom(get_the_id());
                    $videoSingle = isset($values['mb_video']) ? esc_attr($values['mb_video'][0]) : '';
                    $images = isset($values['mb_images']) ?  $values['mb_images'][0]  :  '';

                    $sliders = false;
                    if (!empty($images)) {
                      $images = unserialize($images);
                      $sliders = true;
                    }
                  ?>

                  <figure class="Single-gallery text-center">
                    <?php if (!empty($videoSingle)) : ?>
                      <script>
                        var heightVideo = '270',
                            widthVideo = '480';

                        if (window.innerWidth < 500) {
                          heightVideo = '240';
                          widthVideo = '320';
                        }

                        playerInfoList.push({
                          id: '<?php echo get_the_id(); ?>',
                          idPlayer: 'player<?php echo get_the_id(); ?>',
                          height: heightVideo,
                          width: widthVideo,
                          videoId: '<?php echo $videoSingle; ?>'
                        });
                      </script>
                      <div class="Single-video" id="player<?php echo get_the_id(); ?>"></div>
                    <?php elseif ($sliders) : ?>
                      <?php $i = 0; $j = 0; ?>
                      <div id="carousel-single" class="carousel slide Carousel Carousel--single" data-ride="carousel">
                        <?php if (count($images) > 1) : ?>
                          <ol class="carousel-indicators text-center">
                            <?php foreach ($images as $image) : ?>
                              <?php $active = ($i === 0) ? 'active' : ''; ?>
                              <li data-target="#carousel-single" data-slide-to="<?php echo $i ?>" class="<?php echo $active; ?>"></li>
                              <?php $i++; ?>
                            <?php endforeach; ?>
                          </ol>
                        <?php endif; ?>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                          <?php foreach ($images as $image) : ?>
                            <?php $active = ($j === 0) ? 'active' : ''; ?>
                            <div class="item <?php echo $active; ?>">
                              <img class="img-responsive center-block" src="<?php echo $image; ?>" />
                            </div>
                            <?php $j++; ?>
                          <?php endforeach; ?>
                        </div>

                        <?php if (count($images) > 1) : ?>
                          <a class="left carousel-control" href="#carousel-single" role="button" data-slide="prev">
                            <i class="icons icon-arrow_left"></i>
                            <span class="sr-only">Previous</span>
                          </a>
                          <a class="right carousel-control" href="#carousel-single" role="button" data-slide="next">
                            <i class="icons icon-arrow_right"></i>
                            <span class="sr-only">Next</span>
                          </a>
                        <?php endif; ?>
                      </div>
                    <?php endif; ?>
                  </figure>

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

        <?php /*
        <aside class="Sidebar">
          <article class="Sidebar-widget Sidebar-widget--noMargin">
            <ul class="Sidebar-widget-links">
              <li><a href=""><img class="img-responsive center-block" src="images/resources/link1-widget.jpg" alt=""></a></li>
              <li><a href=""><img class="img-responsive center-block" src="images/resources/link2-widget.jpg" alt=""></a></li>
            </ul>
          </article><!-- end Sidebar-widget -->
        </aside><!-- end Sidebar -->
        */ ?>

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
