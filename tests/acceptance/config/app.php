<?php

use Leonidas\Library\Core\Models\Taxonomy\OptionHandlers\MaintainMetaboxHierarchy;

return [
    'data_managers' => [],

    'option_handlers' => [
        'post_type' => [],

        'taxonomy' => [
            'maintain_mb_hierarchy' => MaintainMetaboxHierarchy::class,
        ],
    ]
];
