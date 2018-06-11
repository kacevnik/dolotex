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
        'title' => __('Дополнительные настройки проекта', '{domain}'),
        'options' => array(
            'kdv_sistem_aq' => array(
                'type'  => 'text',
                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                'label' => __('Площадь', '{domain}'),
                'desc'  => __('Площадь выполненных работ', '{domain}')
            ),

            'dolotex_sistem_promo' => array(
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
                'label' => __('Расчет', '{domain}'),
                'desc'  => __('', '{domain}'),
                'help'  => __('Загрузите расчет для скачивания (разрешенные файлы для загрузки: pdf, exel, doc)', '{domain}'),
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

            'kdv_sistem_more' => array(
                'type' => 'popup',
                'label' => __('Товары', '{domain}'),
                'desc'  => __('Добавьте товары для блока - Используемые материалы', '{domain}'),
                'template' => '{{- name }}',
                'popup-title' => 'Используемые материалы',
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
            )
        )
    )
);