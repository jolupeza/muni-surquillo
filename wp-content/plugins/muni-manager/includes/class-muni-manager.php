<?php

/**
 * The Muni Manager is the core plugin responsible for including and
 * instantiating all of the code that composes the plugin.
 */

/**
 * The Muni Manager is the core plugin responsible for including and
 * instantiating all of the code that composes the plugin.
 *
 * The Muni Manager includes an instance to the Muni Manager
 * Loader which is responsible for coordinating the hooks that exist within the
 * plugin.
 *
 * It also maintains a reference to the plugin slug which can be used in
 * internationalization, and a reference to the current version of the plugin
 * so that we can easily update the version in a single place to provide
 * cache busting functionality when including scripts and styles.
 *
 * @since    1.0.0
 */
class Muni_Manager
{
    /**
     * A reference to the loader class that coordinates the hooks and callbacks
     * throughout the plugin.
     *
     * @var Cepuch_Manager_Loader Manages hooks between the WordPress hooks and the callback functions.
     */
    protected $loader;

    /**
     * Represents the slug of hte plugin that can be used throughout the plugin
     * for internationalization and other purposes.
     *
     * @var string The single, hyphenated string used to identify this plugin.
     */
    protected $plugin_slug;

    /**
     * Maintains the current version of the plugin so that we can use it throughout
     * the plugin.
     *
     * @var string The current version of the plugin.
     */
    protected $version;

    /**
     * Instantiates the plugin by setting up the core properties and loading
     * all necessary dependencies and defining the hooks.
     *
     * The constructor will define both the plugin slug and the verison
     * attributes, but will also use internal functions to import all the
     * plugin dependencies, and will leverage the Single_Post_Meta_Loader for
     * registering the hooks and the callback functions used throughout the
     * plugin.
     */
    public function __construct()
    {
        $this->plugin_slug = 'muni-manager-slug';
        $this->version = '1.0.0';

        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Imports the Muni Post Meta administration classes, and the Muni Post Meta Loader.
     *
     * The Muni Manager administration class defines all unique functionality for
     * introducing custom functionality into the WordPress dashboard.
     *
     * The Muni Manager Manager Loader is the class that will coordinate the hooks and callbacks
     * from WordPress and the plugin. This function instantiates and sets the reference to the
     * $loader class property.
     */
    private function load_dependencies()
    {
        require_once plugin_dir_path(dirname(__FILE__)).'admin/class-muni-manager-admin.php';
        require_once plugin_dir_path(dirname(__FILE__)).'public/class-muni-manager-public.php';

        require_once plugin_dir_path(__FILE__).'class-muni-manager-loader.php';
        $this->loader = new Muni_Manager_Loader();
    }

    /**
     * Defines the hooks and callback functions that are used for setting up the plugin stylesheets
     * and the plugin's meta box.
     *
     * This function relies on the Muni Post Meta Manager Admin class and the Muni Manager
     * Loader class property.
     */
    private function define_admin_hooks()
    {
        $admin = new Muni_Manager_Admin($this->get_version());
        $this->loader->add_action('init', $admin, 'add_post_type');
        $this->loader->add_action('admin_enqueue_scripts', $admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $admin, 'enqueue_scripts');

        $this->loader->add_action('add_meta_boxes', $admin, 'cd_mb_sliders_add');
        $this->loader->add_action('save_post', $admin, 'cd_mb_sliders_save' );

        $this->loader->add_action('add_meta_boxes', $admin, 'cd_mb_metas_add');
        $this->loader->add_action('save_post', $admin, 'cd_mb_metas_save' );

        // $this->loader->add_action('add_meta_boxes', $admin, 'cd_mb_contacts_add');
        // $this->loader->add_filter('manage_edit-contacts_columns', $admin, 'custom_columns_contacts');
        // $this->loader->add_action('manage_contacts_posts_custom_column', $admin, 'custom_column_contacts');
        // $this->loader->add_filter('views_edit-contacts', $admin, 'contacts_button_view_edit');

        // $this->loader->add_action('add_meta_boxes', $admin, 'cd_mb_posts_add');
        // $this->loader->add_action('save_post', $admin, 'cd_mb_posts_save' );

        // $this->loader->add_action('pre_get_posts', $admin, 'cepuch_get_posts');

        // $this->loader->add_action('add_meta_boxes', $admin, 'cd_mb_partners_add');
        // $this->loader->add_action('save_post', $admin, 'cd_mb_partners_save' );

        // $this->loader->add_action('add_meta_boxes', $admin, 'cd_mb_banners_add');
        // $this->loader->add_action('save_post', $admin, 'cd_mb_banners_save' );

        // $this->loader->add_action('add_meta_boxes', $admin, 'cd_mb_carreras_add');
        // $this->loader->add_action('save_post', $admin, 'cd_mb_carreras_save' );
        // $this->loader->add_action('init', $admin, 'add_taxonomies_carreras');

        // $this->loader->add_action('add_meta_boxes', $admin, 'cd_mb_subscribers_add');
        // $this->loader->add_filter('manage_edit-subscribers_columns', $admin, 'custom_columns_subscribers');
        // $this->loader->add_action('manage_subscribers_posts_custom_column', $admin, 'custom_column_subscribers');
        // $this->loader->add_filter('views_edit-subscribers', $admin, 'subscribers_button_view_edit');
        // $this->loader->add_action('restrict_manage_posts', $admin, 'subscribers_table_filtering');
        // $this->loader->add_filter('parse_query', $admin, 'subscribers_table_filter');
        // $this->loader->add_action('init', $admin, 'add_taxonomies_subscribers');

        // $this->loader->add_action('add_meta_boxes', $admin, 'cd_mb_students_add');
        // $this->loader->add_filter('manage_edit-students_columns', $admin, 'custom_columns_students');
        // $this->loader->add_action('manage_students_posts_custom_column', $admin, 'custom_column_students');
        // $this->loader->add_filter('views_edit-students', $admin, 'students_button_view_edit');
        // $this->loader->add_action('restrict_manage_posts', $admin, 'students_table_filtering');
        // $this->loader->add_filter('parse_query', $admin, 'students_table_filter');
        // $this->loader->add_action('init', $admin, 'add_taxonomies_students');

//         $this->loader->add_action('init', $admin, 'unregister_post_type');
    }

    /**
     * Defines the hooks and callback functions that are used for rendering information on the front
     * end of the site.
     *
     * This function relies on the Muni Manager Public class and the Muni Manager
     * Loader class property.
     */
    private function define_public_hooks()
    {
        $public = new Muni_Manager_Public($this->get_version());
        //$this->loader->add_action( 'the_content', $public, 'display_post_meta_data' );
    }

    /**
     * Sets this class into motion.
     *
     * Executes the plugin by calling the run method of the loader class which will
     * register all of the hooks and callback functions used throughout the plugin
     * with WordPress.
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * Returns the current version of the plugin to the caller.
     *
     * @return string $this->version    The current version of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
