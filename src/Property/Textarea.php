<?php

namespace Talandis\Larams\Property;

use Talandis\Larams\Property;

class Textarea extends Property
{

    protected $rows = 5;

    protected $cssClass = 'col-xs-6';

    public function getHtml()
    {

        $configuration = array(
            'cssClass' => $this->cssClass,
            'rows' => $this->rows,
            'item' => $this->item,
            'name' => $this->name
        );

        return view('larams::properties.textarea', $configuration);

    }
}