<?php
/*
  Template Name: About Page
*/
?>
<?php get_header(); ?>

<?php $idPage = 0; ?>
<?php if (have_posts()) : ?>
  <?php $gallery = ''; ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <?php
      $idPage = get_the_id();
      $values = get_post_custom($idPage);

      $responsive = isset( $values['mb_responsive'] ) ? esc_attr($values['mb_responsive'][0]) : '';
      $gallery = isset($values['mb_gallery']) ?  $values['mb_gallery'][0]  :  $gallery;
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

<?php
  if (!empty($gallery)) :
    $gallery = unserialize($gallery);
?>
    <section class="Gallery Page--blue1">
      <ul class="Gallery-list">
        <?php foreach ($gallery as $image) : ?>
          <?php
            $post_thumb_id = muni_get_image_id($image);

            $post_thumb_src = wp_get_attachment_image_src($post_thumb_id, 'page-gallery');
          ?>
          <li data-toggle="modal" data-target="#js-modal-gallery" data-image="<?php echo $image; ?>">
            <img class="img-responsive center-block" src="<?php echo $post_thumb_src[0]; ?>">
          </li>
        <?php endforeach; ?>
      </ul>

      <div class="modal fade Modal" id="js-modal-gallery" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <figure class="Modal-figure">
                <img class="img-responsive center-block" src="" alt="">
              </figure>
            </div>
          </div>
        </div>
      </div>
    </section>
<?php endif; ?>

<?php get_footer(); ?>
