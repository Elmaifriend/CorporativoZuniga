<?php

namespace App\Filament\Resources\ClientCases\Pages;

use App\Filament\Resources\ClientCases\ClientCaseResource;
use App\Enums\PaymentStatus;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateClientCase extends CreateRecord
{
    protected static string $resource = ClientCaseResource::class;

    protected function afterCreate(): void
    {
        $case = $this->record;
        
        // Filament permite acceder a los datos efímeros desde el formulario crudo
        $data = $this->form->getRawState();

        if (($data['billing_mode'] ?? 'by_case') !== 'by_case') {
            return; // Si cobran por trámite, no hacemos nada aquí.
        }

        $totalCost = (float) ($data['total_pricing'] ?? 0);
        $initialCost = (float) ($data['initial_cost'] ?? 0);
        $installmentsCount = (int) ($data['installments'] ?? 0);
        $interval = $data['installment_interval'] ?? 'monthly';

        if ($totalCost <= 0) return;

        DB::transaction(function () use ($case, $initialCost, $totalCost, $installmentsCount, $interval) {

            if ($initialCost > 0) {
                $case->payments()->create([
                    'client_id' => $case->client_id,
                    'amount' => $initialCost,
                    'concept' => "Anticipo: {$case->case_name}",
                    'payment_method' => 'Efectivo',
                    'due_date' => now(),
                    'payment_status' => PaymentStatus::Paid,
                    'is_notification_enabled' => false,
                ]);
            }

            if ($installmentsCount > 0) {
                $remainingAmount = max(0, $totalCost - $initialCost);
                $amountPerInstallment = round($remainingAmount / $installmentsCount, 2);

                $dateAddMethod = match ($interval) {
                    'weekly', 'biweekly' => 'addWeeks',
                    'yearly' => 'addYears',
                    default => 'addMonths',
                };
                $increment = ($interval === 'biweekly') ? 2 : 1;

                for ($i = 1; $i <= $installmentsCount; $i++) {
                    $case->payments()->create([
                        'client_id' => $case->client_id,
                        'amount' => $amountPerInstallment,
                        'concept' => "Cuota {$i}/{$installmentsCount}: {$case->case_name}",
                        'payment_method' => 'Pendiente de definir',
                        'due_date' => now()->$dateAddMethod($i * $increment),
                        'payment_status' => PaymentStatus::Pending,
                        'is_notification_enabled' => true,
                    ]);
                }
            }
        });
    }
}