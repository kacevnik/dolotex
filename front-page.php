<?php get_header(); ?>
      <section id="main" class="pb_65 pt_55">
        <div class="main_top">
          <div class="container">
            <div class="row">
              <div class="col-md-8">
                <h1><span>Производитель надежных</span><br><span>промышленных полов</span></h1>
                <ul>
                  <li><i class="fas fa-check"></i>Материалы не токсичны, норматив ХХХ</li>
                  <li><i class="fas fa-check"></i>Доставка по РФ, от 3-х дней</li>
                  <li><i class="fas fa-check"></i>Продукция дешевле аналогов на 30-40 %</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="main_bottom">
          <div class="container">
            <div class="row">
              <div class="col-sm-7 col-md-4">
                <div class="main_bottom_text">
                  Всего за 5 минут мы поможем Вам подобрать лучшее покрытие
                </div>
              </div>
              <div class="col-sm-5 col-md-3">
                <div class="main_bottom_btn">
                  <a href="" class="btn">Быстрый расчет</a>
                </div>
              </div>
              <div class="col-md-5">
                <div class="main_bottom_img">
                  <img src="<?php echo get_template_directory_uri(); ?>/img/main_img.png" alt="DOLOTEX">
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="objects" class="pt_90 pb_65">
        <div class="container">
          <h2>Выбор подходящей системы</h2>
          <div class="sub_title">Выберите систему полов</div>
          <div class="row">
            <?php
                $args_category_list = array(
                    'type'         => 'post',
                    'child_of'     => 0,
                    'parent'       => '',
                    'orderby'      => 'ID',
                    'order'        => 'ASC',
                    'hide_empty'   => 0,
                    'hierarchical' => 1,
                    'exclude'      => '',
                    'include'      => '',
                    'number'       => 0,
                    'taxonomy'     => 'cat_sistem',
                    'pad_counts'   => false,
                );

                $category_sistem_list = get_categories( $args_category_list );

            ?>
            <?php  
                foreach ($category_sistem_list as $category_sistem_list_item) { 

                if (defined( 'FW' )){
                    $kdv_category_sistem_icon = fw_get_db_term_option($category_sistem_list_item->term_id, 'cat_sistem', 'kdv_category_sistem_icon');
                }
            ?>
            <div class="sistem_wraper">
              <a href="#object_check" class="obj_item" data-tab="<?php echo $category_sistem_list_item->term_id; ?>">
                <div class="obj_item_img">
                  <img src="<?php echo $kdv_category_sistem_icon['url']; ?>" alt="<?php echo $category_sistem_list_item->name; ?>">
                </div>
                <div class="obj_item_title"><?php echo $category_sistem_list_item->name; ?></div>
                <i class="far fa-check-circle"></i>
              </a>
            </div>
            <?php } ?>
          </div>
        </div>
      </section>
      <section id="object_check" class="pt_90 pb_65">
        <div class="container">
            <?php
                global $post;
                $count_category_sistem = 1;
                foreach ($category_sistem_list as $category_sistem_list_item) { 
            ?>
          <div id="tab_object_check_<?php echo $category_sistem_list_item->term_id; ?>" class="object_check_tab"<?php if($count_category_sistem == 1){echo ' style="display: block;"'; } ?>>
            <?php

                $id_taxonomy = $category_sistem_list_item->term_id;

                $wp_query_sistem = get_posts(array(
                  'post_type' => 'sistem',
                  'posts_per_page' => -1,
                  'tax_query' => array(
                        array(
                            'taxonomy' => 'cat_sistem',
                            'field'    => 'term_id',
                            'terms'    => $id_taxonomy
                        )
                    ),

                ));


                //print_r($wp_query_sistem);

                $count_posts_sistem_item = 1;
                foreach ($wp_query_sistem as $posts_sistem_item) {
            ?>
            <div class="obj_check_item<?php echo ($count_posts_sistem_item & 1) ? ' odd' : ' even' ?>">
              <a class="obj_check_item_img" href="<?php echo get_the_permalink($posts_sistem_item->ID); ?>">
                <?php echo get_the_post_thumbnail( $posts_sistem_item->ID, 'project-thumb' ); ?>
              </a>
              <div class="obj_check_item_content">
                <h5><?php echo $posts_sistem_item->post_title; ?></h5>
                <p>
                  <?php echo wp_trim_words($posts_sistem_item->post_content, 20, '...');; ?>
                </p>
                <?php
                    if (defined( 'FW' )){
                        $kdv_sistem_aq = fw_get_db_post_option($posts_sistem_item->ID, 'kdv_sistem_aq');
                    }
                ?>
                <span><i class="fas fa-arrows-alt-v"></i><?php echo $kdv_sistem_aq; ?></span>
                <div class="obj_check_item_btn">
                  <a href="<?php echo get_the_permalink($posts_sistem_item->ID); ?>" class="btn">
                    <i class="fas fa-file-alt"></i>
                    Расчет стоимости
                  </a>
                </div><!-- .obj_check_item_btn -->
              </div><!-- .obj_check_item_content -->
            </div>
            <?php $count_posts_sistem_item++; } ?>
          </div>
          <?php $count_category_sistem++; } ?>
        </div>
      </section>
      <section id="sale" class="bonus pt_55 pb_65">
        <div class="container">
          <h2><span>Большие объемы? Большие скидки!</span></h2>
          <div class="sub_title"><span>При покупке от 1000 м2</span></div>
          <div class="row">
            <div class="col-md-6 col-md-offset-1">
              <div class="sale_text">
                <ul>
                  <li><i class="fas fa-gift"></i>Ценный подарок для заказчика</li>
                  <li><i class="fas fa-shipping-fast"></i>Доставка на 10% дешевле</li>
                  <li><i class="fas fa-cog"></i>Шеф монтаж</li>
                </ul>
              </div>
            </div>
            <div class="col-md-4">
            <div class="form">
                <h3>Заполните форму</h3>
                <p>и узнайте сколько составит ваша экономия!</p>
                <div class="form_input">
                    <form method="post" action="<?php echo get_template_directory_uri(); ?>/send.php">
                      <div class="form_input_icon"><i class="fas fa-mobile-alt"></i></div>
                      <input type="hidden" name="form" value="Большие объемы? Большие скидки!">
                      <div class="form_input_text"><input type="text" name="phone" placeholder="+380 (__) __ __ ___" required="" autocomplete="off"></div>
                    </div>
                    <div class="form_input">
                      <div class="form_input_icon"><i class="far fa-envelope"></i></div>
                      <div class="form_input_text"><input type="text" name="email" placeholder="Ваша почта" required="" autocomplete="off"></div>
                    </div>
                    <div class="form_btn">
                      <input type="submit" name="submit" value="Оставить заявку" class="btn">
                    </div>
                    </form>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section id="clients" class="pb_90 pt_90">
        <div class="container">
          <h2>Наши клиенты</h2>
          <div class="row">
            <?php
                $args_posts_clients = array(
                    'post_type' => 'client',
                    'posts_per_page' => 6
                );

                $posts_clients = query_posts($args_posts_clients);
                //print_r($posts_clients);
                foreach ($posts_clients as $posts_clients_item) {
            ?>
            <div class="col-md-4 col-sm-6">
              <a class="clients_item" href="<?php echo get_permalink($posts_clients_item->ID); ?>">
                <div class="clients_item_img">
                    <?php echo get_the_post_thumbnail( $posts_clients_item->ID, 'client-thumb' ); ?>
                </div>
                <div class="clients_item_content">
                  <h6><?php echo $posts_clients_item->post_title; ?></h6>
                    <?php
                        if (defined( 'FW' )){
                            $kdv_client_sqw = fw_get_db_post_option($posts_clients_item->ID, 'kdv_client_sqw');
                        }
                    ?>
                  <p><i class="fas fa-arrows-alt-v"></i><?php echo $kdv_client_sqw; ?></p>
                </div>
              </a>
            </div>
            <?php } ?>
          </div>
        </div>
      </section>
      <section id="client_slider" class="pb_90 pt_90">
        <div class="container">
        <h2>И еще более 100 клиентов</h2>
        <div class="client_slider_content">
          <div class="client_slider owl-carousel">
            <div><img src="<?php echo get_template_directory_uri(); ?>/img/contact_logo_1.png" alt=""></div>
            <div><img src="<?php echo get_template_directory_uri(); ?>/img/contact_logo_2.png" alt=""></div>
            <div><img src="<?php echo get_template_directory_uri(); ?>/img/contact_logo_1.png" alt=""></div>
            <div><img src="<?php echo get_template_directory_uri(); ?>/img/contact_logo_3.png" alt=""></div>
            <div><img src="<?php echo get_template_directory_uri(); ?>/img/contact_logo_4.png" alt=""></div>
          </div>
        </div>
        </div>
      </section>
      <section id="com_slider" class="pb_90 pt_90">
        <div class="container">
          <h2>Отзывы и благодарственные письма</h2>
            <div class="com_slider_container">
              <div class="owl-carousel com_slider">
                <?php
                    $args_posts_otziv = array(
                        'post_type' => 'otziv',
                        'posts_per_page' => -1
                    );

                    $posts_otziv = query_posts($args_posts_otziv);
                    //print_r($posts_otziv);
                    foreach ($posts_otziv as $posts_otziv_item) {
                    if (defined( 'FW' )){
                        $kdv_otziv_image   = fw_get_db_post_option($posts_otziv_item->ID, 'kdv_otziv_image');
                        $kdv_otziv_comment = fw_get_db_post_option($posts_otziv_item->ID, 'kdv_otziv_comment');
                    }
                ?>
                <div class="com_slider_item">
                  <div class="com_slider_item_img"><img src="<?php echo $kdv_otziv_image['url']; ?>" alt="<?php echo $posts_otziv_item->post_title; ?>"></div>
                  <div class="com_slider_item_text">
                    <h6><?php echo $posts_otziv_item->post_title; ?></h6>
                    <p>
                        <?php echo $posts_otziv_item->post_content; ?>
                    </p>
                    <i><?php echo $kdv_otziv_comment; ?></i>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
        </div>
      </section>
      <section id="bonus" class="bonus pt_90 pb_65">
        <div class="container">
          <h2><span>Большие объемы? Большие скидки!</span></h2>
          <div class="row">
            <div class="col-md-6 col-md-offset-1">
              <div class="sale_text">
                <p>
                  При покупке материалов для промышленного от 1000 м2, мы возвращаем на бонусную карту 1% от заказа
                </p>
                <p>
                  <span>
                    Вы можете дополнительно приобрести продукцию, или забрать деньги наличными
                  </span>
                </p>
              </div>
            </div>
            <div class="col-md-4">
                <form action="<?php echo get_template_directory_uri(); ?>/send.php" method="post">
                    <div class="form">
                        <h3>Заполните форму</h3>
                        <p>и узнайте сколько составит ваша экономия!</p>
                        <div class="form_input">
                          <div class="form_input_icon"><i class="fas fa-mobile-alt"></i></div>
                          <div class="form_input_text"><input type="text" name="phone" placeholder="+380 (__) __ __ ___" required="" autocomplete="off"></div>
                        </div>
                        <div class="form_input">
                          <div class="form_input_icon"><i class="far fa-envelope"></i></div>
                          <input type="hidden" name="form" value="Форма - получить скидку">
                          <div class="form_input_text"><input type="text" name="email" placeholder="Ваша почта" required="" autocomplete="off"></div>
                        </div>
                        <div class="form_btn">
                          <input type="submit" name="submit" class="btn">
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </section>
<?php get_footer(); ?>