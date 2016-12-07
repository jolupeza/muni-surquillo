<?php
  /*
  Template Name: Agenda Page
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
              <h2 class="Title text--blue h1">
                <?php if (has_excerpt()) : ?>
                  <?php echo get_the_excerpt(); ?>
                <?php else : ?>
                  <?php the_title(); ?>
                <?php endif; ?>
              </h2>
              <?php the_content(); ?>
  <?php endwhile; ?>
<?php endif; ?>

              <?php
                global $wpdb;
                $sections = $wpdb->get_results("SELECT tt.term_taxonomy_id, t.term_id, t.name, tt.description FROM $wpdb->term_taxonomy tt INNER JOIN $wpdb->terms t ON tt.term_id = t.term_id WHERE tt.taxonomy = 'sections'");
                if (count($sections)) :
              ?>
                <section class="ColsFlex">
                  <?php foreach ($sections as $section) : ?>
                    <?php
                      $descArr = explode(',', $section->description);
                      $color = $descArr[0];
                      $option = $descArr[1];
                      $title = $section->name;
                      $titleArr = explode(' ', $title);

                      $firstParagraph = trim(substr($title, 0, strrpos($title, ' ')));
                      $lastParagraph = trim($titleArr[count($titleArr) - 1]);
                    ?>

                    <article class="Col Col--colors Col--<?php echo $color; ?> Col--33 text-center">
                      <h3 class="Title-semi text--blue"><?php echo $firstParagraph; ?></h3>
                      <h2 class="Title text--<?php echo $color; ?> h1"><?php echo $lastParagraph; ?></h2>

                      <?php
                        $args = [
                          'post_type' => 'directories',
                          'posts_per_page' => -1,
                          'tax_query' => array(
                            array(
                              'taxonomy' => 'sections',
                              'terms' => $section->term_id
                            )
                          ),
                        ];
                        $the_query = new WP_Query($args);
                        if ($the_query->have_posts()) :
                      ?>

                      <div class="wrapper-select wrapper-select--<?php echo $color; ?>">
                        <select class="js-select-directory" data-id="<?php echo $section->term_id; ?>">
                          <option value="">-- <?php echo $option; ?> --</option>
                          <?php while ($the_query->have_posts()) : ?>
                            <?php $the_query->the_post(); ?>
                            <option value="<?php echo get_the_id(); ?>"><?php the_title(); ?></option>
                          <?php endwhile; ?>
                        </select>
                      </div>
                      <?php endif; ?>
                      <?php wp_reset_postdata(); ?>

                      <div class="Square hidden">
                        <span class="Square-loader text-center glyphicon glyphicon-refresh animated rotateIn hidden" aria-hidden="true"></span>

                        <h4 class="Title-semi Square-title text-center hidden"></h4>
                        <h3 class="Title-bold Square-number hidden"></h3>
                      </div><!-- end Square -->
                    </article><!-- emd Col -->
                  <?php endforeach; ?>
                </section><!-- end ColsFlex -->
              <?php endif; ?>
            </div><!-- end col-md-12 -->
          </div><!-- end row -->
        </div><!-- end container -->
      </section><!-- end Page -->

<?php get_footer(); ?>
