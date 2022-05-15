<?php

namespace Leonidas\Library\Admin\Field\Formatting;

use Leonidas\Library\System\Schema\Post\PostCollection;
use WebTheory\Saveyour\Contracts\Formatting\DataFormatterInterface;
use WP_Post;

class PostsToIdsDataFormatter implements DataFormatterInterface
{
    /**
     * @param WP_Post[] $posts
     *
     * @return array
     */
    public function formatData($posts)
    {
        $posts = new PostCollection(...$posts);

        return array_map('strval', $posts->getIds());
    }

    /**
     * @param array $terms
     *
     * @return array
     */
    public function formatInput($posts)
    {
        if (in_array('', $posts)) {
            unset($posts[array_search('', $posts)]);
        }

        return array_map('intval', $posts);
    }
}