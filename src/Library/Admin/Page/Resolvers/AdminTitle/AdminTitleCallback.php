<?php

namespace Leonidas\Library\Admin\Page\Resolvers\AdminTitle;

use Leonidas\Contracts\Admin\AdminTitleResolverInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminTitleCallback implements AdminTitleResolverInterface
{
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function resolveAdminTitle(ServerRequestInterface $request): string
    {
        return ($this->callback)($request);
    }
}
