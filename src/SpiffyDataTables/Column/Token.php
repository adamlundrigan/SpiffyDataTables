<?php

namespace SpiffyDataTables\Column;

use RuntimeException;

class Token extends AbstractColumn
{
    public function parse(array $data)
    {
        $format = isset($this->config['format']) ? $this->config['format'] : null;
        if (!$format) {
            throw new RuntimeException('Token requires a format property to operate');
        }

        preg_match_all('/%(\w+)%/', $format, $matches);

        $result = null;
        foreach ($matches[1] as $match) {
            if (array_key_exists($match, $data)) {
                $result = str_replace("%{$match}%", $data[$match], $format);
            }
        }

        return $result;
    }
}