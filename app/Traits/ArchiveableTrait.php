<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\ValidationException;

trait ArchiveableTrait {

	use SoftDeletes;

    /* Archive Item */
    public function archive() {
        if (!$this->trashed() && $this->isArchiveable()) {
            $this->delete();
        } else {
            throw ValidationException::withMessages([
                'deleted_at' => $this->archiveErrorMessage(),
            ]);
        }

        return true;
    }

    /* Restore Item */
    public function unarchive() {
        if ($this->trashed() && $this->isRestorable()) {
            $this->restore();
        } else {
            throw ValidationException::withMessages([
                'deleted_at' => $this->restoreErrorMessage(),
            ]);
        }

        return true;
    }

    /* Determine if item is archiveable */
    public function isArchiveable() {
        return true;
    }

    /* Determine if item is restorable */
    public function isRestorable() {
        return true;
    }

    /* Archive error message */
    public function archiveErrorMessage() {
        $result = 'Item';

        if ($this->isArchiveable()) {
            $result .= ' has already been archived.';
        } else {
            $result .= ' cannot be archived.';
        }

        return $result;
    }

    /* Restore error message */
    public function restoreErrorMessage() {
        $result = 'Item';

        if ($this->isRestorable()) {
            $result .= ' has already been restored.';
        } else {
            $result .= ' cannot be restored.';
        }

        return $result;
    }

    /* Archive URL */
    public function renderArchiveUrl() {}

    /* Restore URL */
    public function renderRestoreUrl() {}
}