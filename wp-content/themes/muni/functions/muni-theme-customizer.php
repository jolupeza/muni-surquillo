<?php
/***********************************************************************************************/
/* Add a menu option to link to the customizer */
/***********************************************************************************************/
add_action('admin_menu', 'display_custom_options_link');
function display_custom_options_link() {
    add_theme_page('Theme Muni Options', 'Theme Muni Options', 'edit_theme_options', 'customize.php');
}

/***********************************************************************************************/
/* Add options in the theme customizer page */
/***********************************************************************************************/
add_action('customize_register', 'muni_customize_register');
function muni_customize_register($wp_customize) {
    // Links Social Media
    $wp_customize->add_section('muni_social', array(
        'title' => __( 'Links Redes Sociales', THEMEDOMAIN),
        'description' => __('Mostrar links a redes sociales', THEMEDOMAIN),
        'priority' => 35
    ));

    $wp_customize->add_setting('muni_custom_settings[display_social_link]', array(
        'default' => 0,
        'type' => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[display_social_link]', array(
        'label' => __('¿Mostrar links?', THEMEDOMAIN),
        'section' => 'muni_social',
        'settings' => 'muni_custom_settings[display_social_link]',
        'type' => 'checkbox'
    ));

    // Facebook
    $wp_customize->add_setting('muni_custom_settings[facebook]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[facebook]', array(
        'label'    => __('Facebook', THEMEDOMAIN),
        'section'  => 'muni_social',
        'settings' => 'muni_custom_settings[facebook]',
        'type'     => 'text'
    ));

    // Twitter
    $wp_customize->add_setting('muni_custom_settings[twitter]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[twitter]', array(
        'label'    => __('Twitter', THEMEDOMAIN),
        'section'  => 'muni_social',
        'settings' => 'muni_custom_settings[twitter]',
        'type'     => 'text'
    ));

    // Google+
    $wp_customize->add_setting('muni_custom_settings[googleplus]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[googleplus]', array(
        'label'    => __('Google+', THEMEDOMAIN),
        'section'  => 'muni_social',
        'settings' => 'muni_custom_settings[googleplus]',
        'type'     => 'text'
    ));

    // Linkedin
    $wp_customize->add_setting('muni_custom_settings[linkedin]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[linkedin]', array(
        'label'    => __('Linkedin', THEMEDOMAIN),
        'section'  => 'muni_social',
        'settings' => 'muni_custom_settings[linkedin]',
        'type'     => 'text'
    ));

    // Information
    $wp_customize->add_section('muni_info', array(
        'title' => __( 'Datos de la empresa', THEMEDOMAIN),
        'description' => __('Configurar información sobre la empresa', THEMEDOMAIN),
        'priority' => 36
    ));

    // Address
    $wp_customize->add_setting('muni_custom_settings[address]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[address]', array(
        'label'    => __('Dirección', THEMEDOMAIN),
        'section'  => 'muni_info',
        'settings' => 'muni_custom_settings[address]',
        'type'     => 'textarea'
    ));

    // Email
    /*$wp_customize->add_setting('muni_custom_settings[email_contact]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[email_contact]', array(
        'label'    => __('Email de contacto', THEMEDOMAIN),
        'section'  => 'muni_info',
        'settings' => 'muni_custom_settings[email_contact]',
        'type'     => 'text'
    ));*/

    // Phone
    $wp_customize->add_setting('muni_custom_settings[phone]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[phone]', array(
        'label'    => __('Teléfonos', THEMEDOMAIN),
        'section'  => 'muni_info',
        'settings' => 'muni_custom_settings[phone]',
        'type'     => 'text'
    ));

    // Latitud
    /*$wp_customize->add_setting('muni_custom_settings[latitud]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[latitud]', array(
        'label'    => __('Ubicación Google Map Latitud', THEMEDOMAIN),
        'section'  => 'muni_info',
        'settings' => 'muni_custom_settings[latitud]',
        'type'     => 'text'
    ));

    // Longitud
    $wp_customize->add_setting('muni_custom_settings[longitud]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[longitud]', array(
        'label'    => __('Ubicación Google Map Longitud', THEMEDOMAIN),
        'section'  => 'muni_info',
        'settings' => 'muni_custom_settings[longitud]',
        'type'     => 'text'
    ));*/
}
