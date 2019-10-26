<?php

use Respect\Validation\Validator as v;
use WebTheory\GuctilityBelt\SelectOptions\UsStatesAndTerritories;
use WebTheory\Leonidas\Forms\Controllers\TermFieldFormSubmissionManager;
use WebTheory\Leonidas\Leonidas;
use WebTheory\Leonidas\PostType\Factory as PostTypeFactory;
use WebTheory\Leonidas\Screen;
use WebTheory\Leonidas\Taxonomy\Factory as TaxonomyFactory;
use WebTheory\Leonidas\Term\Field as TermField;
use WebTheory\Leonidas\WpMaster;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

#ErrorHandling
(new Run)->prependHandler(new PrettyPageHandler)->register(); // error handling with whoops

/**
 * init
 */
Leonidas::init();

add_action('init', function () {

    /**
     * admin modifiers
     */
    WpMaster::clearDashboard();
    WpMaster::setPostsAsBlog();

    $app = require 'config/app.php';
    $postTypeHandlers = $app['option_handlers']['post_type'];
    $taxonomyHandlers = $app['option_handlers']['taxonomy'];

    $postTypes = require 'config/post_types.php';
    $taxonomies = require 'config/taxonomies.php';

    $postTypes = (new PostTypeFactory($postTypeHandlers))->create($postTypes);
    $taxonomies = (new TaxonomyFactory($taxonomyHandlers))->create($taxonomies);

    require 'admin-page.php';
});

/**
 *
 */
Screen::load(['edit-tags', 'term'], ['taxonomy' => 'ba_menu_category'], function () {

    $app = require 'config/app.php';
    $dataManagers = $app['data_managers'];

    $taxonomy = 'ba_menu_category';

    $controller = Leonidas::createField([
        'post_var' => 'test-1',
        'type' => [
            '@create' => 'select',
            'options' => UsStatesAndTerritories::states(),
            'label' => 'Test Label',
            'classlist' => ['regular-text'],
        ],
        'data' => [
            '@create' => 'term_meta',
            'meta_key' => 'test_data',
        ],
        // 'rules' => [
        //     'thing' => [
        //         'check' => Validator::optional(Validator::phone()),
        //         'alert' => 'wrong thing'
        //     ]
        // ]
    ]);

    $formManager = (new TermFieldFormSubmissionManager($taxonomy))
        ->addField($controller)
        ->hook();

    $field = (new TermField($taxonomy, $controller))
        ->setLabel('Test Field')
        ->setDescription('This is a test term field description')
        ->hook();
}, 'add-tag');

/**
 *
 */
Screen::load('post', ['post_type' => 'ba_location'], function () {
    include 'fields.php';
});

/**
 *
 */
Screen::load('post', ['post_type' => 'ba_menu_item'], function () {
    return;
});


/**
 *
 */
// SkyHooks::collect();
// SkyHooks::dump();