<?php
    if (defined( 'FW' )){
        $kdv_phone_header    = fw_get_db_settings_option('kdv_phone_header');
    }
?>
<?php get_header(); ?>
          <section id="dilers">
        <div class="container">
            <?php the_content(); ?>
        </div>
      </section>
<?php get_footer(); ?>