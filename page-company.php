<?php
/*
Template Name: Шаблон страницы О компании
*/
?>
<?php
    if (defined( 'FW' )){
        $kdv_phone_header               = fw_get_db_settings_option('kdv_phone_header');
        $dolotex_company_add_section    = fw_get_db_settings_option('dolotex_company_add_section');

        //print_r($dolotex_company_add_section);
    }
?>
<?php get_header(); ?>
    <section id="product" class="company">
        <div class="container">
            <div class="breadcrumbs bold_500">
                <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' / '); ?>
            </div>
            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="row">
                    <div class="product_item">
                        <div class="content">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="company_form">
                        <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <a  data-fancybox data-src="#call_back_hidden_boss" href="javascript:;" class="btn">Задать вопрос руководителю</a>
                        </div>
                    </div>
                </div>
            </article>
            <?php endwhile; ?>
        </div>
    </section>
    <?php 
        if(defined( 'FW' ) && $dolotex_company_add_section){
        foreach ($dolotex_company_add_section as $dolotex_company_add_section_item) {
    ?>
    <section class="company_add">
        <div class="container">
            <h2 class="bold900"><?php echo $dolotex_company_add_section_item['title']; ?></h2>
            <div class="row">
                <div class="company_add_content">
                    <?php echo $dolotex_company_add_section_item['content']; ?>
                </div>
            </div>
        </div>
    </section>
    <?php } } ?>
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
              
            <div id="call_back_hidden_boss" style="display: none;">
            <div class="form">
              <h3>Укажите номер</h3>
              <p>и я свяжусь с Вам в течении 5 минут</p>
              <div class="form_input">
                <form method="post" action="<?php echo get_template_directory_uri(); ?>/send.php">
                  <input type="hidden" name="form" value="Форма Задать вопрос руководителю">
                  <div class="form_input_icon"><i class="fas fa-mobile-alt"></i></div>
                  <div class="form_input_text"><input type="text" name="phone" placeholder="+380 (__) __ __ ___" required="" autocomplete="off"></div>
                </div><!-- .form_input -->
                <div class="form_btn">
                  <input type="submit" name="submit" value="Отправить" class="btn">
                </div><!-- .form_btn -->
              </form>
            </div>.<!-- form -->
          </div><!-- #call_back_hidden_boss -->

      </section>
       <section>
<?php get_footer(); ?>