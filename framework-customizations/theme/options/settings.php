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

        'kdv_contacts' => array(
            'type' => 'tab',
            'options' => array(
                'kdv_map_text' => array(
                    'type'  => 'html',
                    'label' => __('Внимание!', '{domain}'),
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'html'  => '<em>Для использования настроек страницы контакты следует создать "Страницу", и указать для нее шаблон "Шаблон страницы контакты". Только в этом случае применятся настройки для данной страницы.</em><br><em>Для вывода информации справа от карты используйте визуальный редактор контента на созданной странице Контакты.</em>',
                ),

                'kdv_map_center' => array(
                    'value' => '[54.930181, 83.129441]',
                    'type'  => 'text',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Центр карты', '{domain}'),
                    'help' => __('Задайте координаты центра карты через запятую в квадратных скобках(например: [54.930181, 83.129441])', '{domain}')
                ),

                'kdv_map_marker' => array(
                    'value' => '[54.930181, 83.129441]',
                    'type'  => 'text',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Точка', '{domain}'),
                    'help' => __('Задайте координаты точки на карте через запятую в квадратных скобках(например: [54.930181, 83.129441])', '{domain}')
                ),

                'kdv_map_zoom' => array(
                    'value' => '16',
                    'type'  => 'text',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Зум', '{domain}'),
                    'help' => __('Задайте зум-приближение карты', '{domain}')
                ),

                'kdv_map_height' => array(
                    'value' => '350',
                    'type'  => 'text',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Высота', '{domain}'),
                    'help' => __('Задайте высоту карты. Можно подогнать в зависимости от высоты контента справа. Задается в пикселях, в поле указывается число (по умолчанию 350px).', '{domain}')
                ),

                'kdv_map_img_marker' => array(
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
                    'label' => __('Логотип на карте', '{domain}'),
                    'desc'  => __('', '{domain}'),
                    'help'  => __('Задайте логотип компании для карты (разрешенные файлы для загрузки: jpg, png, gif)', '{domain}'),
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

                'kdv_map_marker_size' => array(
                    'value' => '102, 22',
                    'type'  => 'text',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Размеры лого', '{domain}'),
                    'help' => __('Задайте через запятую ширину и высоту логотипа для маркера накарте (пример: 102, 22)', '{domain}')
                ),

                'kdv_cargo_on' => array(
                    'type'  => 'switch',
                    'value' => 'yes',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Доставка', '{domain}'),
                    'desc'  => __('Включить блок Доставка на странице Контакты', '{domain}'),
                    'left-choice' => array(
                        'value' => 'yes',
                        'label' => __('Да', '{domain}'),
                    ),
                    'right-choice' => array(
                        'value' => 'no',
                        'label' => __('Нет', '{domain}'),
                    ),
                ),

                'kdv_cargo_title' => array(
                    'value' => 'Доставка',
                    'type'  => 'text',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Заголовок Доставки', '{domain}'),
                    'help' => __('Задайте заголовок для блока Доставка', '{domain}')
                ),

                'kdv_cargo_text' =>array(
                    'type'  => 'wp-editor',
                    'value' => '',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Текст', '{domain}'),
                    'desc'  => __('Задайте текст для блока Доставка. Отображается слева от картинки', '{domain}'),
                    'size' => 'large', // small, large
                    'editor_height' => 400,
                    'wpautop' => true,
                    'editor_type' => false, // tinymce, html

                    /**
                     * By default, you don't have any shortcodes into the editor.
                     *
                     * You have two possible values:
                     *   - false:   You will not have a shortcodes button at all
                     *   - true:    the default values you provide in wp-shortcodes
                     *              extension filter will be used
                     *
                     *   - An array of shortcodes
                     */
                    'shortcodes' => false // true, array('button', map')

                    /**
                     * Also available
                     * https://github.com/WordPress/WordPress/blob/4.4.2/wp-includes/class-wp-editor.php#L80-L94
                     */
                ),

                'kdv_contact_info_on' => array(
                    'type'  => 'switch',
                    'value' => 'yes',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Реквизиты', '{domain}'),
                    'desc'  => __('Включить блок Реквизиты на странице Контакты', '{domain}'),
                    'left-choice' => array(
                        'value' => 'yes',
                        'label' => __('Да', '{domain}'),
                    ),
                    'right-choice' => array(
                        'value' => 'no',
                        'label' => __('Нет', '{domain}'),
                    ),
                ),

                'kdv_contact_info_title' => array(
                    'value' => 'Реквизиты',
                    'type'  => 'text',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Заголовок Доставки', '{domain}'),
                    'help' => __('Задайте заголовок для блока Реквизиты', '{domain}')
                ),

                'kdv_contact_info_text' =>array(
                    'type'  => 'wp-editor',
                    'value' => '',
                    'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'label' => __('Текст', '{domain}'),
                    'desc'  => __('Задайте текст для блока Реквизиты.', '{domain}'),
                    'size' => 'large', // small, large
                    'editor_height' => 400,
                    'wpautop' => true,
                    'editor_type' => false, // tinymce, html

                    /**
                     * By default, you don't have any shortcodes into the editor.
                     *
                     * You have two possible values:
                     *   - false:   You will not have a shortcodes button at all
                     *   - true:    the default values you provide in wp-shortcodes
                     *              extension filter will be used
                     *
                     *   - An array of shortcodes
                     */
                    'shortcodes' => false // true, array('button', map')

                    /**
                     * Also available
                     * https://github.com/WordPress/WordPress/blob/4.4.2/wp-includes/class-wp-editor.php#L80-L94
                     */
                ),
            ),
            'title' => __('Контакты', '{domain}'),
            'attr' => array('class' => 'custom-class', 'data-foo' => 'bar'),
        )
    );

?>