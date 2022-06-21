<?php

namespace Leonidas\Console\Library\Abstracts;

abstract class AbstractTypedClassPrinter extends AbstractClassPrinter
{
    use TypedClassPrinterTrait;

    public function __construct($namespace, $class, $type)
    {
        parent::__construct($namespace, $class);

        $this->type = $type;
    }
}