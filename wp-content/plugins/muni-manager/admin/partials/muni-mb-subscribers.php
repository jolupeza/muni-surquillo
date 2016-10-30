<?php
/**
 * Displays the user interface for the Watson Manager meta box by type content Subscribers.
 *
 * This is a partial template that is included by the Muni Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-subscribers-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        $email = isset($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';

        wp_nonce_field( 'subscribers_meta_box_nonce', 'meta_box_nonce' );
    ?>

    <!-- Email-->
    <p class="content-mb">
        <label for="mb_email">Correo electrónico: </label>
        <input type="text" name="mb_email" id="mb_email" value="<?php echo $email; ?>" />
    </p>
</div><!-- #single-post-meta-manager -->
