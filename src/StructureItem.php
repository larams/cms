<?php

namespace Talandis\Larams;

//use Illuminate\Database\Eloquent\Model;

/**
 * Class StructureItem
 * @package Talandis\Larams
 *
 * @method static StructureItem forSite( $currentLanguage, $isActive = 1, $inTree = 1 )
 * @method static StructureItem byTypeName( $typeName )
 * @method static StructureItem byParentId( $itemId )
 */

class StructureItem extends \Eloquent
{


    protected $table = 'structure_items';

    protected $fillable = ['id', 'parent_id', 'user_id', 'name', 'date', 'level', 'type_id', 'left', 'right', 'active', 'tree', 'data', 'sort', 'uri'];

    public function type()
    {
        return $this->belongsTo('Talandis\Larams\StructureType', 'type_id');
    }

    public function childs()
    {
        return $this->hasMany('Talandis\Larams\StructureItem', 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo('Talandis\Larams\StructureItem', 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo('Talandis\Larams\User', 'user_id');
    }

    public function childsOf( $itemId )
    {
        $item = $this->find( $itemId );

        return $this->where('left', '>', $item->left )->where('right', '<', $item->right );
    }

    public function path( $left, $right )
    {
        return $this->where('left', '<=', $left )->where('right', '>=', $right );
    }

    public function delete()
    {

        $this->where('left', '>', $this->left )->where('right','<', $this->right )->delete();

        $delta = $this->right - $this->left + 1;

        $this->where('left', '>', $this->left )->decrement('left', $delta );
        $this->where('right', '>', $this->right )->decrement('right', $delta );

        return parent::delete();
    }

    public function setDataAttribute( $data )
    {

        $this->attributes['data'] = json_encode( $data );

    }

    public function getDataAttribute( $data )
    {
        return json_decode( $data );
    }

    /**
     * @param \Eloquent $query
     * @param int $tree
     * @return mixed
     */
    public function scopeForSite( $query, $currentLanguage, $tree = 1, $active = 1 )
    {
        return $query->where('active', $active )->where('tree', $tree )->where('left','>', $currentLanguage->left )->where('right','<', $currentLanguage->right );
    }

    /**
     * @param \Eloquent $query
     * @param $typeName
     * @return mixed
     */
    public function scopeByTypeName( $query, $typeName )
    {
        return $query->leftJoin('structure_types', 'structure_items.type_id','=','structure_types.id')->where('structure_types.name', $typeName )->select('structure_items.*', 'structure_types.name AS type_name');
    }

    /**
     * @param \Eloquent $query
     * @param $parentId
     * @return mixed
     */
    public function scopeByParentId( $query, $parentId )
    {
        return $query->where('parent_id', $parentId );
    }

}
