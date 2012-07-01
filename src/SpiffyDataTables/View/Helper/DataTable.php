<?php

namespace SpiffyDataTables\View\Helper;

use SpiffyDataTables\Source\Source;
use Zend\Json\Encoder;
use Zend\View\Helper\AbstractHtmlElement;

class DataTable extends AbstractHtmlElement
{
    protected static $loaded = false;

    public function __invoke($id, Source $source, array $attributes = array(), array $dtOptions = array())
    {
        $this->load();
        
        // dtOptions has the data table final options
        $columns = $source->getColumns();
        
        // If the source is server-side then our job is simple
        $dtOptions['aaData'] = $source->getData();

        // Setup column data
        foreach ($columns as $column) {
            $dtOptions['aoColumns'][] = array_merge(array(
                'sTitle' => $column->getName()
            ), $column->getAttributes());
        }
        
        $js = sprintf('$("#%s").dataTable(%s);', $id, Encoder::encode($dtOptions));
        $this->view->inlineScript()->appendScript($js);
        
        // Force ID attribute.
        $attributes['id'] = $id;
        
        return sprintf('<table%s></table>', $this->_htmlAttribs($attributes));
    }

    protected function load()
    {
        if (self::$loaded) {
            return;
        }
        
        $this->view->inlineScript()->appendFile('/js/SpiffyDataTables/jquery.dataTables.min.js');
        
        self::$loaded = true;
    }
}