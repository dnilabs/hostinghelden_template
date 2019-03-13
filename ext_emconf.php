<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'hostinghelden template',
    'description' => 'hostinghelden template extends bootstrap_package',
    'category' => 'templates',
    'constraints' => [
        'depends' => [
            'bootstrap_package' => '10.0.0-10.99.99'
        ],
        'conflicts' => [
            'css_styled_content' => '*',
            'fluid_styled_content' => '*',
            'themes' => '*',
            'fluidpages' => '*',
            'dyncss' => '*',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'Hostinghelden\\HostingheldenTemplate\\' => 'Classes'
        ],
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'author' => 'Daniel Krahofer',
    'author_email' => 'office@hostinghelden.at',
    'author_company' => 'private',
    'version' => '1.0.0',
];
