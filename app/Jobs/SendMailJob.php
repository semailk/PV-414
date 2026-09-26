<?php

namespace App\Jobs;

use App\Mail\SendMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Queueable;

    public function __construct(private User $user)
    {}

    public function handle(): void
    {
        Mail::to($this->user->email)->send(new SendMail($this->user));
    }
}
