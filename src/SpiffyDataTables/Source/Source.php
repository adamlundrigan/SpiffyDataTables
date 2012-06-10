<?php

namespace SpiffyDataTables\Source;

use InvalidArgumentException;
use Traversable;;

class Source extends AbstractSource
{
    public function __construct($data)
    {
        if (!is_array($data) && !$data instanceof Traversable) {
            throw new InvalidArgumentException(
                'Default source expects an array of input'
            );
        }

        $this->data = $data;
    }
}