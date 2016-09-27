<?php

namespace Larams\Cms\Property;

use Larams\Cms\Property;
use Larams\Cms\StructureItem;

class DbSelect extends Property
{

    protected $rows = 5;

    protected $cssClass = 'col-xs-6';

    protected $model = '';

    protected $style = null;

    protected $firstLevel = false;

    protected $multiple = false;

    protected $allowEmpty = false;

    protected $keyColumn = 'id';

    protected $valueColumn = 'name';

    public function getHtml()
    {

        $tableModel = new $this->model;

        $items = $tableModel->get();

        $value = isset($this->item->data->{$this->name}) ? $this->item->data->{$this->name} : null;

        foreach ( $items as &$item ) {
            $item->selected = !empty($value) && (is_array($value) && in_array($item->{$this->keyColumn}, $value) || (!is_array($value) && $item->{$this->keyColumn} == $value));
        }

        $configuration = array(
            'cssClass' => $this->cssClass,
            'style' => $this->style,
            'value' => $value,
            'multiple' => $this->multiple,
            'allowEmpty' => $this->allowEmpty,
            'item' => $this->item,
            'name' => $this->name,
            'items' => $items,
            'keyColumn' => $this->keyColumn,
            'valueColumn' => $this->valueColumn
        );

        return view('larams::properties.db_select', $configuration);

    }
}