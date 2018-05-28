<?php
    if (defined( 'FW' )){
        $kdv_phone_header    = fw_get_db_settings_option('kdv_phone_header');
    }
?>
<?php get_header(); ?>
    <section id="product">
        <div class="container">
            <div class="breadcrumbs bold_500">
                <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' / '); ?>
            </div>
            <h1><?php the_title(); ?></h1>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="product_item">
                    <div class="content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </article>
        </div>
    </section>
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