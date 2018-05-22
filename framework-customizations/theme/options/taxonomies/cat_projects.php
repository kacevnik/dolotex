<?php if (!defined( 'FW' )) die('Forbidden');

$options = array(
    'kdv_category_project_icon' => array(
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
        'label' => __('Иконка', '{domain}'),
        'desc'  => __('', '{domain}'),
        'help'  => __('Загрузите иконку категории (разрешенные файлы для загрузки: jpg, png, gif)', '{domain}'),
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
);