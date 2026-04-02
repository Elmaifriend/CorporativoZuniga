<?php

namespace App\Console\Commands;

use App\Enums\PaymentNotificationStatus;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\WhatsApp\WhatsApp;
use Illuminate\Console\Command;

class NotifyLatePayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-late-payments';

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
            ->whereDate('due_date', '<', now())
            ->where(function ($query) {
                $query->whereNull('last_reminded_at')
                    ->orWhere('last_reminded_at', '<=', now()->subDays(3));
            })
            ->get();

        foreach ($payments as $payment) {
            $message = "Recordatorio de pago atrasado: {$payment->client->full_name}, tienes un saldo pendiente de {$payment->amount}.";
            if (WhatsApp::sendText($payment->client->phone_number, $message)) {
                $payment->update([
                    'last_reminded_at' => now(),
                    'notification_status' => PaymentNotificationStatus::LateReminder
                ]);
            }
        }
    }
}
