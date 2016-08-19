<?php

namespace Larams\Cms;

class TranslationKeyword extends \Eloquent
{

    protected $table = 'translation_keywords';

    protected $fillable = ['keyword'];

    public function values()
    {
        return $this->hasMany('Larams\Cms\TranslationValue', 'keyword_id');
    }

    public function getLangValueAttribute()
    {

        $items = $this->values()->lists('value', 'language_id');

        return $items;

    }

    public function translations( $locale )
    {
        $language = StructureItem::getModel()->byTypeName('site_lang')->whereData('short_code', $locale )->first();

        if (empty( $language )) {
            return [];
        }

        $translations = $this
            ->leftJoin('translation_values', 'translation_keywords.id', '=', 'translation_values.keyword_id')
            ->where('translation_values.language_id', '=', $language->id )
            ->lists('value', 'keyword');

        return $translations->toArray();
    }

}
