<?php
/**
 * Displays the user interface for the Watson Manager meta box by type content Directories.
 *
 * This is a partial template that is included by the Muni Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-directories-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';

        wp_nonce_field( 'directories_meta_box_nonce', 'meta_box_nonce' );
    ?>
    
    <!-- Name-->
    <p class="content-mb">
        <label for="mb_phone">Teléfono o Anexo: </label>
        <input type="text" name="mb_phone" id="mb_phone" value="<?php echo $phone; ?>" />
    </p>
</div><!-- #single-post-meta-manager -->
