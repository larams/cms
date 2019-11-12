<?php

namespace Larams\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Larams\Cms\Redirect;
use Larams\Cms\StructureItem;
use Larams\Cms\TranslationKeyword;
use Larams\Cms\TranslationValue;
use Larams\Cms\User;

class RedirectsController extends Controller
{

    protected $route = 'redirects';

    public function getIndex(Redirect $redirect)
    {

        $items = $redirect->orderBy('position')->get();
        return $this->view('larams::admin.redirects.index', compact('items'));

    }

    public function getAdd()
    {

        return $this->view('larams::admin.redirects.edit');

    }

    public function getEdit(TranslationKeyword $translationKeyword, TranslationValue $translationValue, StructureItem $structureItem, $id)
    {

        $keyword = $translationKeyword->find($id);

        $values = $translationValue->where('keyword_id', $id)->get()->keyBy('language_id');

        $languages = $structureItem->byTypeName($this->languageTypeName)->orderBy('left')->get();

        return $this->view('larams::admin.redirects.edit', compact('values', 'keyword', 'languages', 'id'));

    }

    public function postSave(Redirect $redirect, Request $request, $id)
    {
        $data = $request->input();

        if (!empty($id)) {
            $item = $redirect->find($id);
            $item->fill( $data );
            $item->save();
        } else {
            $item = $redirect->create([
                'from_url' => $data['from_url'],
                'to_url' => $data['to_url']
            ]);
        }

        if (!$request->ajax()) {
            return redirect('admin/' . $this->route);
        } else {
            return response()->json(['success' => true]);
        }
    }

    public function getDelete(TranslationKeyword $translationKeyword, TranslationValue $translationValue, $id)
    {

        $translationKeyword->where('id', $id)->delete();
        $translationValue->where('keyword_id', $id)->delete();

        return redirect('admin/' . $this->route);

    }
}
