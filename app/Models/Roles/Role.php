<?php

namespace App\Models\Roles;

use Spatie\Permission\Models\Role as SpatieRole;

use Illuminate\Validation\ValidationException;
use Spatie\Activitylog\Traits\LogsActivity;

use Laravel\Scout\Searchable;

use App\Traits\ArchiveableTrait;
use App\Traits\HelperTrait;
use App\Traits\DateTrait;

use App\Helpers\ArrayHelper;

class Role extends SpatieRole
{
    use ArchiveableTrait, HelperTrait, DateTrait, LogsActivity, Searchable;
    protected $dates = ['deleted_at'];

    protected static $logAttributes = [];
    protected static $ignoreChangedAttributes = ['updated_at'];
    protected static $logOnlyDirty = false;

    public function getDescriptionForEvent(string $eventName): string {
        return "{$this->renderLogName()} has been {$eventName}";
    }

    const MINIMAL_COLUMN = [
        'id',
        'name',
    ];

    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    /**
     * @Methods
     */

    public static function store($request, $item = null) 
    {
        $vars  = $request->only(['name', 'description']);

        if(!$item) {
            $item = static::create($vars);
        } else {
            $item->update($vars);
        }

        return $item;
    }

    public function updatePermissions($request) {
        if (!$this->isPermissionEditable()) {
            throw ValidationException::withMessages([
                'permissions' => 'Permissions cannot be updated.',
            ]);
        }

        $newIds = $request->input('permissions');
        $result = ArrayHelper::diff($newIds, $this->permissions()->pluck('id')->toArray());

        $this->syncPermissions($newIds);

        if ($result['action']) {
            unset($result['action']);
            activity()
                ->performedOn($this)
                ->causedBy($request->user())
                ->withProperties($result)
                ->log($this->renderLogName() . " permissions has been updated");
        }

        return $this;
    }

    /**
     * @Checker
     */
    public function isPermissionEditable() {
        return $this->id !== 1;
    }

    public function isArchiveable(): bool {
        return $this->id !== 1;
    }

    public function isRestorable(): bool {
        return $this->id !== 1;
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

    /*
     * @Renders
     */

    public function renderName() {
        return $this->name;
    }

    public function renderShowUrl() {
    	return route('admin.roles.show', $this->id);
    }

    public function renderArchiveUrl() {
        return route('admin.roles.archive', $this->id);
    }

    public function renderRestoreUrl() {
        return route('admin.roles.restore', $this->id);
    }
}