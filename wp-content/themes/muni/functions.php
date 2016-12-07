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

  add_theme_support('post-thumbnails', array('post', 'page', 'sliders', 'authorities', 'locales'));
  //set_post_thumbnail_size(210, 210, true);
  add_image_size('post-thumb', 320, 240, true);
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

/*****************************************************************/
/* Add Support excerpt to page */
/*****************************************************************/
function wpcodex_add_excerpt_support_for_pages() {
  add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'wpcodex_add_excerpt_support_for_pages' );

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
      $receiverEmail = $options['email_contact'];

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

            wp_mail($email, $subjectEmail, $content, $headers);

            $post_id = wp_insert_post(array(
                'post_author' => 1,
                'post_status' => 'publish',
                'post_type' => 'subscribers',
            ));
            update_post_meta($post_id, 'mb_email', $email);
            $result['result'] = true;
          } else {
            $result['error'] = 'Plantilla email no encontrada.';
          }
        } else {
          $result['error'] = 'No se puedo enviar email.';
        }
      } else {
        $result['error'] = 'Plantilla email no encontrada.';
      }
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

/***********************************************************/
/* Register contacts via ajax */
/***********************************************************/
add_action('wp_ajax_register_contact', 'register_contact_callback');
add_action('wp_ajax_nopriv_register_contact', 'register_contact_callback');

function register_contact_callback()
{
  $nonce = $_POST['nonce'];
  $result = array(
    'result' => false,
    'error' => ''
  );

  if (!wp_verify_nonce($nonce, 'muniajax-nonce')) {
      die('¡Acceso denegado!');
  }

  $name = trim($_POST['name']);
  $lastname = trim($_POST['lastname']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $address = trim($_POST['address']);
  $urba = trim($_POST['urba']);
  $message = trim($_POST['message']);
  $subject = (int)trim($_POST['subject']);

  if (!empty($name) && !empty($lastname) && !empty($email) && is_email($email) && !empty($phone) && preg_match('/^[0-9]+$/', $phone) && !empty($address) && !empty($urba) && $subject && !empty($message)) {
    $options = get_option('muni_custom_settings');

    $name     = sanitize_text_field($name);
    $lastname = sanitize_text_field($lastname);
    $email    = sanitize_email($email);
    $phone    = sanitize_text_field($phone);
    $address  = sanitize_text_field($address);
    $urba     = sanitize_text_field($urba);
    $message  = sanitize_text_field($message);

    $subject = get_term($subject, 'subjects');

    if (!is_wp_error($subject)) {
      $receiverEmail = $options['email_contact'];

      if (!isset($receiverEmail) || empty($receiverEmail)) {
        $receiverEmail = get_option('admin_email');
      }

      $subjectEmail = "Consulta Web Municipalidad de Surquillo";

      ob_start();
      $filename = TEMPLATEPATH . '/includes/template-email-contact.php';
      if (file_exists($filename)) {
        include $filename;

        $content = ob_get_contents();
        ob_get_clean();

        $headers[] = 'From: Municipalidad de Surquillo';
        //$headers[] = 'Reply-To: jolupeza@icloud.com';
        $headers[] = 'Content-type: text/html; charset=utf-8';

        if (wp_mail($receiverEmail, $subjectEmail, $content, $headers)) {
          // Send email to customer
          $subjectEmail = "Consulta recepcionada. Municipalidad de Surquillo.";

          ob_start();
          $filename = TEMPLATEPATH . '/includes/template-gratitude.php';
          if (file_exists($filename)) {
            $textEmail = 'Gracias por contactarte con nosotros, en breve nos pondremos en contacto con usted.';

            include $filename;

            $content = ob_get_contents();
            ob_get_clean();

            $headers[] = 'From: Municipalidad de Surquillo';
            //$headers[] = 'Reply-To: jolupeza@icloud.com';
            $headers[] = 'Content-type: text/html; charset=utf-8';

            wp_mail($email, $subjectEmail, $content, $headers);

            $post_id = wp_insert_post(array(
                'post_author' => 1,
                'post_status' => 'publish',
                'post_type' => 'contacts',
            ));
            update_post_meta($post_id, 'mb_name', $name);
            update_post_meta($post_id, 'mb_lastname', $lastname);
            update_post_meta($post_id, 'mb_email', $email);
            update_post_meta($post_id, 'mb_phone', $phone);
            update_post_meta($post_id, 'mb_address', $address);
            update_post_meta($post_id, 'mb_urba', $urba);
            update_post_meta($post_id, 'mb_message', $message);
            wp_set_object_terms($post_id, $subject->term_id, 'subjects');

            $result['result'] = true;
          } else {
            $result['error'] = 'Plantilla email no encontrada.';
          }
        } else {
          $result['error'] = 'No se puedo enviar email.';
        }
      } else {
        $result['error'] = 'Plantilla email no encontrada.';
      }
    } else {
      $result['error'] = 'Debe indicar el asunto de su consulta';
    }
  } else {
    $result['error'] = 'Verifique que ha ingresado los datos correctamente.';
  }

  echo json_encode($result);
  die();
}

// Bugs send emails WP 4.6.1
add_filter('wp_mail_from', function() {
  return 'jolupeza@gmail.com';
});

/***********************************************************/
/* Get directory phone via ajax */
/***********************************************************/
add_action('wp_ajax_get_directory', 'get_directory_callback');
add_action('wp_ajax_nopriv_get_directory', 'get_directory_callback');

function get_directory_callback()
{
  $nonce = $_POST['nonce'];
  $result = array(
    'result' => false,
    'error' => '',
    'data' => []
  );

  if (!wp_verify_nonce($nonce, 'muniajax-nonce')) {
      die('¡Acceso denegado!');
  }

  $termId = (int)$_POST['termid'];
  $value = (int)$_POST['value'];

  if ($termId > 0 && $value > 0) {
    $args = [
      'post_type' => 'directories',
      'p' => $value,
      'posts_per_page' => 1,
      'tax_query' => array(
        array(
          'taxonomy' => 'sections',
          'terms' => $termId
        )
      ),
    ];
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) {
      while ($the_query->have_posts()) {
        $the_query->the_post();

        $values = get_post_custom(get_the_ID());
        $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
        $title = get_the_title();

        if (has_excerpt()) {
          $title .= ' ' . get_the_excerpt();
        }

        $result['data']['title'] = $title;

        $result['data']['number'] = $phone;
        $result['result'] = true;
      }
    } else {
      $result['error'] = 'Directorio no encontrado';
    }
    wp_reset_postdata();
  } else {
    $result['error'] = 'No ha seleccionado directorio a buscar';
  }

  echo json_encode($result);
  die();
}

/***********************************************************/
/* Get authorities phone via ajax */
/***********************************************************/
add_action('wp_ajax_get_authorities', 'get_authorities_callback');
add_action('wp_ajax_nopriv_get_authorities', 'get_authorities_callback');

function get_authorities_callback()
{
  $nonce = $_POST['nonce'];
  $result = array(
    'result' => false,
    'error' => '',
    'data' => []
  );

  if (!wp_verify_nonce($nonce, 'muniajax-nonce')) {
      die('¡Acceso denegado!');
  }

  $role = (int)$_POST['role'];
  $page = (int)$_POST['page'];

  if ($role > 0 && $page > 0) {
    $args = [
      'post_type' => 'authorities',
      'posts_per_page' => 4,
      'tax_query' => array(
        array(
          'taxonomy' => 'roles',
          'terms' => $role
        )
      ),
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'offset' => ( $page - 1 ) * 4
    ];
    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) {
      ob_start();

      if (file_exists(TEMPLATEPATH . '/includes/authorities-ajax.php')) {
        include TEMPLATEPATH . '/includes/authorities-ajax.php';
      }

      $content = ob_get_contents();

      ob_get_clean();

      $result['data']['content'] = $content;

      $result['result'] = true;
    } else {
      $result['error'] = 'Datos no encontrado';
    }
    wp_reset_postdata();
  } else {
    $result['error'] = 'Por favor vuelva a intentarlo';
  }

  echo json_encode($result);
  die();
}

/***********************************************************/
/* Get authorities by role via ajax */
/***********************************************************/
add_action('wp_ajax_get_authorities_role', 'get_authorities_role_callback');
add_action('wp_ajax_nopriv_get_authorities_role', 'get_authorities_role_callback');

function get_authorities_role_callback()
{
  $nonce = $_POST['nonce'];
  $result = array(
    'result' => false,
    'error' => '',
    'data' => []
  );

  if (!wp_verify_nonce($nonce, 'muniajax-nonce')) {
      die('¡Acceso denegado!');
  }

  $role = (int)$_POST['role'];
  $page = 1;

  if ($role > 0 && $page > 0) {
    $args = [
      'post_type' => 'authorities',
      'posts_per_page' => 4,
      'tax_query' => array(
        array(
          'taxonomy' => 'roles',
          'terms' => $role
        )
      ),
      'orderby' => 'menu_order',
      'order' => 'ASC'
    ];
    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) {
      ob_start();

      if (file_exists(TEMPLATEPATH . '/includes/authorities-ajax.php')) {
        include TEMPLATEPATH . '/includes/authorities-ajax.php';
      }

      $content = ob_get_contents();

      ob_get_clean();

      $result['data']['content'] = $content;

      $result['result'] = true;
    } else {
      $result['error'] = 'Datos no encontrado';
    }
    wp_reset_postdata();
  } else {
    $result['error'] = 'Por favor vuelva a intentarlo';
  }

  echo json_encode($result);
  die();
}

/***********************************************************/
/* Get authorities phone via ajax */
/***********************************************************/
add_action('wp_ajax_get_services', 'get_services_callback');
add_action('wp_ajax_nopriv_get_services', 'get_services_callback');

function get_services_callback()
{
  $nonce = $_POST['nonce'];
  $result = array(
    'result' => false,
    'error' => '',
    'data' => []
  );

  if (!wp_verify_nonce($nonce, 'muniajax-nonce')) {
      die('¡Acceso denegado!');
  }

  $service = (int)$_POST['service'];
  $page = (int)$_POST['page'];

  if ($service > 0 && $page > 0) {
    $args = [
      'post_type' => 'page',
      'posts_per_page' => 6,
      'tax_query' => array(
        array(
          'taxonomy' => 'services',
          'terms' => $service
        )
      ),
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'offset' => ( $page - 1 ) * 6
    ];
    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) {
      ob_start();

      if (file_exists(TEMPLATEPATH . '/includes/services-ajax.php')) {
        include TEMPLATEPATH . '/includes/services-ajax.php';
      }

      $content = ob_get_contents();

      ob_get_clean();

      $result['data']['content'] = $content;

      $result['result'] = true;
    } else {
      $result['error'] = 'Datos no encontrado';
    }
    wp_reset_postdata();
  } else {
    $result['error'] = 'Por favor vuelva a intentarlo';
  }

  echo json_encode($result);
  die();
}

/***********************************************************/
/* Get authorities by role via ajax */
/***********************************************************/
add_action('wp_ajax_get_services_s', 'get_services_s_callback');
add_action('wp_ajax_nopriv_get_services_s', 'get_services_s_callback');

function get_services_s_callback()
{
  $nonce = $_POST['nonce'];
  $result = array(
    'result' => false,
    'error' => '',
    'data' => []
  );

  if (!wp_verify_nonce($nonce, 'muniajax-nonce')) {
    die('¡Acceso denegado!');
  }

  $service = (int)$_POST['service'];
  $page = 1;

  if ($service > 0 && $page > 0) {
    $args = [
      'post_type' => 'page',
      'posts_per_page' => 6,
      'tax_query' => array(
        array(
          'taxonomy' => 'services',
          'terms' => $service
        )
      ),
      'orderby' => 'menu_order',
      'order' => 'ASC'
    ];
    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) {
      ob_start();

      if (file_exists(TEMPLATEPATH . '/includes/services-ajax.php')) {
        include TEMPLATEPATH . '/includes/services-ajax.php';
      }

      $content = ob_get_contents();

      ob_get_clean();

      $result['data']['content'] = $content;

      $result['result'] = true;
    } else {
      $result['error'] = 'Datos no encontrado';
    }
    wp_reset_postdata();
  } else {
    $result['error'] = 'Por favor vuelva a intentarlo';
  }

  echo json_encode($result);
  die();
}

/**********************************************************************************/
/* Short content */
/**********************************************************************************/
function getSubString($string, $length = NULL)
{
  //Si no se especifica la longitud por defecto es 50
  if ($length == NULL)
      $length = 50;
  //Primero eliminamos las etiquetas html y luego cortamos el string
  $stringDisplay = substr(strip_tags($string), 0, $length);
  //Si el texto es mayor que la longitud se agrega puntos suspensivos
  if (strlen(strip_tags($string)) > $length)
      $stringDisplay .= ' ...';
  return $stringDisplay;
}

/***********************************************************/
/* Get cities via ajax */
/***********************************************************/
add_action('wp_ajax_get_cities', 'get_cities_callback');
add_action('wp_ajax_nopriv_get_cities', 'get_cities_callback');

function get_cities_callback()
{
  $nonce = $_POST['nonce'];
  $result = array(
    'result' => false,
    'error' => '',
    'data' => []
  );

  if (!wp_verify_nonce($nonce, 'muniajax-nonce')) {
      die('¡Acceso denegado!');
  }

  $idDpto = (int)$_POST['id'];
  $title = $_POST['title'];

  if ($idDpto > 0 && !empty($title)) {
    $title = sanitize_text_field($title);

    $args = [
      'post_type' => 'cities',
      'posts_per_page' => -1,
      'post_parent' => $idDpto,
      'order' => 'ASC'
    ];
    $the_query = new WP_Query($args);
    if ($the_query->have_posts()) {
      ob_start();

      if (file_exists(TEMPLATEPATH . '/includes/select-cities.php')) {
        include TEMPLATEPATH . '/includes/select-cities.php';
      }

      $content = ob_get_contents();

      ob_get_clean();

      $result['data']['content'] = $content;

      $result['result'] = true;
    } else {
      $result['error'] = 'No se encontró ciudades';
    }
    wp_reset_postdata();
  } else {
    $result['error'] = 'No ha seleccionado ciudad';
  }

  echo json_encode($result);
  die();
}

/***********************************************************/
/* Register book via ajax */
/***********************************************************/
add_action('wp_ajax_register_book', 'register_book_callback');
add_action('wp_ajax_nopriv_register_book', 'register_book_callback');

function register_book_callback()
{
  $nonce = $_POST['nonce'];
  $result = array(
    'result' => false,
    'error' => ''
  );

  if (!wp_verify_nonce($nonce, 'muniajax-nonce')) {
      die('¡Acceso denegado!');
  }

  if (isset($_FILES['files-0'])) {
    $file = $_FILES['files-0'];

    $types = array(
      'application/pdf',
      'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
      'application/msword',
      'image/jpeg',
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
      'application/vnd.ms-excel',
    );

    $extensions = array('pdf', 'doc', 'docx', 'jpg', 'xls', 'xlsx');
    $arrVia = array('Av.', 'Cl.', 'Jr.', 'Psje.');

    if ( $file['error'] === 0) {
      if ( in_array( $file['type'], $types ) ) {
        if ( $file['size'] <= 2097152 ) {
          $nameFile = $file['name'];
          $nameFile = explode('.', $nameFile);
          $ext = $nameFile[count($nameFile) - 1];

          if (in_array($ext, $extensions)) {
            $service = trim($_POST['service']);
            $area    = trim($_POST['area']);
            $message = trim($_POST['message']);
            $name    = trim($_POST['name']);
            $dni     = trim($_POST['dni']);
            $email   = trim($_POST['email']);
            $phone   = trim($_POST['phone']);
            $dpto    = (int)trim($_POST['dpto']);
            $prov    = (int)trim($_POST['prov']);
            $dist    = (int)trim($_POST['dist']);
            $via     = (int)trim($_POST['via']);
            $address = trim($_POST['address']);
            $number  = trim($_POST['number']);

            if(!empty($service) && !empty($area) && !empty($message) && !empty($name) && preg_match('/^[0-9]+$/', $dni) && (strlen($dni) == 8) && !empty($email) && is_email($email) && !empty($phone) && preg_match('/^[0-9]+$/', $phone) && $dpto > 0 && $prov > 0 && $dist > 0 && $via > 0 && !empty($address) && !empty($number)) {
              $service = sanitize_text_field($service);
              $area    = sanitize_text_field($area);
              $message = sanitize_text_field($message);
              $name    = sanitize_text_field($name);
              $dni     = sanitize_text_field($dni);
              $email   = sanitize_email($email);
              $phone   = sanitize_text_field($phone);
              $dpto    = sanitize_text_field($dpto);
              $prov    = sanitize_text_field($prov);
              $dist    = sanitize_text_field($dist);
              $via     = sanitize_text_field($via);
              $address = sanitize_text_field($address);
              $number  = sanitize_text_field($number);

              // $nameFilePath = sha1_file($file['tmp_name']) . '.' . $ext;

              $nameFilePath = basename(randomString(20) . '.' . $ext);
              $filepath = ABSPATH . 'librodereclamaciones' . DIRECTORY_SEPARATOR . $nameFilePath;

              $via = $arrVia[$via - 1];
              $addressFull = $via . ' ' . $address . ' ' . $number;

              if (move_uploaded_file($file['tmp_name'], $filepath)) {
                $post_id = wp_insert_post(array(
                  'post_author' => 1,
                  'post_status' => 'publish',
                  'post_type' => 'books',
                ));

                update_post_meta($post_id, 'mb_service', $service);
                update_post_meta($post_id, 'mb_area', $area);
                update_post_meta($post_id, 'mb_message', $message);
                update_post_meta($post_id, 'mb_name', $name);
                update_post_meta($post_id, 'mb_dni', $dni);
                update_post_meta($post_id, 'mb_email', $email);
                update_post_meta($post_id, 'mb_phone', $phone);
                update_post_meta($post_id, 'mb_dpto', $dpto);
                update_post_meta($post_id, 'mb_prov', $prov);
                update_post_meta($post_id, 'mb_dist', $dist);
                update_post_meta($post_id, 'mb_via', $via);
                update_post_meta($post_id, 'mb_address', $address);
                update_post_meta($post_id, 'mb_number', $number);
                update_post_meta($post_id, 'mb_file', $nameFilePath);

                $options = get_option('muni_custom_settings');
                $receiverEmail = $options['email_contact'];

                if (!isset($receiverEmail) || empty($receiverEmail)) {
                  $receiverEmail = get_option('admin_email');
                }

                $dataDpto = get_post($dpto);
                $nameDpto = $dataDpto->post_title;

                $dataProv = get_post($prov);
                $nameProv = $dataProv->post_title;

                $dataDist = get_post($dist);
                $nameDist = $dataDist->post_title;

                $subjectEmail = "Libro de Reclamaciones Web Municipalidad de Surquillo";

                ob_start();
                $filename = TEMPLATEPATH . '/includes/template-email-book.php';
                if (file_exists($filename)) {
                  include $filename;

                  $content = ob_get_contents();
                  ob_get_clean();

                  $headers[] = 'From: Municipalidad de Surquillo';
                  //$headers[] = 'Reply-To: jolupeza@icloud.com';
                  $headers[] = 'Content-type: text/html; charset=utf-8';

                  if (wp_mail($receiverEmail, $subjectEmail, $content, $headers)) {
                    ob_start();
                    $filename = TEMPLATEPATH . '/includes/template-gratitude.php';
                    if (file_exists($filename)) {
                      $textEmail = 'Hemos recepcionado correctamente su solicitud, en breve nos pondremos en contacto con usted.';

                      include $filename;

                      $content = ob_get_contents();
                      ob_get_clean();

                      $headers[] = 'From: Municipalidad de Surquillo';
                      //$headers[] = 'Reply-To: jolupeza@icloud.com';
                      $headers[] = 'Content-type: text/html; charset=utf-8';

                      wp_mail($email, $subjectEmail, $content, $headers);
                    }
                  }
                }

                $result['result'] = true;
              } else {
                $result['error'] = 'No se pudo subir su archivo por favor vuelva a intentarlo.';
              }
            } else {
                $result['error'] = "Debe verificar que haya ingresado correctamente los datos solicitados.";
            }
          } else {
            $result['error'] = "Su archivo no es de los siguientes formatos permitidos: PDF, DOC, DOCX, XLS, XLSX, JPG";
          }
        } else {
          $result['error'] = "Su archivo excede los 2Mb permitidos";
        }
      } else {
        $result['error'] = "Su archivo no es de los siguientes formatos permitidos: PDF, DOC, DOCX, XLS, XLSX, JPG";
      }
    } else {
      $result['error'] = "No se pudo subir el archivo. Por favor verifique esta correcto.";
    }
  } else {
    $result['error'] = 'No ha subido su archivo.';
  }

  echo json_encode($result);
  die();
}

function randomString($length = 6) {
  $str = "";
  $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
  $max = count($characters) - 1;
  for ($i = 0; $i < $length; $i++) {
    $rand = mt_rand(0, $max);
    $str .= $characters[$rand];
  }
  return $str;
}

/***********************************************************/
/* Register information via ajax */
/***********************************************************/
add_action('wp_ajax_register_info', 'register_info_callback');
add_action('wp_ajax_nopriv_register_info', 'register_info_callback');

function register_info_callback()
{
  $nonce = $_POST['nonce'];
  $result = array(
    'result' => false,
    'error' => ''
  );

  if (!wp_verify_nonce($nonce, 'muniajax-nonce')) {
      die('¡Acceso denegado!');
  }

  $arrVia = array('Av.', 'Cl.', 'Jr.', 'Psje.');
  $arrTipPer = array('Persona Natural', 'Persona Jurídica');

  $name         = trim($_POST['name']);
  $tipdoc       = (int)trim($_POST['tipdoc']);
  $numdoc       = trim($_POST['numdoc']);
  $dpto         = (int)trim($_POST['dpto']);
  $prov         = (int)trim($_POST['prov']);
  $dist         = (int)trim($_POST['dist']);
  $urb          = trim($_POST['urb']);
  $via          = (int)trim($_POST['via']);
  $address      = trim($_POST['address']);
  $number       = trim($_POST['number']);
  $email        = trim($_POST['email']);
  $phone        = trim($_POST['phone']);
  $infsol       = trim($_POST['infsol']);
  $depend       = trim($_POST['depend']);
  $formaentrega = (int)trim($_POST['formaentrega']);
  $obser        = trim($_POST['obser']);
  $namerep      = trim($_POST['namerep']);
  $tipdocrep    = (int)trim($_POST['tipdocrep']);
  $numdocrep   = trim($_POST['numdocrep']);
  $tipper       = (int)trim($_POST['tipper']);

  if(!empty($name) && $tipdoc > 0 && !empty($numdoc) && $dpto > 0 && $prov > 0 && $dist > 0 && !empty($urb) && $via > 0 && !empty($address) && !empty($number) && !empty($email) && is_email($email) && !empty($phone) && preg_match('/^[0-9]+$/', $phone) && !empty($infsol) && !empty($depend) && $formaentrega > 0 && !empty($obser) && !empty($namerep) && $tipdocrep > 0 && !empty($numdocrep) && $tipper > 0) {
    $name         = sanitize_text_field($name);
    $tipdoc       = sanitize_text_field($tipdoc);
    $numdoc       = sanitize_text_field($numdoc);
    $dpto         = sanitize_text_field($dpto);
    $prov         = sanitize_text_field($prov);
    $dist         = sanitize_text_field($dist);
    $urb          = sanitize_text_field($urb);
    $via          = sanitize_text_field($via);
    $address      = sanitize_text_field($address);
    $number       = sanitize_text_field($number);
    $email        = sanitize_email($email);
    $phone        = sanitize_text_field($phone);
    $infsol       = sanitize_text_field($infsol);
    $depend       = sanitize_text_field($depend);
    $formaentrega = sanitize_text_field($formaentrega);
    $obser        = sanitize_text_field($obser);
    $namerep      = sanitize_text_field($namerep);
    $tipdocrep    = sanitize_text_field($tipdocrep);
    $numdoccrep   = sanitize_text_field($numdoccrep);
    $tipper       = sanitize_text_field($tipper);

    $formaentrega = get_term($formaentrega, 'deliveries');

    $via = $arrVia[$via - 1];
    $addressFull = $via . ' ' . $address . ' ' . $number;
    $tipper = $arrTipPer[$tipper - 1];

    $options = get_option('muni_custom_settings');
    $receiverEmail = $options['email_contact'];

    if (!isset($receiverEmail) || empty($receiverEmail)) {
      $receiverEmail = get_option('admin_email');
    }

    $dataDpto = get_post($dpto);
    $nameDpto = $dataDpto->post_title;

    $dataProv = get_post($prov);
    $nameProv = $dataProv->post_title;

    $dataDist = get_post($dist);
    $nameDist = $dataDist->post_title;

    $dataTipDoc = get_post($tipdoc);
    $nameTipDoc = $dataTipDoc->post_title;

    $dataTipDocRep = get_post($tipdocrep);
    $nameTipDocRep = $dataTipDocRep->post_title;

    $subjectEmail = "Acceso a la Información Web Municipalidad de Surquillo";

    ob_start();
    $filename = TEMPLATEPATH . '/includes/template-email-info.php';
    if (file_exists($filename)) {
      include $filename;

      $content = ob_get_contents();
      ob_get_clean();

      $headers[] = 'From: Municipalidad de Surquillo';
      //$headers[] = 'Reply-To: jolupeza@icloud.com';
      $headers[] = 'Content-type: text/html; charset=utf-8';

      if (wp_mail($receiverEmail, $subjectEmail, $content, $headers)) {
        ob_start();
        $filename = TEMPLATEPATH . '/includes/template-gratitude.php';
        if (file_exists($filename)) {
          $textEmail = 'Hemos recepcionado correctamente su solicitud, en breve nos pondremos en contacto con usted.';

          include $filename;

          $content = ob_get_contents();
          ob_get_clean();

          $headers[] = 'From: Municipalidad de Surquillo';
          //$headers[] = 'Reply-To: jolupeza@icloud.com';
          $headers[] = 'Content-type: text/html; charset=utf-8';

          wp_mail($email, $subjectEmail, $content, $headers);

          $post_id = wp_insert_post(array(
            'post_author' => 1,
            'post_status' => 'publish',
            'post_type' => 'informations',
          ));

          update_post_meta($post_id, 'mb_name', $name);
          update_post_meta($post_id, 'mb_tipdoc', $tipdoc);
          update_post_meta($post_id, 'mb_numdoc', $numdoc);
          update_post_meta($post_id, 'mb_dpto', $dpto);
          update_post_meta($post_id, 'mb_prov', $prov);
          update_post_meta($post_id, 'mb_dist', $dist);
          update_post_meta($post_id, 'mb_urb', $urb);
          update_post_meta($post_id, 'mb_via', $via);
          update_post_meta($post_id, 'mb_address', $address);
          update_post_meta($post_id, 'mb_number', $number);
          update_post_meta($post_id, 'mb_email', $email);
          update_post_meta($post_id, 'mb_phone', $phone);
          update_post_meta($post_id, 'mb_infsol', $infsol);
          update_post_meta($post_id, 'mb_depend', $depend);
          update_post_meta($post_id, 'mb_obser', $obser);
          update_post_meta($post_id, 'mb_namerep', $namerep);
          update_post_meta($post_id, 'mb_tipdocrep', $tipdocrep);
          update_post_meta($post_id, 'mb_numdocrep', $numdocrep);
          update_post_meta($post_id, 'mb_tipper', $tipper);

          wp_set_object_terms($post_id, $formaentrega->term_id, 'deliveries');

          $result['result'] = true;
        } else {
          $result['error'] = "No se encontró plantilla.";
        }
      } else {
        $result['error'] = "No se pudo enviar el correo.";
      }
    } else {
      $result['error'] = "No se encontró plantilla.";
    }
  } else {
    $result['error'] = "Debe verificar que haya ingresado correctamente los datos solicitados.";
  }

  echo json_encode($result);
  die();
}

/****************************************************/
/* Load Theme Options Page and Custom Widgets */
/****************************************************/
require_once(TEMPLATEPATH . '/functions/muni-theme-customizer.php');
require_once(TEMPLATEPATH . '/functions/widget-categories.php');
require_once(TEMPLATEPATH . '/functions/widget-tags.php');

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
