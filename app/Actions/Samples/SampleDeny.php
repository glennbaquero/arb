<?php

namespace App\Actions\Samples;

use Illuminate\Validation\ValidationException;
use DB;
use Notification;

use App\Notifications\Samples\SampleItemDenied;

use App\Models\Users\Admin;
use App\Models\Permissions\Permission;
use App\Models\Samples\SampleItem;

class SampleDeny
{
    /* Execute Action */
	public function execute($id, $reason, $user) {

		DB::beginTransaction();

		$item = SampleItem::withTrashed()->findOrFail($id);

		if ($item->canApprove()) {
            $item->status = SampleItem::STATUS_DENIED;
            $item->reason = $reason;
            $item->save();

            $this->sendNotifications($item);

            activity()
                ->causedBy($user)
                ->performedOn($item)
                ->log("{$item->renderLogName()} status has been changed to denied.");
        } else {
            throw ValidationException::withMessages([
                'status' => 'Status can no longer be change to deny.',
            ]);
        }

        DB::commit();

        $item->broadcast();

        return $item;
	}

    /* Send notifications */
    public function sendNotifications($item) {
        $ids = Permission::getUsersByPermission(['admin.sample-items.crud']);
        $admins = Admin::whereIn('id', $ids)->get();

        if (count($admins)) {
            Notification::send($admins, new SampleItemDenied($item));
        }
    }
}