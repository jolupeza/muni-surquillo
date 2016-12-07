<?php
/*
  Template Name: Metas Page
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
      </figure>
    <?php endif; ?>

    <section class="Page Page--details">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="Title text--blue h1"><?php the_title(); ?></h2>
            <?php the_content(); ?>

            <?php
              $args = array(
                'post_type' => 'metas',
                'posts_per_page' => -1,
                'order' => 'ASC',
                'orderby' => 'menu_order',
              );
              $the_query = new WP_Query($args);
              if ($the_query->have_posts()) :
                $i = 1;
            ?>
              <div class="panel-group Panels Panels--metas" id="accordion-metas" role="tablist" aria-multiselectable="true">
                <h3 class="Title-semi text-center text--blue">Metas vigentes</h3>
                <?php while ($the_query->have_posts()) : ?>
                  <?php $the_query->the_post(); ?>
                  <?php $in = ($i === 1) ? 'in' : ''; ?>
                  <?php $active = ($i === 1) ? 'active' : ''; ?>
                  <div class="panel panel-default">
                    <div class="panel-heading <?php echo $active; ?>" role="tab" id="heading<?php echo $i; ?>">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion-metas" href="#collapse<?php echo $i; ?>" aria-expanded="true" aria-controls="collapse<?php echo $i; ?>">
                          <?php the_title(); ?>
                        </a>
                      </h4>
                    </div>
                    <div id="collapse<?php echo $i; ?>" class="panel-collapse collapse <?php echo $in; ?>" role="tabpanel" aria-labelledby="heading<?php echo $i; ?>">
                      <div class="panel-body">
                        <?php the_content(); ?>
                      </div>
                    </div>
                  </div>
                  <?php $i++; ?>
                <?php endwhile; ?>
              </div>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
          </div><!-- end col-md-12 -->
        </div><!-- end row -->
      </div><!-- end container -->
    </section><!-- end Page -->
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
