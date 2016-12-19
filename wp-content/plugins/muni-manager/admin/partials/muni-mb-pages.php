<?php
/**
 * Displays the user interface for the Muni Manager meta box by type content Pages.
 *
 * This is a partial template that is included by the Muni Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-pages-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        $video = isset($values['mb_video']) ? esc_attr($values['mb_video'][0]) : '';
        $icon = isset($values['mb_icon']) ? esc_attr($values['mb_icon'][0]) : '';
        $link = isset($values['mb_link']) ? esc_attr($values['mb_link'][0]) : '';      
        $linkText = isset($values['mb_link_text']) ? esc_attr($values['mb_link_text'][0]) : '';
        $files = isset($values['mb_files']) ?  $values['mb_files'][0]  :  '';
        $files_title = isset($values['mb_files_title']) ?  $values['mb_files_title'][0]  :  '';
        
        $display_home = isset($values['mb_display_home']) ? esc_attr($values['mb_display_home'][0]) : '';
        $responsive = isset( $values['mb_responsive'] ) ? esc_attr($values['mb_responsive'][0]) : '';
        
        $forms = (isset($values['mb_forms'])) ? $values['mb_forms'][0] : '';
        $how = (isset($values['mb_how'])) ? $values['mb_how'][0] : '';
        $cases = (isset($values['mb_cases'])) ? $values['mb_cases'][0] : '';
        $legislation = (isset($values['mb_legislation'])) ? $values['mb_legislation'][0] : '';
        
        $locales = isset($values['mb_locales']) ? $values['mb_locales'][0] : '';
        $iframe = isset($values['mb_iframe']) ? esc_attr($values['mb_iframe'][0]) : '';
        
        $gallery = isset($values['mb_gallery']) ?  $values['mb_gallery'][0]  :  '';
        
        $args = array(
            'post_type' => 'locales',
            'posts_per_page' => -1,
        );
        $locals = get_posts($args);
        
        $bg = isset( $values['mb_bg'] ) ? esc_attr($values['mb_bg'][0]) : '';
        
        wp_nonce_field('pages_meta_box_nonce', 'meta_box_nonce');
    ?>
    
    <!-- Iframe-->
    <p class="content-mb">
        <label for="mb_iframe">Iframe SRC: </label>
        <input type="text" name="mb_iframe" id="mb_iframe" value="<?php echo $iframe; ?>" />
    </p>

    <!-- Video-->
    <p class="content-mb">
        <label for="mb_video">Id Video: </label>
        <input type="text" name="mb_video" id="mb_video" value="<?php echo $video; ?>" />
    </p>

    <!-- Icono-->
    <p class="content-mb">
        <label for="mb_icon">Ícono: </label>
        <input type="text" name="mb_icon" id="mb_icon" value="<?php echo $icon; ?>" />
    </p>
    
    <!-- Link-->
    <p class="content-mb">
        <label for="mb_link">Enlace: </label>
        <input type="text" name="mb_link" id="mb_link" value="<?php echo $link; ?>" />
    </p>
    
    <!-- Text Link-->
    <p class="content-mb">
        <label for="mb_link_text">Texto de enlace: </label>
        <input type="text" name="mb_link_text" id="mb_link_text" value="<?php echo $linkText; ?>" />
    </p>
    
    <!-- Display home -->
    <p class="content-mb">
        <label for="mb_display_home">Mostrar en home (Sólo para Servicios Municipales):</label>
        <input type="checkbox" name="mb_display_home" id="mb_display_home" <?php checked($display_home, 'on'); ?> />
    </p>
    
    <fieldset class="GroupForm">
        <legend class="GroupForm-legend">Imagen Responsive</legend>

        <div class="container-upload-file GroupForm-wrapperImage">
            <p class="btn-add-file">
                <a title="Agregar imagen" href="javascript:;" class="set-file button button-primary">Añadir</a>
            </p>

            <div class="hidden media-container">
                <img src="<?php echo $responsive; ?>" alt="<?php //echo get_post_meta( $post->ID, 'slider-1-alt', true ); ?>" title="<?php //echo get_post_meta( $post->ID, 'slider-1-title', true ); ?>" />
            </div><!-- .media-container -->

            <p class="hidden">
                <a title="Qutar imagen" href="javascript:;" class="remove-file button button-secondary">Quitar</a>
            </p>

            <p class="media-info">
                <input class="hd-src" type="hidden" name="mb_responsive" value="<?php echo $responsive; ?>" />
            </p><!-- .media-info -->
        </div><!-- end container-upload-file -->
    </fieldset><!-- end GroupFrm -->
    
    <fieldset>
        <legend>Archivos</legend>

        <?php
            $totalFiles = 6;
            $count = 0;
            
            if (!empty($files)) :
            $files = unserialize($files);
            $files_title = unserialize($files_title);
            $count = count($files);
            $i = 0;

            foreach ($files as $file) :
        ?>
                <div class="container-upload-file">
                    <p class="btn-add-file">
                        <a title="Agregar archivo" href="javascript:;" class="set-file button button-primary">Añadir Archivo</a>
                    </p>

                    <div class="hidden media-container">
                        <p>
                            <span class="dashicons dashicons-media-default"></span>
                            <span class="name"><?php echo $files_title[$i]; ?></span>
                        </p>
                    </div><!-- .media-container -->

                    <p class="hidden">
                        <a title="Quitar archivo" href="javascript:;" class="remove-file button button-secondary">Quitar Archivo</a>
                    </p>

                    <p class="media-info">
                        <input class="hd-src" type="hidden" name="mb_files[]" value="<?php echo $file; ?>" />
                        <input class="hd-title" type="hidden" name="mb_files_title[]" value="<?php echo $files_title[$i]; ?>" />
                    </p><!-- end .media-info -->
                </div><!-- end container-upload-file -->
                <?php ++$i; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($count < $totalFiles) : ?>
            <?php for ($i = 0; $i < ($totalFiles - $count); ++$i) : ?>
                <div class="container-upload-file">
                    <p class="btn-add-file">
                        <a title="Agregar Archivo" href="javascript:;" class="set-file button button-primary">Añadir Archivo</a>
                    </p>

                    <div class="hidden media-container">
                        <p>
                            <span class="dashicons dashicons-media-default"></span>
                            <span class="name"></span>
                        </p>
                    </div><!-- .media-container -->

                    <p class="hidden">
                        <a title="Quitar archivo" href="javascript:;" class="remove-file button button-secondary">Quitar Archivo</a>
                    </p>

                    <p class="media-info">
                        <input class="hd-src" type="hidden" name="mb_files[]" value="" />
                        <input class="hd-title" type="hidden" name="mb_files_title[]" value="" />
                    </p><!-- end .media-info -->
                </div><!-- end container-upload-file -->
            <?php endfor; ?>
        <?php endif; ?>
    </fieldset>
    
    <fieldset>
        <legend>Formularios</legend>
        <p>
            <label for="mb_forms"></label>
            <?php
                $settings = array(
                    'wpautop' => false,
                    'textarea_name' => 'mb_forms',
                    'media_buttons' => false,
                    'textarea_rows' => 10,
                );
                wp_editor($forms, 'mb_forms', $settings);
            ?>
        </p>
    </fieldset>
    
    <fieldset>
        <legend>Como completar los formularios</legend>
        <p>
            <label for="mb_how"></label>
            <?php
                $settings = array(
                    'wpautop' => false,
                    'textarea_name' => 'mb_how',
                    'media_buttons' => false,
                    'textarea_rows' => 10,
                );
                wp_editor($how, 'mb_how', $settings);
            ?>
        </p>
    </fieldset>
    
    <fieldset>
        <legend>Casos Prácticos</legend>
        <p>
            <label for="mb_cases"></label>
            <?php
                $settings = array(
                    'wpautop' => false,
                    'textarea_name' => 'mb_cases',
                    'media_buttons' => false,
                    'textarea_rows' => 10,
                );
                wp_editor($cases, 'mb_cases', $settings);
            ?>
        </p>
    </fieldset>
    
    <fieldset>
        <legend>Legislación</legend>
        <p>
            <label for="mb_legislation"></label>
            <?php
                $settings = array(
                    'wpautop' => false,
                    'textarea_name' => 'mb_legislation',
                    'media_buttons' => false,
                    'textarea_rows' => 10,
                );
                wp_editor($legislation, 'mb_legislation', $settings);
            ?>
        </p>
    </fieldset>
    
    <hr>
    
    <fieldset>
        <legend>Locales</legend>
        
        <?php if (count($locals)) : ?>
            <?php
                if (!empty($locales)) {
                    $locales = unserialize($locales);
                }
            ?>
            <ul>
                <?php foreach ($locals as $local) : ?>
                    <?php $id = $local->ID; ?>
                    <li>
                        <input type="checkbox" id="mb_locales_<?php echo $id; ?>" name="mb_locales[<?php echo $id; ?>]" <?php (isset($locales[$id])) ? checked($locales[$id], 'on') : ''; ?> />
                        <label for="mb_locales_<?php echo $id; ?>"><?php echo $local->post_title; ?></label>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>No existen locales</p>
        <?php endif; ?>
    </fieldset>
    
    <fieldset class="GroupForm">
        <legend class="GroupForm-legend">Imagen para Plantilla de Servicios con Locales</legend>

        <div class="container-upload-file GroupForm-wrapperImage">
            <p class="btn-add-file">
                <a title="Agregar imagen" href="javascript:;" class="set-file button button-primary">Añadir</a>
            </p>

            <div class="hidden media-container">
                <img src="<?php echo $bg; ?>" alt="<?php //echo get_post_meta( $post->ID, 'slider-1-alt', true ); ?>" title="<?php //echo get_post_meta( $post->ID, 'slider-1-title', true ); ?>" />
            </div><!-- .media-container -->

            <p class="hidden">
                <a title="Qutar imagen" href="javascript:;" class="remove-file button button-secondary">Quitar</a>
            </p>

            <p class="media-info">
                <input class="hd-src" type="hidden" name="mb_bg" value="<?php echo $bg; ?>" />
            </p><!-- .media-info -->
        </div><!-- end container-upload-file -->
    </fieldset><!-- end GroupFrm -->
    
    <fieldset>
        <legend>Galeria de Imágenes</legend>

        <?php
            $totalGallery = 15;
            $count = 0;
            
            if (!empty($gallery)) :
            $gallery = unserialize($gallery);
            $count = count($gallery);
            $i = 0;

            foreach ($gallery as $image) :
        ?>
                <div class="container-upload-file">
                    <p class="btn-add-file">
                        <a title="Agregar imagen" href="javascript:;" class="set-file button button-primary">Añadir Imagen</a>
                    </p>

                    <div class="hidden media-container">
                        <img src="<?php echo $image; ?>" alt="<?php //echo get_post_meta( $post->ID, 'slider-1-alt', true ); ?>" title="<?php //echo get_post_meta( $post->ID, 'slider-1-title', true ); ?>" />
                    </div><!-- .media-container -->

                    <p class="hidden">
                        <a title="Quitar imagen" href="javascript:;" class="remove-file button button-secondary">Quitar Imagen</a>
                    </p>

                    <p class="media-info">
                        <input class="hd-src" type="hidden" name="mb_gallery[]" value="<?php echo $image; ?>" />
                    </p><!-- end .media-info -->
                </div><!-- end container-upload-file -->
                <?php ++$i; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($count < $totalGallery) : ?>
            <?php for ($i = 0; $i < ($totalGallery - $count); ++$i) : ?>
                <div class="container-upload-file">
                    <p class="btn-add-file">
                        <a title="Agregar Imagen" href="javascript:;" class="set-file button button-primary">Añadir Imagen</a>
                    </p>

                    <div class="hidden media-container">
                        <img src="" />
                    </div><!-- .media-container -->

                    <p class="hidden">
                        <a title="Quitar archivo" href="javascript:;" class="remove-file button button-secondary">Quitar Imagen</a>
                    </p>

                    <p class="media-info">
                        <input class="hd-src" type="hidden" name="mb_gallery[]" value="" />
                    </p><!-- end .media-info -->
                </div><!-- end container-upload-file -->
            <?php endfor; ?>
        <?php endif; ?>
    </fieldset>
</div><!-- #single-post-meta-manager -->
