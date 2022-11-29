<?php

namespace App\Services;

use App\DeviceToken;
use GuzzleHttp\Client;

use App\Models\Users\User;

class PushService
{
    protected $title;
    protected $message;
    protected $sound;
    protected $android_channel_id;

    public function __construct($title, $message) {
        $this->title = $title;
        $this->message = $message;
    }

    public function setSound($sound) {
        $this->sound = $sound;
    }

    public function setChannel($android_channel_id) {
        $this->android_channel_id = $android_channel_id;
    }

    public function pushToAll() {
        $this->push(DeviceToken::all());
    }

    public function pushToUsers() {
        $this->push(DeviceToken::where('user_type', User::class)->get());
    }

    public function pushToMany($users) {
        $device_tokens = [];

        foreach ($users as $user) {
            foreach ($user->device_tokens as $device_token) {
                array_push($device_tokens, $device_token);
            }
        }

        $this->push($device_tokens);

    }

    public function pushToOne($user) {
        $device_tokens = [];

        foreach ($user->device_tokens as $device_token) {
            array_push($device_tokens, $device_token);
        }

        $this->push($device_tokens);

    }

    public function push($device_tokens) {
        $ios = [];
        $android = [];

        foreach($device_tokens as $device_token) {
            switch($device_token->platform) {
                case 'iOS':
                        array_push($ios, $device_token->token);
                    break;

                case 'Android':
                        array_push($android, $device_token->token);
                    break;
            }
        }

        // short-circuit if no tokens found
        if(!$ios && !$android) {
            return false;
        }

        $this->deliverPayload([
            'ios' => $ios,
            'android' => $android,
        ]);
    }

    public function deliverPayload($payload) {
        $payload = array_merge($payload, [
            'title' => $this->title,
            'message' => strip_tags($this->message),
            'sound' => $this->sound,
            'android_channel_id' => $this->android_channel_id,
        ]);

        $client = new Client();
        $client->post(config('push.url'), [
            'form_params' => $payload
        ]);
    }

    public function pushToOneDevice($device_token) {
        $ios = [];
        $android = [];

        switch($device_token->platform) {
            case 'iOS':
                array_push($ios, $device_token->token);
                break;

            case 'Android':
                array_push($android, $device_token->token);
                break;
        }

        // short-circuit if no tokens found
        if(!$ios && !$android) {
            return false;
        }

        $this->deliverPayload([
            'ios' => $ios,
            'android' => $android,
        ]);
    }

}
