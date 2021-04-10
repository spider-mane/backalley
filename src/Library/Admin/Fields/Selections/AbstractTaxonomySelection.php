<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use WebTheory\Saveyour\Contracts\SelectionProviderInterface;
use WP_Taxonomy;
use WP_Term;

abstract class AbstractTaxonomySelection extends AbstractTermSelectionProvider implements SelectionProviderInterface
{
    /**
     * @var WP_Taxonomy
     */
    protected $taxonomy;

    /**
     *
     */
    public function __construct(string $taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    /**
     * @return WP_Term[]
     */
    public function provideSelectionsData(): array
    {
        return get_terms([
            'taxonomy' => $this->taxonomy,
            'hide_empty' => false,
        ]);
    }
}
