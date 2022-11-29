<?php

namespace App\Models\Notifications;

use Illuminate\Notifications\DatabaseNotification;

use App\Traits\HelperTrait;
use App\Traits\DateTrait;

use App\Helpers\StringHelper;

class UserNotification extends DatabaseNotification
{
	use HelperTrait, DateTrait;

    protected $table = 'notifications';

    /**
     * @Renders
     */
    public function renderDataColumn($column, $emptyvalue = null) {
    	return isset($this->data[$column]) ? $this->data[$column] : $emptyvalue;
    }

    public function renderShowUrl($prefix = 'admin') {
    	$result = null;
    	$item = null;

        if ($class = $this->renderDataColumn('subject_type')) {
            $item = $class::withTrashed()->find($this->renderDataColumn('subject_id'));

            if ($item) {
                $result = $item->renderShowUrl($prefix);
            }
        }

        return $result;
    }

    public function renderDate($column = 'created_at') {
        $date = null;

        if (isset($this->$column) && $this->$column) {
            $date = $this->$column->diffForHumans();
        }

        return $date;
    }

    public function renderReadUrl($prefix = 'admin') {
        return route($prefix . '.notifications.read', $this->id);
    }

    public function renderUnreadUrl($prefix = 'admin') {
        return route($prefix . '.notifications.unread', $this->id);
    }
}