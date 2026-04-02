<?php

namespace App\Console\Commands;

use App\Enums\PaymentNotificationStatus;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\WhatsApp\WhatsApp;
use Illuminate\Console\Command;

class NotifyDuePayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-due-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $payments = Payment::where('is_notification_enabled', true)
            ->where('payment_status', PaymentStatus::Pending)
            ->whereDate('due_date', now())
            ->where('notification_status', '!=', PaymentNotificationStatus::Reminder)
            ->get();

        foreach ($payments as $payment) {
            $message = "Atención {$payment->client->full_name}, hoy es la fecha límite para tu pago de {$payment->amount}.";
            if (WhatsApp::sendText($payment->client->phone_number, $message)) {
                $payment->update([
                    'last_reminded_at' => now(),
                    'notification_status' => PaymentNotificationStatus::Reminder
                ]);
            }
        }
    }
}
