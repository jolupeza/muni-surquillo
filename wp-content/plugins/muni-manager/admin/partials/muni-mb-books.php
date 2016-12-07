<?php
/**
 * Displays the user interface for the Watson Manager meta box by type content Books.
 *
 * This is a partial template that is included by the Muni Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-books-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        
        $service = isset($values['mb_service']) ? esc_attr($values['mb_service'][0]) : '';
        $area = isset($values['mb_area']) ? esc_attr($values['mb_area'][0]) : '';
        $message = isset($values['mb_message']) ? esc_attr($values['mb_message'][0]) : '';
        $file = isset($values['mb_file']) ? esc_attr($values['mb_file'][0]) : '';
        
        $name = isset($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
        $dni = isset($values['mb_dni']) ? esc_attr($values['mb_dni'][0]) : '';
        $email = isset($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
        $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
        
        $dpto = isset($values['mb_dpto']) ? (int)esc_attr($values['mb_dpto'][0]) : 0;
        $prov = isset($values['mb_prov']) ? (int)esc_attr($values['mb_prov'][0]) : 0;
        $dist = isset($values['mb_dist']) ? (int)esc_attr($values['mb_dist'][0]) : 0;

        $via = isset($values['mb_via']) ? esc_attr($values['mb_via'][0]) : '';
        $address = isset($values['mb_address']) ? esc_attr($values['mb_address'][0]) : '';
        $number = isset($values['mb_number']) ? esc_attr($values['mb_number'][0]) : '';
        
        $dataDpto = get_post($dpto);
        $nameDpto = $dataDpto->post_title;

        $dataProv = get_post($prov);
        $nameProv = $dataProv->post_title;

        $dataDist = get_post($dist);
        $nameDist = $dataDist->post_title;

        wp_nonce_field( 'books_meta_box_nonce', 'meta_box_nonce' );
    ?>
    
    <!-- Service-->
    <p class="content-mb">
        <label for="mb_service">Servicio: </label>
        <input type="text" name="mb_service" id="mb_service" value="<?php echo $service; ?>" />
    </p>
    
    <!-- Area-->
    <p class="content-mb">
        <label for="mb_area">Área encargada: </label>
        <input type="text" name="mb_area" id="mb_area" value="<?php echo $area; ?>" />
    </p>
    
    <!-- File-->
    <p class="content-mb">
        <label for="mb_file">Archivo: </label>
        <input type="text" name="mb_file" id="mb_file" value="<?php echo $file; ?>" />
    </p>
    
    <!-- Name-->
    <p class="content-mb">
        <label for="mb_name">Nombres: </label>
        <input type="text" name="mb_name" id="mb_name" value="<?php echo $name; ?>" />
    </p>
    
    <!-- DNI-->
    <p class="content-mb">
        <label for="mb_dni">D.N.I: </label>
        <input type="text" name="mb_dni" id="mb_dni" value="<?php echo $dni; ?>" />
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
    
    <!-- Dpto-->
    <p class="content-mb">
        <label for="mb_dpto">Departamento: </label>
        <input type="text" name="mb_dpto" id="mb_dpto" value="<?php echo $nameDpto; ?>" />
    </p>
    
    <!-- Prov-->
    <p class="content-mb">
        <label for="mb_prov">Provincia: </label>
        <input type="text" name="mb_prov" id="mb_prov" value="<?php echo $nameProv; ?>" />
    </p>
    
    <!-- Dist -->
    <p class="content-mb">
        <label for="mb_dist">Distrito: </label>
        <input type="text" name="mb_dist" id="mb_dist" value="<?php echo $nameDist; ?>" />
    </p>
    
    <!-- Via -->
    <p class="content-mb">
        <label for="mb_via">Vía: </label>
        <input type="text" name="mb_via" id="mb_via" value="<?php echo $via; ?>" />
    </p>
    
    <!-- Address-->
    <p class="content-mb">
        <label for="mb_address">Dirección: </label>
        <input type="text" name="mb_address" id="mb_address" value="<?php echo $address; ?>" />
    </p>
    
    <!-- Number -->
    <p class="content-mb">
        <label for="mb_number">N°|Dpto|Int: </label>
        <input type="text" name="mb_number" id="mb_number" value="<?php echo $number; ?>" />
    </p>
    
    <!-- Message-->
    <p class="content-mb">
        <label for="mb_message">Mensaje: </label>
        <textarea name="mb_message" id="mb_message" rows="8"><?php echo $message; ?></textarea>
    </p>
</div><!-- #single-post-meta-manager -->
