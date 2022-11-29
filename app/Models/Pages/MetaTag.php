<?php

namespace App\Models\Pages;

use App\Extenders\Models\BaseModel as Model;

use App\Traits\ImageTrait;

class MetaTag extends Model
{
	use ImageTrait;
	
    public function page() {
        return $this->morphTo();
    }
}
