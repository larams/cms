<?php

namespace Larams\Cms\Property;

use Larams\Cms\Property;

class DoubleText extends Property
{

    protected $inputs = [];

    public function getHtml()
    {

        $configuration = array(
            'inputs' => $this->inputs,
            'item' => $this->item,
            'name' => $this->name,
            'hint' => $this->hint,
        );

        return view('larams::properties.double_text', $configuration);

    }
}
