<?php

namespace App\Filament\Resources\Procedures\Pages;

use App\Filament\Resources\Procedures\ProcedureResource;
use App\Models\ClientCase;
use Filament\Resources\Pages\CreateRecord;

class CreateProcedure extends CreateRecord
{
    protected static string $resource = ProcedureResource::class;

    protected function afterCreate(): void
    {
        $procedure = $this->record;
        $data = $this->form->getState();

        $initialCost = (float) ($data['initial_cost'] ?? 0);
        $totalCost = (float) ($data['total_cost'] ?? 0);
        $installments = (int) ($data['installments'] ?? 0);
        
        $clientId = ClientCase::find($procedure->case_id)?->client_id;

        if (! $clientId) {
            return; 
        }

        // 1. Registrar el pago inicial como PAGADO
        if ($initialCost > 0) {
            $procedure->payments()->create([
                'client_id' => $clientId,
                'amount' => $initialCost,
                'concept' => 'Pago inicial',
                // Cambiamos de 'Pendiente' a 'Pagado' (o 'Completado', como prefieras)
                'payment_metod' => 'Pagado', 
            ]);
        }

        // 2. Registrar las cuotas restantes como PENDIENTES
        if ($installments > 0) {
            $remaining = max(0, $totalCost - $initialCost);
            $installmentAmount = round($remaining / $installments, 2);

            for ($i = 1; $i <= $installments; $i++) {
                $procedure->payments()->create([
                    'client_id' => $clientId,
                    'amount' => $installmentAmount,
                    'concept' => 'Cuota ' . $i . ' de ' . $installments,
                    'payment_metod' => 'Pendiente',
                ]);
            }
        }
    }
}