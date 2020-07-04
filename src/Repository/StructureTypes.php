<?php

namespace Larams\Cms\Repository;

use Larams\Cms\Repository;
use Larams\Cms\Model\StructureItem;
use Larams\Cms\Model\StructureType;

class StructureTypes extends Repository
{
    /** @var StructureItem */
    protected $model;

    public function __construct(StructureType $model)
    {
        $this->model = $model;
    }

    public function update($model, $input)
    {
        $model = parent::update($model, $input);

        $this->syncRelations($model, $input);
    }

    protected function syncRelations($model, $input)
    {
        $relationsArray = [];

        if (isset($input['additionals']) && count($input['additionals']) > 0) {
            foreach ($input['additionals'] as $additional => $relTypeIds) {
                foreach ($relTypeIds as $relTypeId) {
                    $relationsArray[] = [
                        'rel_type_id' => $relTypeId,
                        'additional' => $additional,
                    ];
                }
            }
        }

        $model->types()->sync($relationsArray);
    }

    public function create($input)
    {
        $model = parent::create($input);

        $this->syncRelations($model, $input);

        return $model;
    }

}
