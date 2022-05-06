<?php

namespace Leonidas\Library\System\Model\Post\Policies;

use Leonidas\Traits\ExpectsPostTrait;
use Psr\Http\Message\ServerRequestInterface;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class PostPolicy implements ServerRequestPolicyInterface
{
    use ExpectsPostTrait;

    /**
     * @var int[]
     */
    protected array $posts = [];

    public function __construct(int ...$posts)
    {
        $this->posts = $posts;
    }

    /**
     * Get the value of posts
     *
     * @return int[]
     */
    public function getPosts(): array
    {
        return $this->posts;
    }

    public function approvesRequest(ServerRequestInterface $request): bool
    {
        return in_array($this->getPostId($request), $this->posts);
    }
}
