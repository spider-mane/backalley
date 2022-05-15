<?php

namespace Leonidas\Library\Admin\Printer\Abstracts;

use Leonidas\Contracts\Admin\Component\AdminNoticeCollectionInterface;
use Leonidas\Contracts\Admin\Component\AdminNoticePrinterInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAdminNoticePrinter implements AdminNoticePrinterInterface
{
    public function printSet(AdminNoticeCollectionInterface $notices, ServerRequestInterface $request): string
    {
        $output = '';

        foreach ($notices as $notice) {
            $output .= $this->print($notice, $request);
        }

        return $output;
    }
}