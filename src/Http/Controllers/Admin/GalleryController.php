<?php

namespace Larams\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Larams\Cms\Model\StructureItem;
use Larams\Cms\Model\StructureType;

class GalleryController extends StructureController
{

    protected $route = 'gallery';

    public function getIndex(StructureItem $structureItem, StructureType $structureType, $itemId = null, $select = 0, $target = null)
    {

        /** @var StructureItem $currentItem */
        if (!empty($itemId)) {
            $currentItem = $structureItem->with('type')->find($itemId);
        } else {
            $mediaGalleryType = $structureType->where('name', 'cms.gallery')->first();
            $currentItem = $structureItem->where('type_id', $mediaGalleryType->id)->with('type')->first();
        }

        if (empty($currentItem)) {
            $this->panic('Cms actions : no items!');
        } else {
            $currentPath = $structureItem->path($currentItem->left, $currentItem->right)->get();;
            $folders = $structureItem->where('parent_id', $currentItem->id)->where('tree', 1)->orderBy('left')->get();
            $files = $structureItem->where('parent_id', $currentItem->id)->where('tree', 0)->orderBy('left')->get();
        }

        $CKEditor = request()->input('CKEditor', null);
        $CKEditorFuncNum = request()->input('CKEditorFuncNum', null);

        if (!empty($select)) {
            \View::share('hideNavigationBar', true);
        }

        return $this->view('larams::admin.gallery.index', compact('currentItem', 'currentPath', 'folders', 'files', 'target', 'select', 'CKEditor', 'CKEditorFuncNum'));

    }

    public function postSaveFolder(StructureItem $structureItem, StructureType $structureType, $itemId)
    {

        $folderName = request()->input('folder');

        if (!empty($folderName)) {

            $parentItem = $structureItem->find($itemId);

            $type = $structureType->where('name', 'cms.media_folder')->first();

            $item = [
                'parent_id' => $itemId,
                'name' => $folderName,
                'tree' => 1,
                'type_id' => $type->id,
                'left' => $parentItem->right,
                'right' => $parentItem->right + 1,
                'level' => $parentItem->level + 1,
                'active' => 1
            ];

            $structureItem->where('left', '>', $parentItem->right)->increment('left', 2);
            $structureItem->where('right', '>', $parentItem->right - 1)->increment('right', 2);

            $structureItem->create($item);

        }


        return redirect('admin/'.$this->route.'/index/' . $itemId);

    }

    public function getDelete(StructureItem $structureItem, $itemId, $delItemId)
    {
        /** @var StructureItem $item */
        $item = $structureItem->find($delItemId);

        if (!empty( $item->data->name )) {
            $item->removeFile( $item->data->name );
        }

        $item->delete();

        return redirect('admin/'.$this->route.'/index/' . $itemId);

    }

    public function anyUpload(StructureItem $structureItem, StructureType $structureType, $itemId)
    {

        $file = request()->file('file');
        $storedFileName = uniqid('larams_');

		$originalName = $file->getClientOriginalName();
		$originalExtension = $file->getClientOriginalExtension();
		$clientMimeType = $file->getClientMimeType();
		$clientSize = $file->getClientSize();

        $uploadSuccess = $file->move(storage_path('uploads'), $storedFileName);

        $parentItem = $structureItem->find($itemId);

        $type = $structureType->where('name', 'cms.media_file')->first();

        if ( $originalExtension != 'php') {

            $item = [
                'parent_id' => $itemId,
                'name' => $originalName,
                'tree' => 0,
                'type_id' => $type->id,
                'left' => $parentItem->right,
                'right' => $parentItem->right + 1,
                'level' => $parentItem->level + 1,
                'active' => 1,
            ];

            $structureItem->where('left', '>', $parentItem->right)->increment('left', 2);
            $structureItem->where('right', '>', $parentItem->right - 1)->increment('right', 2);

            $item = $structureItem->create($item);

            $data = [
                'name' => $storedFileName,
                'is_file' => (int)(strpos($clientMimeType, 'image') === false),
                'is_svg' => (int)(strpos($clientMimeType, 'svg') !== false),
                'type' => $clientMimeType,
                'size' => $clientSize,
                'extension' => $originalExtension
            ];

            foreach ($data as $fieldName => $fieldValue) {
                $item->content()->create(array(
                    'name' => $fieldName,
                    'data' => $fieldValue
                ));
            }
        }

        if ($uploadSuccess) {
            return response($item);
        } else {
            return response('error', 400);
        }
    }


    public function postMove( StructureItem $structureItem, Request $request )
    {

        $data = $request->input();

        $element = $structureItem->find( $data['id']);
        $element->move( $data['parent_id'], $data['position'] );

        return response()->json( [ 'success' => true ] );

    }

}
