<?php

namespace Leonidas\Framework\Module\Abstracts\Traits;

use Leonidas\Contracts\Admin\Component\Page\BaseAdminPageInterface;
use Leonidas\Framework\Abstracts\FluentlySetsPropertiesTrait;
use Psr\Http\Message\ServerRequestInterface;

trait AdminPageModuleTrait
{
    use AbstractModuleTraitTrait;
    use FluentlySetsPropertiesTrait;

    protected function filterAdminTitle(string $adminTitle, string $title): string
    {
        if (!$this->isMatchingAdminPage($title)) {
            return $adminTitle;
        }

        $request = $this->getServerRequest()
            ->withAttribute('admin_title', $adminTitle)
            ->withAttribute('title', $title);

        return $this->resolvedAdminTitle($request) ?? $adminTitle;
    }

    protected function isMatchingAdminPage(string $title): bool
    {
        return $this->isset('definition')
            && $this->getDefinition()->getPageTitle() !== $title;
    }

    protected function resolvedAdminTitle(ServerRequestInterface $request): ?string
    {
        return $this->getDefinition()->defineAdminTitle($request);
    }

    protected function renderAdminPage(ServerRequestInterface $request): string
    {
        $definition = $this->getDefinition();

        return $definition->shouldBeRendered($request)
            ? $definition->renderComponent($request)
            : $definition->getLoadErrorPage()->renderComponent($request);
    }

    abstract protected function getDefinition(): BaseAdminPageInterface;
}
