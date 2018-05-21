    <?php
        if (defined( 'FW' )){
            $kdv_call_back_form = fw_get_db_settings_option('kdv_call_back_form');
        }
    ?>

    <footer>
        <div class="container">
          <div class="col-md-3 col-sm-6 footer_cil">
            <?php dynamic_sidebar('footer_1'); ?>
          </div>
          <div class="col-md-3 col-sm-6 footer_cil">
            <?php dynamic_sidebar('footer_2'); ?>
          </div>
          <div class="col-md-3 col-sm-6 footer_cil">
            <?php dynamic_sidebar('footer_3'); ?>
          </div>
          <div class="col-md-3 col-sm-6 footer_cil">
            <?php dynamic_sidebar('footer_4'); ?>
          </div>
        </div>
      </footer>
    </div>
    <?php
        $args = array('theme_location' => 'top', 'container'=> 'nav', 'menu_class' => '', 'menu_id' => '', 'container_id' => 'mmenu');
        wp_nav_menu($args);
    ?>

  <div id="call_back_hidden">
    <?php echo do_shortcode($kdv_call_back_form); ?>
  </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <?php wp_footer(); ?>
    </body>
</html>