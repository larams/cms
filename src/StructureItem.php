<?php

namespace Talandis\Larams;

//use Illuminate\Database\Eloquent\Model;

/**
 * Class StructureItem
 * @package Talandis\Larams
 *
 * @method static StructureItem forLang( $currentLanguage, $isActive = 1, $inTree = 1 )
 * @method static StructureItem byTypeName( $typeName )
 * @method static StructureItem byParentId( $itemId )
 * @method static StructureItem whereData( $key, $value )
 * @method static StructureItem byId( $itemId )
 */

class StructureItem extends \Eloquent
{


    protected $table = 'structure_items';

    protected $fillable = ['id', 'parent_id', 'user_id', 'name', 'date', 'level', 'type_id', 'left', 'right', 'active', 'tree', 'sort', 'uri'];

    protected $appends = ['data'];

    protected $hidden = ['content'];

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

    public function content()
    {
        return $this->hasMany('Talandis\Larams\StructureData', 'item_id');
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

    public function getDataAttribute()
    {

        if ( !isset( $this->content )) {
            $this->content = $this->content()->get();
        }

        return (object)$this->content->lists('data', 'name')->toArray();
    }

    /**
     * @param \Eloquent $query
     * @param int $tree
     * @return mixed
     */
    public function scopeForLang( $query, $currLang, $isActive = 1, $inTree = 1 )
    {
        return $query->where('active', $isActive )->where('tree', $inTree )->where('left','>', $currLang->left )->where('right','<', $currLang->right );
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
     * @param $key
     * @param null $value
     * @return mixed
     */
    public function scopeWhereData( $query, $key, $value = null )
    {
        return $query->leftJoin('structure_data', 'structure_items.id','=','structure_data.item_id')
                    ->where('structure_data.name', $key )
                    ->where('structure_data.data', $value )
                    ->select( ['structure_items.*'])
                    ;
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

    public function scopeById( $query, $id )
    {
        return $query->where('id', $id );
    }

    public function updateChildUris( $item )
    {

        $childs = $this->where('left', '>', $item->left )->where('right', '<', $item->right )->get();

        foreach ( $childs as $child ) {
            $uri = $this->path( $child->left, $child->right )->where('active', 1 )->lists('name')->toArray();
            $uri = array_slice( $uri, 1 );
            $uri = implode('/', array_map( function( $item ) { return Utils::toAscii( $item ); }, $uri ) );

            $child->uri = $uri;
            $child->save();
        }

    }

}
