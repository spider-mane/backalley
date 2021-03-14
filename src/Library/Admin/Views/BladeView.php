<?php

namespace Leonidas\Library\Admin\Views;

use Leonidas\Contracts\Ui\ViewInterface;

class BladeView implements ViewInterface
{
    /**
     * @var string
     */
    protected $template;

    /**
     *
     */
    public function __construct(string $template)
    {
        $this->template = $template;
    }

    /**
     *
     */
    public function render(array $context = []): string
    {
        //
    }
}