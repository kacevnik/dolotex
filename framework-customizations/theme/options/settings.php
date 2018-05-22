<?php

    if (!defined('FW')) die('Forbidden');

    $args_category_list = array(
        'type'         => 'post',
        'child_of'     => 0,
        'parent'       => '',
        'orderby'      => 'name',
        'order'        => 'ASC',
        'hide_empty'   => 1,
        'hierarchical' => 1,
        'exclude'      => '',
        'include'      => '',
        'number'       => 0,
        'taxonomy'     => 'category',
        'pad_counts'   => false,
    );

    $res_category_list =  array();

    $category_list = get_categories( $args_category_list );

    foreach ($category_list as $category_listt_item) {
        $res_category_list[$category_listt_item->term_id] = $category_listt_item->name;
    }

    $args = array(
        'numberposts' => -1,
        'category'    => 0,
        'orderby'     => 'date',
        'order'       => 'DESC',
        'include'     => array(),
        'exclude'     => array(),
        'meta_key'    => '',
        'meta_value'  =>'',
        'post_type'   => 'wpcf7_contact_form',
        'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
    );

    $posts = get_posts( $args );

    foreach ($posts as $posts_item) {
        $posts_cf_7['[contact-form-7 id="'.$posts_item->ID.'" title="'.$posts_item->post_title.'"]'] = $posts_item->post_title;
    }

//настройки для страницы настроек темы
    $options = array(
        'kdv_tap_general_opions' => array(
            'type' => 'tab',
            'options' => array(
                'kdv_phone_header' => array(
                    'type'  => 'text',
                    'value' => '8 (800) 350 50 50',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Номер телефона в хедере', '{domain}'),
                    'desc'  => __('Пример: 8 800 350 50 50', '{domain}'),
                    'help'  => __('Укажите номер телефона для связи в верхней части сайта', '{domain}'),
                ),

                'kdv_phone_header2' => array(
                    'type'  => 'text',
                    'value' => 'Бесплатный звонок по России',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Текст под телефоном', '{domain}'),
                    'help'  => __('Укажите пояснительный текст под телефоном', '{domain}'),
                ),

                'kdv_logo' => array(
                    'type'  => 'upload',
                    'value' => array(
                        /*
                        'attachment_id' => '9',
                        'url' => '//site.com/wp-content/uploads/2014/02/whatever.jpg'
                        */
                        // if value is set in code, it is not considered and not used
                        // because there is no sense to set hardcode attachment_id
                    ),
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Логотип', '{domain}'),
                    'desc'  => __('', '{domain}'),
                    'help'  => __('Загрузите логотип сайта (разрешенные файлы для загрузки: jpg, png, gif)', '{domain}'),
                    /**
                     * If set to `true`, the option will allow to upload only images, and display a thumb of the selected one.
                     * If set to `false`, the option will allow to upload any file from the media library.
                     */
                    'images_only' => true,
                    /**
                     * An array with allowed files extensions what will filter the media library and the upload files.
                     */
                    'files_ext' => array( 'jpg', 'png', 'gif' ),
                    /**
                     * An array with extra mime types that is not in the default array with mime types from the javascript Plupload library.
                     * The format is: array( '<mime-type>, <ext1> <ext2> <ext2>' ).
                     * For example: you set rar format to filter, but the filter ignore it , than you must set
                     * the array with the next structure array( '.rar, rar' ) and it will solve the problem.
                     */
                    'extra_mime_types' => array( 'audio/x-aiff, aif aiff' )
                ),

                'kdv_call_back_form' => array(
                    'type'  => 'select',
                    'value' => 'choice-3',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Форма обратного звонка', '{domain}'),
                    'desc'  => __('Выбирите форму обратного звонка', '{domain}'),
                    'help'  => __('Выбирите форму обратного звонка плагина Contact Form 7', '{domain}'),
                    'choices' => $posts_cf_7,
                    /**
                     * Allow save not existing choices
                     * Useful when you use the select to populate it dynamically from js
                     */
                    'no-validate' => false,
                ),

                'kdv_big_sale_form' => array(
                    'type'  => 'select',
                    'value' => 'choice-3',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Форма №2', '{domain}'),
                    'desc'  => __('Выбирите форму для блока Большие скидки', '{domain}'),
                    'help'  => __('Выбирите форму для блока Большие скидки плагина Contact Form 7', '{domain}'),
                    'choices' => $posts_cf_7,
                    /**
                     * Allow save not existing choices
                     * Useful when you use the select to populate it dynamically from js
                     */
                    'no-validate' => false,
                )
            ),
            'title' => __('Настройки главной', '{domain}'),
            'attr' => array('class' => 'custom-class', 'data-foo' => 'bar'),
        ),
        'kdv_tap_gallary_post_new' => array(
            'type' => 'tab',
            'options' => array(
                'kdv_gallery_off'  => array(
                    'type'  => 'switch',
                    'value' => true, // checked/unchecked
                    'label' => __('Включть галерею', '{domain}'),
                    'desc'  => __('', '{domain}'),
                    'help'  => __('Если включить, то галерея будет отражаться на главной странице', '{domain}')
                ),

                'kdv_gallery_background' => array(
                    'type'  => 'upload',
                    'value' => array(
                        /*
                        'attachment_id' => '9',
                        'url' => '//site.com/wp-content/uploads/2014/02/whatever.jpg'
                        */
                        // if value is set in code, it is not considered and not used
                        // because there is no sense to set hardcode attachment_id
                    ),
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Фон секции', '{domain}'),
                    'desc'  => __('', '{domain}'),
                    'help'  => __('Загрузите задний фон для секции галереи (разрешенные файлы для загрузки: jpg, png, gif), требуемые размеры ВхШ (850Х1920)', '{domain}'),
                    /**
                     * If set to `true`, the option will allow to upload only images, and display a thumb of the selected one.
                     * If set to `false`, the option will allow to upload any file from the media library.
                     */
                    'images_only' => true,
                    /**
                     * An array with allowed files extensions what will filter the media library and the upload files.
                     */
                    'files_ext' => array( 'jpg', 'png', 'gif' ),
                    /**
                     * An array with extra mime types that is not in the default array with mime types from the javascript Plupload library.
                     * The format is: array( '<mime-type>, <ext1> <ext2> <ext2>' ).
                     * For example: you set rar format to filter, but the filter ignore it , than you must set
                     * the array with the next structure array( '.rar, rar' ) and it will solve the problem.
                     */
                    'extra_mime_types' => array( 'audio/x-aiff, aif aiff' )
                ),

                'kdv_gallery_category' => array(
                    'type'  => 'select',
                    'value' => 'choice-3',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Рубрика', '{domain}'),
                    'desc'  => __('', '{domain}'),
                    'help'  => __('Выберите рубрику, посты каторой будут показываться.', '{domain}'),
                    'choices' => $res_category_list,
                    'no-validate' => false,
                ),

                'kdv_gallery_count_items' => array(
                    'type'  => 'text',
                    'value' => '7',
                    'label' => __('Максимальное количество слайдов', '{domain}'),
                    'desc'  => __('', '{domain}'),
                    'help'  => __('Задайте максимальное количество слайдов для галереи.', '{domain}'),
                ),

                'kdv_gallery_speed' => array(
                    'type'  => 'text',
                    'value' => '500',
                    'label' => __('Скорость анимации переходов', '{domain}'),
                    'desc'  => __('', '{domain}'),
                    'help'  => __('Задайте скорость анимации переходов для галереи при ручном перелистывании. (указать в милисекундах)', '{domain}'),
                )

            ),
            'title' => __('Галерея постов', '{domain}'),
            'attr' => array('class' => 'custom-class', 'data-foo' => 'bar'),
        ),
    );

?>