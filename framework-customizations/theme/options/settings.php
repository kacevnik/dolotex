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

                'kdv_count_tovar_on_page' => array(
                    'type'  => 'text',
                    'value' => '8',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Сколько товаров?', '{domain}'),
                    'desc'  => __('Укажите количество товаров, каторое следует показывать на странице', '{domain}'),
                ),

                'kdv_price' => array(
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
                    'label' => __('Прайс-лист', '{domain}'),
                    'desc'  => __('', '{domain}'),
                    'help'  => __('Загрузите прайс-лист (разрешенные файлы для загрузки: pdf, exel, doc)', '{domain}'),
                    /**
                     * If set to `true`, the option will allow to upload only images, and display a thumb of the selected one.
                     * If set to `false`, the option will allow to upload any file from the media library.
                     */
                    'images_only' => true,
                    /**
                     * An array with allowed files extensions what will filter the media library and the upload files.
                     */
                    'files_ext' => array( 'pdf', 'exel', 'doc' ),
                    /**
                     * An array with extra mime types that is not in the default array with mime types from the javascript Plupload library.
                     * The format is: array( '<mime-type>, <ext1> <ext2> <ext2>' ).
                     * For example: you set rar format to filter, but the filter ignore it , than you must set
                     * the array with the next structure array( '.rar, rar' ) and it will solve the problem.
                     */
                    'extra_mime_types' => array( 'audio/x-aiff, aif aiff' )
                )
            ),
            'title' => __('Настройки главной', '{domain}'),
            'attr' => array('class' => 'custom-class', 'data-foo' => 'bar'),
        ),

        'kdv_on_line' => array(
            'type' => 'tab',
            'options' => array(
                'kdv_on_line_name' => array(
                    'type'  => 'text',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Имя', '{domain}'),
                    'desc'  => __('Укажите имя On-line менеджера', '{domain}')
                ),

                'kdv_on_line_dolg' => array(
                    'type'  => 'text',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Должность', '{domain}'),
                    'desc'  => __('Укажите должность On-line менеджера', '{domain}')
                ),

                'kdv_on_line_img' => array(
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
                    'label' => __('Фото', '{domain}'),
                    'desc'  => __('', '{domain}'),
                    'help'  => __('Загрузите фото менеджера (разрешенные файлы для загрузки: jpg, png, gif)', '{domain}'),
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

                'kdv_on_line_text' => array(
                    'type'  => 'textarea',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Текст', '{domain}'),
                    'desc'  => __('Добавьте пояснительный текст', '{domain}'),
                )
            ),
            'title' => __('Онлайн менеджер', '{domain}'),
            'attr' => array('class' => 'custom-class', 'data-foo' => 'bar'),
        ),
    );

?>