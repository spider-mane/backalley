<?php

namespace Leonidas\Library\Core\Http;

use Leonidas\Contracts\Http\Policy\ServerRequestPolicyInterface;
use Psr\Http\Message\ServerRequestInterface;

class CompositePolicy implements ServerRequestPolicyInterface
{
    /**
     * @var ServerRequestPolicyInterface[]
     */
    public $policies = [];

    public function __construct(ServerRequestPolicyInterface ...$policies)
    {
        $this->policies = $policies;
    }

    public function addPolicy(ServerRequestPolicyInterface $policy)
    {
        $this->policies[] = $policy;
    }

    public function approvesRequest(ServerRequestInterface $request): bool
    {
        foreach ($this->policies as $policy) {
            if (!$policy->approvesRequest($request)) {
                return false;
            }
        }

        return true;
    }

    public static function with(ServerRequestPolicyInterface ...$policies): self
    {
        return new static(...$policies);
    }

    public static function from(array $policies): self
    {
        return new static(...$policies);
    }
}