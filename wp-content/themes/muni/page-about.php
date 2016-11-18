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
    <?php $idPage = get_the_id(); ?>
    <?php if (has_post_thumbnail()) : ?>
      <figure class="Page-image Page-image--full">
        <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block']); ?>
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
