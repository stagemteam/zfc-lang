<?php

namespace Stagem\ZfcLang;

return [

    'dependencies' => [
        'aliases' => [
            'translator' => \Zend\I18n\Translator\TranslatorInterface::class,
        ],
    ],

    'templates' =>  [
        'paths' => [
            'admin-lang'  => [__DIR__ . '/../view/admin/lang'],
        ],
    ],

    'view_helpers' => [
        'aliases' => [
            'lang' => View\Helper\LangHelper::class,
        ],
    ],

    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Model']
            ],
            'orm_default' => [
                'class' => \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                'drivers' => [
                    __NAMESPACE__ . '\Model' => __NAMESPACE__ . '_driver'
                ]
            ]
        ],
    ],

];
