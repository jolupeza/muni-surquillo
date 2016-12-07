<?php
/**
 * Displays the user interface for the Muni Manager meta box by type content Banners.
 *
 * This is a partial template that is included by the Muni Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-sliders-id">
    <?php
        $values = get_post_custom( get_the_ID() );
        $responsive = isset( $values['mb_responsive'] ) ? esc_attr($values['mb_responsive'][0]) : '';
        $link_text = isset($values['mb_link_text']) ? esc_attr($values['mb_link_text'][0]) : '';
        $url = isset($values['mb_url']) ? esc_attr($values['mb_url'][0]) : '';
        $target = isset($values['mb_target']) ? esc_attr($values['mb_target'][0]) : '';
        $pageId = isset($values['mb_page']) ? esc_attr($values['mb_page'][0]) : '';
        
        $pages = get_pages();

        wp_nonce_field( 'sliders_meta_box_nonce', 'meta_box_nonce' );
    ?>
    
    <?php if (count($pages)) : ?>
        <p class="content-mb">
            <label for="mb_page">Páginas:</label>
            <select name="mb_page" id="mb_page">
                <option value="">-- Seleccionar página --</option>
                <?php foreach ($pages as $page) : ?>
                <option value="<?php echo $page->ID; ?>" <?php selected($pageId, $page->ID); ?>><?php echo $page->post_title; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
    <?php endif; ?>
        
    <!-- Link Text-->
    <p class="content-mb">
        <label for="mb_link_text">Texto de enlace: </label>
        <input type="text" name="mb_link_text" id="mb_link_text" value="<?php echo $link_text; ?>" />
    </p>

    <!-- URL-->
    <p class="content-mb">
        <label for="mb_url">Url: </label>
        <input type="text" name="mb_url" id="mb_url" value="<?php echo $url; ?>" />
    </p>

    <!-- Target-->
    <p class="content-mb">
        <label for="mb_target">Mostrar en otra pestaña:</label>
        <input type="checkbox" name="mb_target" id="mb_target" <?php checked($target, 'on'); ?> />
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
</div><!-- #single-post-meta-manager -->
