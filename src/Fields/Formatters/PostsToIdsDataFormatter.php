<?php

namespace WebTheory\Post2Post;

use WP_Post;
use WebTheory\Leonidas\Util\PostCollection;
use WebTheory\Saveyour\Contracts\DataFormatterInterface;

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
     * @param WP_Post[] $posts
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