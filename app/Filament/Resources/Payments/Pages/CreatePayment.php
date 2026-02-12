<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $selector = $data['paymentable_selector'] ?? null;

        if (!$selector) {
            throw new \Exception('Debes seleccionar el tipo de pago.');
        }

        if ($selector === 'case') {
            if (empty($data['paymentable_id'])) {
                throw new \Exception('Debes seleccionar un caso.');
            }

            $data['paymentable_type'] = \App\Models\ClientCase::class;
            $data['paymentable_id'] = $data['paymentable_id'];
        }

        if ($selector === 'recurrent') {
            if (empty($data['recurrent_payment_id'])) {
                throw new \Exception('Debes seleccionar un pago recurrente.');
            }

            $data['paymentable_type'] = \App\Models\RecurrentPayment::class;
            $data['paymentable_id'] = $data['recurrent_payment_id'];
        }

        unset($data['paymentable_selector']);
        unset($data['recurrent_payment_id']);

        return $data;
    }
}
