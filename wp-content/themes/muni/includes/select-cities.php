<option value="">-- <?php echo $title; ?> --</option>

<?php while ($the_query->have_posts()) : ?>
  <?php $the_query->the_post(); ?>
  <option value="<?php echo get_the_id(); ?>"><?php the_title(); ?></option>
<?php endwhile; ?>
