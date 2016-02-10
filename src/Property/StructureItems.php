<?php

namespace Talandis\Larams\Property;

use Talandis\Larams\Property;
use Talandis\Larams\StructureItem;

class StructureItems extends Property
{

    protected $rows = 5;

    protected $cssClass = 'col-xs-6';

    protected $typeName = 'site';

    protected $style = null;

    protected $firstLevel = false;

    protected $multiple = false;

    protected $allowEmpty = false;

    public function getHtml()
    {

        $structureItems = new StructureItem();

        $topLevelItem = $structureItems->byTypeName($this->typeName)->first();

        if (!empty($this->firstLevel)) {
            $childs = $structureItems->where('parent_id', $topLevelItem->id)->get();
        } else {
            $childs = $structureItems->where('left', '>', $topLevelItem->left)->where('right', '<', $topLevelItem->right)->orderBy('left')->get();
        }

        $value = isset($this->item->data->{$this->name}) ? $this->item->data->{$this->name} : null;

        foreach ($childs as $k => &$child) {
            $child->hasChilds = !empty($childs[$k + 1]) && $childs[$k + 1]->level > $child->level;
            $child->selected = !empty($value) && (is_array($value) && in_array($child->id, $value) || (!is_array($value) && $child->id == $value));

            $whitespaces = '';
            $i = 0;
            while ($i < ($child->level - $childs[0]->level)) {
                $whitespaces .= '&nbsp;&nbsp;&nbsp;';
                $i++;
            }

            $child->whitespaces = $whitespaces;

        }

        $configuration = array(
            'cssClass' => $this->cssClass,
            'typeName' => $this->typeName,
            'style' => $this->style,
            'firstLevel' => $this->firstLevel,
            'multiple' => $this->multiple,
            'allowEmpty' => $this->allowEmpty,
            'item' => $this->item,
            'name' => $this->name,
            'childs' => $childs
        );

        return view('larams::properties.struct_items', $configuration);

    }
}