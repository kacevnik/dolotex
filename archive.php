<?php 
    get_header();

    if (defined( 'FW' )){
        $kdv_count_tovar_on_page = fw_get_db_settings_option('kdv_count_tovar_on_page');
    }

    $taxonomy= get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
    //print_r($taxonomy);
    $count_tovar = 1;
    $count_tovar_hide = 1;
    $hide_tovar_class = ' show_row';
    if($taxonomy->taxonomy == 'cat_tovar'){
?>
      <section id="catalog">
        <div class="container">
          <div class="breadcrumbs bold_500">
            <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' / '); ?>
            </div>
          <h1><?php echo $taxonomy->name; ?></h1>
            <?php if (have_posts()) : while (have_posts()) : the_post(); // если посты есть - запускаем цикл wp ?>
            <?php if($count_tovar_hide > $kdv_count_tovar_on_page){$hide_tovar_class = ' hide_row'; $data_humber = ' data-number="' . $count_tovar_hide . '"';} $count_tovar_hide++?>
            <?php if($count_tovar == 1){echo '<div class="row' . $hide_tovar_class . '"' . $data_humber . '>'; } $count_tovar++; ?>
                <?php get_template_part('loop_tovar'); // для отображения каждой записи берем шаблон loop.php ?>
            <?php if($count_tovar == 5 || $taxonomy->count == $count_tovar_hide - 1){echo '</div>'; $count_tovar = 1;}?>
            <?php endwhile; // конец цикла ?>
            <?php else: echo '<h2>Товаров нет</h2>'; endif; // если записей нет, напишим "простите" ?>
            <?php if($taxonomy->count > $kdv_count_tovar_on_page){ ?>
          <div class="more_product_catalog">
            <a href="" class="btn more" data-show-row="<?php echo $kdv_count_tovar_on_page*2; ?>" data-count-tovar="<?php echo $kdv_count_tovar_on_page; ?>"><i class="fas fa-sync-alt"></i>Ещё <span><?php echo $taxonomy->count - $kdv_count_tovar_on_page; ?></span> товаров</a>
          </div>
          <?php } ?>
        </div>
      </section>
      <section id="catalog_download" class="pt_90 pb_90">
        <div class="div container">
          <h2>Скачать прайс-лист</h2>
          <div class="form">
            <div class="row">
              <div class="col-md-4">
                <div class="form_input">
                  <div class="form_input_icon"><i class="fas fa-mobile-alt"></i></div>
                  <div class="form_input_text"><input type="text" name="phone" placeholder="+380 (__) __ __ ___" required=""></div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form_input">
                  <div class="form_input_icon"><i class="far fa-envelope"></i></div>
                  <div class="form_input_text"><input type="text" name="email" placeholder="Ваша почта" required=""></div>
                </div>
              </div>
              <div class="col-md-4 form_btn">
                <a href="#" class="btn"><i class="fas fa-file-alt"></i>Скачать прайс-лист</a>
              </div>
            </div>
          </div>
          <div class="row article_phone_text">
            <div class="col-md-8 pnone_text">
              Или задайте вопрос эксперту по телефону:
            </div>
            <div class="col-md-4">
              <div class="number_phone">
                <i class="fas fa-phone"></i>8 800 800 80 80
              </div>
              <div class="phone">
                Звонок БЕСПЛАТНЫЙ
              </div>
            </div>
          </div>
        </div>
      </section>
    <div id="call_back_hidden_product">
          <div class="form">
            <h3>Укажите номер</h3>
            <p>и наш специалист перезвонит Вам в тесении 5 минут</p>
            <div class="form_input">
              <div class="form_input_icon"><i class="fas fa-mobile-alt"></i></div>
              <input type="hidden" name="name_product">
              <div class="form_input_text"><input type="text" name="phone" placeholder="+380 (__) __ __ ___" required=""></div>
            </div>
            <div class="form_btn">
              <a href="#" class="btn">Отправить</a>
            </div>
          </div>
      </div>
<?php
    }else{
?>
<section>
    <h1><?php // заголовок архивов
                if (is_day()) : printf('Daily Archives: %s', get_the_date()); // если по дням
                elseif (is_month()) : printf('Monthly Archives: %s', get_the_date('F Y')); // если по месяцам
                elseif (is_year()) : printf('Yearly Archives: %s', get_the_date('Y')); // если по годам
                else : 'Archives';
        endif; ?></h1>
    <?php if (have_posts()) : while (have_posts()) : the_post(); // если посты есть - запускаем цикл wp ?>
        <?php get_template_part('loop'); // для отображения каждой записи берем шаблон loop.php ?>
    <?php endwhile; // конец цикла
    else: echo '<h2>Товаров нет</h2>'; endif; // если записей нет, напишим "простите" ?>
    <?php pagination(); // пагинация, функция нах-ся в function.php ?>
</section>
<?php }get_footer(); ?>