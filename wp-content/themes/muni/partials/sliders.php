<?php $options = get_option('muni_custom_settings'); ?>

<?php
  $args = array(
    'post_type' => 'sliders',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
  );
  $the_query = new WP_Query($args);

  if ($the_query->have_posts()) :
    $total = count($the_query);
    $i = 0; $j = 0;
?>
  <section id="carousel-home" class="carousel slide Carousel Carousel--home" data-ride="carousel">
    <?php if ($total > 1) : ?>
      <ol class="carousel-indicators Carousel-indicators">
        <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
          <?php $active = ($i === 0) ? 'active' : ''; ?>
          <li data-target="#carousel-home" data-slide-to="<?php echo $i; ?>" class="<?php echo $active; ?>"></li>
          <?php $i++; ?>
        <?php endwhile; ?>
      </ol><!-- end Carousel-indicators -->
    <?php endif; ?>

    <div class="carousel-inner Carousel-inner" role="listbox">
      <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <?php $active = ($j === 0) ? 'active' : ''; ?>
        <div class="item <?php echo $active; ?> Carousel-item">
          <?php
            if (has_post_thumbnail()) {
              the_post_thumbnail('full', array('class' => 'img-responsive center-block'));
            }
          ?>
          <!-- <img src="images/resources/slider-1920-548.jpg" alt="" /> -->
          <div class="carousel-caption Carousel-caption">
            <h3 class="Carousel-caption-title"><?php the_title(); ?></h3>
          </div><!-- end Carousel-caption -->
        </div><!-- end Carousel-item -->
        <?php $j++; ?>
      <?php endwhile; ?>
    </div><!-- end Carousel-inner -->

    <?php /*
    <!-- Controls -->
    <a class="left carousel-control Carousel-control" href="#carousel-home" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control Carousel-control" href="#carousel-home" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
    */ ?>

    <?php
      $args = array(
        'theme_location' => 'left-menu',
        'container' => 'nav',
        'container_class' => 'Carousel-nav',
        'menu_class' => 'Carousel-menu',
      );
      wp_nav_menu( $args );
    ?>

    <?php if ($options['display_social_link']) : ?>
      <nav class="Social-nav">
        <ul class="Social-list">
          <?php if (!empty($options['facebook'])) : ?>
            <li class="Social-fb">
              <a href="https://www.facebook.com/<?php echo $options['facebook']; ?>" class="text-hide" title="Ir a Facebook" target="_blank" rel="noopener">Facebook</a>
            </li>
          <?php endif; ?>
          <?php if (!empty($options['linkedin'])) : ?>
            <li class="Social-lk">
              <a href="<?php echo $options['linkedin']; ?>" class="text-hide" title="Ir a Linkedin" target="_blank" rel="noopener">Linkedin</a>
            </li>
          <?php endif; ?>
          <?php if (!empty($options['twitter'])) : ?>
            <li class="Social-tw">
              <a href="https://twitter.com/<?php echo $options['twitter'] ?>" class="text-hide" title="Ir a Twitter" target="_blank" rel="noopener">Twitter</a>
            </li>
          <?php endif; ?>
          <?php if (!empty($options['googleplus'])) : ?>
            <li class="Social-gplus">
              <a href="<?php echo $options['googleplus']; ?>" class="text-hide" title="Ir a Google+" target="_blank" rel="noopener">Google+</a>
            </li>
          <?php endif; ?>
        </ul>
      </nav>
    <?php endif; ?>
  </section><!-- end Carousel -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>
