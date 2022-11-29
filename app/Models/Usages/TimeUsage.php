<?php

namespace App\Models\Usages;

use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;

class TimeUsage extends Model
{
	protected $guarded = [];
    public function user() {
    	return $this->belongsTo(User::class)->withTrashed();
    }
}
