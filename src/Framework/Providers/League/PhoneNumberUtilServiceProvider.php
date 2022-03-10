<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Framework\Providers\PhoneNumberUtilProvider;
use libphonenumber\PhoneNumberUtil;
use Psr\Container\ContainerInterface;

class PhoneNumberUtilServiceProvider extends AbstractLeagueProviderWrapper
{
    protected function serviceId(): string
    {
        return PhoneNumberUtil::class;
    }

    protected function serviceTags(): array
    {
        return ['phone', 'phone_util', 'phoneUtil'];
    }

    protected function serviceProvider(): StaticProviderInterface
    {
        return new PhoneNumberUtilProvider();
    }

    protected function providerArgs(ContainerInterface $container): ?array
    {
        return $this->getConfig('phone.util');
    }
}
