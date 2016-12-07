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
        
        // Display home
        $display_home = isset($_POST['mb_display_home']) && $_POST['mb_display_home'] ? 'on' : 'off';
        update_post_meta($post_id, 'mb_display_home', $display_home);
        
        // Image Responsive
        if (isset($_POST['mb_responsive']) && !empty($_POST['mb_responsive'])) {
            update_post_meta($post_id, 'mb_responsive', esc_attr($_POST['mb_responsive']));
        } else {
            delete_post_meta($post_id, 'mb_responsive');
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
        
        // Forms
        if (isset($_POST['mb_forms']) && !empty($_POST['mb_forms'])) {
            update_post_meta($post_id, 'mb_forms', wp_kses($_POST['mb_forms'], $this->allowed));
        } else {
            delete_post_meta($post_id, 'mb_forms');
        }
        
        // How
        if (isset($_POST['mb_how']) && !empty($_POST['mb_how'])) {
            update_post_meta($post_id, 'mb_how', wp_kses($_POST['mb_how'], $this->allowed));
        } else {
            delete_post_meta($post_id, 'mb_how');
        }
        
        // Cases
        if (isset($_POST['mb_cases']) && !empty($_POST['mb_cases'])) {
            update_post_meta($post_id, 'mb_cases', wp_kses($_POST['mb_cases'], $this->allowed));
        } else {
            delete_post_meta($post_id, 'mb_cases');
        }
        
        // Legislation
        if (isset($_POST['mb_legislation']) && !empty($_POST['mb_legislation'])) {
            update_post_meta($post_id, 'mb_legislation', wp_kses($_POST['mb_legislation'], $this->allowed));
        } else {
            delete_post_meta($post_id, 'mb_legislation');
        }
        
        // Locales
        if (isset($_POST['mb_locales'])) {
            update_post_meta($post_id, 'mb_locales', $_POST['mb_locales']);
        } else {
            delete_post_meta($post_id, 'mb_locales');
        }
        
        // iframe
        if (isset($_POST['mb_iframe']) && !empty($_POST['mb_iframe'])) {
            update_post_meta($post_id, 'mb_iframe', esc_attr($_POST['mb_iframe']));
        } else {
            delete_post_meta($post_id, 'mb_iframe');
        }
        
        // Image Bg
        if (isset($_POST['mb_bg']) && !empty($_POST['mb_bg'])) {
            update_post_meta($post_id, 'mb_bg', esc_attr($_POST['mb_bg']));
        } else {
            delete_post_meta($post_id, 'mb_bg');
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
     * associated with post type page.
     */
    public function cd_mb_post_add()
    {
        add_meta_box(
            'mb-post-id',
            'Otras Configuraciones',
            array($this, 'render_mb_post'),
            'post',
            'normal',
            'core'
        );
    }

    public function cd_mb_post_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'post_meta_box_nonce')) {
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
        
        // Images
        if (isset($_POST['mb_images']) && count($_POST['mb_images'])) {
            $images = $_POST['mb_images'];

            $save = false;
            $newArrImages = array();
            $i = 0;

            foreach ($images as $image) {
                if (!empty($image)) {
                    $save = true;
                    $newArrImages[] = $image;
                }

                ++$i;
            }

            if ($save) {
                update_post_meta($post_id, 'mb_images', $newArrImages);
            } else {
                delete_post_meta($post_id, 'mb_images');
            }
        } else {
            delete_post_meta($post_id, 'mb_images');
        }
        
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
    public function render_mb_post()
    {
        require_once plugin_dir_path(__FILE__).'partials/muni-mb-post.php';
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
        
        // Page
        if( isset( $_POST['mb_page'] ) && !empty($_POST['mb_page']) ) {
            update_post_meta( $post_id, 'mb_page', esc_attr( $_POST['mb_page'] ) );
        } else {
            delete_post_meta($post_id, 'mb_page');
        }
        
        // Link Text
        if (isset($_POST['mb_link_text']) && !empty($_POST['mb_link_text'])) {
            update_post_meta($post_id, 'mb_link_text', esc_attr($_POST['mb_link_text']));
        } else {
            delete_post_meta($post_id, 'mb_link_text');
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
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type directories.
     */
    public function cd_mb_directories_add()
    {
        add_meta_box(
            'mb-directories-id', 'Configuraciones', array($this, 'render_mb_directories'), 'directories', 'normal', 'core'
        );
    }

    public function cd_mb_directories_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'directories_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Phone
        if (isset($_POST['mb_phone']) && !empty($_POST['mb_phone'])) {
            update_post_meta($post_id, 'mb_phone', esc_attr($_POST['mb_phone']));
        } else {
            delete_post_meta($post_id, 'mb_phone');
        }
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_directories()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/muni-mb-directories.php';
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type authorities.
     */
    public function cd_mb_authorities_add()
    {
        add_meta_box(
            'mb-sliders-id', 'Configuraciones', array($this, 'render_mb_authorities'), 'authorities', 'normal', 'core'
        );
    }

    public function cd_mb_authorities_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'authorities_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Job
        if( isset( $_POST['mb_job'] ) && !empty($_POST['mb_job']) ) {
            update_post_meta( $post_id, 'mb_job', esc_attr( $_POST['mb_job'] ) );
        } else {
            delete_post_meta($post_id, 'mb_job');
        }
        
        // Email
        if (isset($_POST['mb_email']) && !empty($_POST['mb_email'])) {
            update_post_meta($post_id, 'mb_email', esc_attr($_POST['mb_email']));
        } else {
            delete_post_meta($post_id, 'mb_email');
        }
        
        // Phone
        if (isset($_POST['mb_phone']) && !empty($_POST['mb_phone'])) {
            update_post_meta($post_id, 'mb_phone', esc_attr($_POST['mb_phone']));
        } else {
            delete_post_meta($post_id, 'mb_phone');
        }
        
        // Address
        if (isset($_POST['mb_address']) && !empty($_POST['mb_address'])) {
            update_post_meta($post_id, 'mb_address', esc_attr($_POST['mb_address']));
        } else {
            delete_post_meta($post_id, 'mb_address');
        }
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_authorities()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/muni-mb-authorities.php';
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type locales.
     */
    public function cd_mb_locales_add()
    {
        add_meta_box(
            'mb-locales-id', 'Configuraciones', array($this, 'render_mb_locales'), 'locales', 'normal', 'core'
        );
    }

    public function cd_mb_locales_save($post_id)
    {
        // Bail if we're doing an auto save
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // if our nonce isn't there, or we can't verify it, bail
        if (!isset($_POST['meta_box_nonce']) || !wp_verify_nonce($_POST['meta_box_nonce'], 'locales_meta_box_nonce')) {
            return;
        }

        // if our current user can't edit this post, bail
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Phone
        if( isset( $_POST['mb_phone'] ) && !empty($_POST['mb_phone']) ) {
            update_post_meta( $post_id, 'mb_phone', esc_attr( $_POST['mb_phone'] ) );
        } else {
            delete_post_meta($post_id, 'mb_phone');
        }
        
        // Address
        if (isset($_POST['mb_address']) && !empty($_POST['mb_address'])) {
            update_post_meta($post_id, 'mb_address', esc_attr($_POST['mb_address']));
        } else {
            delete_post_meta($post_id, 'mb_address');
        }
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_locales()
    {
        require_once plugin_dir_path(__FILE__) . 'partials/muni-mb-locales.php';
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type books.
     */
    public function cd_mb_books_add() {
        add_meta_box(
            'mb-books-id', 'Datos', array($this, 'render_mb_books'), 'books', 'normal', 'core'
        );
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_books() {
        require_once plugin_dir_path(__FILE__) . 'partials/muni-mb-books.php';
    }
    
    public function custom_columns_books($columns)
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => __('Nombre'),
            'email' => __('Correo electrónico'),
            'service' => __('Servicio'),
            'file' => __('Archivo'),
            'date' => __('Fecha'),
        );

        return $columns;
    }

    public function custom_column_books($column)
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

                // Display the name
                if (!empty($name)) {
                    if($can_edit_post && $post->post_status != 'trash') {
                        echo '<a class="row-title" href="' . $edit_link . '" title="' . esc_attr(__('Editar este elemento')) . '">' . $name . '</a>';
                    } else {
                        echo "$name";
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
            case 'service':
                $service = isset($values['mb_service']) ? esc_attr($values['mb_service'][0]) : '';
                echo $service;
                break;
            case 'file':
                $file = isset($values['mb_file']) ? esc_attr($values['mb_file'][0]) : '';

                if (!empty($file)) {
//                    $arrFile = explode('/', $file);

                    $filePath = ABSPATH . 'librodereclamaciones' . DIRECTORY_SEPARATOR . $file;

                    if (file_exists($filePath)) {
                        $urlFile = home_url('librodereclamaciones/' . $file);

                        echo '<a href="'.$urlFile.'" class="button button-primary button-large view-pdf" target="_blank">Descargar Archivo</a>';
                    }
                }
                break;
        }
    }

    public function books_button_view_edit($views)
    {
        echo '<p>'
        . '<a href="' . plugin_dir_url(dirname(__FILE__)) . 'books/generateExcel/" class="button button-primary">Generar excel</a>'
        . '</p>';

        return $views;
    }
    
    /**
     * Registers the meta box that will be used to display all of the post meta data
     * associated with post type informations.
     */
    public function cd_mb_informations_add() {
        add_meta_box(
            'mb-informations-id', 'Datos', array($this, 'render_mb_informations'), 'informations', 'normal', 'core'
        );
    }

    /**
     * Requires the file that is used to display the user interface of the post meta box.
     */
    public function render_mb_informations() {
        require_once plugin_dir_path(__FILE__) . 'partials/muni-mb-informations.php';
    }
    
    public function custom_columns_informations($columns)
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'name' => __('Nombre'),
            'email' => __('Correo electrónico'),
            'phone' => __('Teléfono'),
            'infsol' => __('Información Solicitada'),
            'date' => __('Fecha'),
        );

        return $columns;
    }

    public function custom_column_informations($column)
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

                // Display the name
                if (!empty($name)) {
                    if($can_edit_post && $post->post_status != 'trash') {
                        echo '<a class="row-title" href="' . $edit_link . '" title="' . esc_attr(__('Editar este elemento')) . '">' . $name . '</a>';
                    } else {
                        echo "$name";
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
            case 'phone':
                $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
                echo $phone;
                break;
            case 'infsol':
                $infsol = isset($values['mb_infsol']) ? esc_attr($values['mb_infsol'][0]) : '';
                echo $infsol;
                break;
        }
    }

    public function informations_button_view_edit($views)
    {
        echo '<p>'
        . '<a href="' . plugin_dir_url(dirname(__FILE__)) . 'informations/generateExcel/" class="button button-primary">Generar excel</a>'
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
        
        $labels = array(
            'name'               => __('Directorios', $this->domain),
            'singular_name'      => __('Directorio', $this->domain),
            'add_new'            => __('Nuevo directorio', $this->domain),
            'add_new_item'       => __('Agregar nuevo directorio', $this->domain),
            'edit_item'          => __('Editar directorio', $this->domain),
            'new_item'           => __('Nuevo directorio', $this->domain),
            'view_item'          => __('Ver directorio', $this->domain),
            'search_items'       => __('Buscar directorio', $this->domain),
            'not_found'          => __('Directorio no encontrado', $this->domain),
            'not_found_in_trash' => __('Directorio no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todos los Directorios', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Directorio de Teléfonos y Anexos Municipales',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-phone',
            // 'hierarchical'        => false,
            'supports' => array(
                 'title',
//                 'editor',
                'custom-fields',
                'author',
                // 'thumbnail',
                // 'page-attributes',
                 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            // 'rewrite'     => true
        );
        register_post_type('directories', $args);
        
        $labels = array(
            'name'               => __('Metas', $this->domain),
            'singular_name'      => __('Meta', $this->domain),
            'add_new'            => __('Nueva meta', $this->domain),
            'add_new_item'       => __('Agregar nueva meta', $this->domain),
            'edit_item'          => __('Editar meta', $this->domain),
            'new_item'           => __('Nueva meta', $this->domain),
            'view_item'          => __('Ver meta', $this->domain),
            'search_items'       => __('Buscar meta', $this->domain),
            'not_found'          => __('Meta no encontrada', $this->domain),
            'not_found_in_trash' => __('Meta no encontrada en la papelera', $this->domain),
            'all_items'          => __('Todos las Metas Municipales', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Metas Municipales',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-share-alt2',
            // 'hierarchical'        => false,
            'supports' => array(
                 'title',
                 'editor',
//                'custom-fields',
                'author',
                // 'thumbnail',
                 'page-attributes',
//                 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            // 'rewrite'     => true
        );
        register_post_type('metas', $args);
        
        $labels = array(
            'name'               => __('Autoridades', $this->domain),
            'singular_name'      => __('Autoridad', $this->domain),
            'add_new'            => __('Nueva autoridad', $this->domain),
            'add_new_item'       => __('Agregar nueva autoridad', $this->domain),
            'edit_item'          => __('Editar autoridad', $this->domain),
            'new_item'           => __('Nueva autoridad', $this->domain),
            'view_item'          => __('Ver autoridad', $this->domain),
            'search_items'       => __('Buscar autoridad', $this->domain),
            'not_found'          => __('Autoridad no encontrada', $this->domain),
            'not_found_in_trash' => __('Autoridad no encontrada en la papelera', $this->domain),
            'all_items'          => __('Todos las Autoridades Municipales', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Autoridades Municipales',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-networking',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
                'editor',
                'custom-fields',
                'author',
                'thumbnail',
                'page-attributes',
//                 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            // 'rewrite'     => true
        );
        register_post_type('authorities', $args);
        
        $labels = array(
            'name'               => __('Locales', $this->domain),
            'singular_name'      => __('Local', $this->domain),
            'add_new'            => __('Nuevo local', $this->domain),
            'add_new_item'       => __('Agregar nuevo local', $this->domain),
            'edit_item'          => __('Editar local', $this->domain),
            'new_item'           => __('Nuevo local', $this->domain),
            'view_item'          => __('Ver local', $this->domain),
            'search_items'       => __('Buscar local', $this->domain),
            'not_found'          => __('Local no encontrado', $this->domain),
            'not_found_in_trash' => __('Local no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todos los Locales', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Locales',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-admin-home',
            // 'hierarchical'        => false,
            'supports' => array(
                'title',
                'editor',
                'custom-fields',
                'author',
                'thumbnail',
                'page-attributes',
//                 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            // 'rewrite'     => true
        );
        register_post_type('locales', $args);
        
        $labels = array(
            'name'               => __('Ciudades', $this->domain),
            'singular_name'      => __('Ciudad', $this->domain),
            'add_new'            => __('Nueva ciudad', $this->domain),
            'add_new_item'       => __('Agregar nueva ciudad', $this->domain),
            'edit_item'          => __('Editar ciudad', $this->domain),
            'new_item'           => __('Nueva ciudad', $this->domain),
            'view_item'          => __('Ver ciudad', $this->domain),
            'search_items'       => __('Buscar ciudad', $this->domain),
            'not_found'          => __('Ciudad no encontrada', $this->domain),
            'not_found_in_trash' => __('Ciudad no encontrada en la papelera', $this->domain),
            'all_items'          => __('Todos las Ciudades', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Ciudades',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-location-alt',
            'hierarchical'        => true,
            'supports' => array(
                'title',
//                'editor',
//                'custom-fields',
                'author',
//                'thumbnail',
                'page-attributes',
//                 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            // 'rewrite'     => true
        );
        register_post_type('cities', $args);
        
        $labels = array(
            'name'               => __('Libros', $this->domain),
            'singular_name'      => __('Libro', $this->domain),
            'add_new'            => __('Nuevo Libro', $this->domain),
            'add_new_item'       => __('Agregar nuevo Libro', $this->domain),
            'edit_item'          => __('Editar libro ', $this->domain),
            'new_item'           => __('Nuevo libro', $this->domain),
            'view_item'          => __('Ver libro', $this->domain),
            'search_items'       => __('Buscar libro', $this->domain),
            'not_found'          => __('Libro no encontrado', $this->domain),
            'not_found_in_trash' => __('Libro no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todos los Libros', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Libro de Reclamaciones',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-book',
            'hierarchical'        => false,
            'supports' => array(
//                'title',
//                'editor',
                'custom-fields',
                'author',
//                'thumbnail',
//                'page-attributes',
//                 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            // 'rewrite'     => true
        );
        register_post_type('books', $args);
        
        $labels = array(
            'name'               => __('Documentos', $this->domain),
            'singular_name'      => __('Documento', $this->domain),
            'add_new'            => __('Nuevo Documento', $this->domain),
            'add_new_item'       => __('Agregar nuevo Documento', $this->domain),
            'edit_item'          => __('Editar documento ', $this->domain),
            'new_item'           => __('Nuevo documento', $this->domain),
            'view_item'          => __('Ver documento', $this->domain),
            'search_items'       => __('Buscar documento', $this->domain),
            'not_found'          => __('Documento no encontrado', $this->domain),
            'not_found_in_trash' => __('Documento no encontrado en la papelera', $this->domain),
            'all_items'          => __('Todos los Documentos', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Tipo de Documento',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-id',
            'hierarchical'        => false,
            'supports' => array(
                'title',
//                'editor',
//                'custom-fields',
                'author',
//                'thumbnail',
//                'page-attributes',
//                 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            // 'rewrite'     => true
        );
        register_post_type('documents', $args);
        
        $labels = array(
            'name'               => __('Solicitudes', $this->domain),
            'singular_name'      => __('Solicitud', $this->domain),
            'add_new'            => __('Nueva Solicitud', $this->domain),
            'add_new_item'       => __('Agregar nueva Solicitud', $this->domain),
            'edit_item'          => __('Editar solicitud ', $this->domain),
            'new_item'           => __('Nueva solicitud', $this->domain),
            'view_item'          => __('Ver solicitud', $this->domain),
            'search_items'       => __('Buscar solicitud', $this->domain),
            'not_found'          => __('Solicitud no encontrada', $this->domain),
            'not_found_in_trash' => __('Solicitud no encontrada en la papelera', $this->domain),
            'all_items'          => __('Todos los Solicitudes', $this->domain),
        );
        $args = array(
            'labels' => $labels,
            'description' => 'Solicitud Acceso a la Información',
            // 'public'              => false,
            // 'exclude_from_search' => true,
            // 'publicly_queryable' => false,
            'show_ui' => true,
            'show_in_nav_menus' => false,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            // 'menu_position'          => null,
            'menu_icon' => 'dashicons-media-text',
            'hierarchical'        => false,
            'supports' => array(
//                'title',
//                'editor',
                'custom-fields',
                'author',
//                'thumbnail',
//                'page-attributes',
//                 'excerpt'
                // 'trackbacks'
                // 'comments',
                // 'revisions',
                // 'post-formats'
            ),
            // 'taxonomies'  => array('post_tag', 'category'),
            // 'has_archive' => false,
            // 'rewrite'     => true
        );
        register_post_type('informations', $args);
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
            if (isset($_GET['only_posts']) && $_GET['only_posts'] === 'posts') {
                $query->set('post_type', 'post');
            }
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
    
    /**
     * Add custom taxonomies category to post type directories.
     */
    public function add_taxonomies_directories()
    {
        $labels = array(
            'name' => _x('Secciones', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Sección', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Sección', THEMEDOMAIN),
            'popular_items' => __('Secciones Populares', THEMEDOMAIN),
            'all_items' => __('Todos las Secciones', THEMEDOMAIN),
            'parent_item' => __('Sección Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Sección Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Sección', THEMEDOMAIN),
            'update_item' => __('Actualizar Sección', THEMEDOMAIN),
            'add_new_item' => __('Añadir nueva Sección', THEMEDOMAIN),
            'new_item_name' => __('Nueva Sección', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Sección', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Secciones', THEMEDOMAIN),
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

        register_taxonomy('sections', 'directories', $args);
    }
    
    /**
     * Add custom taxonomies category to post type authorities.
     */
    public function add_taxonomies_authorities()
    {
        $labels = array(
            'name' => _x('Roles', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Rol', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Rol', THEMEDOMAIN),
            'popular_items' => __('Roles Populares', THEMEDOMAIN),
            'all_items' => __('Todos los Roles', THEMEDOMAIN),
            'parent_item' => __('Rol Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Rol Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Rol', THEMEDOMAIN),
            'update_item' => __('Actualizar Rol', THEMEDOMAIN),
            'add_new_item' => __('Añadir nuevo Rol', THEMEDOMAIN),
            'new_item_name' => __('Nuevo Rol', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Rol', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Roles', THEMEDOMAIN),
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

        register_taxonomy('roles', 'authorities', $args);
    }
    
    /**
     * Add custom taxonomies category to post type pages.
     */
    public function add_taxonomies_pages()
    {
        $labels = array(
            'name' => _x('Servicios', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Servicio', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Servicio', THEMEDOMAIN),
            'popular_items' => __('Servicios Populares', THEMEDOMAIN),
            'all_items' => __('Todos los Servicios', THEMEDOMAIN),
            'parent_item' => __('Servicio Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Servicio Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Servicio', THEMEDOMAIN),
            'update_item' => __('Actualizar Servicio', THEMEDOMAIN),
            'add_new_item' => __('Añadir nuevo Servicio', THEMEDOMAIN),
            'new_item_name' => __('Nuevo Servicio', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Servicio', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Servicios', THEMEDOMAIN),
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

        register_taxonomy('services', 'page', $args);
    }
    
    /**
     * Add custom taxonomies category to post type documents.
     */
    public function add_taxonomies_deliveries()
    {
        $labels = array(
            'name' => _x('Formas de Entrega', 'Taxonomy plural name', THEMEDOMAIN),
            'singular_name' => _x('Forma de Entrega', 'Taxonomy singular name', THEMEDOMAIN),
            'search_items' => __('Buscar Forma de Entrega', THEMEDOMAIN),
            'popular_items' => __('Formas de Entrega Populares', THEMEDOMAIN),
            'all_items' => __('Todos las Formas de Entrega', THEMEDOMAIN),
            'parent_item' => __('Forma de Entrega Padre', THEMEDOMAIN),
            'parent_item_colon' => __('Forma de Entrega Padre', THEMEDOMAIN),
            'edit_item' => __('Editar Forma de Entrega', THEMEDOMAIN),
            'update_item' => __('Actualizar Forma de Entrega', THEMEDOMAIN),
            'add_new_item' => __('Añadir nueva Forma de Entrega', THEMEDOMAIN),
            'new_item_name' => __('Nueva Forma de Entrega', THEMEDOMAIN),
            'add_or_remove_items' => __('Añadir o eliminar Forma de Entrega', THEMEDOMAIN),
            'choose_from_most_used' => __('Choose from most used text-domain', THEMEDOMAIN),
            'menu_name' => __('Formas de Entrega', THEMEDOMAIN),
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

        register_taxonomy('deliveries', 'informations', $args);
    }
}
