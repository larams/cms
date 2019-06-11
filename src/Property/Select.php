<?php

namespace Larams\Cms\Property;

use Larams\Cms\Property;

class Select extends Property
{

    protected $options = [];

	protected $cssClass = 'col-xs-6';

    protected $multiple = false;

    public function getHtml()
    {

        $configuration = array(
            'options' => $this->options,
			'cssClass' => $this->cssClass,
            'item' => $this->item,
            'name' => $this->name,
            'hint' => $this->hint,
            'multiple' => $this->multiple
        );

        return view('larams::properties.select', $configuration);

    }
}
