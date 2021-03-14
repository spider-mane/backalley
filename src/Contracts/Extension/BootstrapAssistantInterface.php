<?php

namespace Leonidas\Contracts\Extension;

interface BootstrapAssistantInterface
{
    public function __construct(WpExtensionInterface $extension);

    public function boot(): void;
}