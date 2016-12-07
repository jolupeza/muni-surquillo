<?php $options = get_option('muni_custom_settings'); ?>

    <footer class="Footer">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <?php
              $lat = $options['map_latitud'];
              $long = $options['map_longitud'];
            ?>
            <figure class="Footer-map" id="map" data-lat="<?php echo $lat; ?>" data-long="<?php echo $long; ?>"></figure>
          </div><!-- end col-md-4 -->
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-6">
                <h3 class="text--white Title">Enlaces</h3>
                <?php
                  $args = [
                    'theme_location' => 'footer-link-menu',
                    'menu_class' => 'Footer-list',
                  ];
                  wp_nav_menu( $args );
                ?>
              </div>
              <div class="col-md-6">
                <h3 class="text--white Title">Servicios</h3>
                <?php
                  $args = [
                    'theme_location' => 'footer-service-menu',
                    'menu_class' => 'Footer-list',
                  ];
                  wp_nav_menu( $args );
                ?>
              </div>
            </div>
          </div><!-- end col-md-4 -->
          <div class="col-md-4">
            <h3 class="text--white Title">Suscríbete</h3>
            <p class="text--white">Suscríbete y entérate de las últimas novedades, eventos, actividades y nuevas ordenanzas.</p>

            <form class="Form" id="js-form-subs" method="POST">
              <div class="Footer-loader text-center hidden" id="js-form-subs-loader">
                <span class="animated infinite glyphicon glyphicon-refresh text--white" aria-hidden="true"></span>
              </div>
              <p class="text-center text--white" id="js-form-subs-msg"></p>

              <div class="form-group">
                <label for="emailsub" class="sr-only">Correo electrónico</label>
                <div class="input-group">
                  <input type="email" name="emailsub" id="emailsub" class="form-control" placeholder="Ingresa tu correo electrónico" aria-describedby="basic-email" required>
                  <span class="input-group-addon" id="basic-email"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></span>
                </div>
              </div><!-- end form-group -->

              <p class="text-center">
                <button type="submit" class="Button Button--transp Button--white text-uppercase">Suscribirme</button>
              </p>
            </form>

            <?php if (!empty($options['phone']) || !empty($options['phone_alert'])) : ?>
              <div class="Header-central-wrapper text-center">
                <?php if (!empty($options['phone'])) : ?>
                  <aside class="Header-central">
                    <i class="Header-central-icon icons icon-phone text--red"></i>
                    <span>Central Telefónica <b><?php echo $options['phone']; ?></b></span>
                  </aside>
                <?php endif; ?>

                <?php if (!empty($options['phone_alert'])) : ?>
                  <aside class="Header-central">
                    <i class="Header-central-icon icons icon-phone text--green"></i>
                    <span>Seguridad Ciudadana <b><?php echo $options['phone_alert']; ?></b></span>
                  </aside>
                <?php endif; ?>
              </div><!-- end Header-central-wrapper -->
            <?php endif; ?>
          </div><!-- end col-md-4 -->
        </div><!-- end row -->
      </div><!-- end container -->

      <div class="Footer-copy">
        <div class="container">
          <p class="text-center text--white text--s">Copyright &copy; 2009 - <?php echo date('Y'); ?>. All rights reserved.</p>
        </div>
      </div>
    </footer><!-- end Footer -->

    <!-- <button class="ArrowTop text-hide">Ir a arriba</button> -->

    <script>
      var _root_ = '<?php echo home_url(); ?>';

      var players = new Array();

      // 3. This function creates an <iframe> (and YouTube player)
      //    after the API code downloads.
      function onYouTubeIframeAPIReady() {
        if (typeof playerInfoList === 'undefined') return;

        for (var i = 0; i < playerInfoList.length; i++) {
          var curplayer = createPlayer(playerInfoList[i]);
          players[i] = curplayer;
        }
      }

      function createPlayer(playerInfo) {
        return new YT.Player(playerInfo.idPlayer, {
            height: playerInfo.height,
            width: playerInfo.width,
            videoId: playerInfo.videoId,
            events: {
              // 'onReady': onPlayerReady,
              'onStateChange': onPlayerStateChange
            }
        });
      }

      // 4. The API will call this function when the video player is ready.
      function onPlayerReady(event) {
        event.target.playVideo();
      }

      // 5. The API calls this function when the player's state changes.
      //    The function indicates that when playing a video (state=1),
      //    the player should play for six seconds and then stop.
      // var done = false;
      function onPlayerStateChange(event) {
        if (event.target.a.className === 'Page-video') {
          // if (event.data == YT.PlayerState.PLAYING && !done) {
          if (event.data == YT.PlayerState.PLAYING) {
            if (jQuery('#carousel-programs-events').length) {
              jQuery('#carousel-programs-events').carousel('pause');
            }
          }

          if ((event.data == YT.PlayerState.ENDED) || (event.data == YT.PlayerState.PAUSED)) {
            if (jQuery('#carousel-programs-events').length) {
              jQuery('#carousel-programs-events').carousel('cycle');
            }
          }
        }
      }

      function stopVideoPlayer(player) {
        player.stopVideo();
      }

      function stopVideo() {
        player.stopVideo();
      }

      function loadVideo(id) {
        player.loadVideoById(id);
      }

      function resizeVideoPlayer(player, width, height) {
        player.setSize(width, height);
      }

      function resizeVideo(width, height) {
        player.setSize(width, height);
      }
    </script>

    <script>
      var map, marker, infowindow;
    </script>

    <?php wp_footer(); ?>

    <?php
      if (!empty($lat) && !empty($long)) :
    ?>
      <script>
        var lat = <?php echo $lat; ?>,
            lon = <?php echo $long; ?>;
        var contentString = '<div id="content" class="Marker">'+
              '<div id="siteNotice">'+
              '</div>'+
              '<h1 id="firstHeading" class="firstHeading Marker-title text-center">Municipalidad de Surquillo</h1>'+
              '<div id="bodyContent" class="Marker-body">'+
              '<ul class="Marker-list">'+
              '<li><strong>Dirección: </strong><?php echo $options['address'] ?></li>'+
              '<li><strong>Teléfono: </strong><?php echo $options['phone'] ?></li>'+
              '<li><strong>Correo: </strong><?php echo $options['email_contact'] ?></li>'+
              '</ul>'+
              '</div>'+
              '</div>';

        function initMap() {
          var mapCoord = new google.maps.LatLng(lat, lon);

          var opciones = {
            zoom: 16,
            center: mapCoord,
            zoomControl: false,
            mapTypeControl: false,
            streetViewControl: false,
            scrollwheel: false,
          }

          infowindow = new google.maps.InfoWindow({
            content: contentString,
            maxWidth: 300
          });

          map = new google.maps.Map(document.getElementById('map'), opciones);

          marker = new google.maps.Marker({
            position: mapCoord,
            map: map,
            title: 'Municipalidad de Surquillo'
          });
        }
      </script>

      <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkaZmovHKN7O8UujpIT5BXnJBFow4Absk&callback=initMap">
      </script>
    <?php endif; ?>
  </body>
</html>
