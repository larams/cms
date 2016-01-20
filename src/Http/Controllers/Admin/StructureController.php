<?php

namespace Talandis\Larams\Http\Controllers\Admin;

use Talandis\Larams\StructureItem;
use Talandis\Larams\StructureType;
use Talandis\Larams\Utils;

class StructureController extends Controller
{

    public function getIndex(StructureItem $structureItem, StructureType $structureType, $itemId = null)
    {

        /** @var StructureItem $currentItem */
        if (!empty($itemId)) {
            $currentItem = $structureItem->with('content')->with('type')->find($itemId);
        }

        $topLevelItem = $structureItem->whereNull('parent_id')->first();
        $languages = $structureItem->where('parent_id', $topLevelItem->id)->orderBy('left')->get();

        if (empty($currentItem)) {
            return redirect('admin/structure/index/' . $languages->first()->id);
        }

        if (empty($currentItem)) {
            $this->panic('Cms actions : no items!');
        } else {

            $currentPath = $structureItem->path($currentItem->left, $currentItem->right)->get();;

            if (count($currentPath) == 1) {
                $currentLanguage = $structureItem->where('parent_id', $currentItem->id)->first();
            } else {
                $currentLanguage = $currentPath[1];
            }

            $isDeveloper = true;

            if (!empty($isDeveloper)) {
//                $_path_curr = array_slice($_path_curr, 2);
            }

        }

        $treeChilds = $structureItem->where('parent_id', $currentItem->id)->where('tree', 1)->orderBy('left')->get();
        $extraChilds = $structureItem->where('parent_id', $currentItem->id)->where('tree', 0)->orderBy('left')->get();

        $types = $structureType->orderBy('name_lang')->get();

        $typeConfiguration = array_merge( config('larams.handler'), (array)config('larams.handlers.' . $currentItem->type->handler ), (array)config('handlers.'. $currentItem->type->handler ) );


        $childTypes = $currentItem->type()->first()->types();

        $treeTypes = $childTypes->where('additional', 0)->get();
        $extraTypes = $childTypes->where('additional', 1)->get();

        if (!empty( $typeConfiguration['properties'] )) {

            foreach ( $typeConfiguration['properties'] as &$propertyConfig ) {

                if ( !isset( $propertyConfig['name'])) {
                    throw new \ErrorException('Property doesn\'t have name');
                }

                /** @var \Talandis\Larams\Property $property */
                $property = new $propertyConfig['class'];
                $property->setConfiguration( $propertyConfig );
                $property->setItem( $currentItem );

                $propertyConfig['html'] = $property->getHtml();

            }
        }

        return $this->view('larams::admin.structure.index', compact('currentItem', 'currentPath', 'currentLanguage', 'isDeveloper', 'treeChilds', 'extraChilds', 'types', 'languages', 'treeTypes', 'extraTypes', 'typeConfiguration'));

    }

    public function getActive(StructureItem $structureItem, $itemId, $activeItemId, $status)
    {


        $currentItem = $structureItem->find($activeItemId);
        $currentItem->active = ($status == 1) ? 0 : 1;
        $currentItem->save();

        $structureItem->updateChildUris( $currentItem );


        return redirect('admin/structure/index/' . $itemId);

    }

    public function postAdd(StructureItem $structureItem, $itemId)
    {


        $parentItem = $structureItem->find($itemId);

        $uri = $structureItem->path( $parentItem->left, $parentItem->right )->where('active', 1 )->lists('name')->toArray();
        $uri = array_slice( $uri, 1 );

        $item = array(
            'parent_id' => $itemId,
            'name' => request()->input('name'),
            'uri' => implode('/', array_map( function( $item ) { return Utils::toAscii( $item ); }, $uri ) ) . '/' . Utils::toAscii( request()->input('name') ),
            'tree' => request()->input('tree'),
            'type_id' => request()->input('type_id'),
            'left' => $parentItem->right,
            'right' => $parentItem->right + 1,
            'level' => $parentItem->level + 1,
            'active' => 0
        );

        $structureItem->where('left', '>', $parentItem->right)->increment('left', 2);
        $structureItem->where('right', '>', $parentItem->right - 1)->increment('right', 2);

        $structureItem->create($item);

        return redirect('admin/structure/index/' . $itemId);


    }

    public function getDelete(StructureItem $structureItem, $itemId, $delItemId)
    {

        $item = $structureItem->find($delItemId);
        $item->delete();

        return redirect('admin/structure/index/' . $itemId);

    }

    public function postSave(StructureItem $structureItem, $itemId)
    {

        $item = $structureItem->find($itemId);

        $typeConfiguration = array_merge( config('larams.handler'), (array)config('larams.handlers.' . $item->type->handler ), (array)config('handlers.'. $item->type->handler ) );

        $rawFormData = request()->input();
        $additionalFieldsData = [];

        if (!empty( $typeConfiguration['properties'] )) {

            foreach ( $typeConfiguration['properties'] as &$propertyConfig ) {

                if ( !isset( $propertyConfig['name'])) {
                    throw new \ErrorException('Property doesn\'t have name');
                }

                /** @var \Talandis\Larams\Property $property */
                $property = new $propertyConfig['class'];
                $property->setConfiguration( $propertyConfig );

                $additionalFieldsData[ $propertyConfig['name'] ] = $property->getFormData( $rawFormData['data'] );

            }

        }

        $rawFormData['data'] = $additionalFieldsData;

//        if (empty( $rawFormData['uri']) || $rawFormData['uri'] == $item->uri ) {

        $uri = $structureItem->path( $item->left, $item->right )->where('active', 1 )->lists('name')->toArray();
        $uri = array_slice( $uri, 1 );
        $rawFormData['uri'] = implode('/', array_map( function( $item ) { return Utils::toAscii( $item ); }, $uri ) );
//        }

//        $item->data = $additionalFieldsData;

        $rawFormData['search'] = $rawFormData['name'];

        $item->content()->delete();
        foreach ( $additionalFieldsData as $fieldName => $fieldValue ) {

            if (!is_array($fieldValue)) {
                $rawFormData['search'] .= PHP_EOL.' '.strip_tags( $fieldValue );
            }


            $item->content()->create( array(
                'name' => $fieldName,
                'data' => $fieldValue
            ) );
        }

        $item->fill( $rawFormData )->save();

        // Update child links
        if ( $item->uri != $rawFormData['uri'] ) {
            $structureItem->updateChildUris( $item );
        }

        return redirect('admin/structure/index/' . $itemId);

    }

    public function postSort( StructureItem $structureItem, $parentId )
    {

        $items = request()->input('item');

        $parentItem = $structureItem->where('id', $parentId )->first();

        $itemsWithChilds = [];
        foreach ( $items as $itemId ) {
            $itemsWithChilds[ $itemId ] = $structureItem->find( $itemId );
            $itemsWithChilds[ $itemId ]->childIds = $structureItem->where('left', '>=', $itemsWithChilds[ $itemId ]->left )->where('right', '<=', $itemsWithChilds[ $itemId ]->right )->lists('id');
        }

        $left = $parentItem->left + 1;
        foreach ( $itemsWithChilds as $item ) {

            $positionsDelta = $left - $item->left;
            $positionsDelta = ( $positionsDelta >= 0 ) ? '+'.$positionsDelta : $positionsDelta;

            $structureItem->whereIn('id', $item->childIds )->update([
                'left' => \DB::raw('`left` ' . $positionsDelta ),
                'right' => \DB::raw('`right` '. $positionsDelta )
            ]);

            $left = $item->right + $positionsDelta + 1;
        }

        return response()->json( ['success' => true ] );
    }

    public function getTree(StructureItem $structureItem, $itemId)
    {

        $items = $structureItem->childsOf($itemId)->where('tree', 1)->orderBy('left')->get();

        $response = [];

        foreach ($items as $item) {

            $response[] = [

                'id' => $item->id,
                'parent' => !empty($item->parent_id) && $item->parent_id != $itemId ? $item->parent_id : '#',
                'text' => $item->name,
                'type' => $item->childs()->count() > 0 ? 'folder' : 'file',
                'state' => [
                    'opened' => ($item->level == 1)
                ]
            ];

        }

        return response()->json($response);

    }

}
