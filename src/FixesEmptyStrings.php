<?php

namespace Larams\Cms;

trait FixesEmptyStrings
{
    protected function emptyStringToNull($string)
    {
        $string = trim($string);

        if ($string === '' || $string === '0000-00-00' || $string === '0000-00-00 00:00:00' || $string === 'null' || $string === 'Invalid date') {
            return null;
        }

        return $string;
    }
}
