<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ClassificationRepositoryInterface;
use App\Http\Resources\GroupResource;
use App\Models\Classification;

class ClassificationRepository extends BaseRepository implements ClassificationRepositoryInterface
{
    public function __construct(Classification $model)
    {
        parent::__construct($model);
    }

    public function getGroups()
    {
        $classifications = Classification::with(['groups' => function ($query) {
            $query->limit(4);
        }])->get();
        $response = [];

        foreach ($classifications as $classification) {
            if ($classification->groups->isNotEmpty()) {
                $response[] = [
                    'classification_id' => $classification->id,
                    'classification_name' => $classification->name,
                    'groups' => GroupResource::collection($classification->groups),
                ];
            } else {
                $response[] = [
                    'classification_id' => $classification->id,
                    'classification_name' => $classification->name,
                    'message' => 'This classification doesn\'t have groups.',
                ];
            }
        }
        return $response;
    }
}
