<?php

namespace WebTheory\Leonidas\Framework\Modules;

use WebTheory\Leonidas\Admin\Contracts\ModuleInterface;
use WebTheory\Leonidas\Framework\Traits\Hooks\TargetsAdminEnqueueScriptHook;

abstract class AbstractAdminAssetLoaderModule extends AbstractModule implements ModuleInterface
{
    use TargetsAdminEnqueueScriptHook;

    public function hook(): void
    {
        $this->targetAdminEnqueueScriptsHook();
    }
}
