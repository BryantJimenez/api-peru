<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\RegisterNotification;

class SendEmailRegister implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $slug;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($slug)
    {
        $this->slug=$slug;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user=User::where('slug', $this->slug)->first();
        $user->notify(new RegisterNotification());
    }
}
