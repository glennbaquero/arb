<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Rutorika\Sortable\SortableTrait;

use App\Traits\ImageTrait;
use App\Traits\ArrayFormatterTrait;

class Picture extends Model
{
    use ImageTrait, ArrayFormatterTrait, SortableTrait;

    protected $guarded = [];

    protected static $sortableField = 'order_column';

    public function parent() {
        return $this->morphTo();
    }

    public static function formatItem($item) {
        return [
            'id' => $item->id,
            'order_column' => $item->order_column,
            'path' => $item->renderImagePath(),
        ];
    }
}
