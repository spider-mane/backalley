<?php

namespace Leonidas\Library\Core\Http;

use Leonidas\Contracts\Http\ConstrainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class ConstrainerCollection
{
    /**
     * @var ConstrainerInterface[]
     */
    public $constrainers = [];

    public function __construct(ConstrainerInterface ...$constrainers)
    {
        $this->constrainers = $constrainers;
    }

    public function addConstrainer(ConstrainerInterface $constrainer)
    {
        $this->constrainers[] = $constrainer;
    }

    public function constrains(ServerRequestInterface $request)
    {
        foreach ($this->constrainers as $constraint) {
            if (!$constraint->requestMeetsCriteria($request)) {
                return true;
            }
        }

        return false;
    }
}