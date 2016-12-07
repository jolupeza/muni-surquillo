<?php
/***********************************************************************************************/
/* Widget that displays categories */
/***********************************************************************************************/

class Muni_List_Tags_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
          'muni_list_tags_w',
          'Custom Widget: Lista de Etiquetas',
          array('description' => __('Mostrar lista de etiquetas utilizadas', THEMEDOMAIN))
        );
    }

    public function form($instance)
    {
        $defaults = array(
          'title' => 'Etiquetas',
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

        $args = array(
          'number' => 5,
          'orderby' => 'count',
          'order' => 'DESC'
        );
        $tags = get_tags($args);

        if (count($tags)) :
          echo $before_widget;

          if ($title) {
            echo $before_title . $title . $after_title;
          }

          $thisTag = false;
          if (is_tag()) {
            $thisTag = get_queried_object();
          }
        ?>
          <ul class="Sidebar-widget-list">
            <?php foreach ($tags as $tag) : ?>
              <?php
                $active = '';
                if ($thisTag) {
                  if ($thisTag->term_id === $tag->term_id) {
                    $active = 'class="active"';
                  }
                }
              ?>
              <li <?php echo $active; ?>><a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="text-uppercase"><?php echo $tag->name; ?></a></li>
            <?php endforeach; ?>
          </ul>
        <?php
          echo $after_widget;
        endif;
    }
}

register_widget('Muni_List_Tags_Widget');
