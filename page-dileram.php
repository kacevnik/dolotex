<?php
    if (defined( 'FW' )){
        $kdv_phone_header    = fw_get_db_settings_option('kdv_phone_header');
    }
?>
<?php get_header(); ?>
    <section id="dilers">
        <div class="container">
            <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php the_content(); ?>
            </article>
            <?php endwhile; ?>
        </div>
    </section>
<?php get_footer(); ?>