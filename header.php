<?php
    if (defined( 'FW' )){
        $kdv_phone_header = fw_get_db_settings_option('kdv_phone_header');
        $kdv_phone_header2 = fw_get_db_settings_option('kdv_phone_header2');
        $kdv_logo_header = fw_get_db_settings_option('kdv_logo');
    }
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <title><?php wp_title('/'); ?></title>
    <link rel="alternate" type="application/rdf+xml" title="RDF mapping" href="<?php bloginfo('rdf_url'); ?>">
    <link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss_url'); ?>">
    <link rel="alternate" type="application/rss+xml" title="Comments RSS" href="<?php bloginfo('comments_rss2_url'); ?>">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <?php wp_head(); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body <?php body_class(); ?>>
    <header>
        <div class="header_top">
          <a class="hamburger_wraper" href="#mmenu">
            <div class="hamburger hamburger--spin">
              <div class="hamburger-box">
                <div class="hamburger-inner"></div>
              </div>
            </div>
          </a>
          <div class="container">
            <div class="row">
                <?php
                $args = array('theme_location' => 'top', 'container'=> 'nav', 'menu_class' => 'main_menu', 'menu_id' => 'bottom-nav');
                wp_nav_menu($args);
                ?>
            </div>
          </div>
        </div>
        <div class="header_bottom">
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <div class="logo">
                  <a href="<?php echo home_url(); ?>">
                    <img src="<?php echo $kdv_logo_header['url']; ?>" alt="<?php bloginfo( 'name' ); ?>">
                  </a>
                  <span><?php bloginfo( 'description' ); ?></span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="phone">
                  <div class="phone_number"><?php echo $kdv_phone_header; ?></div>
                  <div class="phone_text"><?php echo $kdv_phone_header2; ?></div>
                </div>
                <div class="call_back"><a data-fancybox data-src="#call_back_hidden" href="javascript:;" class="btn">Заказать звонок</a></div>
              </div>
            </div>
          </div>
        </div>
      </header>