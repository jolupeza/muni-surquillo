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
</div><!-- #single-post-meta-manager -->
