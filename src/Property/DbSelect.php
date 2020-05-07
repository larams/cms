<?php

namespace Larams\Cms\Property;

use Larams\Cms\Property;
use Larams\Cms\StructureItem;

class DbSelect extends Property
{

    protected $rows = 5;

    protected $cssClass = 'col-xs-6';

    protected $model = '';

    protected $method = '';

    protected $style = null;

    protected $firstLevel = false;

    protected $multiple = false;

    protected $allowEmpty = false;

    protected $keyColumn = 'id';

    protected $valueColumn = 'name';

    protected function collectData()
    {
        $tableModel = app()->make($this->model);

        if (!empty($this->method)) {
            return call_user_func([$tableModel, $this->method]);
        }

        return $tableModel->get();
    }

    public function getHtml()
    {

        $items = $this->collectData();

        $value = isset($this->item->data->{$this->name}) ? $this->item->data->{$this->name} : null;

        foreach ($items as &$item) {
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
            'valueColumn' => $this->valueColumn,
            'hint' => $this->hint,
        );

        return view('larams::properties.db_select', $configuration);

    }
}
