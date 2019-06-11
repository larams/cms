<?php

namespace Larams\Cms\Property;

use Larams\Cms\Property;

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
            'name' => $this->name,
            'hint' => $this->hint,
        );

        return view('larams::properties.textarea', $configuration);

    }
}
