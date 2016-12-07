<form method="get" class="Form" action="<?php echo home_url(); ?>">
  <div class="form-group">
    <label for="s" class="sr-only">Buscar</label>
    <div class="input-group input-group--gray">
      <input type="text" class="form-control" name="s" id="s" placeholder="Buscar" aria-describedby="basic-search" autocomplete="off" />
      <span class="input-group-addon" id="basic-search">
        <button type="submit">
          <i class="glyphicon glyphicon-search" aria-hidden="true"></i>
        </button>
      </span>
    </div><!-- end input-group -->
  </div><!-- end form-group -->
  <input type="hidden" name="only_posts" value="posts" />
</form><!-- end Form -->
