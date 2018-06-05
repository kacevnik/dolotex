<?php 
    get_header();
    if (defined( 'FW' )){
        $kdv_count_tovar_on_page = fw_get_db_settings_option('kdv_count_tovar_on_page');
        $kdv_phone_header        = fw_get_db_settings_option('kdv_phone_header');
    }
    $taxonomy= get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

    $count_tovar = 1;
    $count_tovar_hide = 1;
    $hide_tovar_class = ' show_row';
    $args_posts_tovar = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'cat_tovar',
                'field' => 'slug',
                'terms' => $taxonomy->slug
            )
        ),
        'post_type' => 'tovar',
        'posts_per_page' => -1
    );

    $posts_tovar = query_posts($args_posts_tovar);

    $arg_post_sistem = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'cat_sistem',
                'field' => 'slug',
                'terms' => $taxonomy->slug
            )
        ),
        'post_type' => 'sistem',
        'posts_per_page' => -1
    );

    $posts_sistem = query_posts($arg_post_sistem);

    //echo count($posts_tovar);
    //print_r($posts_sistem);

    if($taxonomy->taxonomy == 'cat_tovar'){
?>
      <section id="catalog">
        <div class="container">
          <div class="breadcrumbs bold_500">
            <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' / '); ?>
            </div>
          <h1><?php echo $taxonomy->name; ?></h1>
            <?php if(count($posts_tovar) > 0){ foreach($posts_tovar as $posts_tovar_item){ ?>
            <?php if($count_tovar_hide > $kdv_count_tovar_on_page){$hide_tovar_class = ' hide_row'; $data_humber = ' data-number="' . $count_tovar_hide . '"';} $count_tovar_hide++?>
            <?php if($count_tovar == 1){echo '<div class="row' . $hide_tovar_class . '"' . $data_humber . '>'; } $count_tovar++; ?>
                    <div class="col-md-3 col-sm-6">
                      <div class="catalog_item" id="post-<?php echo $posts_tovar_item->ID; ?>">
                        <div class="catalog_item_img">
                            <a href="<?php echo get_permalink($posts_tovar_item->ID); ?>">
                                <?php echo get_the_post_thumbnail($posts_tovar_item->ID, 'project-thumb'); ?>
                            </a>
                        </div>
                        <?php 
                            if (defined( 'FW' )){
                                $kdv_tovar_price = fw_get_db_post_option($posts_tovar_item->ID, 'kdv_tovar_price');
                                $kdv_tovar_box = fw_get_db_post_option($posts_tovar_item->ID, 'kdv_tovar_box');
                            }
                        ?>
                        <h3><a href="<?php echo get_permalink($posts_tovar_item->ID); ?>" data-name-product="<?php echo $posts_tovar_item->post_title; ?>"><?php echo $posts_tovar_item->post_title; ?></a></h3>
                        <div class="catalog_item_content">
                          <div class="catalog_item_price"><?php echo $kdv_tovar_price; ?></div>
                          <p><?php echo $kdv_tovar_box; ?></p>
                          <a class="catalog_item_cart" data-fancybox data-src="#call_back_hidden_product" href="javascript:;">
                            <i class="fas fa-shopping-cart"></i>
                          </a>
                        </div>
                      </div>
                    </div>
            <?php if($count_tovar == 5 || count($posts_tovar) == $count_tovar_hide - 1){echo '</div>'; $count_tovar = 1;}?>
            <?php } ?>
            <?php }else{ echo '<h2>Товаров нет</h2>'; } ?>
            <?php if(count($posts_tovar) > $kdv_count_tovar_on_page){ ?>
          <div class="more_product_catalog">
            <a href="" class="btn more" data-show-row="<?php echo $kdv_count_tovar_on_page*2; ?>" data-count-tovar="<?php echo $kdv_count_tovar_on_page; ?>"><i class="fas fa-sync-alt"></i>Ещё <span><?php echo count($posts_tovar) - $kdv_count_tovar_on_page; ?></span> товаров</a>
          </div>
          <?php } ?>
        </div>
      </section>
      <section id="catalog_download" class="pt_90 pb_90">
        <div class="div container">
          <h2>Скачать прайс-лист</h2>
          <div class="form form_pdf">
            <form method="post" action="<?php echo get_template_directory_uri(); ?>/send.php">
            <div class="row">
              <div class="col-md-4">
                <div class="form_input">
                  <div class="form_input_icon"><i class="fas fa-mobile-alt"></i></div>
                  <div class="form_input_text"><input type="text" name="phone" placeholder="+380 (__) __ __ ___" required="" autocomplete="off"></div>
                  <input type="hidden" name="form" value="Скачать Прайс-Лист">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form_input">
                  <div class="form_input_icon"><i class="far fa-envelope"></i></div>
                  <div class="form_input_text"><input type="text" name="email" placeholder="Ваша почта" required=""></div>
                </div>
              </div>
              <div class="col-md-4 form_btn">
                <button class="btn" id="douwload_price"><i class="fas fa-file-alt"></i>Скачать прайс-лист</button>
              </div>
            </div>
            </form>
          </div>
          <div class="row article_phone_text">
            <div class="col-md-8 pnone_text">
              Или задайте вопрос эксперту по телефону:
            </div>
            <div class="col-md-4">
              <div class="number_phone">
                <i class="fas fa-phone"></i><?php echo $kdv_phone_header; ?>
              </div>
              <div class="phone">
                Звонок БЕСПЛАТНЫЙ
              </div>
            </div>
          </div>
        </div>
      </section>
<?php
    }else if($taxonomy->taxonomy == 'cat_sistem'){ ?>
    <section id="catalog">
        <div class="container">
          <div class="breadcrumbs bold_500">
            <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' / '); ?>
            </div>
          <h1><?php echo $taxonomy->name; ?></h1>
            <?php if(count($posts_sistem) > 0){ foreach($posts_sistem as $posts_tovar_item){ ?>
            <?php if($count_tovar_hide > $kdv_count_tovar_on_page){$hide_tovar_class = ' hide_row'; $data_humber = ' data-number="' . $count_tovar_hide . '"';} $count_tovar_hide++?>
            <?php if($count_tovar == 1){echo '<div class="row' . $hide_tovar_class . '"' . $data_humber . '>'; } $count_tovar++; ?>
                    <div class="col-md-4 col-sm-6">
                      <div class="catalog_item item_sistem" id="post-<?php echo $posts_tovar_item->ID; ?>">
                        <div class="catalog_item_img">
                            <a href="<?php echo get_permalink($posts_tovar_item->ID); ?>">
                                <?php echo get_the_post_thumbnail($posts_tovar_item->ID, 'project-thumb'); ?>
                            </a>
                        </div>
                        <?php 
                            if (defined( 'FW' )){
                                $kdv_tovar_price = fw_get_db_post_option($posts_tovar_item->ID, 'kdv_tovar_price');
                                $kdv_tovar_box = fw_get_db_post_option($posts_tovar_item->ID, 'kdv_tovar_box');
                            }
                        ?>
                        <h3><a href="<?php echo get_permalink($posts_tovar_item->ID); ?>" data-name-product="<?php echo $posts_tovar_item->post_title; ?>"><?php echo $posts_tovar_item->post_title; ?></a></h3>
                        <div class="catalog_item_content">
                          <p><?php echo $kdv_tovar_box; ?></p>
                          <a class="btn" href="<?php echo get_permalink($posts_tovar_item->ID); ?>">Сделать расчет</a>
                        </div>
                      </div>
                    </div>
            <?php if($count_tovar == 5 || count($posts_sistem) == $count_tovar_hide - 1){echo '</div>'; $count_tovar = 1;}?>
            <?php } ?>
            <?php }else{ echo '<h2>Товаров нет</h2>'; } ?>
            <?php if(count($posts_sistem) > $kdv_count_tovar_on_page){ ?>
          <div class="more_product_catalog">
            <a href="" class="btn more" data-show-row="<?php echo $kdv_count_tovar_on_page*2; ?>" data-count-tovar="<?php echo $kdv_count_tovar_on_page; ?>"><i class="fas fa-sync-alt"></i>Ещё <span><?php echo count($posts_sistem) - $kdv_count_tovar_on_page; ?></span> товаров</a>
          </div>
          <?php } ?>
        </div>
      </section>
      <section id="catalog_download" class="pt_90 pb_90">
        <div class="div container">
          <h2>Скачать прайс-лист</h2>
          <div class="form form_pdf">
            <form method="post" action="<?php echo get_template_directory_uri(); ?>/send.php">
            <div class="row">
              <div class="col-md-4">
                <div class="form_input">
                  <div class="form_input_icon"><i class="fas fa-mobile-alt"></i></div>
                  <div class="form_input_text"><input type="text" name="phone" placeholder="+380 (__) __ __ ___" required="" autocomplete="off"></div>
                  <input type="hidden" name="form" value="Скачать Прайс-Лист">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form_input">
                  <div class="form_input_icon"><i class="far fa-envelope"></i></div>
                  <div class="form_input_text"><input type="text" name="email" placeholder="Ваша почта" required=""></div>
                </div>
              </div>
              <div class="col-md-4 form_btn">
                <button class="btn" id="douwload_price"><i class="fas fa-file-alt"></i>Скачать прайс-лист</button>
              </div>
            </div>
            </form>
          </div>
          <div class="row article_phone_text">
            <div class="col-md-8 pnone_text">
              Или задайте вопрос эксперту по телефону:
            </div>
            <div class="col-md-4">
              <div class="number_phone">
                <i class="fas fa-phone"></i><?php echo $kdv_phone_header; ?>
              </div>
              <div class="phone">
                Звонок БЕСПЛАТНЫЙ
              </div>
            </div>
          </div>
        </div>
      </section>

    <?php }else{ ?>
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