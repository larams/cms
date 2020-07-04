<?php

namespace Larams\Cms;

trait HasRelatedModels
{

    public function related()
    {
        $childs = [];

        if (!empty($this->related)) {
            foreach ($this->related as $relationName => $title) {

                $total = $this->{$relationName}->count();

                if ($total > 0) {
                    $childs[$relationName] = [
                        'title' => $title,
                        'key' => $relationName,
                        'total' => $total,
                    ];
                }
            }
        }

        return array_values($childs);
    }
}
