<?php

namespace App\Models\Samples;

use App\Extenders\Models\BaseModel as Model;

use Rutorika\Sortable\SortableTrait;

use App\Traits\ManyImagesTrait;
use App\Traits\ImageTrait;

use App\Models\Permissions\Permission;
use App\Models\Users\Admin;

use App\Events\Samples\SampleChanged;

class SampleItem extends Model
{
    use ManyImagesTrait, ImageTrait, SortableTrait;
    
    const STATUS_PENDING = 'PENDING';
    const STATUS_APPROVED = 'APPROVED';
    const STATUS_DENIED = 'DENIED';

    protected static $sortableField = 'order_column';

    protected static $logAttributes = ['name', 'description', 'date', 'dates', 'data'];
    protected static $ignoreChangedAttributes = ['updated_at', 'status', 'reason'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
        'dates' => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date',
    ];

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
     * @Getters
     */
    public static function getStatus() {
    	return [
    		['value' => static::STATUS_PENDING, 'label' => 'Pending', 'class' => 'bg-info'],
    		['value' => static::STATUS_APPROVED, 'label' => 'Approved', 'class' => 'bg-success'],
            ['value' => static::STATUS_DENIED, 'label' => 'Denied', 'class' => 'bg-danger'],
    	];
    }

    /**
     * @Setters
     */
    public static function store($request, $item = null, $columns = ['name', 'description', 'sample_item_id', 'data', 'date', 'dates', 'status'])
    {
        $vars = $request->only($columns);

        if (!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        if ($request->hasFile('image_path')) {
            $item->storeImage($request->file('image_path'), 'image_path', 'sample-item-images');
        }

        if ($request->hasFile('images')) {
            $item->addImages($request->file('images'));
        }

        $item->broadcast();

        return $item;
    }

    public function broadcast() {
        if (config('socket.enabled')) {
            broadcast(new SampleChanged($this));
        }
    }

    /**
     * @Checkers
     */
    public function canApprove() {
        if ($this->trashed()) {
            return false;
        }

        switch ($this->status) {
            case static::STATUS_PENDING:
                return true;
            case static::STATUS_APPROVED:
            case static::STATUS_DENIED:
                return false;
        }
    }

    public function canDeny() {
        if ($this->trashed()) {
            return false;
        }
        
        switch ($this->status) {
            case static::STATUS_PENDING:
                return true;
            case static::STATUS_APPROVED:
            case static::STATUS_DENIED:
                return false;
        }
    }

    /**
     * @Render
     */
    
    public function renderStatus($column = 'label') {
    	return static::renderConstants(static::getStatus(), $this->status, $column);
    }

    public function renderName() {
        return $this->name;
    }

    public function renderApproveUrl($prefix = 'admin') {
        return route($prefix . '.sample-items.approve', $this->id);
    }

    public function renderDenyUrl($prefix = 'admin') {
        return route($prefix . '.sample-items.deny', $this->id);
    }

    public function renderShowUrl($prefix = 'admin') {
        return route($prefix . '.sample-items.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        return route($prefix . '.sample-items.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        return route($prefix . '.sample-items.restore', $this->id);
    }

    public function renderRemoveImageUrl($prefix = 'admin') {
        return route($prefix . '.sample-items.remove-image', $this->id);
    }
}
