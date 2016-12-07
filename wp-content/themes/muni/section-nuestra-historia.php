
<?php
  $backgroundImage = '';
  if (has_post_thumbnail()) {
    $backgroundImage = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()), 'full')[0];
  }

  $values = get_post_custom( get_the_ID() );
  $link = isset($values['mb_link']) ? esc_attr($values['mb_link'][0]) : '';
  $linkText = isset($values['mb_link_text']) ? esc_attr($values['mb_link_text'][0]) : 'Ver reseña histórica >';

  // $files = isset($values['mb_files']) ? $values['mb_files'][0] : '';
  // $files_title = isset($values['mb_files_title']) ? $values['mb_files_title'][0] : '';
?>
<section class="Page Page--gray Page--details Page--flex Page--nopadding">
  <figure class="Page-flex50">
    <img class="img-responsive" src="<?php echo $backgroundImage; ?>" />
  </figure>
  <article class="Page-flex40">
    <h2 class="Title text--blue h1 text-right"><?php the_title(); ?></h2>
    <?php the_content(); ?>

    <?php /* if (!empty($files)) : ?>
      <?php
        $files = unserialize($files);
        // $filesTitle = unserialize($files_title);

        $firstFile = $files[0];
        // $firstFileTitle = $filesTitle[0];

        if (!empty($firstFile)) :
      ?>
        <p class="text-right text--nimportant">
          <a href="<?php echo $firstFile; ?>" class="Button Button--transp Button--blue" target="_blank" rel="noopener noreferrer"><?php echo $linkText; ?></a>
        </p>
      <?php endif; ?>
    <?php endif; */ ?>

    <?php if (!empty($link)) : ?>
      <p class="text-right text--nimportant">
        <a href="<?php echo $link; ?>" class="Button Button--transp Button--blue" target="_blank" rel="noopener noreferrer"><?php echo $linkText; ?></a>
      </p>
    <?php endif; ?>
  </article><!-- end Page-flex50 -->
</section><!-- end Page -->
