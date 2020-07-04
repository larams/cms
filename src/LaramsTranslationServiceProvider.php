<?php

namespace Larams\Cms;


use Illuminate\Translation\TranslationServiceProvider;
use Larams\Cms\Model\TranslationKeyword;
use Larams\Cms\Translations\DatabaseLoader;

class LaramsTranslationServiceProvider extends TranslationServiceProvider
{
    /**
     * Register the translation line loader.
     *
     * @return void
     */
    protected function registerLoader()
    {
        if (config('larams.translations')) {
            $this->app->singleton('translation.loader', function () {
                return new DatabaseLoader(new TranslationKeyword());
            });
        } else {
            parent::registerLoader();
        }
    }
}
