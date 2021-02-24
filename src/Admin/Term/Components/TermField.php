<?php

namespace WebTheory\Leonidas\Admin\Term\Components;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Leonidas\Admin\AbstractAdminField;
use WebTheory\Leonidas\Admin\Contracts\TermFieldInterface;
use WebTheory\Leonidas\Admin\Contracts\ViewInterface;
use WebTheory\Leonidas\Admin\Term\Views\AddTermFieldView;
use WebTheory\Leonidas\Admin\Term\Views\EditTermFieldView;
use WebTheory\Leonidas\Admin\Traits\CanBeRestrictedTrait;
use WebTheory\Leonidas\Admin\Traits\RendersWithViewTrait;

class TermField extends AbstractAdminField implements TermFieldInterface
{
    use CanBeRestrictedTrait;
    use RendersWithViewTrait;

    /**
     *
     */
    protected function defineView(ServerRequestInterface $request): ViewInterface
    {
        switch (get_current_screen()->base) {

            case 'edit-tags':
                $view = $this->getAddTermFieldView();
                break;

            case 'term':
                $view = $this->getEditTermFieldView();
                break;
        }

        return $view;
    }

    /**
     *
     */
    protected function getAddTermFieldView(): ViewInterface
    {
        return new AddTermFieldView();
    }

    /**
     *
     */
    protected function getEditTermFieldView(): ViewInterface
    {
        return new EditTermFieldView();
    }

    /**
     *
     */
    protected function defineViewContext(ServerRequestInterface $request): array
    {
        return [
            'label' => $this->label,
            'description' => $this->description,
            'field' => $this->renderFormField($request)
        ];
    }
}
