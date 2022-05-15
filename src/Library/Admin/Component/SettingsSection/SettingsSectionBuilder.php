<?php

namespace Leonidas\Library\Admin\Component\SettingsSection;

use Leonidas\Contracts\Admin\Component\SettingsSectionBuilderInterface;
use Leonidas\Contracts\Admin\Component\SettingsSectionInterface;
use Leonidas\Library\Admin\Component\SettingsSection\Traits\HasSettingsSectionDataTrait;
use WebTheory\HttpPolicy\ServerRequestPolicyInterface;

class SettingsSectionBuilder implements SettingsSectionBuilderInterface
{
    use HasSettingsSectionDataTrait;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id(string $id)
    {
        $this->id = $id;
    }

    public function title(string $title)
    {
        $this->title = $title;
    }

    public function page(string $page)
    {
        $this->page = $page;
    }

    public function description(string $description)
    {
        $this->description = $description;
    }

    public function policy(?ServerRequestPolicyInterface $policy)
    {
        $this->policy = $policy;
    }

    public function getPolicy(): ?ServerRequestPolicyInterface
    {
        return $this->policy;
    }

    public function get(): SettingsSectionInterface
    {
        return new SettingsSection(
            $this->getId(),
            $this->getTitle(),
            $this->getPage(),
            $this->getDescription(),
            $this->getPolicy(),
        );
    }
}