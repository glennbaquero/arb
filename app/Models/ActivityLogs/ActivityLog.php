<?php

namespace App\Models\ActivityLogs;

/* Activity Logs: https://github.com/spatie/laravel-activitylog */
use Spatie\Activitylog\Models\Activity;
use Laravel\Scout\Searchable;

use App\Helpers\ObjectHelper;
use App\Helpers\ArrayHelper;

use App\Traits\ArchiveableTrait;
use App\Traits\HelperTrait;
use App\Traits\DateTrait;

class ActivityLog extends Activity
{
    use ArchiveableTrait, HelperTrait, DateTrait, Searchable;

	/**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'subject_type' => $this->subject_type,
            'description' => $this->description,
        ];
    }

    /**
     * @Getters
     */
    public static function getTypes() {
        $types = static::pluck('subject_type')->unique();
        $result = [];

        foreach ($types as $type) {
            $result[] = [
                'value' => $type,
                'label' => ObjectHelper::getShortClassName($type),
            ];
        }

        $result = ArrayHelper::sortArray($result, 'label');

        return $result;
    }

    /**
     * @Renders
     */
    
    /**
     * Name for common calls
     * @return string
     */
    public function renderName() {
    	return $this->description;
    }


    /* URL of subject */
    public function renderShowUrl($prefix = 'admin') {
    	$result = null;

    	if ($this->subject && method_exists($this->subject, 'renderShowUrl')) {
    		$result = $this->subject->renderShowUrl($prefix);
    	}

    	return $result;
    }


    /**
     * Subject type
     * @return string
     */
    public function renderSubjectType() {
        $result = 'System';

        if ($this->subject_type) {
            $result = ObjectHelper::getShortClassName($this->subject_type) . ' #' . $this->subject_id;
        }

        return $result;
    }


    /**
     * Subject class name
     * @return string
     */
    public function renderSubjectName() {
        $result = null;

        if ($this->subject && method_exists($this->subject, 'renderName')) {
            $result = $this->subject->renderName();
        }

        return $result;
    }

    /**
     * User name 
     * @return string
     */
    public function renderCauserName() {
        $result = 'System';

        if ($this->causer && method_exists($this->causer, 'renderName')) {
            $result = $this->causer->renderName();
        }

        return $result;
    }

    /**
     * User show URL
     * @return [type] [description]
     */
    public function renderCauserShowUrl() {
        $result = null;

        if ($this->causer && method_exists($this->causer, 'renderShowUrl')) {
            $result = $this->causer->renderShowUrl();
        }

        return $result;
    }
}
