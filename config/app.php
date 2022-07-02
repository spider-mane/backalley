<?php

use function Leonidas\Plugin\plugin_header;

return [

    'name' => plugin_header('name'),

    'slug' => plugin_header('textdomain'),

    'version' => plugin_header('version'),

    'description' => plugin_header('description'),

    'namespace' => 'leonidas',

    'prefix' => 'leon',

    'dev' => defined('LEONIDAS_DEVELOPMENT'),

    'modules' => [

        Leonidas\Plugin\Module\AdminAssets::class,

    ],

    'providers' => [

        # Framework
        Leonidas\Framework\Provider\League\AdminNoticeRepositoryServiceProvider::class,
        Leonidas\Framework\Provider\League\AutoInvokerServiceProvider::class,
        Leonidas\Framework\Provider\League\GuzzleServerRequestServiceProvider::class,
        Leonidas\Framework\Provider\League\TransientsChannelServiceProvider::class,
        Leonidas\Framework\Provider\League\TwigViewServiceProvider::class,

        # Plugin

    ],

    'bootstrap' => [

        Leonidas\Framework\Bootstrap\BindContainerToFacades::class,
        Leonidas\Framework\Bootstrap\RegisterModelServices::class,

    ],

    'facade' => Leonidas\Library\Access\_Facade::class,
];
