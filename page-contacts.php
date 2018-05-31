<?php
/*
Template Name: Шаблон страницы Контакты
*/
?>
<?php
    if (defined( 'FW' )){
        $kdv_phone_header        = fw_get_db_settings_option('kdv_phone_header');
        $kdv_map_center          = fw_get_db_settings_option('kdv_map_center');
        $kdv_map_marker          = fw_get_db_settings_option('kdv_map_marker');
        $kdv_map_zoom            = fw_get_db_settings_option('kdv_map_zoom');
        $kdv_map_height          = fw_get_db_settings_option('kdv_map_height');
        $kdv_map_img_marker      = fw_get_db_settings_option('kdv_map_img_marker');
        $kdv_map_marker_size     = fw_get_db_settings_option('kdv_map_marker_size');
        $kdv_cargo_on            = fw_get_db_settings_option('kdv_cargo_on');
        $kdv_cargo_title         = fw_get_db_settings_option('kdv_cargo_title');
        $kdv_cargo_text          = fw_get_db_settings_option('kdv_cargo_text');
        $kdv_contact_info_on     = fw_get_db_settings_option('kdv_contact_info_on');
        $kdv_contact_info_title  = fw_get_db_settings_option('kdv_contact_info_title');
        $kdv_contact_info_text   = fw_get_db_settings_option('kdv_contact_info_text');
        $kdv_phone_header        = fw_get_db_settings_option('kdv_phone_header');
    }else{
        $kdv_map_height          = 350;
        $kdv_map_marker_size     = '102, 22';
        $kdv_phone_header        = '8 800 350 50 50';
    }
?>
<?php get_header(); ?>

    <section id="contacts_map">
        <div class="container">
            <div class="breadcrumbs bold_500">
                <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' / '); ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
                    <script type="text/javascript">
                        ymaps.ready(init);
         
                        function init () {
                            var myMap = new ymaps.Map("map", {
                                // Центр карты, указываем коордианты
                                center:<?php echo $kdv_map_center; ?>,
                                // Масштаб, тут все просто
                                zoom: <?php echo $kdv_map_zoom; ?>,
                            }); 
                                     
                            var myGeoObjects = [];
                             
                            // Наша метка, указываем коордианты
                            myGeoObjects = new ymaps.Placemark(<?php echo $kdv_map_marker; ?>,{
                                            balloonContentBody: 'Текст в балуне',
                                            },{
                                            iconLayout: 'default#image',
                                            // Путь до нашей картинки
                                            iconImageHref: '<?php echo $kdv_map_img_marker['url']; ?>', 
                                            // Размер по ширине и высоте
                                            iconImageSize: [<?php echo $kdv_map_marker_size; ?>],
                                            // Смещение левого верхнего угла иконки относительно
                                            // её «ножки» (точки привязки).
                                            iconImageOffset: [-35, -35]
                            });
                                         
                            var clusterer = new ymaps.Clusterer({
                                clusterDisableClickZoom: false,
                                clusterOpenBalloonOnClick: false,
                            });
                             
                            clusterer.add(myGeoObjects);
                            myMap.geoObjects.add(clusterer);
                         
                        }
                    </script>
                    <div id="map" style="height: <?php echo $kdv_map_height; ?>px;">
                    </div>
                </div>
                <div class="col-md-6">
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
    </section>
    <section id="contacts_answ">
        <div class="container">
            <h2 class="bold_900">Узнать наличие продукции</h2>
            <div class="sub_title">
                на ближайшем к Вам складе
            </div>
            <div class="row">
                <form action="<?php echo get_template_directory_uri(); ?>/send.php" method="post">
                    <div class="form">
                        <div class="col-md-4">
                            <div class="form_input">
                                <div class="form_input_icon"><i class="fas fa-user"></i></div>
                                <div class="form_input_text"><input type="text" name="email" placeholder="Ваше имя" required="" autocomplete="off"></div>
                                <input type="hidden" name="form" value="Узнать наличие продукции">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form_input">
                                <div class="form_input_icon"><i class="fas fa-mobile-alt"></i></div>
                                <div class="form_input_text"><input type="text" name="phone" placeholder="+380 (__) __ __ ___" required="" autocomplete="off"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input class="btn" name="submit" type="submit" value="Узнать наличие">
                        </div>
                    </div>
                </form>
            </div>
            <p>Наш менеджер свяжется с Вами в течении 15 минут и скажет, где Вы сможете забрать продукцию</p>
        </div>
    </section>
    <?php if($kdv_cargo_on == 'yes'){ ?>
    <section id="cargo">
        <div class="container">
            <h2 class="bold_900"><?php echo $kdv_cargo_title; ?></h2>
            <div class="row">
                <div class="col-md-7">
                    <?php echo $kdv_cargo_text; ?>
                </div>
            </div>
            <div class="container cargo_img">
                <img src="<?php echo get_template_directory_uri(); ?>/img/cargo.png" alt="Доставка">
            </div>
        </div>
    </section>
    <?php } ?>
    <?php if($kdv_contact_info_on == 'yes'){ ?>
    <section id="contact_info">
        <div class="container">
            <?php if($kdv_contact_info_title){ ?>
            <h2 class="bold_900"><?php echo $kdv_contact_info_title; ?></h2>
            <?php } ?>
            <?php echo $kdv_contact_info_text; ?>
        </div>
    </section>
    <?php } ?>
    <section id="product_answ" class="pt_55 pb_65">
        <div class="container">
            <h2>Остались вопросы?</h2>
            <form method="post" action="<?php echo get_template_directory_uri(); ?>/send.php">
                <div class="form">
                    <div class="row">
                        <h3>Мы свяжемся с Вами в течении 15 минут</h3>
                        <div class="col-md-3">
                            <div class="form_input">
                                <div class="form_input_icon"><i class="fas fa-user"></i></div>
                                <div class="form_input_text"><input type="text" name="email" placeholder="Ваше имя" required="" autocomplete="off"></div>
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
                                <input type="hidden" name="form" value="Форма - Остались вопросы на странице Контакты">
                                <div class="form_input_text"><input type="text" name="phone" placeholder="+380 (__) __ __ ___" required="" autocomplete="off"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="submit" class="btn" name="submit" value="Задать вопрос">
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
        </div>
    </section>
<?php get_footer(); ?>