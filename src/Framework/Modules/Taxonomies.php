<?php

namespace Leonidas\Framework\Modules;

use Leonidas\Contracts\Extension\ModuleInterface;
use Leonidas\Contracts\System\Model\Taxonomy\TaxonomyFactoryInterface;
use Leonidas\Contracts\System\Model\Taxonomy\TaxonomyOptionHandlerCollectionInterface;
use Leonidas\Library\System\Model\Taxonomy\TaxonomyFactory;

class Taxonomies extends AbstractTaxonomyRegistrationModule implements ModuleInterface
{
    protected function taxonomies(): array
    {
        return $this->factory()->createMany($this->getTaxonomyResource());
    }

    protected function getTaxonomyResource(): array
    {
        return $this->getConfig($this->taxonomyResourceKey());
    }

    protected function factory(): TaxonomyFactoryInterface
    {
        return new TaxonomyFactory($this->extension->prefix('', '_'));
    }

    protected function optionHandlers(): ?TaxonomyOptionHandlerCollectionInterface
    {
        $service = $this->optionHandlerService();

        return $this->hasService($service)
            ? $this->getService($service)
            : null;
    }

    protected function taxonomyResourceKey(): string
    {
        return 'taxonomies';
    }

    protected function optionHandlerService(): string
    {
        return 'taxonomy_option_handlers';
    }
}
