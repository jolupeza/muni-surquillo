<?php

/**
 * The Muni Manager Admin defines all functionality for the dashboard
 * of the plugin.
 */

/**
 * The Muni Manager Admin defines all functionality for the dashboard
 * of the plugin.
 *
 * This class defines the meta box used to display the post meta data and registers
 * the style sheet responsible for styling the content of the meta box.
 *
 * @since    1.0.0
 */
class Muni_Manager_Admin
{
    /**
     * A reference to the version of the plugin that is passed to this class from the caller.
     *
     * @var string The current version of the plugin.
     */
    private $version;

    /**
     * Labels indicate allowed in custom fields.
     *
     * @var array
     */
    private $allowed;

    private $domain;

    /**
     * Initializes this class and stores the current version of this plugin.
     *
     * @param string $version The current version of this plugin.
     */
    public function __construct($version)
    {
        $this->version = $version;
        $this->allowed = array(
            'h2' => array(
              'style' => array(),
            ),
            'h4' => array(
              'style' => array(),
            ),
            'h5' => array(
              'style' => array(),
            ),
            'p' => array(
              'style' => array(),
            ),
            'a' => array(// on allow a tags
                'href' => array(),
                'target' => array(),
            ),
            'ul' => array(
                'class' => array(),
            ),
            'ol' => array(),
            'li' => array(
                'style' => array(),
            ),
            'strong' => array(),
            'br' => array(),
            'span' => array(),
        );

        $this->domain = 'cepuch-framework';
//        add_action('wp_ajax_generate_pdf', array(&$this, 'generate_pdf'));
//        add_action('wp_ajax_download_cv', array(&$this, 'download_cv'));
    }

    /**
     * Enqueues the style sheet responsible for styling the contents of this
     * meta box.
     */
    public function enqueue_styles()
    {
        wp_enqueue_style(
            'muni-manager-admin',
            plugin_dir_url(__FILE__).'css/muni-manager-admin.css',
            array(),
            $this->version,
            false
        );
    }

    /**
     * Enqueues the scripts responsible for functionality.
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            'muni-manager-admin',
            plugin_dir_url(__FILE__).'js/muni-manager-admin.js',
            array('jquery'),
            $this->version,
            true
        );
    }

    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type page.
     */
    public function cd_mb_pages_add()
    {
        add_meta_box(
            'mb-pages-id',
            'Otras Configuraciones',
            array($this, 'render_mb_pages'),
            'page',
            'normal',
            'core'
        );
    }

    public function cd_mb_pages_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'pages_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Video
        if (isset($_POST['mb_video']) && !empty($_POST['mb_video'])) {
            update_post_meta($post_id, 'mb_video', esc_attr($_POST['mb_video']));
        } else {
            delete_post_meta($post_id, 'mb_video');
        }

        // Icon
        if (isset($_POST['mb_icon']) && !empty($_POST['mb_icon'])) {
            update_post_meta($post_id, 'mb_icon', esc_attr($_POST['mb_icon']));
        } else {
            delete_post_meta($post_id, 'mb_icon');
        }
        
        // Text Link
        if (isset($_POST['mb_link_text']) && !empty($_POST['mb_link_text'])) {
            update_post_meta($post_id, 'mb_link_text', esc_attr($_POST['mb_link_text']));
        } else {
            delete_post_meta($post_id, 'mb_link_text');
        }
        
        // Link
        if (isset($_POST['mb_link']) && !empty($_POST['mb_link'])) {
            update_post_meta($post_id, 'mb_link', esc_attr($_POST['mb_link']));
        } else {
            delete_post_meta($post_id, 'mb_link');
        }
        
        // Files
        if (isset($_POST['mb_files']) && count($_POST['mb_files'])) {
            $files = $_POST['mb_files'];
            $files_title = $_POST['mb_files_title'];

            $save = false;
            $newArrFiles = array();
            $newArrTitle = array();
            $i = 0;

            foreach ($files as $file) {
                if (!empty($file)) {
                    $save = true;
                    $newArrFiles[] = $file;
                    $newArrTitle[] = $files_title[$i];
                }

                ++$i;
            }

            if ($save) {
                update_post_meta($post_id, 'mb_files', $newArrFiles);
                update_post_meta($post_id, 'mb_files_title', $newArrTitle);
            } else {
                delete_post_meta($post_id, 'mb_files');
                delete_post_meta($post_id, 'mb_files_title');
            }
        }
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_pages()
    {
        require_once plugin_dir_path(__FILE__).'partials/muni-mb-pages.php';
    }

    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type sliders.
     */
    public function cd_mb_sliders_add()
    {
        add_meta_box(
            'mb-sliders-id', 'Otras configuraciones', array($this, 'render_mb_sliders'), 'sliders', 'normal', 'core'
        );
    }

    public function cd_mb_sliders_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'sliders_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // URL
        if (isset($_POST['mb_url']) && !empty($_POST['mb_url'])) {
            update_post_meta($post_id, 'mb_url', esc_attr($_POST['mb_url']));
        } else {
            delete_post_meta($post_id, 'mb_url');
        }

        // Target
        $target = isset($_POST['mb_target']) && $_POST['mb_target'] ? 'on' : 'off';
        update_post_meta($post_id, 'mb_target', $target);
        
        // Image Responsive
        if (isset($_POST['mb_responsive']) && !empty($_POST['mb_responsive'])) {
            update_post_meta($post_id, 'mb_responsive', esc_attr($_POST['mb_responsive']));
        } else {
            delete_post_meta($post_id, 'mb_responsive');
        }
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_sliders()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/muni-mb-sliders.php';
    }

    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type subscribers.
     */
    public function cd_mb_subscribers_add()
    {
        add_meta_box(
            'mb-subscribers-id', 'Datos', array($this, 'render_mb_subscribers'), 'subscribers', 'normal', 'core'
        );
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_subscribers()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/muni-mb-subscribers.php';
    }

    public function custom_columns_subscribers($columns)
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'email' => __('Correo electrónico'),
            'date' => __('Fecha'),
        );

        return $columns;
    }

    public function custom_column_subscribers($column)
    {
        global $post;

        // Setup some vars
        $edit_link = get_edit_post_link($post->ID);
        $post_type_object = get_post_type_object($post->post_type);
        $can_edit_post = current_user_can('edit_post', $post->ID);
        $values = get_post_custom($post->ID);

        switch ($column) {
            case 'email':
                $email = isset($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';

                // Display the email
                if (!empty($email)) {
                    if($can_edit_post && $post->post_status != 'trash') {
                        echo '<a class="row-title" href="' . $edit_link . '" title="' . esc_attr(__('Editar este elemento')) . '">' . $email . '</a>';
                    } else {
                        echo "$email";
                    }
                }

                // Add admin actions
                $actions = array();
                if ($can_edit_post && 'trash' != $post->post_status) {
                    $actions['edit'] = '<a href="' . get_edit_post_link($post->ID, true) . '" title="' . esc_attr(__( 'Editar este elemento')) . '">' . __('Editar') . '</a>';
                }

                if (current_user_can('delete_post', $post->ID)) {
                    if ('trash' == $post->post_status) {
                        $actions['untrash'] = "<a title='" . esc_attr(__('Restaurar este elemento desde la papelera')) . "' href='" . wp_nonce_url(admin_url(sprintf($post_type_object->_edit_link . '&amp;action=untrash', $post->ID)), 'untrash-post_' . $post->ID) . "'>" . __('Restaurar') . "</a>";
                    } elseif(EMPTY_TRASH_DAYS) {
                        $actions['trash'] = "<a class='submitdelete' title='" . esc_attr(__('Mover este elemento a la papelera')) . "' href='" . get_delete_post_link($post->ID) . "'>" . __('Papelera') . "</a>";
                    }

                    if ('trash' == $post->post_status || !EMPTY_TRASH_DAYS) {
                        $actions['delete'] = "<a class='submitdelete' title='" . esc_attr(__('Borrar este elemento permanentemente')) . "' href='" . get_delete_post_link($post->ID, '', true) . "'>" . __('Borrar permanentemente') . "</a>";
                    }
                }

                $html = '<div class="row-actions">';
                if (isset($actions['edit'])) {
                    $html .= '<span class="edit">' . $actions['edit'] . ' | </span>';
                }
                if (isset($actions['trash'])) {
                    $html .= '<span class="trash">' . $actions['trash'] . '</span>';
                }
                if (isset($actions['untrash'])) {
                    $html .= '<span class="untrash">' . $actions['untrash'] . ' | </span>';
                }
                if (isset($actions['delete'])) {
                    $html .= '<span class="delete">' . $actions['delete'] . '</span>';
                }
                $html .= '</div>';

                echo $html;
                break;
        }
    }

    public function subscribers_button_view_edit($views)
    {
        echo '<p>'
        . '<a href="' . plugin_dir_url(dirname(__FILE__)) . 'subscribers/generateExcel/" class="button button-primary">Generar excel</a>'
        . '</p>';

        return $views;
    }

    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type contacts.
     */
    public function cd_mb_contacts_add() {
        add_meta_box(
            'mb-contacts-id', 'Datos', array($this, 'render_mb_contacts'), 'contacts', 'normal', 'core'
        );
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_contacts() {
        require_once plugin_dir_path(__FILE__) . 'partials/muni-mb-contacts.php';
    }
    
    public function custom_columns_contacts($columns)
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => __('Nombre'),
            'email' => __('Correo electrónico'),
            'taxonomy-subjects' => __('Asunto'),
            'date' => __('Fecha'),
        );

        return $columns;
    }

    public function custom_column_contacts($column)
    {
        global $post;

        // Setup some vars
        $edit_link = get_edit_post_link($post->ID);
        $post_type_object = get_post_type_object($post->post_type);
        $can_edit_post = current_user_can('edit_post', $post->ID);
        $values = get_post_custom($post->ID);

        switch ($column) {
            case 'name':
                $name = isset($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
                $lastname = isset($values['mb_lastname']) ? esc_attr($values['mb_lastname'][0]) : '';
                
                $fullname = "$name $lastname";

                // Display the email
                if (!empty($fullname)) {
                    if($can_edit_post && $post->post_status != 'trash') {
                        echo '<a class="row-title" href="' . $edit_link . '" title="' . esc_attr(__('Editar este elemento')) . '">' . $fullname . '</a>';
                    } else {
                        echo "$fullname";
                    }
                }

                // Add admin actions
                $actions = array();
                if ($can_edit_post && 'trash' != $post->post_status) {
                    $actions['edit'] = '<a href="' . get_edit_post_link($post->ID, true) . '" title="' . esc_attr(__( 'Editar este elemento')) . '">' . __('Editar') . '</a>';
                }

                if (current_user_can('delete_post', $post->ID)) {
                    if ('trash' == $post->post_status) {
                        $actions['untrash'] = "<a title='" . esc_attr(__('Restaurar este elemento desde la papelera')) . "' href='" . wp_nonce_url(admin_url(sprintf($post_type_object->_edit_link . '&amp;action=untrash', $post->ID)), 'untrash-post_' . $post->ID) . "'>" . __('Restaurar') . "</a>";
                    } elseif(EMPTY_TRASH_DAYS) {
                        $actions['trash'] = "<a class='submitdelete' title='" . esc_attr(__('Mover este elemento a la papelera')) . "' href='" . get_delete_post_link($post->ID) . "'>" . __('Papelera') . "</a>";
                    }

                    if ('trash' == $post->post_status || !EMPTY_TRASH_DAYS) {
                        $actions['delete'] = "<a class='submitdelete' title='" . esc_attr(__('Borrar este elemento permanentemente')) . "' href='" . get_delete_post_link($post->ID, '', true) . "'>" . __('Borrar permanentemente') . "</a>";
                    }
                }

                $html = '<div class="row-actions">';
                if (isset($actions['edit'])) {
                    $html .= '<span class="edit">' . $actions['edit'] . ' | </span>';
                }
                if (isset($actions['trash'])) {
                    $html .= '<span class="trash">' . $actions['trash'] . '</span>';
                }
                if (isset($actions['untrash'])) {
                    $html .= '<span class="untrash">' . $actions['untrash'] . ' | </span>';
                }
                if (isset($actions['delete'])) {
                    $html .= '<span class="delete">' . $actions['delete'] . '</span>';
                }
                $html .= '</div>';

                echo $html;
                break;
            case 'email':
                $email = isset($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
                echo $email;
                break;
        }
    }

    public function contacts_button_view_edit($views)
    {
        echo '<p>'
        . '<a href="' . plugin_dir_url(dirname(__FILE__)) . 'contacts/generateExcel/" class="button button-primary">Generar excel</a>'
        . '</p>';

        return $views;
    }

    /**
     * Add custom content type slides.
     */
    public function add_post_type()
    {
        $labels = array(
            'name'               => __('Sliders', $this->domain),
            'singular_name'      => __('Slider', $this->domain),
            'add_new'            => __('Nuevo slider', $this->domain),
            'add_new_item'       => __('Agregar nuevo slider', $this->domain),
            'edit_item'          => __('Editar slider', $this->domain),
            'new_item'           => __('Nuevo slider', $this->domain),
            'view_item'          => __('Ver slider', $this->domain),
            'search_items'       => __('Buscar slider', $this->domain),
            'not_found'          => __('Slider no encontrado', $this->domain),
            'not_found_in_trash' => __('Slider no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todos los sliders', $this->domain),
  //          'archives' - String for use with archives in nav menus. Default is Post Archives/Page Archives.
  //          'insert_into_item' - String for the media frame button. Default is Insert into post/Insert into page.
  //          'uploaded_to_this_item' - String for the media frame filter. Default is Uploaded to this post/Uploaded to this page.
  //          'featured_image' - Default is Featured Image.
  //          'set_featured_image' - Default is Set featured image.
  //          'remove_featured_image' - Default is Remove featured image.
  //          'use_featured_image' - Default is Use as featured image.
  //          'menu_name' - Default is the same as `name`.
  //          'filter_items_list' - String for the table views hidden heading.
  //          'items_list_navigation' - String for the table pagination hidden heading.
  //          'items_list' - String for the table hidden heading.
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Sliders visibles en el homepage',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-images-alt2',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
                'editor',
                'custom-fields',
                'author',
                'thumbnail',
                'page-attributes',
                // 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            // 'rewrite'     => true
        );
        register_post_type('sliders', $args);

        $labels = array(
            'name'               => __('Suscriptores', $this->domain),
            'singular_name'      => __('Suscriptor', $this->domain),
            'add_new'            => __('Nuevo Suscriptor', $this->domain),
            'add_new_item'       => __('Agregar nuevo Suscriptor', $this->domain),
            'edit_item'          => __('Editar Suscriptor', $this->domain),
            'new_item'           => __('Nuevo Suscriptor', $this->domain),
            'view_item'          => __('Ver Suscriptor', $this->domain),
            'search_items'       => __('Buscar Suscriptor', $this->domain),
            'not_found'          => __('Suscriptor no encontrado', $this->domain),
            'not_found_in_trash' => __('Suscriptor no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todos los Suscriptores', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Lista de Suscriptores',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-groups',
            // 'hierarchical'        => false,
            'supports' => array(
                // 'title',
                // 'editor',
                'custom-fields',
                'author',
                // 'thumbnail',
                // 'page-attributes',
                // 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            // 'rewrite'     => true
        );
        register_post_type('subscribers', $args);
        
        $labels = array(
            'name'               => __('Contactos', $this->domain),
            'singular_name'      => __('Contacto', $this->domain),
            'add_new'            => __('Nuevo contacto', $this->domain),
            'add_new_item'       => __('Agregar nuevo contacto', $this->domain),
            'edit_item'          => __('Editar contacto', $this->domain),
            'new_item'           => __('Nuevo contacto', $this->domain),
            'view_item'          => __('Ver contacto', $this->domain),
            'search_items'       => __('Buscar contacto', $this->domain),
            'not_found'          => __('Contacto no encontrado', $this->domain),
            'not_found_in_trash' => __('COntacto no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todos los Contactos', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Lista de Contactos',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-id',
            // 'hierarchical'        => false,
            'supports' => array(
                // 'title',
                // 'editor',
                'custom-fields',
                'author',
                // 'thumbnail',
                // 'page-attributes',
                // 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            // 'rewrite'     => true
        );
        register_post_type('contacts', $args);
    }

    public function unregister_post_type()
    {
        global $wp_post_types;

        if (isset($wp_post_types[ 'videos' ])) {
            unset($wp_post_types[ 'videos' ]);

            return true;
        }

        return false;
    }

    /**
     * Exclude pages from search results.
     */
    public function remove_pages_wp_search($query)
    {
        if ($query->is_search() && $query->is_main_query()) {
            $query->set('post_type', 'post');
        }
    }
    
    /**
     * Add custom taxonomies category to post type contacts.
     */
    public function add_taxonomies_contacts()
    {
        $labels = array(
            'name' => _x('Asuntos', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Asunto', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Asunto', THEMEDOMAIN),
            'popular_items' => __('Asuntos Populares', THEMEDOMAIN),
            'all_items' => __('Todos los Asuntos', THEMEDOMAIN),
            'parent_item' => __('Asunto Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Asunto Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Asunto', THEMEDOMAIN),
            'update_item' => __('Actualizar Asunto', THEMEDOMAIN),
            'add_new_item' => __('Añadir nuevo Asunto', THEMEDOMAIN),
            'new_item_name' => __('Nuevo Asunto', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Asunto', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Asunto', THEMEDOMAIN),
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => false,
            'show_admin_column' => true,
            'hierarchical' => true,
            'show_tagcloud' => false,
            'show_ui' => true,
            'query_var' => true,
            'reqrite' => true,
            'rewrite' => false,
            'query_var' => true,
            'capabilities' => array(),
        );

        register_taxonomy('subjects', 'contacts', $args);
    }
}
