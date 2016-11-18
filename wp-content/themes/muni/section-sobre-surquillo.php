<section class="Page Page--details">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <h2 class="Title text--blue h1"><?php the_title(); ?></h2>
        <?php the_content(); ?>

        <?php
          $values = get_post_custom(get_the_id());
          $files = isset($values['mb_files']) ? $values['mb_files'][0] : '';
          $files_title = isset($values['mb_files_title']) ? $values['mb_files_title'][0] : '';

          if (!empty($files)) :
        ?>
          <p>Vea los siguientes documentos</p>
          <p class="text-center text--nimportant">
            <?php
              $files = unserialize($files);
              $filesTitle = unserialize($files_title);
              $i = 0;

              foreach ($files as $file) :
            ?>
              <a href="<?php echo $file; ?>" class="Button Button--transp Button--blue" target="_blank" title="<?php echo $filesTitle[$i]; ?>">
                <i class="glyphicon glyphicon-file text--l text--greenSoft" aria-hidden="true"></i><?php echo $filesTitle[$i]; ?>
              </a>
              <?php $i++; ?>
            <?php endforeach; ?>
          </p>
        <?php endif; ?>
      </div><!-- end col-md-8 -->

      <?php $options = get_option('muni_custom_settings'); ?>
      <?php
        $population = (isset($options['population'])) ? $options['population'] : '';
        $location = (isset($options['location'])) ? $options['location'] : '';
        $latitud = (isset($options['latitud'])) ? $options['latitud'] : '';
        $longitud = (isset($options['longitud'])) ? $options['longitud'] : '';
        $limit = (isset($options['limit'])) ? $options['limit'] : '';

        if (!empty($population) || !empty($location) || !empty($latitud) || !empty($longitud) || !empty($limit)) :
      ?>
        <div class="col-md-4">
          <section class="Table">
            <header class="Table-header text-center text--white">Datos Adicionales</header>
            <?php if (!empty($population)) : ?>
              <article class="Table-row text--white">
                <div class="Table-col Table-col--legend text-right">Población</div>
                <div class="Table-col"><?php echo $population; ?></div>
              </article>
            <?php endif; ?>

            <?php if (!empty($options['location'])) : ?>
              <article class="Table-row text--white">
                <div class="Table-col Table-col--legend text-right">Ubicación</div>
                <div class="Table-col"><?php echo $location; ?></div>
              </article>
            <?php endif; ?>

            <?php if (!empty($options['latitud'])) : ?>
              <article class="Table-row text--white">
                <div class="Table-col Table-col--legend text-right">Latitud</div>
                <div class="Table-col"><?php echo $latitud; ?></div>
              </article>
            <?php endif; ?>

            <?php if (!empty($options['longitud'])) : ?>
              <article class="Table-row text--white">
                <div class="Table-col Table-col--legend text-right">Longitud</div>
                <div class="Table-col"><?php echo $longitud; ?></div>
              </article>
            <?php endif; ?>

            <?php if (!empty($options['limit'])) : ?>
              <article class="Table-row text--white">
                <div class="Table-col Table-col--legend text-right">Límites</div>
                <div class="Table-col"><?php echo $limit; ?></div>
              </article>
            <?php endif; ?>

            <?php $plano = (isset($options['plano'])) ? $options['plano'] : ''; ?>
            <?php if (!empty($plano)) : ?>
              <footer class="Table-footer text-center">
                <a href="<?php echo $plano; ?>" target="_blank" rel="noopener noreferrer">
                  <i class="Icon Icon--map"></i> Ver Plano Distrital
                </a>
              </footer>
            <?php endif; ?>
          </section><!-- end Table -->
        </div><!-- end col-md-4 -->
      <?php endif; ?>
    </div><!-- end row -->
  </div><!-- end container -->
</section><!-- end Page -->
