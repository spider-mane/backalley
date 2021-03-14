<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use Leonidas\Library\Admin\Fields\Selections\Traits\TermSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\OptionsProviderInterface;

class TaxonomySelectOptions extends AbstractTaxonomySelection implements OptionsProviderInterface
{
    use TermSelectOptionsTrait;
}