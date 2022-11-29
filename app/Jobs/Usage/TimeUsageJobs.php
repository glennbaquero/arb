<?php

namespace App\Jobs\Usage;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TimeUsageJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $now = now()->format('Y-m-d');
        $usage_today = $this->user->timeUsage()->whereDate('date', $now)->first();
        if($usage_today) {
            $usage_today->increment('seconds', 60);
        } else {
            $this->user->timeUsage()->create([
                'date' => $now,
                'seconds' => 60
            ]);
        }
    }
}
