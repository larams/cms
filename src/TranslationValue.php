<?php

namespace Larams\Cms;

class TranslationValue extends \Eloquent
{

    protected $table = 'translation_values';

    protected $fillable = ['keyword_id', 'language_id', 'value'];

    public function getGroupped()
    {
        $values = $this->get();

        $output = [];
        foreach ($values as $value) {
            $output[$value->keyword_id][$value->language_id] = $value->value;
        }

        return $output;
    }
}
