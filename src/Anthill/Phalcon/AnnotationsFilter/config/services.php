<?php
return array(
    'annotations' => array(
        'className' => \Phalcon\Annotations\Adapter\Memory::class,
        'shared' => true
    ),
    'filter' => array(
        'className' => \Phalcon\Filter::class,
    ),
    'filter.service' => array(
        'className' => \Anthill\Phalcon\AnnotationsFilter\Filters\AnnotationFilterManager::class,
        'arguments' => array(
            array('type' => 'service', 'name' => 'annotations'),
            array('type' => 'service', 'name' => 'filter'),
        )
    )
);