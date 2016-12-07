<?php
  /*
  Template Name: Libro Reclamaciones Page
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

              <form action="<?php echo home_url('libro-de-reclamaciones'); ?>" class="Form Form--80 Form--round" method="POST" id="js-frm-book" enctype="multipart/form-data">
                <div class="Form-loader text-center hidden" id="js-form-book-loader">
                  <span class="animated glyphicon glyphicon-refresh h2" aria-hidden="true"></span>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="service" class="sr-only">Servicio</label>
                      <input type="text" class="form-control" name="service" id="service" placeholder="Servicio" autocomplete="off" required />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="area" class="sr-only">Área encargada</label>
                      <input type="text" class="form-control" name="area" id="area" placeholder="Área encargada" autocomplete="off" required />
                    </div>
                  </div>
                </div><!-- end row -->

                <div class="form-group">
                  <label for="message" class="Form-label sr-only">Mensaje</label>
                  <textarea class="form-control Form-input" name="message" id="message" placeholder="Escribe tu mensaje aquí" rows="8" required></textarea>
                </div>

                <div class="row">
                  <div class="col-md-4">
                    <!-- File -->
                    <div class="form-group">
                      <div class="Form-fileUpload">
                        <span>Adjuntar archivo</span>
                        <input type="file" class="Form-file" name="file" id="file" multiple required data-fv-notempty-message="Debe adjuntar su archivo" />
                      </div>
                    </div><!-- end form-group -->
                  </div><!-- end col-md-4 -->
                </div><!-- end row -->

                <h2 class="SubTitle text--blue">Datos relativos al vecino</h2>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name" class="sr-only">Nombres y Apellidos</label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Nombres y Apellidos" autocomplete="off" required />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="dni" class="sr-only">D.N.I.</label>
                      <input type="text" class="form-control" name="dni" id="dni" placeholder="D.N.I." autocomplete="off" data-fv-stringlength="true" data-fv-stringlength-max="8" data-fv-stringlength-min="8" data-fv-stringlength-message="Debe contener 8 dígitos" required />
                    </div>
                  </div>
                </div><!-- end row -->

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

                <p class="text-center">
                  <input type="submit" class="Button Button--blue Button--blueBg text-uppercase" value="Enviar" />
                </p>

                <div class="alert text-center" role="alert"  id="js-form-book-msg"></div>
              </form>
            </div><!-- end col-md-12 -->
          </div><!-- end row -->
        </div><!-- end container -->
      </section><!-- end Page -->
    <?php endif; ?>
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
