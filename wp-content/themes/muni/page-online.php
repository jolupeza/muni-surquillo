<?php
  /*
  Template Name: Online Page
  */
?>
<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <?php if (has_post_thumbnail()) : ?>
      <figure class="Page-image Page-image--full">
        <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block']); ?>
      </figure>

      <section class="Page Page--details">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2 class="Title text--blue h1"><?php the_title(); ?></h2>
              <?php the_content(); ?>

              <?php
                $id = get_the_id();
                $args = [
                  'post_type'   => 'page',
                  'post_parent' => $id,
                  'order'       => 'ASC',
                  'orderby'     => 'menu_order',
                ];
                $the_query = new WP_Query($args);
                if ($the_query->have_posts()) :
              ?>
                  <section class="ColsFlex">
                    <?php while ($the_query->have_posts()) : ?>
                      <?php $the_query->the_post(); ?>
                      <?php
                        $values = get_post_custom(get_the_id());
                        $icon = isset($values['mb_icon']) ? esc_attr($values['mb_icon'][0]) : '';
                        $link_text = isset($values['mb_link_text']) ? esc_attr($values['mb_link_text'][0]) : '';
                        $link = isset($values['mb_link']) ? esc_attr($values['mb_link'][0]) : '';
                      ?>
                      <article class="Col Col--gray Col--50 text-center">
                        <?php if (!empty($icon)) : ?>
                          <i class="icons <?php echo $icon; ?> text--blue"></i>
                        <?php endif; ?>

                        <h3 class="Title text--blue"><?php the_title(); ?></h3>
                        <?php the_content(); ?>

                        <?php if (!empty($link_text) && !empty($link)) : ?>
                          <p class="text-center">
                            <a href="<?php echo $link; ?>" class="Button Button--transp Button--blue" target="_blank" rel="noopener noreferrer"><?php echo $link_text; ?></a>
                          </p>
                        <?php endif; ?>
                      </article><!-- emd Col -->
                    <?php endwhile; ?>
                      <?php /*
                      <article class="Col Col--gray Col--50 text-center">
                        <i class="icons icon-tramite_documentario text--blue"></i>

                        <h3 class="Title text--blue">Trámite documentario</h3>
                        <p>Con nuestro módulo de Trámite Documentario podrá acceder al estado de sus trámites municipales.</p>

                        <p class="text-center">
                          <a href="" class="Button Button--transp Button--blue">entrar</a>
                        </p>
                      </article><!-- emd Col -->
                      */ ?>
                  </section><!-- end ColsFlex -->
              <?php endif; ?>
              <?php wp_reset_postdata(); ?>
            </div><!-- end col-md-12 -->
          </div><!-- end row -->
        </div><!-- end container -->
      </section><!-- end Page -->
    <?php endif; ?>
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
