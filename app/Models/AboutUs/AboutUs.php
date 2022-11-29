<?php

namespace App\Models\AboutUs;

use App\Extenders\Models\BaseModel as Model;

use App\Traits\ManyImagesTrait;

class AboutUs extends Model
{

    use ManyImagesTrait;

    /**
     * Relationship
     */
    
    public function pictures()
    {
        return $this->morphMany(Picture::class, 'parent');
    }

    /**
     * Store/Update resource to storage
     * 
     * @param  array $request
     * @param  object $item
     */
     public static function store($request, $item = null, $columns = ['title', 'description'])
    {
        $vars = $request->only($columns);

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        if ($request->hasFile('images')) {
            $item->addImages($request->file('images'));
        }

        return $item;
    }

     /**
     * @Render
     */
    
    public function renderShowUrl($prefix = 'admin') {
        $route = $this->id;
        return route($prefix . '.about-us.index');
    }
    
    public function renderRemoveImageUrl($prefix = 'admin') {
        return route($prefix . '.about-us.remove-image', $this->id);
    }
}
