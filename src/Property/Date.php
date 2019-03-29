<?php

namespace Larams\Cms\Property;

use Larams\Cms\Property;

class Date extends Property
{

    protected $format = 'yyyy-mm-dd';

    public function getHtml()
    {

        return view('larams::properties.date', [ 'name' => $this->name, 'item' => $this->item, 'format' => $this->format ] );

    }

}