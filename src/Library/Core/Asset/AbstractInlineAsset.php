<?php

namespace Leonidas\Library\Core\Asset;

use Leonidas\Contracts\Http\Policy\ServerRequestPolicyInterface;
use Leonidas\Library\Core\Http\Policies\NoPolicy;
use Psr\Http\Message\ServerRequestInterface;

class AbstractInlineAsset
{
    protected string $handle;

    protected string $code;

    protected ?ServerRequestPolicyInterface $policy = null;

    public function __construct(string $handle, string $code, ?ServerRequestPolicyInterface $policy = null)
    {
        $this->handle = $handle;
        $this->code = $code;

        $this->policy = $policy ?? new NoPolicy();
    }

    public function getHandle(): string
    {
        return $this->handle;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getPolicy(): ServerRequestPolicyInterface
    {
        return $this->policy;
    }

    public function shouldBeLoaded(ServerRequestInterface $request): bool
    {
        return $this->policy->approvesRequest($request);
    }
}
