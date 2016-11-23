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
    // Logo Footer
    $wp_customize->add_section('muni_logo', array(
        'title' => __('Logos', THEMEDOMAIN),
        'description' => __('Le permite cargar un logos personalizados.', THEMEDOMAIN),
        'priority' => 35
    ));

    $wp_customize->add_setting('muni_custom_settings[logo_movil]', array(
        'default' => IMAGES . '/logo-escudo.png',
        'type' => 'option'
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo_movil', array(
        'label' => __('Logo Móvil', THEMEDOMAIN),
        'section' => 'muni_logo',
        'settings' => 'muni_custom_settings[logo_movil]'
    )));

    $wp_customize->add_setting('muni_custom_settings[logo]', array(
        'default' => IMAGES . '/logo-footer.png',
        'type' => 'option'
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo', array(
        'label' => __('Logo Footer', THEMEDOMAIN),
        'section' => 'muni_logo',
        'settings' => 'muni_custom_settings[logo]'
    )));

    // Links Social Media
    $wp_customize->add_section('muni_social', array(
        'title' => __( 'Links Redes Sociales', THEMEDOMAIN),
        'description' => __('Mostrar links a redes sociales', THEMEDOMAIN),
        'priority' => 36
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

    // Youtube
    $wp_customize->add_setting('muni_custom_settings[youtube]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[youtube]', array(
        'label'    => __('Youtube', THEMEDOMAIN),
        'section'  => 'muni_social',
        'settings' => 'muni_custom_settings[youtube]',
        'type'     => 'text'
    ));

    // Information
    $wp_customize->add_section('muni_info', array(
        'title' => __( 'Datos de la empresa', THEMEDOMAIN),
        'description' => __('Configurar información sobre la empresa', THEMEDOMAIN),
        'priority' => 37
    ));

    // Description
    $wp_customize->add_setting('muni_custom_settings[desc]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[desc]', array(
        'label'    => __('Descripción', THEMEDOMAIN),
        'section'  => 'muni_info',
        'settings' => 'muni_custom_settings[desc]',
        'type'     => 'textarea'
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
    $wp_customize->add_setting('muni_custom_settings[email_contact]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[email_contact]', array(
        'label'    => __('Email de contacto', THEMEDOMAIN),
        'section'  => 'muni_info',
        'settings' => 'muni_custom_settings[email_contact]',
        'type'     => 'text'
    ));

    // Phone
    $wp_customize->add_setting('muni_custom_settings[phone]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[phone]', array(
        'label'    => __('Central Telefónica', THEMEDOMAIN),
        'section'  => 'muni_info',
        'settings' => 'muni_custom_settings[phone]',
        'type'     => 'text'
    ));

    // Datos Municipalidad
    $wp_customize->add_section('muni_data', array(
        'title' => __( 'Datos de la Municipalidad de Surquillo', THEMEDOMAIN),
        'description' => __('Configurar información sobre la empresa', THEMEDOMAIN),
        'priority' => 38
    ));

    // Population
    $wp_customize->add_setting('muni_custom_settings[population]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[population]', array(
        'label'    => __('Población', THEMEDOMAIN),
        'section'  => 'muni_data',
        'settings' => 'muni_custom_settings[population]',
        'type'     => 'text'
    ));

    // Location
    $wp_customize->add_setting('muni_custom_settings[location]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[location]', array(
        'label'    => __('Ubicación', THEMEDOMAIN),
        'section'  => 'muni_data',
        'settings' => 'muni_custom_settings[location]',
        'type'     => 'text'
    ));

    // Latitud
    $wp_customize->add_setting('muni_custom_settings[latitud]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[latitud]', array(
        'label'    => __('Latitud', THEMEDOMAIN),
        'section'  => 'muni_data',
        'settings' => 'muni_custom_settings[latitud]',
        'type'     => 'text'
    ));

    // Longitud
    $wp_customize->add_setting('muni_custom_settings[longitud]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[longitud]', array(
        'label'    => __('Longitud', THEMEDOMAIN),
        'section'  => 'muni_data',
        'settings' => 'muni_custom_settings[longitud]',
        'type'     => 'text'
    ));

    // Limit
    $wp_customize->add_setting('muni_custom_settings[limit]', array(
        'default' => '',
        'type'    => 'option'
    ));

    $wp_customize->add_control('muni_custom_settings[limit]', array(
        'label'    => __('Límites', THEMEDOMAIN),
        'section'  => 'muni_data',
        'settings' => 'muni_custom_settings[limit]',
        'type'     => 'textarea'
    ));

    // Plano Distrital
    $wp_customize->add_setting('muni_custom_settings[plano]', array(
        'default' => '',
        'type' => 'option'
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'plano', array(
        'label' => __('Plano distrital', THEMEDOMAIN),
        'section' => 'muni_data',
        'settings' => 'muni_custom_settings[plano]'
    )));
}
