<?php get_header(); ?>

<section class="Page-search"></section>

<section class="Page Page--nopadding">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <?php if (have_posts()) : ?>
          <h2 class="Title text--blue h1"><?php echo single_tag_title('', false); ?></h2>

          <section class="Boxes Boxes--wrap">
            <?php while (have_posts()) : ?>
              <?php the_post(); ?>

              <?php get_template_part('content', get_post_format()); ?>
            <?php endwhile; ?>
          </section><!-- end Boxes -->
        <?php else : ?>
          <article class="Boxes-noposts">
            <h2 class="Title text--blue text-center"><?php _e('No se encontraron publicaciones.', THEMEDOMAIN); ?></h2>
          </article>
        <?php endif; ?>

        <?php
          global $wp_query;
          $total = $wp_query->max_num_pages;

          if ( $total > 1 ) :
        ?>
          <nav aria-label="Page navigation" class="Page-navigation text-center">
            <?php
              $current_page = (get_query_var( 'paged' )) ? get_query_var( 'paged' ) : 1;
              $format = ( get_option('permalink_structure' ) == '/%postname%/') ? 'page/%#%/' : '&paged=%#%';

              echo paginate_links(array(
                'base'      =>    get_pagenum_link(1) . '%_%',
                'format'    =>    $format,
                'current'   =>    $current_page,
                'prev_next' =>    True,
                'prev_text' =>    __('&laquo;', THEMEDOMAIN),
                'next_text' =>    __('&raquo;', THEMEDOMAIN),
                'total'     =>    $total,
                'mid_size'  =>    4,
                'type'      =>    'list'
              ));
            ?>
          </nav>
        <?php endif; ?>
      </div><!-- end col-md-8 -->

      <div class="col-md-4">
        <aside class="Sidebar Sidebar--gray">

          <?php get_sidebar('main-sidebar'); ?>

        </aside><!-- end Sidebar -->

        <?php /*
        <aside class="Sidebar">
          <article class="Sidebar-widget Sidebar-widget--noMargin">
            <ul class="Sidebar-widget-links">
              <li><a href=""><img class="img-responsive center-block" src="images/resources/link1-widget.jpg" alt=""></a></li>
              <li><a href=""><img class="img-responsive center-block" src="images/resources/link2-widget.jpg" alt=""></a></li>
            </ul>
          </article><!-- end Sidebar-widget -->
        </aside><!-- end Sidebar -->
        */ ?>

        <?php
          $filePath = TEMPLATEPATH . '/includes/last-programs.php';
          if (file_exists($filePath)) {
            include $filePath;
          }
        ?>
      </div>
    </div>
  </div><!-- end container -->
</section><!-- end Page -->

<?php get_footer(); ?>
