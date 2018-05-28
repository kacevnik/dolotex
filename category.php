<?php get_header(); print_r($wp_query->query['page']); ?>
    <section id="category">
        <div class="container">
            <div class="breadcrumbs bold_500">
                <?php if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' / '); ?>
            </div>
            <h1 class="bold700"><?php single_cat_title(); // название категории ?></h1>
            <div class="row">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="col-md-4 col-sm-6 item_post">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail( 'post-thumb' ); ?>
                            <div class="item_post_info"><i class="far fa-calendar-alt"></i> <?php the_time('d.m.Y'); ?></div>
                        </a>
                        <a href="<?php the_permalink(); ?>" class="item_post_title bold500"><?php the_title(); ?></a>
                        <div class="item_post_title_content bold300">
                            <?php  global $more; $more = 0; echo wp_trim_words(get_the_content(), 20, '...'); ?>
                        </div>
                    </article>
                </div>
                <?php endwhile; 
                else: echo '<h2>Нет записей Категория.</h2>'; endif;  ?>
                <div class="pogin">
                    <?php pagination($wp_query->query['page']); ?>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>