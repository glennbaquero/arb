<?php

namespace App\Traits;

trait DeviceTokenTrait
{
    public function device_tokens() {
        return $this->morphMany(DeviceToken::class, 'user');
    }
}