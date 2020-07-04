<?php namespace Larams\Cms\Translations;

use Illuminate\Contracts\Translation\Loader as LoaderInterface;
use Larams\Cms\Model\TranslationKeyword;

class DatabaseLoader implements LoaderInterface
{
    /** @var TranslationKeyword $translationKeyword */
    protected $translationKeyword;

    public function __construct(TranslationKeyword $translationKeyword)
    {
        $this->translationKeyword = $translationKeyword;
    }

    public function load($locale, $group, $namespace = null)
    {
        return $this->translationKeyword->translations($locale, $group, $namespace);
    }

    /**
     *  Add a new namespace to the loader.
     *
     * @param  string $namespace
     * @param  string $hint
     * @return void
     */
    public function addNamespace($namespace, $hint)
    {
//        $this->hints[$namespace] = $hint;
    }

    public function namespaces()
    {
        return [];
    }

    /**
     * Add a new JSON path to the loader.
     *
     * @param  string $path
     * @return void
     */
    public function addJsonPath($path)
    {
        //
    }
}
