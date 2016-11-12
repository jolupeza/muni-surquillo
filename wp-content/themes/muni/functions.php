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
  add_image_size('post-thumb', 350, 350, true);
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
  register_sidebar(
    array(
      'name'          => __('Categorías Sidebar', THEMEDOMAIN),
      'id'            => 'main-sidebar',
      'description'   => __('Sidebar en sección Novedades', THEMEDOMAIN),
      'before_widget' => '<article class="Sidebar-widget">',
      'after_widget'  => '</article><!-- end Sidebar-widget -->',
      'before_title'  => '<h3 class="Sidebar-widget-title text--blue">',
      'after_title'   => '</h3>'
    )
  );

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

/***********************************************************/
/* Register subscriptor via ajax */
/***********************************************************/
add_action('wp_ajax_register_subscriptor', 'register_subscriptor_callback');
add_action('wp_ajax_nopriv_register_subscriptor', 'register_subscriptor_callback');

function register_subscriptor_callback()
{
  $nonce = $_POST['nonce'];
  $result = array(
    'result' => false,
    'error' => ''
  );

  if (!wp_verify_nonce($nonce, 'muniajax-nonce')) {
      die('¡Acceso denegado!');
  }

  $email = trim($_POST['email']);

  if (!empty($email) && is_email($email)) {
    $options = get_option('muni_custom_settings');
    $email = sanitize_email($email);

    // Verify register previous of email
    $args = array(
      'post_type' => 'subscribers',
      'meta_query' => array(
        array(
          'key' => 'mb_email',
          'value' => $email,
        ),
      ),
    );
    $the_query = new WP_Query($args);
    if (!$the_query->have_posts()) {
      /*$receiverEmail = $options['email_contact'];

      if (!isset($receiverEmail) || empty($receiverEmail)) {
        $receiverEmail = get_option('admin_email');
      }

      $subjectEmail = "Nuevo suscriptor";

      ob_start();
      $filename = TEMPLATEPATH . '/includes/template-email-subscriber.php';
      if (file_exists($filename)) {
        include $filename;

        $content = ob_get_contents();
        ob_get_clean();

        $headers[] = 'From: Municipalidad de Surquillo';
        //$headers[] = 'Reply-To: jolupeza@icloud.com';
        $headers[] = 'Content-type: text/html; charset=utf-8';

        if (wp_mail($receiverEmail, $subjectEmail, $content, $headers)) {
          // Send email to customer
          $subjectEmail = "Suscripción satisfactoria. Municipalidad de Surquillo.";

          ob_start();
          $filename = TEMPLATEPATH . '/includes/template-gratitude.php';
          if (file_exists($filename)) {
            $textEmail = 'Gracias por suscribirte, recibirás información importante.';

            include $filename;

            $content = ob_get_contents();
            ob_get_clean();

            $headers[] = 'From: Municipalidad de Surquillo';
            //$headers[] = 'Reply-To: jolupeza@icloud.com';
            $headers[] = 'Content-type: text/html; charset=utf-8';

            wp_mail($email, $subjectEmail, $content, $headers);*/

            $post_id = wp_insert_post(array(
                'post_author' => 1,
                'post_status' => 'publish',
                'post_type' => 'subscribers',
            ));
            update_post_meta($post_id, 'mb_email', $email);
            $result['result'] = true;
          /*} else {
            $result['error'] = 'Plantilla email no encontrada.';
          }
        } else {
          $result['error'] = 'No se puedo enviar email.';
        }
      } else {
        $result['error'] = 'Plantilla email no encontrada.';
      }*/
    } else {
      $result['error'] = 'Correo electrónico se encuentra registrado.';
    }

    wp_reset_postdata();
  } else {
    $result['error'] = 'No ha ingresado el correo electrónico.';
  }

  echo json_encode($result);
  die();
}

/***********************************************************/
/* Send and register form subscribers via ajax */
/***********************************************************/
add_action('wp_ajax_validate_email_subscriber', 'validate_email_subscriber_callback');
add_action('wp_ajax_nopriv_validate_email_subscriber', 'validate_email_subscriber_callback');

function validate_email_subscriber_callback() {
  $nonce = $_POST['nonce'];
  $result = ['valid' => true];

  if (!wp_verify_nonce( $nonce, 'muniajax-nonce' )) {
    die('¡Acceso denegado!');
  }

  $email    = trim($_POST['email']);

  if (!empty($email) && is_email($email)) {
    $email = sanitize_email($email);

    // Verify if email is register
    $args = [
      'post_type' => 'subscribers',
      'meta_query' => array(
        array(
          'key' => 'mb_email',
          'value' => $email,
        ),
      ),
    ];
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) {
      $result['valid'] = false;
    }
  }

  echo json_encode($result);
  die();
}

/****************************************************/
/* Load Theme Options Page and Custom Widgets */
/****************************************************/
require_once(TEMPLATEPATH . '/functions/muni-theme-customizer.php');
require_once(TEMPLATEPATH . '/functions/widget-categories.php');
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
