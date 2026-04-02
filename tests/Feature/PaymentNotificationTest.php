<?php

namespace Tests\Feature;

use App\Console\Commands\NotifyDuePayments;
use App\Console\Commands\NotifyEarlyPayments;
use App\Console\Commands\NotifyLatePayments;
use App\Enums\PaymentNotificationStatus;
use App\Enums\PaymentStatus;
use App\Models\Client;
use App\Models\Payment;
use App\WhatsApp\WhatsApp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PaymentNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockWhatsApp();
    }

    private function mockWhatsApp()
    {
        Mockery::mock('alias:' . WhatsApp::class)
            ->shouldReceive('sendText')
            ->andReturn(true);
    }

    #[Test]
    public function early_reminder_is_sent_three_days_before_due_date()
    {
        // given a pending payment due in exactly 3 days
        $payment = Payment::factory()->create([
            'payment_status' => PaymentStatus::Pending,
            'notification_status' => PaymentNotificationStatus::NotReminded,
            'due_date' => now()->addDays(3)->toDateString(),
            'is_notification_enabled' => true,
        ]);

        // when running the early notification command
        Artisan::call(NotifyEarlyPayments::class);

        // then a whatsapp message should be sent and notification status updated
        $payment->refresh();
        $this->assertEquals(PaymentNotificationStatus::EarlyReminder, $payment->notification_status);
        $this->assertTrue($payment->last_reminded_at->isToday());
    }

    #[Test]
    public function due_date_reminder_is_sent_on_the_exact_day()
    {
        // given a pending payment where today is the due date
        $payment = Payment::factory()->create([
            'payment_status' => PaymentStatus::Pending,
            'due_date' => now()->toDateString(),
            'is_notification_enabled' => true,
        ]);

        // when running the due date notification command
        Artisan::call(NotifyDuePayments::class);

        // then the notification status should be updated to reminder
        $payment->refresh();
        $this->assertEquals(PaymentNotificationStatus::Reminder, $payment->notification_status);
        $this->assertTrue($payment->last_reminded_at->isToday());
    }

    #[Test]
    public function late_reminder_is_sent_every_three_days_of_delay()
    {
        // given a late payment reminded 3 days ago
        $payment = Payment::factory()->create([
            'payment_status' => PaymentStatus::Pending,
            'due_date' => now()->subDays(6)->toDateString(),
            'last_reminded_at' => now()->subDays(3),
            'is_notification_enabled' => true,
        ]);

        // when running the late notification command
        Artisan::call(NotifyLatePayments::class);

        // then it should send a new reminder and update the date
        $payment->refresh();
        $this->assertTrue($payment->last_reminded_at->isToday());
        $this->assertEquals(PaymentNotificationStatus::LateReminder, $payment->notification_status);
    }

    #[Test]
    public function notification_is_not_sent_if_toggle_is_disabled()
    {
        // given a payment due today but with notifications disabled
        $payment = Payment::factory()->create([
            'payment_status' => PaymentStatus::Pending,
            'due_date' => now()->toDateString(),
            'is_notification_enabled' => false,
        ]);

        // when running the due date notification command
        Artisan::call(NotifyDuePayments::class);

        // then no reminder should be registered
        $payment->refresh();
        $this->assertNull($payment->last_reminded_at);
    }

    #[Test]
    public function notifications_are_ignored_for_paid_payments()
    {
        // given a payment that is already paid
        $payment = Payment::factory()->create([
            'payment_status' => PaymentStatus::Paid,
            'due_date' => now()->toDateString(),
            'is_notification_enabled' => true,
        ]);

        // when running the notification commands
        Artisan::call(NotifyEarlyPayments::class);
        Artisan::call(NotifyDuePayments::class);
        Artisan::call(NotifyLatePayments::class);

        // then it should not update the reminder date
        $payment->refresh();
        $this->assertNull($payment->last_reminded_at);
    }
}
