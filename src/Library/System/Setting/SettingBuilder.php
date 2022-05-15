<?php

namespace Leonidas\Library\System\Setting;

use Leonidas\Contracts\System\Setting\SettingBuilderInterface;
use Leonidas\Contracts\System\Setting\SettingHandlerInterface;
use Leonidas\Library\System\Setting\Traits\HasSettingDataTrait;

class SettingBuilder implements SettingBuilderInterface
{
    use HasSettingDataTrait;

    protected ?SettingHandlerInterface $handler = null;

    public function __construct(string $optionName)
    {
        $this->optionName = $optionName;
    }

    public function optionGroup(string $optionGroup)
    {
        $this->optionGroup = $optionGroup;
    }

    public function optionName(string $optionName)
    {
        $this->optionName = $optionName;
    }

    public function type(?string $type)
    {
        $this->type = $type;
    }

    public function description(?string $description)
    {
        $this->description = $description;
    }

    public function schema($schema)
    {
        $this->restSchema = $schema;
    }

    public function default($default)
    {
        $this->defaultValue = $default;
    }

    public function extra(?array $extraArgs)
    {
        $this->extraArgs = $extraArgs;
    }

    public function handler(?SettingHandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    public function getHandler(): ?SettingHandlerInterface
    {
        return $this->handler;
    }

    public function get(): Setting
    {
        return new Setting(
            $this->getOptionGroup(),
            $this->getOptionName(),
            $this->getType(),
            $this->getDescription(),
            $this->getHandler(),
            $this->getRestSchema(),
            $this->getDefaultValue(),
            $this->getExtraArgs()
        );
    }

    public static function for(string $optionName): SettingBuilder
    {
        return new static($optionName);
    }
}