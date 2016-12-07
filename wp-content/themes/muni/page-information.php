<?php
  /*
  Template Name: Acceso Informacion Page
  */
?>

<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <?php
      $idPage = get_the_id();
      $values = get_post_custom($idPage);

      $responsive = isset( $values['mb_responsive'] ) ? esc_attr($values['mb_responsive'][0]) : '';
    ?>
    <?php if (has_post_thumbnail()) : ?>
      <figure class="Page-image Page-image--full">
        <picture>
          <?php if (!empty($responsive)) : ?>
              <source class="img-responsive center-block" media="(max-width: 767px)" srcset="<?php echo $responsive; ?>">
            <?php endif; ?>
            <?php the_post_thumbnail('full', array('class' => 'img-responsive center-block')); ?>
        </picture>
      </figure>

      <section class="Page Page--details">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2 class="Title text--blue h1"><?php the_title(); ?></h2>
              <?php the_content(); ?>

              <form action="" class="Form Form--80 Form--round" method="POST" id="js-frm-info" enctype="multipart/form-data">
                <div class="Form-loader text-center hidden" id="js-form-info-loader">
                  <span class="animated glyphicon glyphicon-refresh h2" aria-hidden="true"></span>
                </div>

                <h2 class="SubTitle text--blue">Datos del Solicitante</h2>

                <div class="form-group">
                  <label for="name" class="sr-only">Nombres y Apellidos</label>
                  <input type="text" class="form-control" name="name" id="name" placeholder="Nombres y Apellidos" autocomplete="off" required />
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <?php
                      $args = [
                        'post_type' => 'documents',
                        'posts_per_page' => -1,
                        'order' => 'ASC'
                      ];
                      $the_query = new WP_Query($args);

                      if ($the_query->have_posts()) :
                    ?>
                        <div class="form-group">
                          <div class="select-style select-style--full">
                            <select class="Form-select Form-select--full" name="tipdoc" required data-fv-notempty-message="Seleccionar Documento de Identidad">
                              <option value="">-- Seleccione Documento de Identidad --</option>
                              <?php while ($the_query->have_posts()) : ?>
                                <?php $the_query->the_post(); ?>
                                <option value="<?php echo get_the_id(); ?>"><?php the_title(); ?></option>
                              <?php endwhile; ?>
                            </select><!-- end Form-select -->
                          </div><!-- end select-style -->
                        </div><!-- end form-group -->
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <label for="numdoc" class="sr-only">Número de documento</label>
                      <input type="text" class="form-control" name="numdoc" id="numdoc" placeholder="Número de documento" autocomplete="off" required />
                    </div>
                  </div>
                  <div class="col-md-3"></div>
                </div><!-- end row -->

                <div class="row">
                  <div class="col-md-4">
                    <?php
                      $args = [
                        'post_type' => 'cities',
                        'posts_per_page' => -1,
                        'post_parent' => 0,
                        'order' => 'ASC'
                      ];
                      $the_query = new WP_Query($args);

                      if ($the_query->have_posts()) :
                    ?>
                        <div class="form-group">
                          <div class="select-style select-style--full">
                            <select class="Form-select Form-select--full" name="dpto" id="js-dpto" required data-fv-notempty-message="Seleccionar Departamento">
                              <option value="">-- Seleccione Departamento --</option>
                              <?php while ($the_query->have_posts()) : ?>
                                <?php $the_query->the_post(); ?>
                                <option value="<?php echo get_the_id(); ?>"><?php the_title(); ?></option>
                              <?php endwhile; ?>
                            </select><!-- end Form-select -->
                          </div><!-- end select-style -->
                        </div><!-- end form-group -->
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="select-style select-style--full">
                        <select class="Form-select Form-select--full" name="prov" id="js-prov" required data-fv-notempty-message="Seleccionar Provincia">
                          <option value="">-- Seleccione Provincia --</option>
                        </select><!-- end Form-select -->
                      </div><!-- end select-style -->
                    </div><!-- end form-group -->
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <div class="select-style select-style--full">
                        <select class="Form-select Form-select--full" name="dist" id="js-dist" required data-fv-notempty-message="Seleccionar Distrito">
                          <option value="">-- Seleccione Distrito --</option>
                        </select><!-- end Form-select -->
                      </div><!-- end select-style -->
                    </div><!-- end form-group -->
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-2">
                    <div class="form-group">
                      <div class="select-style select-style--full">
                        <select class="Form-select Form-select--full" name="via" id="via" required data-fv-notempty-message="Seleccionar Vía">
                          <option value="">-- Indicar Vía --</option>
                          <option value="1">Av.</option>
                          <option value="2">Cl.</option>
                          <option value="3">Jr.</option>
                          <option value="4">Psje.</option>
                        </select><!-- end Form-select -->
                      </div><!-- end select-style -->
                    </div><!-- end form-group -->
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <label for="address" class="sr-only">Dirección</label>
                      <input type="text" class="form-control" name="address" id="address" placeholder="Dirección" autocomplete="off" required />
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="number" class="sr-only">N°|Dpto|Int</label>
                      <input type="text" class="form-control" name="number" id="number" placeholder="N°|Dpto|Int" autocomplete="off" required />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="urb" class="sr-only">Urb | AA.HH.</label>
                  <input type="text" class="form-control" name="urb" id="urb" placeholder="Urb | AA.HH." autocomplete="off" required />
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email" class="sr-only">Correo electrónico</label>
                      <input type="email" class="form-control" name="email" id="email" placeholder="Correo electrónico" autocomplete="off" required />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone" class="sr-only">Teléfono</label>
                      <input type="text" class="form-control" name="phone" id="phone" placeholder="Teléfono" autocomplete="off" required data-fv-stringlength="true" data-fv-stringlength-max="9" data-fv-stringlength-min="7" data-fv-stringlength-message="Debe contener entre 7 y 9 dígitos"  />
                    </div>
                  </div>
                </div><!-- end row -->

                <h2 class="SubTitle text--blue">Información Solicitada</h2>

                <div class="form-group">
                  <label for="infsol" class="Form-label sr-only">Información del Solicitante</label>
                  <textarea class="form-control Form-input" name="infsol" id="infsol" placeholder="Escribe la información solicitada aquí" rows="8" required></textarea>
                </div>

                <h2 class="SubTitle text--blue">Dependencia de la cual se requiere la información</h2>

                <div class="form-group">
                  <label for="depend" class="Form-label sr-only">Dependencia</label>
                  <textarea class="form-control Form-input" name="depend" id="depend" placeholder="Unidad Orgánica" rows="8" required></textarea>
                </div>

                <?php
                  global $wpdb;
                  $deliveries = $wpdb->get_results("SELECT tt.term_taxonomy_id, t.name FROM $wpdb->term_taxonomy tt INNER JOIN $wpdb->terms t ON tt.term_id = t.term_id WHERE tt.taxonomy = 'deliveries' ORDER BY tt.term_taxonomy_id ASC");
                  if (count($deliveries)) :
                ?>
                  <h2 class="SubTitle text--blue">Forma de entrega</h2>
                    <div class="row">
                      <?php foreach ($deliveries as $delivery) : ?>
                        <div class="col-md-3">
                          <div class="form-group">
                            <div class="radio">
                              <label>
                                <input type="radio" name="formaentrega" value="<?php echo $delivery->term_taxonomy_id; ?>"> <?php echo $delivery->name; ?>
                              </label>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <h2 class="SubTitle text--blue">Observaciones</h2>

                <div class="form-group">
                  <label for="obser" class="Form-label sr-only">Observación</label>
                  <textarea class="form-control Form-input" name="obser" id="obser" placeholder="Escribe tu observación aquí" rows="8" required></textarea>
                </div>

                <h2 class="SubTitle text--blue">Representante Legal</h2>

                <div class="form-group">
                  <label for="namerep" class="sr-only">Nombres y Apellidos</label>
                  <input type="text" class="form-control" name="namerep" id="namerep" placeholder="Nombres y Apellidos" autocomplete="off" required />
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <?php
                      $args = [
                        'post_type' => 'documents',
                        'posts_per_page' => -1,
                        'order' => 'ASC'
                      ];
                      $the_query = new WP_Query($args);

                      if ($the_query->have_posts()) :
                    ?>
                        <div class="form-group">
                          <div class="select-style select-style--full">
                            <select class="Form-select Form-select--full" name="tipdocrep" required data-fv-notempty-message="Seleccionar Documento de Identidad">
                              <option value="">-- Seleccione Documento de Identidad --</option>
                              <?php while ($the_query->have_posts()) : ?>
                                <?php $the_query->the_post(); ?>
                                <option value="<?php echo get_the_id(); ?>"><?php the_title(); ?></option>
                              <?php endwhile; ?>
                            </select><!-- end Form-select -->
                          </div><!-- end select-style -->
                        </div><!-- end form-group -->
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <label for="numdocrep" class="sr-only">Número de documento</label>
                      <input type="text" class="form-control" name="numdocrep" id="numdocrep" placeholder="Número de documento" autocomplete="off" required />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <div class="select-style select-style--full">
                        <select class="Form-select Form-select--full" name="tipper" required data-fv-notempty-message="Seleccionar Tipo de Persona">
                          <option value="">-- Seleccione Tipo de Persona --</option>
                          <option value="1">Persona Natural</option>
                          <option value="2">Persona Jurídica</option>
                        </select><!-- end Form-select -->
                      </div><!-- end select-style -->
                    </div><!-- end form-group -->
                  </div>
                </div><!-- end row -->

                <p class="text-center">
                  <input type="submit" class="Button Button--blue Button--blueBg text-uppercase" value="Enviar" />
                </p>

                <div class="alert text-center" role="alert"  id="js-form-info-msg"></div>
              </form>
            </div><!-- end col-md-12 -->
          </div><!-- end row -->
        </div><!-- end container -->
      </section><!-- end Page -->
    <?php endif; ?>
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
