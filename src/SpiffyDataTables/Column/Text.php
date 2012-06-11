<?php

namespace SpiffyDataTables\Column;

use RuntimeException;

class Text extends AbstractColumn
{
    public function parse(array $data)
    {
        $text = isset($this->config['text']) ? $this->config['text'] : null;
        if (!$text) {
            throw new RuntimeException('Text requires a text property to operate');
        }

        return $text;
    }
}