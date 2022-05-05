<?php

namespace Leonidas\Library\Admin\Fields\Managers;

use WebTheory\Saveyour\Contracts\Data\FieldDataManagerInterface;

class TermMetaDataManager extends AbstractWPEntityMetaFieldDataManager implements FieldDataManagerInterface
{
    protected const MODEL = 'term';
    protected const ID_KEY = 'term_id';
    protected const NAME_KEY = 'name';
}
