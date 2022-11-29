<?php

namespace App\Models\Articles;

use App\Extenders\Models\BaseModel as Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use Rutorika\Sortable\SortableTrait;

use App\Traits\Pages\MetaTrait;
use App\Traits\ImageTrait;
use App\Traits\ManyImagesTrait;

class Article extends Model
{
    use MetaTrait, ImageTrait, ManyImagesTrait, HasSlug, SortableTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
    	'published_at',
    ];

    protected static $sortableField = 'order_column';

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->allowDuplicateSlugs();
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name', 'description', 'published_at'])
    {
        $vars = $request->only($columns);

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        $item->storeMeta($request);

        if ($request->hasFile('image_path')) {
            $item->storeImage($request->file('image_path'), 'image_path', 'article-images');
        }

        if ($request->hasFile('images')) {
            $item->addImages($request->file('images'));
        }

        return $item;
    }

    /**
     * @Render
     */
    
    public function renderName() {
        return $this->name;
    }

    public function renderShowUrl($prefix = 'admin') {
        $route = $this->id;

        if ($prefix == 'guest') {
            $route = [$this->id, $this->slug];
        }

        return route($prefix . '.articles.show', $route);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.articles.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.articles.restore', $this->id);
    }

        public function renderRemoveImageUrl($prefix = 'admin') {
        return route($prefix . '.articles.remove-image', $this->id);
    }
}
