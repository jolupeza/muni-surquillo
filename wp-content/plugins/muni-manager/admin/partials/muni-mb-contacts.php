<?php
/**
 * Displays the user interface for the Watson Manager meta box by type content Contacts.
 *
 * This is a partial template that is included by the Muni Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-contacts-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        $name = isset($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
        $lastname = isset($values['mb_lastname']) ? esc_attr($values['mb_lastname'][0]) : '';
        $email = isset($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
        $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
        $address = isset($values['mb_address']) ? esc_attr($values['mb_address'][0]) : '';
        $urba = isset($values['mb_urba']) ? esc_attr($values['mb_urba'][0]) : '';
        $message = isset($values['mb_message']) ? esc_attr($values['mb_message'][0]) : '';

        wp_nonce_field( 'contacts_meta_box_nonce', 'meta_box_nonce' );
    ?>
    
    <!-- Name-->
    <p class="content-mb">
        <label for="mb_name">Nombres: </label>
        <input type="text" name="mb_name" id="mb_name" value="<?php echo $name; ?>" />
    </p>
    
    <!-- LastName-->
    <p class="content-mb">
        <label for="mb_lastname">Apellidos: </label>
        <input type="text" name="mb_lastname" id="mb_lastname" value="<?php echo $lastname; ?>" />
    </p>

    <!-- Email-->
    <p class="content-mb">
        <label for="mb_email">Correo electrónico: </label>
        <input type="email" name="mb_email" id="mb_email" value="<?php echo $email; ?>" />
    </p>
    
    <!-- Phone-->
    <p class="content-mb">
        <label for="mb_phone">Teléfono: </label>
        <input type="text" name="mb_phone" id="mb_phone" value="<?php echo $phone; ?>" />
    </p>
    
    <!-- Address-->
    <p class="content-mb">
        <label for="mb_address">Dirección: </label>
        <input type="text" name="mb_address" id="mb_address" value="<?php echo $address; ?>" />
    </p>
    
    <!-- Urbanizacion-->
    <p class="content-mb">
        <label for="mb_urba">Urbanización: </label>
        <input type="text" name="mb_urba" id="mb_urba" value="<?php echo $urba; ?>" />
    </p>
    
    <!-- Message-->
    <p class="content-mb">
        <label for="mb_message">Mensaje: </label>
        <input type="text" name="mb_message" id="mb_message" value="<?php echo $message; ?>" />
    </p>
</div><!-- #single-post-meta-manager -->
