<?php

namespace Larams\Cms;

trait FixesDecimalNumber
{
    protected $decimalFields = [];

    protected function cleanDecimalFields($input)
    {
        if (!empty($this->decimalFields)) {
            foreach ($this->decimalFields as $decimalField) {
                if (!empty($input[$decimalField])) {
                    $input[$decimalField] = $this->fixDecimalNumber($input[$decimalField]);
                }
            }
        }

        return $input;
    }

    protected function fixDecimalNumber($number)
    {
        return str_replace([',', ' '], ['.', ''], $number);
    }
}
