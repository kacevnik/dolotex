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
      <div class="form">
        <h3>Укажите номер</h3>
        <p>и наш специалист перезвонит Вам в тесении 5 минут</p>
        <div class="form_input">
          <div class="form_input_icon"><i class="fas fa-mobile-alt"></i></div>
          <div class="form_input_text"><input type="text" name="phone" placeholder="+380 (__) __ __ ___" required=""></div>
        </div>
        <div class="form_btn">
          <a href="#" class="btn">Отправить</a>
        </div>
      </div>
  </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <?php wp_footer(); ?>
    </body>
</html>