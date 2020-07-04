<?php

namespace Larams\Cms\Repository;

use Larams\Cms\Model\User;
use Larams\Cms\Repository;
use Larams\Cms\Model\TranslationKeyword;
use Larams\Cms\Model\TranslationValue;

class TranslationKeywords extends Repository
{
    /** @var TranslationKeyword $model */
    protected $model;

    /** @var User $user */
    protected $user;

    /** @var TranslationValue $translationValue */
    protected $translationValue;

    public function __construct(TranslationKeyword $model, User $user, TranslationValue $translationValue)
    {
        $this->model = $model;
        $this->user = $user;
        $this->translationValue = $translationValue;
    }

    public function buildQuery($params)
    {
        $query = parent::buildQuery($params);

        /*
         * define keywords visible
         */
        $user = null;
        if (!empty($params['authorized_user_id'])) {
            $user = $this->user->find($params['authorized_user_id']);
        }

        if (empty($user) || !$user->isAllowed('admin.translations.view_admin_keywords')) {
            $query = $query->where('keyword', 'NOT LIKE', 'admin%');
        }

        return $query;
    }

    public function update($model, $input)
    {
        $model = parent::update($model, $input);

        $this->syncValues($model->id, $input);

        return $model;
    }

    public function create($input)
    {
        $model = parent::create($input);

        $this->syncValues($model->id, $input);

        return $model;
    }

    /**
     * @param $id
     * @param null $authorizedUserId
     * @throws \App\Exceptions\AppException
     */
    public function delete($id, $authorizedUserId = null)
    {
        parent::delete($id, $authorizedUserId);

        $this->syncValues($id, []);
    }

    protected function syncValues($modelId, $input)
    {
        if (isset($input['lang_value']) && count($input['lang_value']) > 0) {
            foreach ($input['lang_value'] as $languageId => $value) {
                $this->updateValueForKeywordForLanguage($modelId, $languageId, $value);
            }

        } else {
            $this->translationValue
                ->where('keyword_id', $modelId)
                ->delete();
        }
    }

    public function updateValueForKeywordForLanguage($modelId, $languageId, $value) {
        $storedValue = $this->translationValue
            ->where('language_id', $languageId)
            ->where('keyword_id', $modelId)
            ->first();

        if (empty($storedValue)) {
            $this->translationValue->create([
                'language_id' => $languageId,
                'keyword_id' => $modelId,
                'value' => $value
            ]);
        } else {
            $storedValue->value = $value;
            $storedValue->save();
        }
    }
}
