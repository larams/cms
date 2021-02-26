<?php

namespace Larams\Cms\Model;

use Illuminate\Database\Eloquent\Model;

class TranslationKeyword extends Model
{

    protected $table = 'translation_keywords';

    protected $languageColumnName = 'language_id';

    protected $fillable = ['keyword'];

    protected $translations = [];

    public function values()
    {
        return $this->hasMany(TranslationValue::class, 'keyword_id');
    }

    public function getLangValueAttribute()
    {
        return $this->values()->pluck('value', 'language_id');
    }

    public function identifyLanguageFromLocale($locale)
    {
        /** @var StructureItem $structureItems */
        $structureItems = StructureItem::getModel();
        $currentSite = $structureItems->currSite();

        $language = $structureItems
            ->byTypeName('site_lang')
            ->whereData('short_code', $locale)
            ->orderBy('left', 'ASC');

        if (!empty($currentSite)) {
            $language = $language->childsOf($currentSite->id);
        }

        $language = $language->first();

        if (empty($language)) {
            return [];
        }

        return $language->id;
    }

    public function translations($locale, $group, $namespace = null)
    {
        if (empty($this->translations[$locale])) {

            $languageId = $this->identifyLanguageFromLocale($locale);

            $this->translations[$locale] = $this
                ->leftJoin('translation_values', 'translation_keywords.id', '=', 'translation_values.keyword_id')
                ->where('translation_values.' . $this->languageColumnName, '=', $languageId)
                ->where('translation_values.value', '!=', '')
                ->pluck('value', 'keyword');
        }

        $output = [];
        foreach ($this->translations[$locale] as $k => $v) {
            if ($group != '*' && !preg_match('/^' . preg_quote($group) . '/si', $k)) {
                continue;
            }

            if ($group != '*') {
                $k = preg_replace('#' . $group . '(\.|/)#si', '', $k);
            }

            $keys = explode('/', $k);
            $lastKey = $k;

            if (count($keys) > 1) {

                $firstKey = true;
                $res = [];
                while (count($keys) > 1) {
                    $key = array_pop($keys);

                    if ($firstKey) {
                        $res[$key] = $v;
                        $firstKey = false;
                    } else {
                        $res = [$key => $res];
                    }
                }

                $lastKey = reset($keys);
            } else {
                $res = $v;
            }

            if (isset($output[$lastKey]) && is_array($output[$lastKey])) {
                $output[$lastKey] = array_merge($output[$lastKey], $res);
            } else {
                $output[$lastKey] = $res;
            }
        }

        return $output;
    }
}
