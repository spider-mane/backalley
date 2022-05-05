<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use WP_Post;
use WebTheory\Saveyour\Contracts\Field\Selection\SelectionProviderInterface;

abstract class AbstractPostSelectionProvider implements SelectionProviderInterface
{
    /**
     * @param WP_Post $post
     */
    public function defineSelectionValue($post): string
    {
        return (string) $post->ID;
    }
}
