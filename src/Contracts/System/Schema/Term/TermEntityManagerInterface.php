<?php

namespace Leonidas\Contracts\System\Schema\Term;

use Leonidas\Contracts\System\Schema\EntityManagerInterface;

interface TermEntityManagerInterface extends EntityManagerInterface
{
    public function whereIds(int ...$ids): object;

    public function selectByTermTaxonomyId(int $ttId): object;

    public function whereTermTaxonomyIds(int ...$ttId): object;

    public function selectBySlug(string $slug): object;

    public function whereSlugs(string ...$slugs): object;

    public function whereParentId(int $parentId): object;

    public function whereChildOf(int $parentId): object;

    public function whereObjectIds(int ...$objects): object;
}
