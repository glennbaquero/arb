<?php

namespace App\Traits;

use Storage;
use App\Helpers\FileHelper;

use App\Models\Picture;

trait ImageTrait
{
    /* Store Image */
	public function storeImage($file, $column = 'image_path', $directory = 'images') {
        if($this[$column] && Storage::exists('public/' . $this[$column])) {
            Storage::delete('public/' . $this[$column]);
        }

        $this[$column] = FileHelper::store($file, $directory);
        $this->save();
	}

    public function renderImagePath($column = 'image_path') {
        $path = $this->getDefaultImage();

        if ($this[$column]) {
            $path = $this->getImageUrl($this[$column]);
        }

        return $path;
    }

    protected function getDefaultImage() {
        return '';
    }

    protected function getImageUrl($path) {
        $url = url('/');

        switch (config('web.filesystem')) {
            case 's3':
                    $url = null;
                break;
        }

        return $url . Storage::url($path);
    }
}

