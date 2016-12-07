<section class="Flex Flex--box">
  <?php while ($the_query->have_posts()) : ?>
    <?php $the_query->the_post(); ?>
    <?php
      $values = get_post_custom( get_the_ID() );
      $job = isset($values['mb_job']) ? esc_attr($values['mb_job'][0]) : '';
      $email = isset($values['mb_email']) ?  $values['mb_email'][0]  :  '';
      $phone = isset($values['mb_phone']) ?  $values['mb_phone'][0]  :  '';
      $address = isset($values['mb_address']) ?  $values['mb_address'][0]  :  '';
    ?>
    <article class="Flex-item Flex-25 text-center">
      <?php if (has_post_thumbnail()) : ?>
        <figure class="Flex-figure">
          <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block']); ?>
        </figure>
      <?php endif; ?>
      <h3 class="Title-semi text--white"><?php the_title(); ?></h3>
      <?php if (!empty($job)) : ?>
        <p class="text--white text--n"><?php echo $job; ?></p>
      <?php endif; ?>
      <?php if (!empty($email)) : ?>
        <p class="text--white text--n">
          <a class="text--white" href="mailto:<?php echo $email; ?>"><i class="icon icon-contacto"></i> <?php echo $email; ?></a>
        </p>
      <?php endif; ?>
      <?php if (!empty($phone)) : ?>
        <p class="text--white text--n">Teléfono: <?php echo $phone; ?></p>
      <?php endif; ?>
      <?php if (!empty($address)) : ?>
        <p class="text--white text--n">Dirección: <?php echo $address; ?></p>
      <?php endif; ?>
    </article>
  <?php endwhile; ?>
</section>

<?php
  $total = $the_query->max_num_pages;
  if ($total > 1) :
    $format = '';
?>
    <nav aria-label="Page navigation" class="Page-navigation Page-navigation--white text-center" id="js-nav-authorities">
      <?php
        echo paginate_links(array(
          'base'      =>    '/' . $role,
          'format'    =>    $format,
          'current'   =>    $page,
          'prev_next' =>    True,
          'prev_text' =>    '&laquo;',
          'next_text' =>    '&raquo;',
          'total'     =>    $total,
          'show_all'  =>    TRUE,
          'type'      =>    'list'
        ));
      ?>
    </nav>
<?php endif; ?>
