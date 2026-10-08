<?php

namespace App\Console\Commands;

use App\Mail\BirthDayMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Signature('app:parse-user-command')]
#[Description('Command description')]
class ParseUserCommand extends Command
{
    public function handle()
    {
        $users = User::query()->select(['*', 'created_at as birthday'])->get();

        $users->map(function ($user) {
            if (Carbon::make($user->birthday)->format('Y-m-d') === Carbon::now()->format('Y-m-d')) {
                Mail::to($user->email)->send(new BirthdayMail($user));
            }
        });



    }
}
