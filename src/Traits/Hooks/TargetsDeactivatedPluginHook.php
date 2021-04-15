<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsDeactivatedPluginHook
{
    protected function targetDeactivatedPluginHook()
    {
        add_action(
            'deactivated_plugin',
            $this->getDeactivatedPluginCallback(),
            null,
            PHP_INT_MAX
        );
    }

    protected function getDeactivatedPluginCallback(): Closure
    {
        return function (string $plugin, bool $networkWide) {
            $this->doDeactivatedPluginAction($plugin, $networkWide);
        };
    }

    abstract protected function doDeactivatedPluginAction(string $plugin, bool $networkWide): void;
}