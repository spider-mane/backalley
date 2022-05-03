<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Admin\Components\AdminNoticeRepositoryInterface;
use Leonidas\Library\Admin\Notice\AdminNoticeRepository;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class AdminNoticeRepositoryProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): AdminNoticeRepositoryInterface
    {
        return new AdminNoticeRepository(
            $args['channel'],
            $container->get('cache_channel')
        );
    }
}