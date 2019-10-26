<?php

namespace WebTheory\Leonidas\Fields;

use WebTheory\Saveyour\Contracts\FormFieldInterface;
use WebTheory\Saveyour\Fields\Input;
use WebTheory\Saveyour\Fields\Text;
use WebTheory\Leonidas\Contracts\WpAdminFieldInterface;

class AbstractField implements WpAdminFieldInterface
{
    /**
     * label
     *
     * @var string
     */
    protected $label;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * @var WpAdminField
     */
    protected $formFieldController;

    /**
     *
     */
    public function __construct(WpAdminField $formFieldController)
    {
        $this->formFieldController = $formFieldController;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Set label
     *
     * @param string  $label  label
     *
     * @return self
     */
    public function setLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description description
     *
     * @return self
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of formFieldController
     *
     * @return WpAdminField
     */
    public function getFormFieldController(): WpAdminField
    {
        return $this->formFieldController;
    }

    /**
     *
     */
    protected function renderFormField($object): FormFieldInterface
    {
        return $this->formFieldController->renderFormField($object);
    }
}