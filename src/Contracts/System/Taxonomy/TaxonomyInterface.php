<?php

namespace Leonidas\Contracts\System\Taxonomy;

use Leonidas\Contracts\System\BaseSystemModelTypeInterface;

interface TaxonomyInterface extends BaseSystemModelTypeInterface
{
    public function getObjectTypes(): array;

    public function isAllowedInTagCloud(): bool;

    public function isAllowedInQuickEdit(): bool;

    public function canHaveAdminColumn(): bool;

    /**
     * @return bool|callable
     */
    public function getMetaBoxCb();

    public function getMetaBoxSanitizeCb(): ?callable;

    public function getUpdateCountCallback(): ?callable;

    /**
     * @return null|string|array
     */
    public function getDefaultTerm();

    public function shouldBeSorted(): ?bool;

    public function getArgs(): ?array;
}