<?php

namespace Leonidas\Library\Admin\Page\Resolvers\ParentFile;

use Leonidas\Contracts\Admin\ParentFileResolverInterface;
use Psr\Http\Message\ServerRequestInterface;

class ParentFileCallback implements ParentFileResolverInterface
{
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function resolveParentFile(ServerRequestInterface $request): string
    {
        return ($this->callback)($request);
    }
}
