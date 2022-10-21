<?php

namespace Larams\Cms\Property;

use Larams\Cms\Property;
use Larams\Cms\Model\StructureItem;

class StructureItems extends Property
{

    protected $rows = 5;

    protected $cssClass = 'col-xs-6';

    protected $typeName = 'site';

    protected $topLevelId = null;

    protected $childTypeName = null;

    protected $style = null;

    protected $firstLevel = false;

    protected $multiple = false;

    protected $allowEmpty = false;

    protected $sameLanguage = false;

    protected $splitByType = '';

    public function getHtml()
    {

        $structureItems = new StructureItem();

        if (!empty($this->item) && !empty($this->sameLanguage)) {
            $language = $this->item->path( $this->item->left, $this->item->right )->byTypeName('site_lang')->first();
        }

        if (!empty( $this->topLevelId )) {
            $topLevelItem = $structureItems->find( $this->topLevelId );
        } elseif (!empty($this->splitByType)){
            $splitByItem = $structureItems
                          ->byTypeName($this->splitByType)
                          ->path($this->item->left, $this->item->right)
                          ->where('active', 1)
                          ->take(PHP_INT_MAX)
                          ->orderBy('left')
                          ->first();

            $topLevelItem = $structureItems
                            ->byTypeName($this->typeName)
                            ->where('left', '>=', $splitByItem->left )
                            ->where('right', '<=', $splitByItem->right)
                            ->first();

        }else {
            $topLevelItem = $structureItems->byTypeName($this->typeName);

            if (!empty($language)) {
                $topLevelItem = $topLevelItem->where('left', '>=', $language->left)->where('right', '<=', $language->right);
            }

            $topLevelItem = $topLevelItem->first();
        }


        if (!empty($this->firstLevel)) {
            $childs = $structureItems->where('parent_id', $topLevelItem->id);
        } else {
            $childs = $structureItems->where('left', '>', $topLevelItem->left)->where('right', '<', $topLevelItem->right)->orderBy('left');
        }

        if (!empty($this->childTypeName)) {
            $childs = $childs->byTypeName( $this->childTypeName );
        }

        $childs = $childs->get();

        $value = isset($this->item->data->{$this->name}) ? $this->item->data->{$this->name} : null;

        foreach ($childs as $k => &$child) {
            $child->hasChilds = !empty($childs[$k + 1]) && $childs[$k + 1]->level > $child->level;
            $child->selected = !empty($value) && (is_array($value) && in_array($child->id, $value) || (!is_array($value) && $child->id == $value));

            $whitespaces = '';
            $i = 0;
            while ($i < ($child->level - $childs[0]->level)) {
                $whitespaces .= '└ ';
                $i++;
            }

            $child->whitespaces = $whitespaces;

        }

        $configuration = array(
            'cssClass' => $this->cssClass,
            'typeName' => $this->typeName,
            'childTypeName' => $this->childTypeName,
            'style' => $this->style,
            'firstLevel' => $this->firstLevel,
            'sameLanguage' => $this->sameLanguage,
            'multiple' => $this->multiple,
            'allowEmpty' => $this->allowEmpty,
            'item' => $this->item,
            'name' => $this->name,
            'hint' => $this->hint,
            'childs' => $childs
        );

        return view('larams::properties.struct_items', $configuration);

    }
}
