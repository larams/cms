<?php

namespace Talandis\Larams\Property;

use Talandis\Larams\Property;

class Select extends Property
{

    protected $options = [];

	protected $cssClass = 'col-xs-6';

    public function getHtml()
    {

        $configuration = array(
            'options' => $this->options,
			'cssClass' => $this->cssClass,
            'item' => $this->item,
            'name' => $this->name
        );

        return view('larams::properties.select', $configuration);

    }
}
