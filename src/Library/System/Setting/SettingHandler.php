<?php

namespace Leonidas\Library\System\Setting;

use Leonidas\Contracts\System\Setting\SettingHandlerInterface;
use Leonidas\Contracts\System\Setting\SettingInterface;
use Leonidas\Contracts\System\Setting\SettingsNoticeCollectionInterface;
use WebTheory\Saveyour\Contracts\Formatting\InputFormatterInterface;
use WebTheory\Saveyour\Contracts\Validation\ValidatorInterface;
use WebTheory\Saveyour\Controller\InputPurifier;

class SettingHandler extends InputPurifier implements SettingHandlerInterface
{
    protected SettingInterface $setting;

    protected SettingsNoticeCollectionInterface $notices;

    public function __construct(
        SettingInterface $setting,
        ValidatorInterface $validator,
        SettingsNoticeCollectionInterface $notices,
        InputFormatterInterface $formatter
    ) {
        $this->setting = $setting;
        $this->notices = $notices;
        parent::__construct($validator, $formatter);
    }

    public function getSetting(): SettingInterface
    {
        return $this->setting;
    }

    protected function returnIfFailed()
    {
        return get_option(
            $this->setting->getOptionName(),
            $this->setting->getDefaultValue()
        );
    }

    protected function handleRuleViolation($rule): void
    {
        $alert = $this->notices->get($rule);

        add_settings_error(
            $this->setting->getOptionName(),
            $alert->getCode(),
            $alert->getMessage(),
            $alert->getType()
        );
    }
}