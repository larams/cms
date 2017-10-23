<?php namespace Larams\Cms\Translations;

use Illuminate\Translation\LoaderInterface;
use Larams\Cms\TranslationKeyword;

class DatabaseLoader implements LoaderInterface
{
    /** @var TranslationKeyword $translationKeyword */
    protected $translationKeyword;

    public function __construct( TranslationKeyword $translationKeyword)
    {
        $this->translationKeyword = $translationKeyword;
    }

    public function load($locale, $group, $namespace = null)
    {
        return $this->translationKeyword->translations( $locale, $group, $namespace );
    }

    /**
     *  Add a new namespace to the loader.
     *
     *  @param  string  $namespace
     *  @param  string  $hint
     *  @return void
     */
    public function addNamespace($namespace, $hint)
    {
//        $this->hints[$namespace] = $hint;
    }

    public function namespaces()
    {
        return [];
    }
}