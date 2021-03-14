<?php

namespace Leonidas\Library\Admin\Fields\Selections;

use Leonidas\Library\Admin\Fields\Selections\Traits\TermSelectOptionsTrait;
use WebTheory\Saveyour\Contracts\OptionsProviderInterface;

class TermCollectionSelectOptions extends AbstractTermCollectionSelection implements OptionsProviderInterface
{
    use TermSelectOptionsTrait;
}