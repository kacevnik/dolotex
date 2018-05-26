<?php if (!defined( 'FW' )) die('Forbidden');

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
        'taxonomy'     => 'cat_tovar',
        'pad_counts'   => false,
    );

    $res_category_list =  array();
    $res_category_data =  array();

    $category_list = get_categories( $args_category_list );

    foreach ($category_list as $category_listt_item) {
        $res_category_list[$category_listt_item->term_id] = $category_listt_item->name;
            $args_post = array(
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'cat_tovar',
                            'field' => 'ID',
                            'terms' => $category_listt_item->term_id
                        )
                    ),
                    'post_type' => 'tovar',
                    'posts_per_page' => -1
                );

        $posts = query_posts( $args_post );

        foreach ($posts as $posts_item) {
            $res_category_data[$category_listt_item->term_id][$posts_item->ID] = array('type'  => 'checkbox', 'label' => $posts_item->post_title);
        }
    }

$options = array(
    'main' => array(
        'type' => 'box',
        'title' => __('Дополнительные настройки товара', '{domain}'),
        'options' => array(
            'kdv_tovar_price' => array(
                'type'  => 'text',
                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                'label' => __('Цена', '{domain}'),
                'desc'  => __('Укажите цену товара', '{domain}')
            ),

            'kdv_tovar_box' => array(
                'type'  => 'text',
                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                'label' => __('Упаковка', '{domain}'),
                'desc'  => __('Укажите упаковку', '{domain}')
            ),

            'kdv_tovar_tu' => array(
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
                'label' => __('ТУ продукта', '{domain}'),
                'desc'  => __('', '{domain}'),
                'help'  => __('Загрузите ТУ для продукта (разрешенные файлы для загрузки: pdf)', '{domain}'),
                /**
                 * If set to `true`, the option will allow to upload only images, and display a thumb of the selected one.
                 * If set to `false`, the option will allow to upload any file from the media library.
                 */
                'images_only' => true,
                /**
                 * An array with allowed files extensions what will filter the media library and the upload files.
                 */
                'files_ext' => array( 'pdf' ),
                /**
                 * An array with extra mime types that is not in the default array with mime types from the javascript Plupload library.
                 * The format is: array( '<mime-type>, <ext1> <ext2> <ext2>' ).
                 * For example: you set rar format to filter, but the filter ignore it , than you must set
                 * the array with the next structure array( '.rar, rar' ) and it will solve the problem.
                 */
                'extra_mime_types' => array( 'audio/x-aiff, aif aiff' )
            ),

            'kdv_slider_tovar' => array(
                'type' => 'addable-popup',
                'label' => __('Слайдер', '{domain}'),
                'desc'  => __('Добавьте картинки для слайдера в карточке товара', '{domain}'),
                'template' => '{{- name }}',
                'popup-title' => null,
                'size' => 'small', // small, medium, large
                'limit' => 0, // limit the number of popup`s that can be added
                'add-button-text' => __('Добавить', '{domain}'),
                'sortable' => true,
                'popup-options' => array(
                    'name' => array(
                        'label' => __('Название', '{domain}'),
                        'type' => 'text',
                        'desc' => __('название картинки(необязательно).', '{domain}'),
                    ),

                    'img' => array(
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
                        'label' => __('Картика', '{domain}'),
                        'desc'  => __('', '{domain}'),
                        'help'  => __('Загрузите изображение слайда (разрешенные файлы для загрузки: jpg, png, gif)', '{domain}'),
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
                    )
                )
            ),

            'kdv_tabs_tovar' => array(
                'type' => 'addable-popup',
                'label' => __('Вкладки', '{domain}'),
                'desc'  => __('Добавьте вкладки для карточки товара(tabs)', '{domain}'),
                'template' => '{{- name }}',
                'popup-title' => null,
                'size' => 'large', // small, medium, large
                'limit' => 0, // limit the number of popup`s that can be added
                'add-button-text' => __('Добавить вкладку', '{domain}'),
                'sortable' => true,
                'popup-options' => array(
                    'name' => array(
                        'label' => __('Заголовок', '{domain}'),
                        'type' => 'text',
                        'desc' => __('Заголовок вкладки.', '{domain}'),
                    ),

                    'content' => array(
                        'type'  => 'wp-editor',
                        'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                        'label' => __('Контент', '{domain}'),
                        'desc'  => __('Содержимое вкладки(контент)', '{domain}'),
                        'size' => 'large', // small, large
                        'editor_height' => 300,
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

                    )
                )
            ),

            'kdv_tovar_more' => array(
                'type' => 'popup',
                'label' => __('Аналоги', '{domain}'),
                'desc'  => __('Добавьте товары для блока - С этим товаром покупают', '{domain}'),
                'template' => '{{- name }}',
                'popup-title' => 'С этим товаром покупают',
                'button' => __('Добавить товары', '{domain}'),
                'size' => 'large', // small, medium, large
                'limit' => 0, // limit the number of popup`s that can be added
                'add-button-text' => __('Добавить товар', '{domain}'),
                'sortable' => true,
                'popup-options' => array(
                    'content' => array(
                        'type'  => 'multi-picker',
                        'label' => false,
                        'desc'  => false,
                        'value' => array(),
                        'picker' => array(
                            // '<custom-key>' => option
                            'category' => array(
                                'label'   => __('Категории товаров', '{domain}'),
                                'type'    => 'select', // or 'short-select'
                                'choices' => $res_category_list,
                                'desc'    => __('Выбирите категорию товаров', '{domain}'),
                            )
                        ),
                            /*
                            'picker' => array(
                                // '<custom-key>' => option
                                'gadget' => array(
                                    'label'   => __('Choose device', '{domain}'),
                                    'type'    => 'radio',
                                    'choices' => array(
                                        'phone'  => __('Phone', '{domain}'),
                                        'laptop' => __('Laptop', '{domain}')
                                    ),
                                    'desc'    => __('Description', '{domain}'),
                                    'help'    => __('Help tip', '{domain}'),
                                )
                            ),
                            */
                            /*
                            'picker' => array(
                                // '<custom-key>' => option
                                'gadget' => array(
                                    'label'   => __('Choose device', '{domain}'),
                                    'type'    => 'image-picker',
                                    'choices' => array(
                                        'phone'  => 'http://placekitten.com/70/70',
                                        'laptop' => 'http://placekitten.com/71/70'
                                    ),
                                    'desc'    => __('Description', '{domain}'),
                                    'help'    => __('Help tip', '{domain}'),
                                )
                            ),
                            */
                            /*
                            picker => array(
                                // '<custom-key>' => option
                                'gadget' => array(
                                    'label' => __('Choose device', '{domain}'),
                                    'type'  => 'switch',
                                    'right-choice' => array(
                                        'value' => 'laptop',
                                        'label' => __('Laptop', '{domain}')
                                    ),
                                    'left-choice' => array(
                                        'value' => 'phone',
                                        'label' => __('Phone', '{domain}')
                                    ),
                                    'desc' => __('Description', '{domain}'),
                                    'help' => __('Help tip', '{domain}'),
                                )
                            ),
                            */
                        'choices' => $res_category_data,
                        /**
                         * (optional) if is true, the borders between choice options will be shown
                         */
                        'show_borders' => false,
                    )
                )
            ),

            'kdv_tovar_title_video' => array(
                'type'  => 'text',
                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                'label' => __('Заголовок видео', '{domain}'),
                'desc'  => __('Укажите заголовок для блока видео', '{domain}')
            ),            

            'kdv_tovar_url_video' => array(
                'type'  => 'text',
                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                'label' => __('URL видео', '{domain}'),
                'desc'  => __('Укажите URL видео на YouTube', '{domain}')
            ),
        )
    )
);