<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Framework\Providers\TaxonomyProvider;
use Leonidas\Library\System\Model\Taxonomy\TaxonomyFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class TaxonomyFactoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function serviceId(): string
    {
        return TaxonomyFactory::class;
    }

    protected function serviceTags(): array
    {
        return ['taxonomy_factory'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new TaxonomyProvider();
    }

    protected function factoryArgs(): ?array
    {
        return [
            'prefix' => $this->getConfig('app.prefix'),
        ];
    }
}