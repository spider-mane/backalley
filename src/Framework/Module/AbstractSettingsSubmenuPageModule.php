<?php

namespace Leonidas\Framework\Module;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Framework\Module\Abstracts\SettingsPageModuleTrait;

abstract class AbstractSettingsSubmenuPageModule extends AbstractSubmenuPageModule implements ModuleInterface
{
    use SettingsPageModuleTrait;
}
