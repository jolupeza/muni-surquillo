<?php get_header(); ?>

<?php
  if (file_exists(TEMPLATEPATH . '/partials/sliders.php')) {
    include TEMPLATEPATH . '/partials/sliders.php';
  }
?>

<div class="container">
  <section class="LastPostsLinks">
    <section class="LastPosts">
      <h3 class="h4 text-uppercase t-blue bdb-blue Page-title">Últimas noticias</h3>

      <?php
        $args = array(
          'category_name' => 'noticias',
          'posts_per_page' => 6,
        );
        $the_query = new WP_Query($args);

        if ($the_query->have_posts()) :
          $i = 0;
      ?>
        <div class="carousel carousel-showmanymoveone slide Carousel-lastPosts" id="carousel-lastPosts" data-ride="carousel">
          <div class="carousel-inner">
            <?php while ($the_query->have_posts()) :
                    $the_query->the_post();
            ?>
              <?php $active = ($i === 0) ? 'active' : ''; ?>
              <div class="item <?php echo $active; ?>">
                <div class="col-xs-12 col-sm-6 col-md-6">
                  <h2 class="LastPosts-title h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                  <?php if (has_post_thumbnail()) : ?>
                    <figure class="LastPosts-figure">
                      <?php the_post_thumbnail('full', array('class' => 'img-responsive center-block')); ?>
                    </figure>
                  <?php endif; ?>
                  <?php the_content('[seguir leyendo]'); ?>
                </div>
              </div>
              <?php $i++; ?>
            <?php endwhile; ?>
          </div>
          <a class="left carousel-control" href="#carousel-lastPosts" data-slide="prev"></a>
          <a class="right carousel-control" href="#carousel-lastPosts" data-slide="next"></a>
        </div>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </section><!-- end LastPosts -->

    <aside class="Links">
      <h3 class="h4 text-center text-uppercase Page-title">Servicios municipales</h3>

      <?php
        $args = array(
          'theme_location' => 'services-menu',
          'container' => 'nav',
          'container_class' => 'Links-nav',
          'menu_class' => 'Links-menu Links-menu--flex33',
        );
        wp_nav_menu( $args );
      ?>
    </aside><!-- end Links -->
  </section><!-- end LastPostsLinks -->

  <section class="LinksVideos">
    <aside class="Links">
      <h3 class="h4 text-center text-uppercase Page-title">Acciones municipales</h3>

      <?php
        $args = array(
          'theme_location' => 'actions-menu',
          'container' => 'nav',
          'container_class' => 'Links-nav',
          'menu_class' => 'Links-menu Links-menu--flex25',
        );
        wp_nav_menu( $args );
      ?>
    </aside><!-- end Links -->

    <?php
      $args = array(
        'post_type' => 'videos',
        'posts_per_page' => -1,
      );
      $the_query = new WP_Query($args);

      if ($the_query->have_posts()) :
        $total = count($the_query);
        $i = 0; $j = 0;
    ?>
      <section class="Videos">
        <h3 class="Page-title text-uppercase t-white bdb-white">Videos</h3>

        <div id="carousel-videos" class="carousel slide Carousel Carousel--videos" data-ride="carousel">
          <?php if ($total > 1) : ?>
            <ol class="carousel-indicators">
              <?php while ($the_query->have_posts()) : ?>
                <?php $the_query->the_post(); ?>
                <?php $active = ($i === 0) ? 'active' : ''; ?>
                <li data-target="#carousel-videos" data-slide-to="<?php echo $i; ?>" class="<?php echo $active; ?>"></li>
                <?php $i++; ?>
              <?php endwhile; ?>
            </ol>
          <?php endif; ?>

          <div class="carousel-inner" role="listbox">
            <?php while ($the_query->have_posts()) : ?>
              <?php $the_query->the_post(); ?>
              <?php $active = ($j === 0) ? 'active' : '0'; ?>

              <?php
                $values = get_post_custom( get_the_ID() );
                $video = (isset($values['mb_video'])) ? esc_attr($values['mb_video'][0]) : '';
              ?>

              <div class="item <?php echo $active; ?> text-center">
                <div class="Video-wrapper" id="player"></div>

                <script>
                  // 2. This code loads the IFrame Player API code asynchronously.
                  var tag = document.createElement('script');
                  var heightVideo = '270',
                      widthVideo = '480';

                  tag.src = "https://www.youtube.com/iframe_api";
                  var firstScriptTag = document.getElementsByTagName('script')[0];
                  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                  if (window.innerWidth < 500) {
                    heightVideo = '240';
                    widthVideo = '320';
                  }

                  // 3. This function creates an <iframe> (and YouTube player)
                  //    after the API code downloads.
                  var player;
                  function onYouTubeIframeAPIReady() {
                    player = new YT.Player('player', {
                      height: heightVideo,
                      width: widthVideo,
                      videoId: '<?php echo $video; ?>',
                      /*events: {
                        'onReady': onPlayerReady,
                        'onStateChange': onPlayerStateChange
                      }*/
                    });
                  }

                  // 4. The API will call this function when the video player is ready.
                  function onPlayerReady(event) {
                    event.target.playVideo();
                  }

                  // 5. The API calls this function when the player's state changes.
                  //    The function indicates that when playing a video (state=1),
                  //    the player should play for six seconds and then stop.
                  var done = false;
                  function onPlayerStateChange(event) {
                    if (event.data == YT.PlayerState.PLAYING && !done) {
                      setTimeout(stopVideo, 6000);
                      done = true;
                    }
                  }
                  function stopVideo() {
                    player.stopVideo();
                  }

                  function loadVideo(id) {
                    player.loadVideoById(id);
                  }

                  function resizeVideo(width, height) {
                    player.setSize(width, height);
                  }
                </script>

                <h3 class="h4 text-uppercase Videos-title text-left">Programa "Ponte Pilas"</h3>
                <p>Programa de impulso local de aprendizaje surquillano orientado al desarrollo de jóvenes y niños</p>
              </div><!-- end item -->

              <?php $j++; ?>
            <?php endwhile; ?>
          </div><!-- end carousel-inner -->
        </div><!-- end Carousel--videos -->
      </section><!-- end Videos -->
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
  </section><!-- end LinksVideos -->

  <?php
    $args = array(
      'post_type' => 'metas',
      'posts_per_page' => -1,
    );
    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) :
  ?>
    <h3 class="Page-title t-blue text-uppercase bdb-blue">Metas Municipales</h3>
    <ul class="Metas-list list-inline text-center">
      <?php while ($the_query->have_posts()) :
        $the_query->the_post();

        $values = get_post_custom( get_the_ID() );
        $url = (isset($values['mb_url'])) ? esc_attr($values['mb_url'][0]) : '';
        $target = (isset($values['mb_target'])) ? esc_attr($values['mb_target'][0]) : '';
        $target = (!empty($target) && $target === 'on') ? 'target="_blank" rel="noopener"' : '';
      ?>
        <li>
          <?php if (!empty($url)) : ?>
            <a href="<?php echo $url; ?>" <?php echo $target; ?> title="<?php the_title(); ?>">
          <?php endif; ?>

            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('full', array('class' => 'img-responsive center-block')); ?>
            <?php endif; ?>

          <?php if (!empty($url)) : ?>
            </a>
          <?php endif; ?>
        </li>
      <?php endwhile; ?>
    </ul>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>
</div><!-- end container -->

<?php get_footer(); ?>
