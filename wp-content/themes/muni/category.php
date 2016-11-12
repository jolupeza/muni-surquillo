<?php get_header(); ?>

<?php
  $filePath = TEMPLATEPATH . '/includes/posts-featured.php';
  if (file_exists($filePath)) {
    include $filePath;
  }
?>

<section class="Page Page--nopadding">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <?php
          global $wp_query;
          $args = array(
            'post__not_in' => $sticky
          );
          $args = array_merge($wp_query->query_vars, $args);
          query_posts($args);
        ?>
        <?php if (have_posts()) : ?>
          <h2 class="Title text--blue h1">Últimas noticias</h2>

          <section class="Boxes Boxes--wrap">
            <?php while (have_posts()) : ?>
              <?php the_post(); ?>

              <?php get_template_part('content', get_post_format()); ?>
            <?php endwhile; ?>
          </section><!-- end Boxes -->

          <?php
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
        <?php endif; ?>
      </div><!-- end col-md-8 -->

      <div class="col-md-4">
        <aside class="Sidebar Sidebar--gray">

          <?php get_sidebar('main-sidebar'); ?>

        </aside><!-- end Sidebar -->

        <aside class="Sidebar">
          <article class="Sidebar-widget Sidebar-widget--noMargin">
            <ul class="Sidebar-widget-links">
              <li><a href=""><img class="img-responsive center-block" src="images/resources/link1-widget.jpg" alt=""></a></li>
              <li><a href=""><img class="img-responsive center-block" src="images/resources/link2-widget.jpg" alt=""></a></li>
            </ul>
          </article><!-- end Sidebar-widget -->
        </aside><!-- end Sidebar -->
        <aside class="Sidebar Sidebar--skyBlue">
          <h3 class="Sidebar-widget-title Sidebar-widget-title--noborder text--white">Últimos vídeos</h3>

          <article class="Videos">
            <figure class="Videos-figure"></figure>
            <h4 class="Videos-title text--white">Programa Ponte Pilas</h4>
            <p><a href="">ver programa</a></p>
          </article><!-- end Videos -->
        </aside>
      </div>
    </div>
  </div><!-- end container -->
</section><!-- end Page -->

<?php get_footer(); ?>
