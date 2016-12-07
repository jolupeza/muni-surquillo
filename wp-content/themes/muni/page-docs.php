<?php
  /*
  Template Name: Service Documents Page
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
      $forms = (isset($values['mb_forms'])) ? $values['mb_forms'][0] : '';
      $how = (isset($values['mb_how'])) ? $values['mb_how'][0] : '';
      $cases = (isset($values['mb_cases'])) ? $values['mb_cases'][0] : '';
      $legislation = (isset($values['mb_legislation'])) ? $values['mb_legislation'][0] : '';
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

    <section class="Page Page--details">
      <div class="container">
        <ul class="Page-breadcrumbs">
          <li><a href="<?php echo home_url(); ?>">Inicio</a></li>
          <li><a href="<?php echo home_url('servicios-y-tramites'); ?>">Servicios y trámites</a></li>
          <li><?php the_title(); ?></li>
        </ul>

        <div class="row">
          <div class="col-md-8">
            <article class="Page-services">
              <h2 class="Title text--blue h1">Sobre el servicio o trámite</h2>
              <?php the_content(); ?>
            </article><!-- end Page-services -->
          </div><!-- end col-md-8 -->

          <div class="col-md-4">
            <?php if (!empty($forms)) : ?>
              <section class="Table">
                <header class="Table-header text-center text--white">Formularios</header>
                <?php echo $forms; ?>
              </section><!-- end Table -->
            <?php endif; ?>
          </div>
        </div><!-- end row -->
      </div><!-- end container -->
    </section><!-- end Page -->

    <?php if (!empty($how)) : ?>
      <section class="Page-medium Page-services">
        <div class="container Page-medium-wrapper">
          <div class="row">
            <div class="col-md-4">
              <h3 class="Title text--white h1">Como completar los formularios</h3>
            </div>
            <div class="col-md-8">
              <?php echo $how; ?>
            </div>
          </div>
        </div>
      </section>
    <?php endif; ?>

    <?php if (!empty($cases) || !empty($legislation)) : ?>
      <section class="Flex Flex--page">
        <article class="Flex-item Flex-50 Flex-white Page-services">
          <h2 class="h1 Title">Casos Prácticos</h2>
          <?php echo $cases; ?>
        </article>
        <article class="Flex-item Flex-50 Flex-gray Page-services">
          <h2 class="h1 Title Title-left">Legislación</h2>
          <?php echo $legislation; ?>
        </article>
      </section>
    <?php endif; ?>

  <?php endwhile; ?>
<?php endif; ?>

<?php
  $filepath = TEMPLATEPATH . '/includes/services-contact.php';
  if (file_exists($filepath)) {
    include $filepath;
  }
?>

<?php get_footer(); ?>
