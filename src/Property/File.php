<?php


namespace Larams\Cms\Property;

use Larams\Cms\Property;
use Larams\Cms\Model\StructureItem;

class File extends Property
{

    /** @var StructureItem $structureItem */
    protected $structureItem;

    public function __construct( StructureItem $structureItem )
    {
        $this->structureItem = $structureItem;
    }

    public function getHtml()
    {

        $configuration = [
            'name' => $this->name,
            'item' => $this->item,
            'hint' => $this->hint,
        ];

        return view('larams::properties.file', $configuration );

    }


    public function getFormData( $formData )
    {

        $fileId = $formData[ $this->name ];

        $shouldDelete = !empty($formData[$this->name . '_delete']);

        if ( empty( $fileId ) || !empty($shouldDelete)) {
            return [];
        }

        $file = $this->structureItem->find( $fileId );

        $return = [
            'id' => $fileId,
            'name' => $file->name,
            'url' => $fileId.'_'.$file->name
        ];

        return $return;
    }

}
