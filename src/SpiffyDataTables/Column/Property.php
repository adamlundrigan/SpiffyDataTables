<?php

namespace SpiffyDataTables\Column;

class Property extends AbstractColumn
{
    public function parse(array $data)
    {
        if (isset($data[$this->getName()])) {
            return $data[$this->getName()];
        }
        return null;
    }
}