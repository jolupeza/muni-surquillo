<?php
  /*
  Template Name: Contact Page
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

              <form action="" class="Form Form--80 Form--round" method="POST" id="js-frm-contact">
                <div class="Form-loader text-center hidden" id="js-form-contact-loader">
                  <span class="animated infinite glyphicon glyphicon-refresh h2" aria-hidden="true"></span>
                </div>

                <p class="text-center" id="js-form-contact-msg"></p>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name" class="sr-only">Nombres</label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Nombres" autocomplete="off" required />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="lastname" class="sr-only">Apellidos</label>
                      <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Apellidos" autocomplete="off" required />
                    </div>
                  </div>
                </div><!-- end row -->

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email" class="sr-only">Email</label>
                      <input type="email" class="form-control" name="email" id="email" placeholder="Email" autocomplete="off" required />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone" class="sr-only">Teléfono</label>
                      <input type="text" class="form-control" name="phone" id="phone" placeholder="Teléfono" autocomplete="off" required />
                    </div>
                  </div>
                </div><!-- end row -->

                <div class="row">
                  <div class="col-md-9">
                    <div class="form-group">
                      <label for="address" class="sr-only">Dirección</label>
                      <input type="text" class="form-control" name="address" id="address" placeholder="Dirección" autocomplete="off" required />
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <label for="urba" class="sr-only">Urb | AA.HH.</label>
                      <input type="text" class="form-control" name="urba" id="urba" placeholder="Urbanización" autocomplete="off" required />
                    </div>
                  </div>
                </div>

                <?php
                  global $wpdb;
                  $subjects = $wpdb->get_results("SELECT tt.term_taxonomy_id, t.name FROM $wpdb->term_taxonomy tt INNER JOIN $wpdb->terms t ON tt.term_id = t.term_id WHERE tt.taxonomy = 'subjects'");
                  if (count($subjects)) :
                ?>
                    <div class="form-group">
                      <div class="select-style">
                        <select class="Form-select" name="subject" id="subject" required data-fv-notempty-message="Seleccionar asunto">
                          <option value="">-- Señale cuál es el asunto --</option>
                          <?php foreach ($subjects as $subject) : ?>
                            <option value="<?php echo $subject->term_taxonomy_id; ?>"><?php echo $subject->name; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                  <label for="message" class="Form-label sr-only">Mensaje</label>
                  <textarea class="form-control Form-input" name="message" id="message" placeholder="Escribe tu mensaje aquí" rows="8" required></textarea>
                </div>

                <p class="text-center">
                  <input type="submit" class="Button Button--blue Button--blueBg text-uppercase" value="Enviar" />
                </p>
              </form>
            </div><!-- end col-md-12 -->
          </div><!-- end row -->
        </div><!-- end container -->
      </section><!-- end Page -->
    <?php endif; ?>
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
