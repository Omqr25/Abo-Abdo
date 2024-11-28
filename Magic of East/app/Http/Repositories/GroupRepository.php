<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\GroupRepositoryInterface;
use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Http\Requests\Media\StoreMediaRequest;
use App\Http\Requests\Media\UpdateMediaRequest;
use App\Http\Resources\GroupResource;
use App\Http\Resources\ItemResource;
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
                (new UpdateItemRequest($item))->validationData();
            }
        }
        if (isset($data['images'])) {
            $imagess = $data['images'];
            foreach ($imagess as $image) {
                $imagecopy = [];
                $imagecopy['image'] = $image;
                $imagecopy['group_id'] = $id;
                (new UpdateMediaRequest($imagecopy))->validationData();
            }
        }
        $group = Group::find($id);
        if ($group == null) throw new Exception('No such group', 404);
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
            $newItemsIds = [];
            $items = $data['items'];
            foreach ($items as $item) {
                $item['group_id'] = $id;
                $item_validated = (new StoreItemRequest($item))->validationData();
                $createdItem = Item::create($item_validated);
                $newItemsIds[] = $createdItem->id;
                $items_data[] = new ItemResource($createdItem);
            }
            $items_to_delete = array_diff($existingItems, $newItemsIds);
            foreach ($items_to_delete as $item_id) {
                $item = Item::find($item_id);
                $item->delete();
            }
        }

        if (isset($data['images'])) {
            $existingImages = $group->media()->pluck('id')->toArray();
            $newImageIds = [];
            $images = $data['images'];
            foreach ($images as $image) {
                $imagecopy = [];
                $imagecopy['image'] = $image;
                $imagecopy['group_id'] =  $id;
                $image_validated =  (new StoreMediaRequest($imagecopy))->validationData();
                $path = UploadImage::upload($image_validated['image']);
                $createdImage = Media::create(['group_id' => $group['id'], 'path' => $path]);
                $newImageIds[] = $createdImage->id;
                $images_data[] = $createdImage->only('id', 'path');
            }
            $imagesToDelete = array_diff($existingImages, $newImageIds);
            foreach ($imagesToDelete as $imageId) {
                $image = Media::find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
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
