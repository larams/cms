<?php

namespace Larams\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Larams\Cms\ActionLog;
use Larams\Cms\StructureItem;
use Larams\Cms\StructureType;
use Larams\Cms\Utils;

class StructureController extends Controller
{

    protected $route = 'structure';

    public function getIndex(StructureItem $structureItem, StructureType $structureType, $itemId = null)
    {

        /** @var StructureItem $currentItem */
        if (!empty($itemId)) {
            $currentItem = $structureItem->with('content')->with('type')->find($itemId);
        }

        $topLevelItem = $structureItem->whereNull('parent_id')->first();
        $languages = $structureItem->where('parent_id', $topLevelItem->id)->orderBy('left')->get();

        if (empty($currentItem)) {
            return redirect('admin/' . $this->route . '/index/' . $languages->first()->id);
        }

        if (empty($currentItem)) {
            $this->panic('Cms actions : no items!');
        } else {

            $currentPath = $structureItem->path($currentItem->left, $currentItem->right)->orderBy('left')->get();;

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

        $typeConfiguration = array_merge(config('larams.handler'), (array)config('larams.handlers.' . $currentItem->type->handler), (array)config('handlers.' . $currentItem->type->handler));

        $treeChilds = $structureItem->where('parent_id', $currentItem->id)->where('tree', 1);
        $extraChilds = $structureItem->where('parent_id', $currentItem->id)->where('tree', 0);

        if (!empty($typeConfiguration['child_tree_sort_column'])) {
            if (!empty($typeConfiguration['child_tree_sort_type']) && $typeConfiguration['child_tree_sort_type'] == 'DATA') {
                $treeChilds = $treeChilds->orderByData($typeConfiguration['child_tree_sort_column'], !empty($typeConfiguration['child_tree_sort_direction']) ? $typeConfiguration['child_tree_sort_direction'] : 'ASC');
            } else {
                $treeChilds = $treeChilds->orderBy($typeConfiguration['child_tree_sort_column'], !empty($typeConfiguration['child_tree_sort_direction']) ? $typeConfiguration['child_tree_sort_direction'] : 'ASC');
            }
        } else {
            $treeChilds = $treeChilds->orderBy('left');
        }

        if (!empty($typeConfiguration['child_sort_column'])) {
            if (!empty($typeConfiguration['child_sort_type']) && $typeConfiguration['child_sort_type'] == 'DATA') {
                $extraChilds = $extraChilds->orderByData($typeConfiguration['child_sort_column'], !empty($typeConfiguration['child_sort_direction']) ? $typeConfiguration['child_sort_direction'] : 'ASC');
            } else {
                $extraChilds = $extraChilds->orderBy($typeConfiguration['child_sort_column'], !empty($typeConfiguration['child_sort_direction']) ? $typeConfiguration['child_sort_direction'] : 'ASC');
            }
        } else {
            $extraChilds = $extraChilds->orderBy('left');
        }


        $treeChilds = $treeChilds->get();
        $extraChilds = $extraChilds->get();

        $types = $structureType->orderBy('name_lang')->get();

        $treeTypes = $currentItem->type()->first()->types()->where('additional', 0)->get();
        $extraTypes = $currentItem->type()->first()->types()->where('additional', 1)->get();

        if (!empty($typeConfiguration['properties'])) {

            foreach ($typeConfiguration['properties'] as &$propertyConfig) {

                if (!isset($propertyConfig['name'])) {
                    throw new \ErrorException('Property doesn\'t have name');
                }

                /** @var \Larams\Cms\Property $property */
                $property = new $propertyConfig['class']($structureItem);
                $property->setConfiguration($propertyConfig);
                $property->setItem($currentItem);

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

        ActionLog::log($activeItemId, 'STRUCTURE', 'Change element status to ' . $currentItem->active);

        $structureItem->updateChildUris($currentItem);

        return redirect('admin/' . $this->route . '/index/' . $itemId);

    }

    public function postAdd(StructureItem $structureItem, $itemId, $prepend = false)
    {

        $parentItem = $structureItem->find($itemId);

        $item = array(
            'parent_id' => $itemId,
            'name' => request()->input('name'),
            'uri' => trim($parentItem->full_uri . '/' . Utils::toAscii(request()->input('name')), '/'),
            'tree' => request()->input('tree'),
            'type_id' => request()->input('type_id'),
            'left' => $prepend ? $parentItem->left + 1 : $parentItem->right,
            'right' => $prepend ? $parentItem->left + 2 : ($parentItem->right + 1),
            'level' => $parentItem->level + 1,
            'active' => 0
        );

        if ($prepend) {
            ActionLog::log($parentItem->id, 'STRUCTURE', "Increment left/right by 2 where left > {$parentItem->left}, right > {$parentItem->left}");
            $structureItem->where('left', '>', $parentItem->left)->increment('left', 2);
            $structureItem->where('right', '>', $parentItem->left)->increment('right', 2);
        } else {
            ActionLog::log($parentItem->id, 'STRUCTURE', "Increment left/right by 2 where left > {$parentItem->left}, right > " . ($parentItem->right - 1));
            $structureItem->where('left', '>', $parentItem->right)->increment('left', 2);
            $structureItem->where('right', '>', $parentItem->right - 1)->increment('right', 2);
        }

        ActionLog::log($itemId, 'STRUCTURE', 'Create new element', $item);
        $item = $structureItem->create($item);

        return redirect('admin/' . $this->route . '/index/' . $item->id);


    }

    public function getDelete(StructureItem $structureItem, $itemId, $delItemId)
    {

        $item = $structureItem->find($delItemId);
        $item->delete();

        ActionLog::log($itemId, 'STRUCTURE', 'Delete element', $item);

        return response('OK');

    }

    public function postSave(StructureItem $structureItem, $itemId)
    {

        $item = $structureItem->find($itemId);

        $typeConfiguration = array_merge(config('larams.handler'), (array)config('larams.handlers.' . $item->type->handler), (array)config('handlers.' . $item->type->handler));

        $rawFormData = request()->input();
        $additionalFieldsData = [];

        if (!empty($typeConfiguration['properties'])) {

            foreach ($typeConfiguration['properties'] as &$propertyConfig) {

                if (!isset($propertyConfig['name'])) {
                    throw new \ErrorException('Property doesn\'t have name');
                }

                /** @var \Larams\Cms\Property $property */
                $property = new $propertyConfig['class']($structureItem);
                $property->setConfiguration($propertyConfig);

                $additionalFieldsData[$propertyConfig['name']] = $property->getFormData($rawFormData['data']);

            }

        }

        $rawFormData['data'] = $additionalFieldsData;

        if ( empty( $rawFormData['custom_uri']) || substr($rawFormData['custom_uri'], 0, 1) !== '/') {

            $pageUri = !empty($rawFormData['custom_uri']) ? $rawFormData['custom_uri'] : Utils::toAscii($rawFormData['name']);

            $iteration = 1;
            do {
                $uri = trim((!empty($item->parent) ? $item->parent->full_uri . '/' : '') . $pageUri, '/');

                if ($iteration > 1) {
                    $uri .= '-' . $iteration;
                }

                $elementWithUri = $structureItem->where('uri', $uri)->where('id', '!=', $item->id)->first();
                $iteration++;
            } while (!empty($elementWithUri));

            $rawFormData['uri'] = $uri;
        } else {
            $rawFormData['uri'] = substr($rawFormData['custom_uri'], 1);
        }

        $rawFormData['search'] = $rawFormData['name'];

        $item->content()->delete();
        foreach ($additionalFieldsData as $fieldName => $fieldValue) {

            if (!is_array($fieldValue)) {
                $rawFormData['search'] .= PHP_EOL . ' ' . strip_tags($fieldValue);
            }


            $item->content()->create(array(
                'name' => $fieldName,
                'data' => $fieldValue
            ));
        }

        $item->fill($rawFormData)->save();

        ActionLog::log($item->id, 'STRUCTURE', 'Save element', $rawFormData);

        // Update child links
        $structureItem->updateChildUris($item);

        if (!empty($typeConfiguration['redirect_to_parent'])) {
            return redirect('admin/' . $this->route . '/index/' . (!empty($item->parent_id) ? $item->parent_id : $item->id));
        }

        return redirect('admin/' . $this->route . '/index/' . $itemId);

    }

    public function postSort(StructureItem $structureItem, $parentId)
    {

        $items = request()->input('item');

        $parentItem = $structureItem->where('id', $parentId)->first();

        $itemsWithChilds = [];
        foreach ($items as $itemId) {
            $itemsWithChilds[$itemId] = $structureItem->find($itemId);
            $itemsWithChilds[$itemId]->childIds = $structureItem->where('left', '>=', $itemsWithChilds[$itemId]->left)->where('right', '<=', $itemsWithChilds[$itemId]->right)->pluck('id');
        }

        ActionLog::log(null, 'STRUCTURE', 'Sort', $items);

        $left = $parentItem->left + 1;
        foreach ($itemsWithChilds as $item) {

            $positionsDelta = $left - $item->left;
            $positionsDelta = ($positionsDelta >= 0) ? '+' . $positionsDelta : $positionsDelta;

            $structureItem->whereIn('id', $item->childIds)->update([
                'left' => \DB::raw('`left` ' . $positionsDelta),
                'right' => \DB::raw('`right` ' . $positionsDelta)
            ]);

            ActionLog::log($item->id, 'STRUCTURE', 'Update left/right by ' . $positionsDelta, $item->childIds);

            $left = $item->right + $positionsDelta + 1;
        }

        return response()->json(['success' => true]);
    }

    public function getTree(StructureItem $structureItem, $itemId)
    {

        $items = $structureItem->with('parent')->childsOf($itemId)->where('tree', 1)->orderBy('left')->get();
        $childsCounts = $structureItem->select([\DB::raw('COUNT( id ) as childs'), 'parent_id'])->groupBy('parent_id')->pluck('childs', 'parent_id');

        $response = [];

        foreach ($items as $item) {

            // @todo: Skip also those items that has more parents not in tree
            if (empty($item->parent->tree)) {
                continue;
            }

            $response[] = [

                'id' => $item->id,
                'parent' => !empty($item->parent_id) && $item->parent_id != $itemId ? $item->parent_id : '#',
                'text' => $item->name,
                'type' => !empty($childsCounts[$item->id]) ? 'folder' : 'file',
                'state' => [
                    'opened' => ($item->level == 1)
                ]
            ];

        }

        return response()->json($response);

    }

    public function postMove(StructureItem $structureItem, Request $request)
    {

        $data = $request->input();
        $element = $structureItem->find($data['id']);
        $language = $structureItem->path($element->left, $element->right)->offset(1)->take(1)->first();

        if ($data['parent'] == '#') {
            $data['parent'] = str_replace('#', $language->id, $data['parent']);
        }

        $element->move($data['parent'], $data['position']);

        ActionLog::log( $element->id, 'STRUCTURE', 'Move to parent:' . $data['parent']. ' position:'.$data['position'] );

        return response()->json(['success' => true]);

    }

    public function getRebuildTree(StructureItem $structureItem)
    {
        $structureItem->rebuildTree();
    }

}
