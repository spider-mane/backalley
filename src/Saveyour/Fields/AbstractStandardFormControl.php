<?php

namespace WebTheory\Saveyour\Fields;

use WebTheory\Saveyour\Contracts\FormFieldInterface;

abstract class AbstractStandardFormControl extends AbstractFormField implements FormFieldInterface
{
    /**
     * {@inheritDoc}
     */
    protected function resolveAttributes()
    {
        return parent::resolveAttributes()
            ->addAttribute('name', $this->name)
            ->addAttribute('disabled', $this->disabled)
            ->addAttribute('readonly', $this->readonly)
            ->addAttribute('required', $this->required)
            ->addAttribute('placeholder', $this->placeholder);
    }
}