<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\GroupRepositoryInterface;
use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Http\Requests\Media\StoreMediaRequest;
use App\Http\Requests\Media\UpdateMediaRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\ItemResource;
use App\Http\Services\Filter\FilterService;
use App\Models\Group;
use App\Models\Item;
use App\Models\Media;
use App\Trait\UploadImage;
use Exception;
use Illuminate\Support\Facades\Storage;

class GroupRepository extends BaseRepository implements GroupRepositoryInterface
{
    use UploadImage;
    public function __construct(Group $model)
    {
        parent::__construct($model);
    }

    public function store($data)
    {
        if (isset($data['items'])) {
            $itemss = $data['items'];
            foreach ($itemss as $item) {
                $item['group_id'] = 1;
                (new StoreItemRequest($item))->validationData();
            }
        }
        if (isset($data['images'])) {
            $imagess = $data['images'];
            foreach ($imagess as $image) {
                $imagecopy = [];
                $imagecopy['image'] = $image;
                $imagecopy['group_id'] = 1;
                (new StoreMediaRequest($imagecopy))->validationData();
            }
        }
        $group = Group::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'colors' => json_encode($data['colors']),
            'classification_id' => $data['classification_id'],
            'net_price' => $data['net_price'],
            'workshop_id' => $data['workshop_id'],
        ]);
        $items_data = [];
        $images_data = [];

        if (isset($data['items'])) {
            $items = $data['items'];
            foreach ($items as $item) {
                $item['group_id'] = $group['id'];
                $item_validated = (new StoreItemRequest($item))->validationData();
                $createdItem = Item::create($item_validated);
                $items_data[] = new ItemResource($createdItem);
            }
        }

        if (isset($data['images'])) {
            $images = $data['images'];
            foreach ($images as $image) {
                $imagecopy = [];
                $imagecopy['image'] = $image;
                $imagecopy['group_id'] =  $group['id'];
                $image_validated =  (new StoreMediaRequest($imagecopy))->validationData();
                $path = UploadImage::upload($image_validated['image']);
                $createdImage = Media::create(['group_id' => $group['id'], 'path' => $path]);
                $images_data[] = $createdImage->only('id', 'path');
            }
        }

        $group_data = new GroupResource($group);

        return [
            'group' => $group_data,
            'items' => $items_data,
            'images' => $images_data,
        ];
    }

    public function update($id, $data)
    {
        if (isset($data['items'])) {
            $itemss = $data['items'];
            foreach ($itemss as $item) {
                $item['group_id'] = $id;
                (new StoreItemRequest($item))->validationData();
            }
        }
        if (isset($data['images'])) {
            $imagess = $data['images'];
            foreach ($imagess as $image) {
                $imagecopy = [];
                $imagecopy['image'] = $image;
                $imagecopy['group_id'] = $id;
                (new StoreMediaRequest($imagecopy))->validationData();
            }
        }

        $group = Group::find($id);
        $group->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'colors' => json_encode($data['colors']),
            'classification_id' => $data['classification_id'],
            'net_price' => $data['net_price'],
            'workshop_id' => $data['workshop_id'],
        ]);
        $items_data = [];
        $images_data = [];
        if (isset($data['items'])) {
            $existingItems = $group->items()->pluck('id')->toArray();
            $newItemsIds = array_column($data['items'], 'id');
            $idstodelete = array_diff($existingItems, $newItemsIds);
            Item::destroy($idstodelete);
            $itemss = $data['items'];
            foreach ($itemss as $item) {
                if (isset($item['id'])) {
                    $it = Item::find($item['id']);
                    $it->update($item);
                    $items_data[] = new ItemResource($it);
                } else {
                    $item['group_id'] = $id;
                    $item_validated = (new StoreItemRequest($item))->validationData();
                    $createdItem = Item::create($item_validated);
                    $items_data[] = new ItemResource($createdItem);
                }
            }
        }
        if (isset($data['old_images'])) {
            $existingImages = $group->media()->pluck('id')->toArray();
            $idstodelete = array_diff($existingImages, $data['old_images']);
            Media::destroy($idstodelete);
        }
        if (isset($data['images'])) {
            $images = $data['images'];
            foreach ($images as $image) {
                $imagecopy = [];
                $imagecopy['image'] = $image;
                $imagecopy['group_id'] =  $group['id'];
                $image_validated =  (new StoreMediaRequest($imagecopy))->validationData();
                $path = UploadImage::upload($image_validated['image']);
                $createdImage = Media::create(['group_id' => $group['id'], 'path' => $path]);
                $images_data[] = $createdImage->only('id', 'path');
            }
        }
        return [
            'group' => $group,
            'items' => $items_data,
            'images' => $images_data,
        ];
    }
}
