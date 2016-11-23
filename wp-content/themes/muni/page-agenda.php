<?php
  /*
  Template Name: Agenda Page
  */
?>
<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <?php $idPage = get_the_id(); ?>
    <?php if (has_post_thumbnail()) : ?>
      <figure class="Page-image Page-image--full">
        <?php the_post_thumbnail('full', ['class' => 'img-responsive center-block']); ?>
      </figure>

      <section class="Page Page--details">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2 class="Title text--blue h1">
                <?php if (has_excerpt()) : ?>
                  <?php echo get_the_excerpt(); ?>
                <?php else : ?>
                  <?php the_title(); ?>
                <?php endif; ?>
              </h2>
              <?php the_content(); ?>

              <section class="ColsFlex">
                <article class="Col Col--colors Col--orange Col--33 text-center">
                  <h3 class="Title-semi text--blue">Consulta tributaria</h3>
                  <h2 class="Title text--orange h1">241-0413</h2>

                  <div class="wrapper-select wrapper-select--orange">
                    <select name="subject" id="subject" required data-fv-notempty-message="Seleccionar asunto">
                      <option value="">-- Seleccione una oficina --</option>
                      <option value="1">Asunto 1</option>
                    </select>
                  </div>

                  <div class="Square">
                    <h4 class="Title-semi Square-title text-center">Gerencia General</h4>
                    <h3 class="Title-bold Square-number">Anexo 113</h3>
                  </div>
                </article><!-- emd Col -->

                <article class="Col Col--colors Col--green Col--33 text-center">
                  <h3 class="Title-semi text--blue">Teléfonos de</h3>
                  <h2 class="Title text--green h1">Emergencia</h2>

                  <div class="wrapper-select wrapper-select--green">
                    <select name="subject" id="subject" required data-fv-notempty-message="Seleccionar asunto">
                      <option value="">-- Seleccione una institución --</option>
                      <option value="1">Asunto 1</option>
                    </select>
                  </div>

                  <div class="Square">
                    <h4 class="Title-semi Square-title text-center">Gerencia General</h4>
                    <h3 class="Title-bold Square-number">Anexo 113</h3>
                  </div>
                </article><!-- emd Col -->

                <article class="Col Col--colors Col--skyBlue Col--33 text-center">
                  <h3 class="Title-semi text--blue">Teléfonos de los</h3>
                  <h2 class="Title text--skyBlue h1">Locales</h2>

                  <div class="wrapper-select wrapper-select--skyBlue">
                    <select name="subject" id="subject" required data-fv-notempty-message="Seleccionar asunto">
                      <option value="">-- Seleccione una sede --</option>
                      <option value="1">Asunto 1</option>
                    </select>
                  </div>

                  <div class="Square">
                    <h4 class="Title-semi Square-title text-center">Gerencia General</h4>
                    <h3 class="Title-bold Square-number">Anexo 113</h3>
                  </div>
                </article><!-- emd Col -->
              </section><!-- end ColsFlex -->
            </div><!-- end col-md-12 -->
          </div><!-- end row -->
        </div><!-- end container -->
      </section><!-- end Page -->

      <?php endif; ?>
  <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>
