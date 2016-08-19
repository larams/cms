<?php

namespace Larams\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Larams\Cms\StructureItem;
use Larams\Cms\TranslationKeyword;
use Larams\Cms\TranslationValue;

class TranslationsController extends Controller
{

    protected $route = 'translations';

    protected $languageTypeName = 'site_lang';

    public function getIndex( StructureItem $structureItem, TranslationKeyword $keyword )
    {

        $languages = $structureItem->byTypeName( $this->languageTypeName )->orderBy('left')->get();

        $keywords = $keyword->get();

        return $this->view('larams::admin.translations.index', compact('keywords', 'languages'));

    }

    public function postAdd( TranslationKeyword $keyword, Request $request )
    {

        $k = $keyword->create( [
            'keyword' => $request->get('title')
        ]);

        return redirect('admin/'.$this->route.'/edit/'. $k->id );

    }

    public function getEdit( TranslationKeyword $translationKeyword, TranslationValue $translationValue, StructureItem $structureItem, $id  )
    {

        $keyword = $translationKeyword->find( $id );

        $values = $translationValue->where('keyword_id', $id )->get()->keyBy('language_id');

        $languages = $structureItem->byTypeName( $this->languageTypeName )->orderBy('left')->get();

        return $this->view('larams::admin.translations.edit', compact('values', 'keyword', 'languages', 'id') );

    }

    public function postSave( TranslationValue $translationValue, Request $request, $id  )
    {

        $values = $request->input('language');

        foreach ( $values as $languageId => $value ) {

            $storedValue = $translationValue->where('language_id', $languageId )->where('keyword_id', $id )->first();

            if (empty( $storedValue )) {
                $translationValue->create( [
                    'language_id' => $languageId,
                    'keyword_id' => $id,
                    'value' => $value
                ]);
            } else {
                $storedValue->value = $value;
                $storedValue->save();
            }
        }

        return redirect('admin/' . $this->route );
    }

    public function getDelete( TranslationKeyword $translationKeyword, TranslationValue $translationValue, $id )
    {

        $translationKeyword->where('id', $id )->delete();
        $translationValue->where('keyword_id', $id )->delete();

        return redirect('admin/' . $this->route );

    }

}
