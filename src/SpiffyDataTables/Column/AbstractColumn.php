<?php

namespace SpiffyDataTables\Column;

use InvalidArgumentException;

abstract class AbstractColumn
{
    public static $typemap = array(
        'closure'  => 'SpiffyDataTables\Column\Closure',
        'link'     => 'SpiffyDataTables\Column\Link',
        'token'    => 'SpiffyDataTables\Column\Token',
        'property' => 'SpiffyDataTables\Column\Property',
        'text'     => 'SpiffyDataTables\Column\Text',
    );

    protected $name;

    protected $config = array();

    protected $attributes = array();

    public static function factory(array $spec)
    {
        if (!isset($spec['name'])) {
            throw new InvalidArgumentException('A name is required for all columns');
        }

        $spec['type']       = isset($spec['type']) ? strtolower(trim($spec['type'])) : 'property';
        $spec['config']     = isset($spec['config']) ? $spec['config'] : array();
        $spec['attributes'] = isset($spec['attributes']) ? $spec['attributes'] : array();

        if (isset(self::$typemap[$spec['type']])) {
            $class = self::$typemap[$spec['type']];
        } else if (class_exists($spec['type'])) {
            $class = $spec['type'];
        } else {
            throw new InvalidArgumentException(sprintf(
                'Failed to load column for type "%s"',
                $spec['type']
            ));
        }

        $column = new $class;
        $column->setName($spec['name']);
        $column->setConfig($spec['config']);
        $column->setAttributes($spec['attributes']);

        return $column;
    }

    abstract public function parse(array $data);

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }
}