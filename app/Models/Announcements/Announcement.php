<?php

namespace App\Models\Announcements;

use App\Extenders\Models\BaseModel as Model;

use App\Traits\ImageTrait;
use App\Services\PushService;

use App\Notifications\Admin\Announcements\AnnouncementNotification;
use Notification;

use App\Models\Users\User;

use Carbon\Carbon;

class Announcement extends Model
{
	use ImageTrait;

    protected $appends = ['full_image', 'days_posted'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    /**
     * Store/Update resource to storage
     * 
     * @param  array $request
     * @param  object $item
     */
     public static function store($request, $item = null, $columns = ['name', 'description'])
    {
        $vars = $request->only($columns);

        if (!$item) {
            $item = static::create($vars);
            $item->notifyUsers();
        } else {
            $item->update($vars);
        }

        if ($request->hasFile('image_path')) {
            $item->storeImage($request->file('image_path'), 'image_path', 'announcements');
        }

        return $item;
    }


    public function notifyUsers() {
        $users = User::all();
        $push = new PushService($this->name, $this->description);
        $this->sendNotification($users);
        $push->pushToMany($users);
    }

    public function sendNotification($users)
    {
        foreach($users as $user) {
            $message = '<b>Announcement:</b> <br>'.
                        '<br>'.  $this->name . '<br>'.
                        '<br>'.$this->description.'<br>';

            Notification::send($user, new AnnouncementNotification($this->name, $this->description));
        }

    }

    /*
	|--------------------------------------------------------------------------
	| @Renders
	|--------------------------------------------------------------------------
	*/

    /**
     * Render show url for specific item
     * 
     * @return string/route
     */
	public function renderShowUrl($prefix = 'admin') 
    {
        $route = $this->id;
        $name = 'announcements.show';

        return route($prefix . ".{$name}", $route);
    }

    /**
     * Render archive url for specific item
     * 
     * @return string/route
     */
    public function renderArchiveUrl($prefix = 'admin') 
    {
        return route($prefix . '.announcements.archive', $this->id);
    }

    /**
     * Render archive url for specific item
     * 
     * @return string/route
     */
    public function renderRestoreUrl($prefix = 'admin') 
    {
        return route($prefix . '.announcements.restore', $this->id);
    }

	/*
	|--------------------------------------------------------------------------
	| @Getters
	|--------------------------------------------------------------------------
	*/

    /**
     * Append image full path
     *
     * @return string $image
     */
    public function getFullImageAttribute()
    {
        return asset('storage/' . $this->image_path);
    }

    /**
     * Append formatted time 
     *
     * @return string $time
     */
    public function getDaysPostedAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}
