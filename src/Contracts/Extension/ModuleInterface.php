<?php

namespace Leonidas\Contracts\Extension;

interface ModuleInterface extends BaseModuleInterface
{
    /**
     * @var WpExtensionInterface Extension base class that contains values to be used throughout all extension functions
     */
    public function __construct(WpExtensionInterface $extension);
}