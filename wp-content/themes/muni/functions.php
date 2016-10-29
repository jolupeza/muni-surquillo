<?php
/***************************************/
/* Define Constants */
/***************************************/
define('THEMEROOT', get_stylesheet_directory_uri());
define('IMAGES', THEMEROOT . '/images');
define('THEMEDOMAIN', 'muni-framework');

/***************************************/
/* Load JS Files */
/***************************************/
function load_custom_scripts() {
  wp_enqueue_script('vendor_script', THEMEROOT . '/js/vendor.min.js', array('jquery'), false, true);
  wp_enqueue_script('custom_script', THEMEROOT . '/js/app.min.js', array('jquery'), false, true);
  wp_enqueue_script('main_script', THEMEROOT . '/js/main.js', array('jquery'), false, true);
  wp_localize_script('custom_script', 'MuniAjax', array('url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('muniajax-nonce')));
}
add_action('wp_enqueue_scripts', 'load_custom_scripts');

/***************************************/
/* Add Theme Support */
/***************************************/
if (function_exists('add_theme_support')) {
  // add_theme_support('post-formats', array('link', 'quote', 'gallery', 'video'));

  add_theme_support('post-thumbnails', array('post', 'page', 'sliders', 'metas'));
  //set_post_thumbnail_size(210, 210, true);
  // add_image_size('events-small', 760, 281, true);
  // add_image_size('events-large', 362, 593, true);

  //add_theme_support('automatic-feed-links');
}

/***************************************/
/* Add Menus */
/***************************************/
function register_my_menus() {
  register_nav_menus(
    [
      'main-menu'   => __( 'Main Menu', THEMEDOMAIN ),
      'top-menu'   => __( 'Top Menu', THEMEDOMAIN ),
      'footer-link-menu'   => __( 'Enlaces Footer Menu', THEMEDOMAIN ),
      'footer-service-menu'   => __( 'Servicios Footer Menu', THEMEDOMAIN ),
    ]
  );
}
add_action('init', 'register_my_menus');

/***************************************/
/* Add Logo Theme */
/***************************************/
function my_theme_setup() {
  add_theme_support('custom-logo', [
    'height' => 90,
    'width' => 285,
    'flex-height' => true
  ]);
}
add_action('after_setup_theme', 'my_theme_setup');

/**********************************************************************************/
/* Add Sidebar Support */
/**********************************************************************************/
if (function_exists('register_sidebar'))
{
  // register_sidebar(
  //   array(
  //     'name'          => __('Category Sidebar', THEMEDOMAIN),
  //     'id'            => 'main-sidebar',
  //     'description'   => __('Sidebar en el Blog', THEMEDOMAIN),
  //     'before_widget' => '<article class="Sidebar-Widget">',
  //     'after_widget'  => '</article><!-- end Sidebar-Widget -->',
  //     'before_title'  => '',
  //     'after_title'   => ''
  //   )
  // );

  // register_sidebar(
  //   array(
  //     'name'          => __('Single Sidebar', THEMEDOMAIN),
  //     'id'            => 'single',
  //     'description'   => __('Sidebar en páginas Single', THEMEDOMAIN),
  //     'before_widget' => '<article class="Sidebar-Widget">',
  //     'after_widget'  => '</article><!-- end Sidebar-Widget -->',
  //     'before_title'  => '<h3 class="Sidebar-Widget-title">',
  //     'after_title'   => '</h3>'
  //   )
  // );

  // register_sidebar(
  //   array(
  //     'name'          => __('Carrera Sidebar', THEMEDOMAIN),
  //     'id'            => 'carrera',
  //     'description'   => __('Sidebar en páginas de Carreras', THEMEDOMAIN),
  //     'before_widget' => '<article class="Sidebar-Widget">',
  //     'after_widget'  => '</article><!-- end Sidebar-Widget -->',
  //     'before_title'  => '<h3 class="Sidebar-Widget-title">',
  //     'after_title'   => '</h3>'
  //   )
  // );

  // register_sidebar(
  //   array(
  //     'name'          => __('Footer Sidebar', THEMEDOMAIN),
  //     'id'            => 'footer',
  //     'description'   => __('Sidebar en el footer', THEMEDOMAIN),
  //     'before_widget' => '<div class="col-md-4 hidden-xs hidden-sm">',
  //     'after_widget'  => '</div><!-- end col-md-4 -->',
  //     'before_title'  => '<h3 class="Footer-title"><span>',
  //     'after_title'   => '</span></h3>'
  //   )
  // );
}

/****************************************************/
/* Load Theme Options Page and Custom Widgets */
/****************************************************/
require_once(TEMPLATEPATH . '/functions/muni-theme-customizer.php');
// require_once(TEMPLATEPATH . '/functions/widget-last-posts.php');
// require_once(TEMPLATEPATH . '/functions/widget-related-carreras.php');
// require_once(TEMPLATEPATH . '/functions/widget-advertising.php');

/*
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (!function_exists('dump')) {
    function dump($var, $label = 'Dump', $echo = true) {
        // Store dump in variable
        ob_start();
        var_dump($var);
        $output = ob_get_clean();

        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", '] => ', $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">'.$label.' => '.$output.'</pre>';

        // Output
        if ($echo == true) {
            echo $output;
        } else {
            return $output;
        }
    }
}

if (!function_exists('dump_exit')) {
    function dump_exit($var, $label = 'Dump', $echo = true) {
        dump($var, $label, $echo);
        exit;
    }
}
