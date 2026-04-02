<?php

namespace App\Console\Commands;

use App\Enums\PaymentNotificationStatus;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\WhatsApp\WhatsApp;
use Illuminate\Console\Command;

class NotifyEarlyPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-early-payments';

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
            ->whereDate('due_date', now()->addDays(3))
            ->where('notification_status', PaymentNotificationStatus::NotReminded)
            ->get();

        foreach ($payments as $payment) {
            $message = "Hola {$payment->client->full_name}, te recordamos que tu pago de {$payment->amount} vence en 3 días.";
            if (WhatsApp::sendText($payment->client->phone_number, $message)) {
                $payment->update([
                    'last_reminded_at' => now(),
                    'notification_status' => PaymentNotificationStatus::EarlyReminder
                ]);
            }
        }
    }
}
