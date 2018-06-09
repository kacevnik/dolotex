<?php
    if (defined( 'FW' )){
        $kdv_tovar_price        = fw_get_db_post_option(get_the_ID(), 'kdv_tovar_price');
        $kdv_tovar_box          = fw_get_db_post_option(get_the_ID(), 'kdv_tovar_box');
        $kdv_tovar_tu           = fw_get_db_post_option(get_the_ID(), 'kdv_tovar_tu');
        $kdv_slider_tovar       = fw_get_db_post_option(get_the_ID(), 'kdv_slider_tovar');
        $kdv_tabs_tovar         = fw_get_db_post_option(get_the_ID(), 'kdv_tabs_tovar');
        $kdv_tovar_more         = fw_get_db_post_option(get_the_ID(), 'kdv_tovar_more');
        $kdv_tovar_title_video  = fw_get_db_post_option(get_the_ID(), 'kdv_tovar_title_video');
        $kdv_tovar_url_video    = fw_get_db_post_option(get_the_ID(), 'kdv_tovar_url_video');
        $dolotex_sistem_promo   = fw_get_db_post_option(get_the_ID(), 'dolotex_sistem_promo');

        $kdv_on_line_name       = fw_get_db_settings_option('kdv_on_line_name');
        $kdv_on_line_dolg       = fw_get_db_settings_option('kdv_on_line_dolg');
        $kdv_on_line_img        = fw_get_db_settings_option('kdv_on_line_img');
        $kdv_on_line_text       = fw_get_db_settings_option('kdv_on_line_text');
        $kdv_phone_header       = fw_get_db_settings_option('kdv_phone_header');


        $arr_kdv_tovar_more     = array();

        function f_array($arr){
            global $arr_kdv_tovar_more;
            foreach($arr as $key => $value){
                if (is_array($value)){
                    f_array($value);
                }else{
                    if($value == 1){
                        $arr_kdv_tovar_more[] = $key;
                    }
                }
            }
        }

        f_array($kdv_tovar_more);

    }

?>
<?php get_header(); ?>
    <section id="product">
        <div class="container">
            <?php if($post->post_type == 'tovar'){ ?>
            <div class="breadcrumbs bold_500">
                <span><a href="<?php echo get_home_url(); ?>">Главная</a></span> / <span><?php echo get_the_term_list( $post->ID, 'cat_tovar', '', ',', '' ); ?></span> / <span class="kb_title"><?php echo $post->post_title; ?></span>
            </div>
            <?php }else{ ?>
            <div class="breadcrumbs bold_500">
                <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' / '); ?>
            </div>
            <?php } ?>
            <h1><?php the_title(); ?></h1>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if($post->post_type == 'tovar'){ ?>
                <div class="product_item">
                    <div class="row">
                        <div class="col-md-4">
                        <?php if($kdv_slider_tovar){ $count_kdv_slider_tovar = 0; $count_finish_slider_tovar = 0; ?>
                            <div class="product_galary">
                            <?php foreach($kdv_slider_tovar as $kdv_slider_tovar_item){ $count_kdv_slider_tovar++; $count_finish_slider_tovar++;?>
                            <?php if($count_kdv_slider_tovar == 2){  ?>
                                <div class="row">
                                <?php } ?>
                                <a class="item_product_galary_<?php if($count_kdv_slider_tovar == 1){echo 'first'; }else{echo 'more'; } ?>" href="<?php echo $kdv_slider_tovar_item['img']['url'] ?>" data-fancybox="images">
                                    <img src="<?php echo $kdv_slider_tovar_item['img']['url'] ?>" alt="<?php echo $kdv_slider_tovar_item['name'] ?>">
                                </a>
                                <?php if($count_kdv_slider_tovar == 4 || count($kdv_slider_tovar) == $count_finish_slider_tovar ){echo '</div>'; $count_kdv_slider_tovar = 1;} ?>
                                <?php } ?>
                                </div>
                            <?php } ?>
                            </div>
                            <div class="col-md-5">
                                <div class="content">
                                <?php echo $post->post_content; ?>
                                <?php if($kdv_tovar_tu['url']){ ?>
                                    <a href="<?php echo $kdv_tovar_tu['url']; ?>" class="download_tu bold500"><i class="fas fa-file-alt"></i>Скачать ТУ</a>
                                <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                            <?php if($kdv_tovar_price || $kdv_tovar_box){ ?>
                                <div class="product_price">
                                    <div class="product_price_count bold_700"><?php echo $kdv_tovar_price; ?></div>
                                    <div class="product_price_tara"><?php echo $kdv_tovar_box; ?></div>
                                    <a href="" class="btn"><i class="fas fa-shopping-cart"></i>Заказать</a>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php if($kdv_tabs_tovar){ $count_kdv_tovar_tabs = 1; ?>
                    <div class="product_tabs_wrap">
                        <div class="row">
                            <div class="col-md-5">
                                <ul class="product_tabs">
                                    <?php foreach($kdv_tabs_tovar as $kdv_tabs_tovar_item){ ?>
                                    <li><a href="" class="bold_500" product-data-tab="<?php echo $count_kdv_tovar_tabs; ?>"><?php echo $kdv_tabs_tovar_item['name']; ?></a></li>
                                    <?php $count_kdv_tovar_tabs++; } ?>
                                </ul>
                            </div>
                        <div class="col-md-7">
                        <?php $count_kdv_tovar_tabs = 1; foreach($kdv_tabs_tovar as $kdv_tabs_tovar_item){ ?>
                            <div class="product_tab_content" id="product_tab_<?php echo $count_kdv_tovar_tabs; ?>"<?php if($count_kdv_tovar_tabs == 1){ ?> style="display: block;"<?php } ?>>
                        <?php echo $kdv_tabs_tovar_item['content']; ?>
                        </div>
                    <?php $count_kdv_tovar_tabs++; } ?>
                    </div>
                </div>
                </div>
                <?php } ?>
                <?php
                    if($arr_kdv_tovar_more){
                    $more_post = query_posts(array( 'post_type' => 'tovar', 'post__in' => $arr_kdv_tovar_more ));
                ?>
                <div class="product_more_slider">
                    <h2>С этим товаром покупают</h2>
                    <div class="product_more_slider_wrap owl-carousel">
                        <?php 
                            foreach ($more_post as $more_post_item) {
                                if (defined( 'FW' )){
                                    $kdv_tovar_price = fw_get_db_post_option($more_post_item->ID, 'kdv_tovar_price');
                                    $kdv_tovar_box = fw_get_db_post_option($more_post_item->ID, 'kdv_tovar_box');
                                }
                        ?>
                        <div class="catalog_item">
                            <div class="catalog_item_img">
                                <a href="<?php echo get_permalink($more_post_item->ID); ?>">
                                    <?php echo get_the_post_thumbnail( $more_post_item->ID, 'tovar-thumb' ); ?>
                                </a>
                            </div>
                            <h3><a href="<?php echo get_permalink($more_post_item->ID); ?>" data-name-product="Наливной пол"><?php echo $more_post_item->post_title; ?></a></h3>
                            <div class="catalog_item_content">
                                <div class="catalog_item_price"><?php echo $kdv_tovar_price; ?></div>
                                <p><?php echo $kdv_tovar_box; ?></p>
                                <a class="catalog_item_cart" data-fancybox data-src="#call_back_hidden_product" href="javascript:;">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
              <?php } ?>
            <?php }elseif($post->post_type == 'sistem'){ ?>
                <div class="sistem_product">
                    <div class="product_item">
                        <div class="content">
                            <?php echo $post->post_content; ?>
                        </div>
                    </div>
                    <a href="#form_pdf" class="sistem_product_more"><i class="fas fa-angle-down"></i></a>
                </div>
                <form action="<?php echo get_template_directory_uri(); ?>/send.php" method="post">
                    <div class="form sistem_product_form form_pdf" id="form_pdf">
                        <div class="row">
                            <h3>Скачайте коммерческое предложение</h3>
                            <div class="col-md-4">
                                <div class="form_input">
                                    <div class="form_input_icon"><i class="fas fa-user"></i></div>
                                    <div class="form_input_text"><input type="text" name="name" placeholder="Ваше имя" required="" autocomplete="off"></div>
                                    <input type="hidden" name="form" value="Форма: Скачайте коммерческое предложение ">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form_input">
                                    <div class="form_input_icon"><i class="fas fa-mobile-alt"></i></div>
                                    <input type="hidden" name="name_product" value="<?php the_title(); ?>">
                                    <div class="form_input_text"><input type="text" name="phone" placeholder="+380 (__) __ __ ___" required="" autocomplete="off"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" name="submit" value="Скачать расчет" class="btn" id="download_promo" data-url="<?php echo $dolotex_sistem_promo['url']; ?>">
                            </div>
                        </div>
                    </div>
                </form>
            <?php }else{ ?>
                <div class="product_item">
                    <div class="content">
                        <?php echo $post->post_content; ?>
                    </div>
                </div>
            <?php } ?>
            </article>
        </div>
    </section>
    <?php if($post->post_type == 'sistem'){ ?>
    <section id="sistem_product_list">
        <div class="container">
            <h2>Используемые материалы</h2>
            <div class="row">
                <div class="sistem_product_list_item_wrap">
                    <a href="" class="sistem_product_list_item">
                        <div class="sistem_product_list_img">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/sistem_product_list_item.png" alt="">
                        </div>
                        <div class="sistem_product_list_title">
                            Клей Dolotex GS-9
                        </div>
                    </a>
                </div>
                <div class="sistem_product_list_item_wrap">
                    <a href="" class="sistem_product_list_item">
                        <div class="sistem_product_list_img">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/sistem_product_list_item.png" alt="">
                        </div>
                        <div class="sistem_product_list_title">
                            Клей Dolotex GS-9
                        </div>
                    </a>
                </div>
                <div class="sistem_product_list_item_wrap">
                    <a href="" class="sistem_product_list_item">
                        <div class="sistem_product_list_img">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/sistem_product_list_item.png" alt="">
                        </div>
                        <div class="sistem_product_list_title">
                            Клей Dolotex GS-9
                        </div>
                    </a>
                </div>
                <div class="sistem_product_list_item_wrap">
                    <a href="" class="sistem_product_list_item">
                        <div class="sistem_product_list_img">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/sistem_product_list_item.png" alt="">
                        </div>
                        <div class="sistem_product_list_title">
                            Клей Dolotex GS-9
                            Клей Dolotex GS-9
                        </div>
                    </a>
                </div>
                <div class="sistem_product_list_item_wrap">
                    <a href="" class="sistem_product_list_item">
                        <div class="sistem_product_list_img">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/sistem_product_list_item.png" alt="">
                        </div>
                        <div class="sistem_product_list_title">
                            Клей Dolotex GS-9
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
    <?php if($kdv_tovar_title_video && $kdv_tovar_url_video){ ?>
    <section id="product_video">
        <div class="container">
            <h2><?php echo $kdv_tovar_title_video; ?></h2>
            <div class="row">
                <div class="col-md-8">
                    <a data-fancybox href="<?php echo $kdv_tovar_url_video; ?>" class="product_video">
                        <?php $img_video = explode('?v=', $kdv_tovar_url_video); ?>
                        <img class="card-img-top img-fluid" src="http://img.youtube.com/vi/<?php echo $img_video[1]; ?>/maxresdefault.jpg" />
                        <i class="far fa-play-circle"></i>
                    </a>
                </div>
                <div class="col-md-4">
                    <div class="product_video_content">
                        <h3><?php echo $kdv_on_line_name; ?></h3>
                        <div class="sub_title bold500"><?php echo $kdv_on_line_dolg; ?></div>
                        <img src="<?php echo $kdv_on_line_img['url']; ?>" alt="<?php echo $kdv_on_line_name; ?>">
                        <p><?php echo $kdv_on_line_text; ?></p>
                        <a data-fancybox data-src="#call_back_hidden" href="javascript:;" class="btn">Задать вопрос</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
    <section id="product_answ" class="pt_55 pb_65">
        <div class="container">
            <h2>Остались вопросы?</h2>
            <form action="<?php echo get_template_directory_uri(); ?>/send.php" method="post">
                <div class="form">
                    <div class="row">
                        <h3>Мы свяжемся с Вами в течении 15 минут</h3>
                        <div class="col-md-3">
                            <div class="form_input">
                                <div class="form_input_icon"><i class="fas fa-user"></i></div>
                                <div class="form_input_text"><input type="text" name="name" placeholder="Ваше имя" required="" autocomplete="off"></div>
                                <input type="hidden" name="form" value="Форма: Остались вопросы? ">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form_input">
                                <div class="form_input_icon"><i class="far fa-envelope"></i></div>
                                <div class="form_input_text"><input type="text" name="email" placeholder="Ваша почта" required="" autocomplete="off"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form_input">
                                <div class="form_input_icon"><i class="fas fa-mobile-alt"></i></div>
                                <input type="hidden" name="name_product" value="<?php the_title(); ?>">
                                <div class="form_input_text"><input type="text" name="phone" placeholder="+380 (__) __ __ ___" required="" autocomplete="off"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="submit" name="submit" value="Задать вопрос" class="btn">
                        </div>
                    </div>
                </div>
            </form>
            <div class="row article_phone_text">
                <div class="col-md-8 pnone_text bold300">
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
      </section>
       <section>
<?php get_footer(); ?>