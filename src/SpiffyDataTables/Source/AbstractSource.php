<?php

namespace SpiffyDataTables\Source;

use InvalidArgumentException;
use SpiffyDataTables\Column\AbstractColumn;

abstract class AbstractSource
{
    protected $columns = array();

    protected $input;

    protected $data;

    public function getRawData()
    {
        return $this->data;
    }

    public function getData()
    {
        $result  = array();
        $rawData = $this->getRawData();

        foreach($rawData as $data) {
            $item = array();
            foreach($this->getColumns() as $column) {
                $item[] = $column->parse($data);
            }

            $result[] = $item;
        }

        return $result;
    }

    public function clearColumns()
    {
        $this->columns = array();
        return $this;
    }

    public function setColumns(array $columns)
    {
        $this->clearColumns();
        $this->addColumns($columns);
        return $this;
    }

    public function addColumn($spec)
    {
        if (is_string($spec)) {
            $spec = array('name' => $spec);
        }

        if (is_array($spec)) {
            $spec = AbstractColumn::factory($spec);
        }

        if (!$spec instanceof AbstractColumn) {
            throw new InvalidArgumentException('Column must be an array or instance of AbstractColumn');
        }

        $this->columns[] = $spec;
        return $this;
    }

    public function addColumns(array $columns)
    {
        foreach ($columns as $name => $column) {
            $this->addColumn($name, $column);
        }
        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }
}