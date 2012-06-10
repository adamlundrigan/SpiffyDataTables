<?php

namespace SpiffyDataTables\Column;

class Link extends Token
{
    public function parse(array $data)
    {
        $label = isset($this->config['label']) ? $this->config['label'] : $this->getName();

        return sprintf('<a href="%s">%s</a>', parent::parse($data), $this->getName());
    }
}