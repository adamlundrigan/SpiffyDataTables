<?php

namespace SpiffyDataTables\Column;

use RuntimeException;

class Closure extends AbstractColumn
{
    public function parse(array $data)
    {
        $closure = isset($this->config['closure']) ? $this->config['closure'] : null;
        if (!$closure) {
            throw new RuntimeException('Closure column requires a closure property to operate');
        }

        if (!is_callable($closure)) {
            throw new RuntimeException('Closure must be callable');
        }

        return call_user_func_array($closure, array($this, $data));
    }
}