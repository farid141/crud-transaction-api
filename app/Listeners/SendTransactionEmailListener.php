<?php

namespace App\Listeners;

use App\Events\TransactionCreated;
use App\Mail\TransactionCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendTransactionEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionCreated $event): void
    {
        $transaction = $event->transaction;
        $user = $transaction->created_by;
        Mail::to($user->email)->send(new TransactionCreatedNotification($transaction));
    }
}
