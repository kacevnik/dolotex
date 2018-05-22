<?php if (!defined( 'FW' )) die('Forbidden');

$options = array(
    'main' => array(
        'type' => 'box',
        'title' => __('Дополнительные настройки проекта', '{domain}'),
        'options' => array(
            'kdv_client_sqw' => array(
                'type'  => 'text',
                'attr'  => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                'label' => __('Площадь', '{domain}'),
                'desc'  => __('Площадь выполненных работ', '{domain}')
            )
        )
    )
);