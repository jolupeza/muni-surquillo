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
        $files = isset($values['mb_files']) ?  $values['mb_files'][0]  :  '';
        $files_title = isset($values['mb_files_title']) ?  $values['mb_files_title'][0]  :  '';

        wp_nonce_field('pages_meta_box_nonce', 'meta_box_nonce');
    ?>

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
</div><!-- #single-post-meta-manager -->
