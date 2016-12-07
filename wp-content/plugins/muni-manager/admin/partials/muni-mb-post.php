<?php
/**
 * Displays the user interface for the Muni Manager meta box by type content Post.
 *
 * This is a partial template that is included by the Muni Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-post-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        $video = isset($values['mb_video']) ? esc_attr($values['mb_video'][0]) : '';
        $images = isset($values['mb_images']) ?  $values['mb_images'][0]  :  '';
        $responsive = isset( $values['mb_responsive'] ) ? esc_attr($values['mb_responsive'][0]) : '';

        wp_nonce_field('post_meta_box_nonce', 'meta_box_nonce');
    ?>

    <!-- Video-->
    <p class="content-mb">
        <label for="mb_video">Id Video: </label>
        <input type="text" name="mb_video" id="mb_video" value="<?php echo $video; ?>" />
    </p>
    
    <fieldset>
        <legend>Imágenes</legend>

        <?php
            $totalFiles = 6;
            $count = 0;
            
            if (!empty($images)) :
            $images = unserialize($images);
            $count = count($images);
            $i = 0;

            foreach ($images as $image) :
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
                        <input class="hd-src" type="hidden" name="mb_images[]" value="<?php echo $image; ?>" />
                    </p><!-- end .media-info -->
                </div><!-- end container-upload-file -->
                <?php ++$i; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($count < $totalFiles) : ?>
            <?php for ($i = 0; $i < ($totalFiles - $count); ++$i) : ?>
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
                        <input class="hd-src" type="hidden" name="mb_images[]" value="" />
                    </p><!-- end .media-info -->
                </div><!-- end container-upload-file -->
            <?php endfor; ?>
        <?php endif; ?>
    </fieldset>
    
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
