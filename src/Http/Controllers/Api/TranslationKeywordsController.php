<?php

namespace Larams\Cms\Http\Controllers\Api;

use Larams\Cms\Repository\TranslationKeywords;
use Illuminate\Http\Request;
use Larams\Cms\Model\StructureItem;
use Larams\Cms\Model\TranslationKeyword;

class TranslationKeywordsController extends CrudController
{
    public function __construct(TranslationKeyword $model, TranslationKeywords $repository, Request $request)
    {
        $this->model = $model;
        $this->repository = $repository;

        parent::__construct($request);
    }

    public function updateValueForKeywordForLanguage(Request $request, $keywordId, $languageId)
    {
        $input = $request->input();

        if (!isset($input['value'])) {
            $input['value'] = '';
        }

        $value = $input['value'];

        $this->repository->updateValueForKeywordForLanguage($keywordId, $languageId, $value);
    }

    /**
     * @param Request $request
     * @param TranslationKeyword $translationKeyword
     * @param StructureItem $structureItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request, TranslationKeyword $translationKeyword, StructureItem $structureItem)
    {
        $fileInfo = $request->input('file');
        if (empty($fileInfo) || empty($fileInfo['path'])) {
            app()->abort(500, 'Missing file details');
        }

        $languages = $structureItem->byTypeName('site_lang')->get();
        $languageEnId = null;
        $languageLtId = null;
        foreach ($languages AS $language) {
            if (!empty($language->data) && !empty($language->data->short_code)) {
                switch ($language->data->short_code) {
                    case 'en':
                        $languageEnId = $language->id;
                        break;
                    case 'lt':
                        $languageLtId = $language->id;
                        break;
                }
            }
        }
        if (empty($languageEnId) || empty($languageLtId)) {
            app()->abort(500, 'Missing language');
        }

        $fileFullName = storage_path('uploads/' . $fileInfo['path']);
        $file = file_get_contents($fileFullName);

        $content = new \SimpleXMLElement($file);

        foreach ($content->file->body->{'trans-unit'} as $transUnit) {
            $id = $transUnit['id'];
            $valueLt = trim($transUnit->note);
            $valueEn = trim($transUnit->source);

            $kw = $translationKeyword->where('keyword', $id)->first();
            if (empty($kw)) {
                /** @var TranslationKeyword $kw */
                $kw = $translationKeyword->create(['keyword' => $id]);
                $kw->values()->create(['language_id' => $languageEnId, 'value' => $valueEn]);
                $kw->values()->create(['language_id' => $languageLtId, 'value' => $valueLt]);
            }
        }

        return response()->json(['success' => 1]);
    }
}
