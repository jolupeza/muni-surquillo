<?php
/*
  Template Name: About Page
*/
?>
<?php get_header(); ?>

<?php $idPage = 0; ?>
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
  <?php endwhile; ?>

  <?php
    $args = [
      'post_type' => 'page',
      'post_parent' => $idPage,
      'order' => 'ASC',
      'orderby' => 'menu_order',
      'posts_per_page' => -1
    ];
    $mainQuery = new WP_Query($args);

    if ($mainQuery->have_posts()) {
      while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

        global $post;
        $postName = $post->post_name;

        get_template_part('section', $postName);
      }
    }
    wp_reset_query();
  ?>
<?php endif; ?>

<?php get_footer(); ?>
