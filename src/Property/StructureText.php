<?php

namespace Larams\Cms\Property;

use Larams\Cms\Property;
use Larams\Cms\Model\StructureItem;

class StructureText extends Property
{

    protected $inputWidthClass = 'col-xs-12';

    protected $typeName = '';

    protected $parentTypeName = '';

    protected $splitByType = '';

    /** @var StructureItem */
    protected $structureItem;

    public function __construct(StructureItem $structureItem)
    {
        $this->structureItem = $structureItem;
    }

    public function getHtml()
    {

        if (!empty($this->parentTypeName)) {
            $items = $this->structureItem->byParentTypeName($this->parentTypeName);
        } elseif (!empty($this->typeName)) {
            $items = $this->structureItem->byTypeName($this->typeName);
        }

        if (!empty($this->splitByType)) {
            $topItem = $this->structureItem
                ->byTypeName($this->splitByType)
                ->path($this->item->left, $this->item->right)
                ->where('active', 1)
                ->take(PHP_INT_MAX)
                ->orderBy('left')
                ->first();
            $items = $items->childsOf($topItem->id);
        }

        $items = $items->orderBy('left')->get();

        $configuration = array(
            'typeName' => $this->typeName,
            'parentTypeName' => $this->parentTypeName,
            'inputWidthClass' => $this->inputWidthClass,
            'item' => $this->item,
            'name' => $this->name,
            'items' => $items,
            'hint' => $this->hint,
        );

        return view('larams::properties.struct_text', $configuration);

    }
}
