<?php

namespace App\Models\Pages;

use App\Extenders\Models\BaseModel as Model;

use Illuminate\Validation\ValidationException;
use Storage;

use App\Helpers\StringHelper;
use App\Traits\ImageTrait;

use App\Models\Pages\Page;

class PageItem extends Model
{
    use ImageTrait;
    
    protected static $logAttributes = ['name', 'slug', 'content', 'type'];

    const TYPE_TEXT = 'TEXT';
    const TYPE_HTML = 'HTML';
    const TYPE_IMAGE = 'IMAGE';

    public function getDescriptionForEvent(string $eventName): string {
        return "{$this->renderName()} has been {$eventName}";
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'page' => $this->renderPageColumn('name'),
        ];
    }

    /**
     * @Relationships
     */
    public function page() {
        return $this->belongsTo(Page::class, 'page_id')->withTrashed();
    }

    /**
     * @Getters
     */
    public static function getTypes() {
    	return [
    		['value' => static::TYPE_TEXT, 'label' => 'Text\Link\Label', 'description' => '', 'class' => 'bg-primary'],
    		['value' => static::TYPE_HTML, 'label' => 'HTML\Content', 'description' => '', 'class' => 'bg-info'],
    		['value' => static::TYPE_IMAGE, 'label' => 'Image', 'description' => '', 'class' => 'bg-secondary'],
    	];
    }

    public static function formatItem($item) {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'type' => $item->type,
            'slug' => $item->slug,
            'note' => $item->renderName(),
            'content' => $item->renderContent(),
        ];
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['page_id', 'slug', 'type', 'content', 'name'])
    {
        $vars = $request->only($columns);
        
        if ($request->filled('slug')) {
            $vars['slug'] = StringHelper::slugify($request->input('slug'));
        }

        if (isset($vars['page_id'])) {

            $parent = Page::withTrashed()->find($vars['page_id']);

            $result = $parent->page_items()->where('slug', $vars['slug']);

            if ($item) {
                $result->where('id', '!=', $item->id);
            }

            $result = $result->first();

            if ($result) {
                throw ValidationException::withMessages([
                    'slug' => 'Slug must be unique within the page.',
                ]);
            }
        }

        if ($request->input('type') == static::TYPE_IMAGE) {
            unset($vars['content']);
        }

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        switch ($request->input('type')) {
            case static::TYPE_IMAGE:
                    if ($request->hasFile('content')) {
                        $item->storeImage($request->file('content'), 'content', 'page-item-images');
                    }
                break;
        }

        return $item;
    }

    /**
     * @Render
     */
    public function renderName() {
        return ucwords(str_replace('_', ' ', $this->slug));
    }

    public function renderPageColumn($column) {
        $result = null;

        if ($this->page && $this->page[$column]) {
            $result = $this->page[$column];
        }

        return $result;
    }

    public function renderContent() {
        $result = null;

        switch ($this->type) {
            case static::TYPE_IMAGE:
                    $result = Storage::url($this->content);
                break;
            case static::TYPE_HTML:
            case static::TYPE_TEXT:
                    $result = $this->content;
                break;
        }

        return $result;
    }

    public function renderType($column = 'label') {
        return static::renderConstants(static::getTypes(), $this->type, $column);
    }

    public function renderShowUrl() {
        return route('admin.page-items.show', $this->id);
    }

    public function renderArchiveUrl() {
        return route('admin.page-items.archive', $this->id);
    }

    public function renderRestoreUrl() {
        return route('admin.page-items.restore', $this->id);
    }
}
