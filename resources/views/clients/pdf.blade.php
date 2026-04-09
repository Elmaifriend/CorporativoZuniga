@extends('layouts.pdf')

@section('title', 'Expediente del Cliente')

@section('content')
    <div class="section">
        <div class="section-title">Información del Cliente</div>
        <table class="grid">
            <tr>
                <td class="label">Nombre Completo:</td>
                <td class="value">{{ $client->full_name }}</td>
                <td class="label">ID:</td>
                <td class="value">#{{ $client->id }}</td>
            </tr>
            <tr>
                <td class="label">Tipo de Persona:</td>
                <td class="value">{{ ucfirst($client->person_type) }}</td>
                <td class="label">Tipo de Cliente:</td>
                <td class="value"><span class="badge {{ $client->client_type === 'cliente' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($client->client_type) }}</span></td>
            </tr>
            <tr>
                <td class="label">Teléfono:</td>
                <td class="value">{{ $client->phone_number }}</td>
                <td class="label">Correo:</td>
                <td class="value">{{ $client->email }}</td>
            </tr>
            <tr>
                <td class="label">CURP:</td>
                <td class="value">{{ $client->curp }}</td>
                <td class="label">RFC:</td>
                <td class="value">{{ $client->rfc }}</td>
            </tr>
            <tr>
                <td class="label">Ocupación:</td>
                <td class="value">{{ $client->occupation ?? 'No especificada' }}</td>
                <td class="label">Nacimiento:</td>
                <td class="value">{{ $client->date_of_birth ? \Carbon\Carbon::parse($client->date_of_birth)->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Dirección:</td>
                <td class="value" colspan="3">{{ $client->address ?? 'No proporcionada' }}</td>
            </tr>
        </table>
    </div>

    @php
        $totalPaid = 0;
        $totalPending = 0;
        $allPayments = $client->payments()->get();
        foreach($allPayments as $p) {
            if($p->payment_status === \App\Enums\PaymentStatus::Paid) $totalPaid += $p->amount;
            elseif($p->payment_status === \App\Enums\PaymentStatus::Pending || $p->payment_status === \App\Enums\PaymentStatus::Partial) $totalPending += $p->amount;
        }
    @endphp

    <div class="summary-box">
        <div class="summary-item">
            <span class="summary-label">Total Pagado</span>
            <span class="summary-value" style="color: #166534;">${{ number_format($totalPaid, 2) }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Total Pendiente</span>
            <span class="summary-value" style="color: #991b1b;">${{ number_format($totalPending, 2) }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Saldo Total Estimado</span>
            <span class="summary-value">${{ number_format($totalPaid + $totalPending, 2) }}</span>
        </div>
    </div>

    @if($client->cases->count() > 0)
    <div class="section">
        <div class="section-title">Expedientes / Casos Activos</div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Caso</th>
                        <th>Tipo</th>
                        <th>Estatus</th>
                        <th>Inicio</th>
                        <th>Progreso Pago</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($client->cases as $case)
                    <tr>
                        <td style="font-weight: bold;">{{ $case->case_name }}</td>
                        <td>{{ $case->case_type }}</td>
                        <td>
                            @php
                                $caseStatuses = ['Abierto' => 'badge-info', 'En Proceso' => 'badge-warning', 'Cerrado' => 'badge-success', 'Pausado' => 'badge-gray'];
                            @endphp
                            <span class="badge {{ $caseStatuses[$case->status] ?? 'badge-gray' }}">{{ $case->status }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($case->start_date)->format('d/m/Y') }}</td>
                        <td>
                            @if($case->billing_mode === 'by_case')
                                {{ $case->paidPorcentage }}%
                            @else
                                <span style="font-size: 8pt; color: #64748b;">(Por trámites)</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($allPayments->count() > 0)
    <div class="section">
        <div class="section-title">Últimos Pagos y Cuotas Pendientes</div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Fecha/Vencimiento</th>
                        <th>Monto</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allPayments->sortByDesc('due_date')->take(10) as $payment)
                    <tr>
                        <td>{{ $payment->concept }}</td>
                        <td>{{ $payment->due_date ? $payment->due_date->format('d/m/Y') : $payment->created_at->format('d/m/Y') }}</td>
                        <td style="font-weight: bold;">${{ number_format($payment->amount, 2) }}</td>
                        <td>
                            <span class="badge {{ 
                                $payment->payment_status === \App\Enums\PaymentStatus::Paid ? 'badge-success' : 
                                ($payment->payment_status === \App\Enums\PaymentStatus::Pending ? 'badge-warning' : 'badge-info') 
                            }}">
                                {{ $payment->payment_status->label() }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection
