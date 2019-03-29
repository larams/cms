<?php

namespace Larams\Cms\Property;

use Larams\Cms\Property;

class Text extends Property
{

    protected $cssClass = 'col-xs-6';

    public function getHtml()
    {

        $configuration = array(
            'cssClass' => $this->cssClass,
            'item' => $this->item,
            'name' => $this->name
        );

        return view('larams::properties.text', $configuration);

    }
}