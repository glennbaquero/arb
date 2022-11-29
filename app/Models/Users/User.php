<?php

namespace App\Models\Users;

use App\Extenders\Models\BaseUser as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\Web\Auth\ResetPassword;
use App\Notifications\Web\Auth\VerifyEmail;
use Password;

use App\Models\Documents\Document;
use App\Models\Usages\TimeUsage;


use Carbon\Carbon;
use Hash;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    const FILLABLE = ['first_name', 'last_name', 'email', 'birthday', 'gender', 'username', 'telephone_number', 'mobile_number', 'user_type', 'calling_code'];

    protected $casts = [
        'birthday' => 'date',
    ];

    protected $appends = [ 'mask_mobile_number' ];

    const USER = 0;
    const SUPERVISOR = 1;
    const ADMIN = 2;

    /**
     * @Mutators
     */
    public function setBirthdayAttribute($value) {
        if (strtotime($value)) {
            $date = Carbon::parse($value);
            $this->attributes['age'] = $date->age;
        }

        $this->attributes['birthday'] = $value;
    }

    /**
     * Overrides default reset password notification
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPassword($token, $this->password));
        $this->password = Hash::make($this->password);
        $this->save();
    }

    /* Overrides default verification notification */
    public function sendEmailVerificationNotification() {
        $this->notify(new VerifyEmail);
    }

    public function device_tokens() {
        return $this->morphMany(DeviceToken::class, 'user');
    }

    public function providers() {
        return $this->morphMany(SocialiteProvider::class, 'user');
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }

    public function timeUsage() {
        return $this->hasMany(TimeUsage::class);
    }

    /* Overrides default forgot password */
    public function broker() {
        return Password::broker('users');
    }

    /**
     * JWT Configurations
     */
    public function getJWTCustomClaims(): array {
        return [
            'guard' => 'web',
        ];
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            // 'username' => $this->username,
            // 'gender' => $this->gender,
            'mobile_number' => $this->mobile_number,
            // 'telephone_number' => $this->telephone_number,
        ];
    }

    /**
     * @Renders
     */
    
    public function isIncomplete() {
        return in_array(null, [
            $this->first_name,
            $this->last_name,
            $this->email,
            $this->username,
            $this->gender,
            $this->mobile_number,
            $this->birthday,
        ]);
    }
    
    /* User Verification Status */
    public function renderStatus($showLabel = true) {
        $result = $showLabel ? 'Unverified' : 'bg-danger';

        if ($this->email_verified_at) {
            $result = $showLabel ? 'Verified' : 'bg-success';
        }

        return $result;
    }

    public function renderShowUrl($prefix = 'admin') {
        if (in_array($prefix, ['web'])) {
            return route($prefix . '.profiles.show');
        }
        
        return route($prefix . '.users.show', $this->id);
    }

    public function renderArchiveUrl($prefix = 'admin') {
        if (in_array($prefix, ['web'])) {
            return;
        }

        return route($prefix . '.users.archive', $this->id);
    }

    public function renderRestoreUrl($prefix = 'admin') {
        if (in_array($prefix, ['web'])) {
            return;
        }

        return route($prefix . '.users.restore', $this->id);
    }


    /**
     * @Getters
     */
    public static function getTypes() {
        return [
            ['value' => static::USER, 'label' => 'User', 'description' => '', 'class' => 'bg-info'],
            ['value' => static::SUPERVISOR, 'label' => 'Supervisor', 'description' => '', 'class' => 'bg-primary'],
            ['value' => static::ADMIN, 'label' => 'Admin', 'description' => '', 'class' => 'bg-secondary'],
        ];
    }

    public function renderType($column = 'label') {
        return static::renderConstants(static::getTypes(), $this->user_type, $column);
    }

    public function getFormattedDocument($limited, $limit_count = 5, $with_status = false, $status = 0, $search=null, $is_archived=false, $sort= 'asc') 
    {
        if($with_status) {
            $documents = $this->documents()->where('status', $status)->where('file_name', 'like', '%'.$search.'%')->orderby('file_name', $sort)->get();
        }

        if($is_archived) {
            $documents = $this->documents()->onlyTrashed()->where('file_name', 'like', '%'.$search.'%')->orderby('file_name', $sort)->get();                
        }

        if($limited) {
            $documents = $this->documents()->latest()->take($limit_count)->orderby('file_name', $sort)->get();
        }

        $arr = [];

        foreach ($documents as $document) {
            array_push($arr, [
                'id' => $document->id,
                'date' => Carbon::parse($document->created_at)->format('j F Y'),
                'file_name' => $document->file_name,
                'file_url' => $document->renderImagePath('file_path'),
                'file_type' => $document->file_type,
                'bg_image' => $document->bg_image,
                'application_type' => $document->application_type,
                'is_image' => $document->is_image,
                'status' => $document->status,
                'reject_message' => $document->documentLogs()->latest()->first() ? $document->documentLogs()->latest()->first()->reject_message : null,
                'enable_edit' => false
            ]);
        }

        return $arr;
    }

    /**
     * Append mask number full path
     *
     * @return string $result
     */
    public function getMaskMobileNumberAttribute()
    {
        $user_num = $this->mobile_number;
        $lastTwoDigits = substr($user_num, -2, 2);
        $result = '*** *** **'.$lastTwoDigits;
        return $result;
    }
}