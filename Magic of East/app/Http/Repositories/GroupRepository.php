<?php

namespace App\Http\Repositories;
use App\Http\Interfaces\GroupRepositoryInterface;
use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Media\StoreMediaRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\ItemResource;
use App\Models\Group;
use App\Models\Item;
use App\Models\Media;
use App\Trait\UploadImage;

class GroupRepository extends BaseRepository implements GroupRepositoryInterface
{
    use UploadImage;
    public function __construct(Group $model)
    {
        parent::__construct($model);
    }

    public function store($data)
    {
        $group = Group::create($data);
        $items_data = [];
        $images_data = [];

        if(isset($data['items'])){
            $items = $data['items'];
            foreach($items as $item){
                $item['group_id'] = $group['id'];
                $item_validated = (new StoreItemRequest($item))->validationData();
                $createdItem = Item::create($item_validated);
                $items_data[] = new ItemResource($createdItem);
            }
        }

        if(isset($data['images'])){
            $images = $data['images'];
            foreach ($images as $image) {
                $image['group_id'] = $group['id'];
                $image_validated = (new StoreMediaRequest($image))->validationData();
                $path = UploadImage::upload($image_validated['image']);
                $createdImage = Media::create(['group_id' => $group['id'], 'path' => $path]);
                $images_data[] = $createdImage->only('id','path');
            }
        }

        $group_data = new GroupResource($group);

        return [
            'group' => $group_data,
            'items' => $items_data,
            'images' => $images_data,
        ];
    }
}
