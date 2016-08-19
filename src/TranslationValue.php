<?php

namespace Larams\Cms;

class TranslationValue extends \Eloquent
{

    protected $table = 'translation_values';

    protected $fillable = ['keyword_id', 'language_id', 'value'];

}
