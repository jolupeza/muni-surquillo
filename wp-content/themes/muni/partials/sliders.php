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
    $i = 0; $j = 0;
?>
  <section id="carousel-home" class="carousel slide Carousel Carousel--home" data-ride="carousel">
    <?php if ($the_query->post_count > 1) : ?>
      <ol class="carousel-indicators">
        <?php while ($the_query->have_posts()) : ?>
          <?php $the_query->the_post(); ?>
          <?php $active = ($i === 0) ? 'active' : ''; ?>
          <li data-target="#carousel-home" data-slide-to="<?php echo $i; ?>" class="<?php echo $active; ?>"></li>
          <?php $i++; ?>
        <?php endwhile; ?>
      </ol><!-- end Carousel-indicators -->
    <?php endif; ?>

    <div class="carousel-inner" role="listbox">
      <?php while ($the_query->have_posts()) : ?>
        <?php $the_query->the_post(); ?>
        <?php $active = ($j === 0) ? 'active' : ''; ?>
        <?php
          $values = get_post_custom( get_the_ID() );
          $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
          $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
          $target = (!empty($target) && $target === 'on') ? 'target="_blank" rel="noopener noreferrer"' : '';
          $responsive = isset( $values['mb_responsive'] ) ? esc_attr($values['mb_responsive'][0]) : '';
        ?>
        <div class="item <?php echo $active; ?>">
          <?php if (has_post_thumbnail()) : ?>
            <picture>
              <?php if (!empty($responsive)) : ?>
                <source class="img-responsive center-block" media="(max-width: 767px)" srcset="<?php echo $responsive; ?>">
              <?php endif; ?>
              <?php the_post_thumbnail('full', array('class' => 'img-responsive center-block')); ?>
            </picture>

          <?php endif?>
          <div class="carousel-caption">
            <?php $content = get_the_content(); ?>
            <h3 class="Carousel-captionTitle text-uppercase"><?php the_title(); ?></h3>
            <h4 class="Carousel-captionSubtitle text-uppercase"><?php echo $content; ?></h4>
            <?php if (!empty($url)) : ?>
              <p><a href="<?php echo $url; ?>" class="Button Button--transp Button--white text-uppercase" <?php echo $target; ?>>ver metas ></a></p>
          <?php endif; ?>
          </div><!-- end Carousel-caption -->
        </div><!-- end Carousel-item -->
        <?php $j++; ?>
      <?php endwhile; ?>
    </div><!-- end Carousel-inner -->

    <a href="about" class="hidden-xs hidden-sm js-move-scroll Carousel-arrow Button Button--arrowDown text-center text-uppercase">Ver más</a>
  </section><!-- end Carousel -->
<?php endif; ?>
<?php wp_reset_postdata(); ?>
