<?php

namespace App\Filament\Resources\Procedures\Pages;

use App\Filament\Resources\Procedures\ProcedureResource;
use App\Models\ClientCase;
use App\Enums\PaymentStatus;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateProcedure extends CreateRecord
{
    protected static string $resource = ProcedureResource::class;

    protected function afterCreate(): void
    {
        $procedure = $this->record;
        
        // ¡AQUÍ ESTÁ LA MAGIA! getRawState() recupera todos los datos, 
        // incluso los que tienen ->dehydrated(false)
        $data = $this->form->getRawState();

        $totalCost = (float) ($data['total_cost'] ?? 0);
        $initialCost = (float) ($data['initial_cost'] ?? 0);
        $installmentsCount = (int) ($data['installments'] ?? 0);
        $interval = $data['installment_interval'] ?? 'monthly';

        $clientId = ClientCase::find($procedure->case_id)?->client_id;

        if (!$clientId || $totalCost <= 0) {
            return;
        }

        DB::transaction(function () use ($procedure, $clientId, $initialCost, $totalCost, $installmentsCount, $interval) {

            if ($initialCost > 0) {
                $procedure->payments()->create([
                    'client_id' => $clientId,
                    'amount' => $initialCost,
                    'concept' => "Anticipo: {$procedure->title}",
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
                    'weekly' => 'addWeeks',
                    'biweekly' => 'addWeeks',
                    'yearly' => 'addYears',
                    default => 'addMonths',
                };

                $increment = ($interval === 'biweekly') ? 2 : 1;

                for ($i = 1; $i <= $installmentsCount; $i++) {
                    $dueDate = now()->$dateAddMethod($i * $increment);

                    $procedure->payments()->create([
                        'client_id' => $clientId,
                        'amount' => $amountPerInstallment,
                        'concept' => "Cuota {$i}/{$installmentsCount}: {$procedure->title}",
                        'payment_method' => 'Pendiente de definir',
                        'due_date' => $dueDate,
                        'payment_status' => PaymentStatus::Pending,
                        'is_notification_enabled' => true,
                    ]);
                }
            }
        });
    }
}