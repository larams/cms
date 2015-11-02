<?php

namespace Talandis\Larams\Property;

use Talandis\Larams\Property;

class DoubleText extends Property
{

    protected $inputs = [];

    public function getHtml()
    {

        $configuration = array(
            'inputs' => $this->inputs,
            'item' => $this->item,
            'name' => $this->name
        );

        return view('larams::properties.double_text', $configuration);

    }
}