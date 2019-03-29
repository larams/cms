<?php

namespace Larams\Cms\Property;

use Larams\Cms\Property;

class Rte extends Property
{

    protected $width = '100%';

    protected $height = '300px';

    public function getHtml()
    {

        $configuration = array(
            'width' => $this->width,
            'height' => $this->height,
            'item' => $this->item,
            'name' => $this->name
        );

        return view('larams::properties.rte', $configuration );

    }

}