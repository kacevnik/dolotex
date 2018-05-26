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
        <form method="post" action="<?php echo get_template_directory_uri(); ?>/send.php">
          <input type="hidden" name="form" value="Форма заказа обратного звонка">
          <div class="form_input_icon"><i class="fas fa-mobile-alt"></i></div>
          <div class="form_input_text"><input type="text" name="phone" placeholder="+380 (__) __ __ ___" required="" autocomplete="off"></div>
        </div>
        <div class="form_btn">
          <input type="submit" name="submit" value="Отправить" class="btn">
        </div>
      </form>
    </div>
  </div>

    <div id="call_back_hidden_product">
      <form method="post" action="<?php echo get_template_directory_uri(); ?>/send.php">
        <div class="form">
          <h3>Укажите номер</h3>
          <p>и наш специалист перезвонит Вам в тесении 5 минут</p>
          <div class="form_input">
            <div class="form_input_icon"><i class="fas fa-mobile-alt"></i></div>
            <input type="hidden" name="name_product">
            <input type="hidden" name="form" value="Форма заказа товара: ">
            <div class="form_input_text"><input type="text" name="phone" placeholder="+380 (__) __ __ ___" required="" autocomplete="off"></div>
          </div>
          <div class="form_btn">
            <input type="submit" name="submit" class="btn">
          </div>
        </div>
      </form>
    </div>

  <a id="thanks_link" style="display: none;" data-fancybox data-src="#thanks_popup" href="javascript:;">Спасибо</a>

  <div id="thanks_popup">
    <h3 class="bold_700">Спасибо</h3>
    <p class="bold_100">Через несколько минут с Вами свяжется наш специалист!</p>
  </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <?php wp_footer(); ?>
    </body>
</html>