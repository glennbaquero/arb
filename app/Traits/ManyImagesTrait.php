<?php

namespace App\Traits;

use Storage;
use App\Helpers\FileHelper;

use App\Models\Picture;

trait ManyImagesTrait {

    public function images() {
        return $this->morphMany(Picture::class, 'parent');
    }

    public function getImages() {
        return Picture::formatList($this->images()->orderBy('order_column', 'asc')->get());
    }

    public function addImages($images, $directory = 'images', $file_column = 'image_path') {
        $action = 0;

        if ($images) {            
            foreach ($images as $image) {
                $path = FileHelper::store($image, $directory);

                $vars = [
                    $file_column => $path,
                ];

                /* Create the image data */
                $this->images()->create($vars);
               
            }

            $action = 1;
        }

        return $action;
    }

    public function removeImage($request, $column = 'image_path', $additionalFilters = []) {
        $filters = [
            'id' => $request->input('id'),
        ];

        $filters = array_merge($filters, $additionalFilters);

        if ($image = $this->images()->where($filters)->first()) {
            Storage::delete('public/' . $image[$column]);
            $image->delete();
        } else {
            abort(403, 'You are not authorized to delete the selected image.');
        }

        return true;
    }

    abstract public function renderRemoveImageUrl();

    public function renderThumbnailPath() {
        return $this->images()->orderBy('order_column', 'asc')->first();
    }

}