<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <?php
      $idPage = get_the_id();
      $values = get_post_custom($idPage);

      $responsive = isset( $values['mb_responsive'] ) ? esc_attr($values['mb_responsive'][0]) : '';
      $iframe = isset($values['mb_iframe']) ? esc_attr($values['mb_iframe'][0]) : '';
    ?>
    <?php if (has_post_thumbnail()) : ?>
      <figure class="Page-image Page-image--full">
        <picture>
          <?php if (!empty($responsive)) : ?>
              <source class="img-responsive center-block" media="(max-width: 767px)" srcset="<?php echo $responsive; ?>">
            <?php endif; ?>
            <?php the_post_thumbnail('full', array('class' => 'img-responsive center-block')); ?>
        </picture>
      </figure>
    <?php endif; ?>

    <section class="Page Page--details">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="Title text--blue h1"><?php the_title(); ?></h2>
            <?php the_content(); ?>

            <?php if (!empty($iframe)) : ?>
              <div class="text-center">
                <iframe class="iFrame" src="<?php echo $iframe; ?>" width="100%" height="600">
                  <p>Tu navegador no soporta iframes.</p>
                </iframe>
              </div>
            <?php endif; ?>
          </div><!-- end col-md-12 -->
        </div><!-- end row -->
      </div><!-- end container -->
    </section><!-- end Page -->
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
