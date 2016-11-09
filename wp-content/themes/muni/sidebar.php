<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('main-sidebar')) : ?>

  <article class="Sidebar-widget">
    <h3 class="Sidebar-widget-title text--blue"><?php bloginfo('title'); ?></h3>
    <p><?php bloginfo('description'); ?></p>
  </article><!-- end Sidebar-widget -->

<?php endif; ?>
