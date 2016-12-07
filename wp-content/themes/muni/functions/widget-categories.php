<?php
/***********************************************************************************************/
/* Widget that displays categories */
/***********************************************************************************************/

class Muni_List_Categories_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
          'muni_list_categories_w',
          'Custom Widget: Lista de Categorías',
          array('description' => __('Mostrar categorías de Novedades', THEMEDOMAIN))
        );
    }

    public function form($instance)
    {
        $defaults = array(
          'title' => 'Categorías',
        );

        $instance = wp_parse_args((array) $instance, $defaults);

        ?>
        <!-- The Title -->
        <p>
          <label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Título:', THEMEDOMAIN); ?></label>
          <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        // The Title
        $instance['title'] = strip_tags($new_instance['title']);

        return $instance;
    }

    public function widget($args, $instance)
    {
        extract($args);

        // Get the title and prepare it for display
        $title = apply_filters('widget_title', $instance['title']);

        $novedades = get_category_by_slug('novedades');

        if ($novedades) :

          $args = array(
            'parent' => $novedades->term_id
          );
          $categories = get_categories($args);

          if(count($categories)) :
            echo $before_widget;

            if ($title) {
              echo $before_title . $title . $after_title;
            }

            $thisCat = false;
            if (is_category()) {
              $thisCat = get_category(get_query_var('cat'));
            }
        ?>
            <ul class="Sidebar-widget-list">
              <?php foreach ($categories as $category) : ?>
                <?php
                  $active = '';
                  if ($thisCat) {
                    if ($thisCat->term_id === $category->term_id) {
                      $active = 'class="active"';
                    }
                  }
                ?>
                <li <?php echo $active; ?>><a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="text-uppercase"><?php echo $category->name; ?></a></li>
              <?php endforeach; ?>
            </ul>
            <?php
              echo $after_widget;
          endif;
        endif;
    }
}

register_widget('Muni_List_Categories_Widget');
