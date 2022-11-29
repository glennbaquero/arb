<?php

namespace App\Helpers;

use Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

class FileHelper 
{
	public static function store($image, $directory) {
		$should_resize = false;
		$default_resize = 700;
		$resize_width = null;
		$resize_height = null;

    	$extension = $image->getClientOriginalExtension() ? $image->getClientOriginalExtension() : 'jpg';

    	$optimized_image = Image::make($image)->encode($extension);

    	$width = $optimized_image->getWidth();
	    $height = $optimized_image->getHeight();

	    if ($width >= $height) {
	    	if ($width > $default_resize) {
	    		$resize_width = $default_resize;
		    	$should_resize = true;
	    	}
	    } else {
	    	if ($height > $default_resize) {
	    		$resize_height = $default_resize;
		    	$should_resize = true;
		    }
	    }

	    if ($should_resize) {
		    $optimized_image->resize($resize_width, $resize_height, function ($constraint) {
			    $constraint->aspectRatio();
			    $constraint->upsize();
			});
	    }

	    $optimized_image->save();

	    switch (config('web.filesystem')) {
	    	case 's3':
	    			$root = null;
	    		break;
	    	
	    	default:
	    			$root = 'public/';
	    		break;
	    }

	    $file_path = $directory . '/' . uniqid() . Str::random(40) . '.' . $extension;
	    $absolute_path = $root . $file_path;

    	Storage::put($absolute_path, $optimized_image);

    	return $file_path;
	}

	public static function getExternalImage($url) {
    	$info = pathinfo($url);
		$contents = file_get_contents($url);
		$file = '/tmp/' . $info['basename'];
		file_put_contents($file, $contents);
		return new UploadedFile($file, $info['basename']);
	}
}