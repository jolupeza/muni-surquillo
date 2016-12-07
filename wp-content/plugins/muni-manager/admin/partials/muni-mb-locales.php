<?php
/**
 * Displays the user interface for the Muni Manager meta box by type content Locales.
 *
 * This is a partial template that is included by the Muni Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-locales-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
        $address = isset($values['mb_address']) ? esc_attr($values['mb_address'][0]) : '';

        
        wp_nonce_field('locales_meta_box_nonce', 'meta_box_nonce');
    ?>

    <!-- Central -->
    <p class="content-mb">
        <label for="mb_phone">Central Telefónica: </label>
        <input type="text" name="mb_phone" id="mb_phone" value="<?php echo $phone; ?>" />
    </p>

    <!-- Dirección-->
    <p class="content-mb">
        <label for="mb_address">Dirección: </label>
        <input type="text" name="mb_address" id="mb_address" value="<?php echo $address; ?>" />
    </p>
</div><!-- #single-post-meta-manager -->
