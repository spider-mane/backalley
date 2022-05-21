<?php

namespace Leonidas\Framework\Provider\League;

class TwigFlexViewServiceProvider extends TwigViewServiceProvider
{
    protected function factoryArgs(): ?array
    {
        $config = $this->getConfig('twig');

        return array_merge(
            $config['@global'] ?? [],
            $config[is_admin() ? '@admin' : '@theme'] ?? []
        ) ?: $config;
    }
}