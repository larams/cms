<?php

namespace Larams\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Larams\Cms\StructureItem;
use Larams\Cms\TranslationKeyword;
use Larams\Cms\TranslationValue;
use Larams\Cms\User;

class TranslationsController extends Controller
{

    protected $route = 'translations';

    protected $languageTypeName = 'site_lang';

    public function getIndex( StructureItem $structureItem, TranslationKeyword $keyword, TranslationValue $translationValue )
    {

        $languages = $structureItem->byTypeName( $this->languageTypeName )->orderBy('left')->get();

        $keywords = $keyword;

        /** @var User $user */
        $user = app()->make( config('larams.admin.database_model') )->find( auth(config('larams.admin.guard'))->user()->id );

        if ( $user->isAllowed('admin.translations.view_admin_keywords') ) {
            $keywords = $keywords->where('keyword', 'NOT LIKE', 'admin%');
        }

        $keywords = $keywords->orderBy('keyword')->get();

        $values = $translationValue->getGroupped();

        return $this->view('larams::admin.translations.index', compact('keywords', 'languages', 'values'));

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

        if ( !$request->ajax()) {
            return redirect('admin/' . $this->route );
        } else {
            return response()->json(['success' => true ]);
        }
     }

    public function getDelete( TranslationKeyword $translationKeyword, TranslationValue $translationValue, $id )
    {

        $translationKeyword->where('id', $id )->delete();
        $translationValue->where('keyword_id', $id )->delete();

        return redirect('admin/' . $this->route );

    }
    public function download(TranslationKeyword $translationKeyword, StructureItem $structureItem, $languageId)
    {
        set_time_limit(0);

        $language = $structureItem->find( $languageId);

        $keywords = $translationKeyword
            ->where('keyword', 'NOT LIKE', 'admin%')
            ->with('values')
            ->get();


        $input = [
            'file' => [
                '@attributes' => [
                    'source-lang' => 'en',
                    'datatype' => 'plaintext',
                    'original' => 'ng2.template'
                ],
                'body' => [],
            ],
            '@attributes' => [
                'version' => '1.2',
                'xmlns' => 'urn:oasis:names:tc:xliff:document:1.2'
            ]
        ];

        foreach ($keywords as $keyword) {
            $input['file']['body'][] = [
                '@name' => 'trans-unit',
                '@attributes' => [
                    'id' => $keyword->keyword,
                    'datatype' => 'html'
                ],
                'target' => $keyword->lang_value[ $languageId ]
            ];
        }


        $formatter = Formatter::make($input, Formatter::ARR);

        $tmpFile = tempnam( storage_path(), 'xlf');
        file_put_contents($tmpFile, $formatter->toXml('xliff') );

        return response()->download( $tmpFile, 'messages.'. (!empty($language->data->short_code) ? $language->data->short_code : '__') . '.xlf' );
    }

    public function upload( Request $request, TranslationKeyword $translationKeyword, TranslationValue $translationValue )
    {
        $file = $request->file('file');

        $content = new \SimpleXMLElement( $file->get() );

        foreach ( $content->file->body->{'trans-unit'} as $transUnit ) {

            $id = $transUnit['id'];
            $valueLt = $transUnit->note;
            $valueEn = $transUnit->source;

            $kw = $translationKeyword->where('keyword', $id )->first();
            if (empty($kw)) {
                /** @var TranslationKeyword $kw */
                $kw = $translationKeyword->create(['keyword' => $id]);
                $kw->values()->create([ 'language_id' => 3, 'value' => $valueEn ]);
                $kw->values()->create([ 'language_id' => 6, 'value' => $valueLt ]);
            }
        }

        return redirect()->back();
    }
}
