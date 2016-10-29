<?php
/**
 * Displays the user interface for the Watson Manager meta box by type content Videos.
 *
 * This is a partial template that is included by the Watson Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-videos-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        $video = isset($values['mb_video']) ? esc_attr($values['mb_video'][0]) : '';

        wp_nonce_field( 'videos_meta_box_nonce', 'meta_box_nonce' );
    ?>

    <!-- Video-->
    <p class="content-mb">
        <label for="mb_video">Video: </label>
        <input type="text" name="mb_video" id="mb_video" value="<?php echo $video; ?>" />
    </p>
</div><!-- #single-post-meta-manager -->
