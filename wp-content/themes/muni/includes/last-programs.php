<?php
  $args = array(
    'posts_per_page' => 3,
    'category_name' => 'novedades'
  );

  if (is_single()) {
    global $post;
    $args['post__not_in'] = [$post->ID];
  }

  $the_query = new WP_Query($args);
  if ($the_query->have_posts()) :
    $i = 0; $j = 0;
?>
  <aside class="Sidebar Sidebar--skyBlue">
    <h3 class="Sidebar-widget-title Sidebar-widget-title--noborder text--white">Últimas Novedades</h3>

    <section class="About--flex">
      <div id="carousel-programs-events" class="carousel slide Carousel Carousel--programs" data-ride="carousel" data-interval="10000">
        <?php
          if ($the_query->post_count > 1) {
            $total = 0;
            while ($the_query->have_posts()) {
              $the_query->the_post();
              $values = get_post_custom(get_the_id());
              $video = isset($values['mb_video']) ? esc_attr($values['mb_video'][0]) : '';

              if (isset($videoSingle)) {
                if ($videoSingle !== $video) {
                  $total++;
                }
              } else {
                $total = $the_query->post_count;
              }
            }
          }
        ?>

        <?php if ($total > 1) : ?>
          <ol class="carousel-indicators text-center">
            <?php while ($the_query->have_posts()) : ?>
              <?php $the_query->the_post(); ?>
              <?php $active = ($i === 0) ? 'active' : ''; ?>
              <?php
                $values = get_post_custom(get_the_id());
                $video = isset($values['mb_video']) ? esc_attr($values['mb_video'][0]) : '';

                if (isset($videoSingle)) {
                  if ($videoSingle === $video) {
                    continue;
                  }
                }
              ?>
              <li data-target="#carousel-programs-events" data-slide-to="<?php echo $i; ?>" class="<?php echo $active; ?>"></li>
              <?php $i++; ?>
            <?php endwhile; ?>
          </ol>
        <?php endif; ?>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <?php while ($the_query->have_posts()) : ?>
            <?php
              $the_query->the_post();
              $active = ($j === 0) ? 'active' : '';
              $values = get_post_custom(get_the_id());
              $video = isset($values['mb_video']) ? esc_attr($values['mb_video'][0]) : '';

              if (isset($videoSingle)) {
                if ($videoSingle === $video) {
                  continue;
                }
              }
            ?>
              <div class="item <?php echo $active; ?>">
                <figure class="Figure text-center">
                  <?php if (!empty($video)) : ?>
                    <script>
                      playerInfoList.push({
                        id: '<?php echo get_the_id(); ?>',
                        idPlayer: 'player<?php echo get_the_id(); ?>',
                        height: '240',
                        width: '320',
                        videoId: '<?php echo $video; ?>'
                      });
                    </script>
                    <div class="Page-video" id="player<?php echo get_the_id(); ?>"></div>
                  <?php elseif (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('post-thumb', ['class' => 'img-responsive center-block']); ?>
                  <?php endif; ?>
                </figure>
                <article class="About-info">
                  <h4 class="Subtitle text--white"><?php the_title(); ?></h4>
                  <p><a class="text--white" href="<?php the_permalink(); ?>">ver artículo</a></p>
                </article>
              </div>
              <?php $j++; ?>
          <?php endwhile; ?>
        </div>

        <?php if ($total > 1) : ?>
          <a class="left carousel-control" href="#carousel-programs-events" role="button" data-slide="prev">
            <i class="icons icon-arrow_left"></i>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#carousel-programs-events" role="button" data-slide="next">
            <i class="icons icon-arrow_right"></i>
            <span class="sr-only">Next</span>
          </a>
        <?php endif; ?>
      </div>
    </section>
  </aside><!-- end Sidebar -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>
