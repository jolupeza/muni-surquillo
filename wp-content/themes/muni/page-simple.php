<?php
  /*
  Template Name: Service Simple Page
  */
?>
<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <?php
      $idPage = get_the_id();
      $values = get_post_custom($idPage);

      $responsive = isset( $values['mb_responsive'] ) ? esc_attr($values['mb_responsive'][0]) : '';
    ?>
    <?php if (has_post_thumbnail()) : ?>
      <figure class="Page-image Page-image--full">
        <picture>
          <?php if (!empty($responsive)) : ?>
              <source class="img-responsive center-block" media="(max-width: 767px)" srcset="<?php echo $responsive; ?>">
            <?php endif; ?>
            <?php the_post_thumbnail('full', array('class' => 'img-responsive center-block')); ?>
        </picture>
        <div class="Page-image-title">
          <h2 class="text--white Title h1">
            <?php if (has_excerpt()) : ?>
              <?php echo get_the_excerpt(); ?>
            <?php else : ?>
              <?php the_title(); ?>
            <?php endif; ?>
          </h2>
        </div>
      </figure>
    <?php endif; ?>

    <section class="Page Page--details Page--simple" style="background-image: url('<?php echo IMAGES; ?>/bg-page-simple.png');">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <ul class="Page-breadcrumbs">
              <li><a href="<?php echo home_url(); ?>">Inicio</a></li>
              <li><a href="<?php echo home_url('servicios-y-tramites'); ?>">Servicios y trámite</a></li>
              <li><?php the_title(); ?></li>
            </ul>

            <article class="Page-services">
              <h2 class="Title text--blue h1">Sobre el servicio o trámite</h2>
              <?php the_content(); ?>
            </article><!-- end Page-services -->
          </div><!-- end col-md-8 -->
          <div class="col-md-4"></div>
        </div><!-- end row -->
      </div><!-- end container -->
    </section><!-- end Page -->
  <?php endwhile; ?>
<?php endif; ?>

<?php
  $filepath = TEMPLATEPATH . '/includes/services-contact.php';
  if (file_exists($filepath)) {
    include $filepath;
  }
?>

<?php get_footer(); ?>
