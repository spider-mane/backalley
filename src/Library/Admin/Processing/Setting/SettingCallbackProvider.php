<?php

namespace Leonidas\Library\Admin\Processing\Setting;

use Leonidas\Contracts\Admin\Processing\Setting\SettingCallbackProviderInterface;
use Leonidas\Contracts\Admin\Processing\Setting\SettingInterface;
use Leonidas\Contracts\Option\OptionRepositoryInterface;
use WebTheory\Saveyour\Contracts\Controller\InputPurifierInterface;
use WebTheory\Saveyour\Controller\InputPurifier;

class SettingCallbackProvider implements SettingCallbackProviderInterface
{
    public function __construct(
        protected OptionRepositoryInterface $optionRepository,
        protected SettingNoticeInjector $noticeRegistrar
    ) {
        //
    }

    public function getProcessingCallback(SettingInterface $setting): callable
    {
        return fn (mixed $input) => $this
            ->createInputHandler($setting)
            ->handleInput($input);
    }

    protected function createInputHandler(SettingInterface $setting): InputPurifierInterface
    {
        return new InputPurifier(
            $setting->getValidator(),
            $setting->getFormatter(),
            new SettingValidationProcessor(
                $setting,
                $this->optionRepository,
                $this->noticeRegistrar
            )
        );
    }
}