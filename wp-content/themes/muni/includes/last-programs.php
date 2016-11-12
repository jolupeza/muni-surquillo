<?php
  $pageParent = get_page_by_title('Programas y eventos');

  $args = array(
    'posts_per_page' => 2,
    'post_type' => 'page',
    'post_parent' => $pageParent->ID,
  );
  $the_query = new WP_Query($args);
  if ($the_query->have_posts()) :
?>
  <aside class="Sidebar Sidebar--skyBlue">
    <h3 class="Sidebar-widget-title Sidebar-widget-title--noborder text--white">Últimos vídeos</h3>

    <?php while ($the_query->have_posts()) : ?>
      <?php
        $the_query->the_post();
        $values = get_post_custom(get_the_id());
        $video = isset($values['mb_video']) ? esc_attr($values['mb_video'][0]) : '';
      ?>
      <article class="Videos">
        <?php if (!empty($video)) : ?>
          <figure class="Videos-figure text-center">
            <div class="Page-video" id="player"></div>

            <script>
              // 2. This code loads the IFrame Player API code asynchronously.
              var tag = document.createElement('script');
              // var heightVideo = '270',
              //     widthVideo = '480';
              var heightVideo = '240',
                  widthVideo = '320';

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
          </figure>
        <?php endif; ?>

        <h4 class="Videos-title text--white"><?php the_title(); ?></h4>
        <p><a href="<?php the_permalink(); ?>">ver programa</a></p>
      </article><!-- end Videos -->
    <?php endwhile; ?>
  </aside>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
