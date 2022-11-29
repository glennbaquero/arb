<?php

namespace App\Actions\Samples;

use Illuminate\Validation\ValidationException;
use DB;
use Notification;

use App\Notifications\Samples\SampleItemApproved;

use App\Models\Permissions\Permission;
use App\Models\Users\Admin;
use App\Models\Samples\SampleItem;

class SampleApprove
{
	/* Execute Action */
	public function execute($id, $user) {

		DB::beginTransaction();

		$item = SampleItem::withTrashed()->findOrFail($id);

		if ($item->canApprove()) {
            $item->status = SampleItem::STATUS_APPROVED;
            $item->save();

            $this->sendNotifications($item);

            activity()
                ->causedBy($user)
                ->performedOn($item)
                ->log("{$item->renderLogName()} status has been changed to approved.");
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
            Notification::send($admins, new SampleItemApproved($item));
        }
    }
}