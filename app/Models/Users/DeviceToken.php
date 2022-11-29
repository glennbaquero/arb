<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->morphTo();
    }
}
