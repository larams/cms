<?php

namespace Larams\Cms\Property;

use Larams\Cms\Property;
use Larams\Cms\StructureItem;

class StructureText extends Property
{

    protected $inputWidthClass = 'col-xs-12';

    protected $typeName = '';

    protected $parentTypeName = '';

    protected $sameLanding = false;

    /** @var StructureItem */
    protected $structureItem;

    public function __construct( StructureItem $structureItem )
    {
        $this->structureItem = $structureItem;
    }

    public function getHtml()
    {

        if (!empty( $this->parentTypeName )) {
            $items = $this->structureItem->byParentTypeName( $this->parentTypeName );
        } elseif (!empty( $this->typeName )) {
            $items = $this->structureItem->byTypeName( $this->typeName );
        }

        if (!empty( $this->sameLanding )) {
            $topItem = $this->structureItem->path( $this->item->left, $this->item->right )->where('active', 1)->take( PHP_INT_MAX )->orderBy('left')->offset( 1 )->first();
            $items = $items->childsOf( $topItem->id );
        }

        $items = $items->orderBy('left')->get();

        $configuration = array(
            'typeName' => $this->typeName,
            'parentTypeName' => $this->parentTypeName,
            'inputWidthClass' => $this->inputWidthClass,
            'item' => $this->item,
            'name' => $this->name,
            'items' => $items
        );

        return view('larams::properties.struct_text', $configuration);

    }
}