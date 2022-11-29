<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class SocialiteProvider extends Model
{
	protected $guarded = [];
	
    public function user() {
        return $this->morphTo();
    }
}
