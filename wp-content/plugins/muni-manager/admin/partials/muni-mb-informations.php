<?php
/**
 * Displays the user interface for the Watson Manager meta box by type content Informations.
 *
 * This is a partial template that is included by the Muni Manager
 * Admin class that is used to display all of the information that is related
 * to the page meta data for the given page.
 */
?>
<div id="mb-informations-id">

    <?php
        $values = get_post_custom( get_the_ID() );
        
        $name = isset($values['mb_name']) ? esc_attr($values['mb_name'][0]) : '';
        $tipdoc = isset($values['mb_tipdoc']) ? (int)esc_attr($values['mb_tipdoc'][0]) : 0;
        $numdoc = isset($values['mb_numdoc']) ? esc_attr($values['mb_numdoc'][0]) : '';
        $dpto = isset($values['mb_dpto']) ? (int)esc_attr($values['mb_dpto'][0]) : 0;
        $prov = isset($values['mb_prov']) ? (int)esc_attr($values['mb_prov'][0]) : 0;
        $dist = isset($values['mb_dist']) ? (int)esc_attr($values['mb_dist'][0]) : 0;
        $via = isset($values['mb_via']) ? esc_attr($values['mb_via'][0]) : '';
        $address = isset($values['mb_address']) ? esc_attr($values['mb_address'][0]) : '';
        $number = isset($values['mb_number']) ? esc_attr($values['mb_number'][0]) : '';
        $urb = isset($values['mb_urb']) ? esc_attr($values['mb_urb'][0]) : '';
        $email = isset($values['mb_email']) ? esc_attr($values['mb_email'][0]) : '';
        $phone = isset($values['mb_phone']) ? esc_attr($values['mb_phone'][0]) : '';
        $infsol = isset($values['mb_infsol']) ? esc_attr($values['mb_infsol'][0]) : '';
        $depend = isset($values['mb_depend']) ? esc_attr($values['mb_depend'][0]) : '';
        $obser = isset($values['mb_obser']) ? esc_attr($values['mb_obser'][0]) : '';
        $namerep = isset($values['mb_namerep']) ? esc_attr($values['mb_namerep'][0]) : '';
        $tipdocrep = isset($values['mb_tipdocrep']) ? (int)esc_attr($values['mb_tipdocrep'][0]) : 0;
        $numdocrep = isset($values['mb_numdocrep']) ? esc_attr($values['mb_numdocrep'][0]) : '';
        $tipper = isset($values['mb_tipper']) ? esc_attr($values['mb_tipper'][0]) : '';
        
        $dataDpto = get_post($dpto);
        $nameDpto = $dataDpto->post_title;

        $dataProv = get_post($prov);
        $nameProv = $dataProv->post_title;

        $dataDist = get_post($dist);
        $nameDist = $dataDist->post_title;
        
        $dataTipDoc = get_post($tipdoc);
        $nameTipDoc = $dataTipDoc->post_title;

        $dataTipDocRep = get_post($tipdocrep);
        $nameTipDocRep = $dataTipDocRep->post_title;

        wp_nonce_field( 'books_meta_box_nonce', 'meta_box_nonce' );
    ?>
    
    <!-- Service-->
    <p class="content-mb">
        <label for="mb_name">Nombres y Apellidos: </label>
        <input type="text" name="mb_name" id="mb_name" value="<?php echo $name; ?>" />
    </p>
    
    <!-- TipDoc-->
    <p class="content-mb">
        <label for="mb_tipdoc">Tipo de Documento: </label>
        <input type="text" name="mb_tipdoc" id="mb_tipdoc" value="<?php echo $nameTipDoc; ?>" />
    </p>
    
    <!-- NumDoc-->
    <p class="content-mb">
        <label for="mb_numdoc">Número de Documento: </label>
        <input type="text" name="mb_numdoc" id="mb_numdoc" value="<?php echo $numdoc; ?>" />
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
    
    <!-- Urb-->
    <p class="content-mb">
        <label for="mb_urb">Urb | AA.HH.: </label>
        <input type="text" name="mb_urb" id="mb_urb" value="<?php echo $urb; ?>" />
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
    
    <hr>
    
    <!-- NameRep -->
    <p class="content-mb">
        <label for="mb_namerep">Nombre Representante Legal: </label>
        <input type="text" name="mb_namerep" id="mb_namerep" value="<?php echo $namerep; ?>" />
    </p>
    
    <!-- TipDocRep -->
    <p class="content-mb">
        <label for="mb_tipdocrep">Tipo de Documento Rep.: </label>
        <input type="text" name="mb_tipdocrep" id="mb_tipdocrep" value="<?php echo $nameTipDocRep; ?>" />
    </p>
    
    <!-- NumDocRep -->
    <p class="content-mb">
        <label for="mb_numdocrep">Número de Documento Rep: </label>
        <input type="text" name="mb_numdocrep" id="mb_numdocrep" value="<?php echo $numdocrep; ?>" />
    </p>
    
    <!-- TipPer -->
    <p class="content-mb">
        <label for="mb_tipper">Tipo de Persona: </label>
        <input type="text" name="mb_tipper" id="mb_tipper" value="<?php echo $tipper; ?>" />
    </p>
    
    <!-- InfSol-->
    <p class="content-mb">
        <label for="mb_infsol">Información Solicitada: </label>
        <textarea name="mb_infsol" id="mb_infsol" rows="8"><?php echo $infsol; ?></textarea>
    </p>
    
    <!-- Depend-->
    <p class="content-mb">
        <label for="mb_depend">Unidad Orgánica: </label>
        <textarea name="mb_depend" id="mb_depend" rows="8"><?php echo $depend; ?></textarea>
    </p>
    
    <!-- Obser-->
    <p class="content-mb">
        <label for="mb_obser">Observación: </label>
        <textarea name="mb_obser" id="mb_obser" rows="8"><?php echo $obser; ?></textarea>
    </p>
</div><!-- #single-post-meta-manager -->
