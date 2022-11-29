<?php

namespace App\Extenders\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Laravel\Scout\Searchable;

use App\Traits\ArchiveableTrait;
use App\Traits\HelperTrait;
use App\Traits\DateTrait;
use App\Traits\PaginationTrait;
use App\Traits\ArrayFormatterTrait;

class BaseModel extends Model
{
    use ArchiveableTrait, Searchable, HelperTrait, DateTrait, LogsActivity, PaginationTrait, ArrayFormatterTrait;

    protected $guarded = [];

    protected static $logAttributes = [];
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $logOnlyDirty = false;

    public function getDescriptionForEvent(string $eventName): string {
        return "{$this->renderLogName()} has been {$eventName}";
    }

    public function archiveErrorMessage() {
        $result = $this->renderLogName();

        if ($this->isArchiveable()) {
            $result .= ' has already been archived.';
        } else {
            $result .= ' cannot be archived.';
        }

        return $result;
    }

    public function restoreErrorMessage() {
        $result = $this->renderLogName();

        if ($this->isRestorable()) {
            $result .= ' has already been restored.';
        } else {
            $result .= ' cannot be restored.';
        }

        return $result;
    }
}
