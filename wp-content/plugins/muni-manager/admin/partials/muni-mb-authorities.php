<?php
/**
 * Displays the user interface for the Muni Manager meta box by type content Authorities.
 *
 * This is a partial template that is included by the Muni Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-authorities-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        $job = isset($values['mb_job']) ? esc_attr($values['mb_job'][0]) : '';
        $email = isset($values['mb_email']) ?  $values['mb_email'][0]  :  '';
        $phone = isset($values['mb_phone']) ?  $values['mb_phone'][0]  :  '';
        $address = isset($values['mb_address']) ?  $values['mb_address'][0]  :  '';

        wp_nonce_field('authorities_meta_box_nonce', 'meta_box_nonce');
    ?>

    <!-- Job-->
    <p class="content-mb">
        <label for="mb_job">Cargo: </label>
        <input type="text" name="mb_job" id="mb_job" value="<?php echo $job; ?>" />
    </p>
    
    <!-- Job-->
    <p class="content-mb">
        <label for="mb_email">Correo electrónico: </label>
        <input type="email" name="mb_email" id="mb_email" value="<?php echo $email; ?>" />
    </p>
    
    <!-- Phone-->
    <p class="content-mb">
        <label for="mb_phone">Teléfono: </label>
        <input type="text" name="mb_phone" id="mb_phone" value="<?php echo $phone; ?>" />
    </p>
    
    <!-- Address -->
    <p class="content-mb">
        <label for="mb_address">Dirección: </label>
        <input type="text" name="mb_address" id="mb_address" value="<?php echo $address; ?>" />
    </p>
</div><!-- #single-post-meta-manager -->
