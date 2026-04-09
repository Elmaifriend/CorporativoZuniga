@extends('layouts.pdf')

@section('title', 'Detalle de Trámite')

@section('content')
    <div class="section">
        <div class="section-title">Información del Trámite</div>
        <table class="grid">
            <tr>
                <td class="label">Título:</td>
                <td class="value" style="font-weight: bold; font-size: 12pt;">{{ $procedure->title }}</td>
                <td class="label">ID:</td>
                <td class="value">#{{ $procedure->id }}</td>
            </tr>
            <tr>
                <td class="label">Expediente:</td>
                <td class="value">{{ $procedure->clientCase->case_name }}</td>
                <td class="label">Cliente:</td>
                <td class="value">{{ $procedure->clientCase->client->full_name }}</td>
            </tr>
            <tr>
                <td class="label">Responsable:</td>
                <td class="value">{{ $procedure->responsable_employee }}</td>
                <td class="label">Estatus:</td>
                <td class="value">
                    @php
                        $pStatuses = ['pending' => 'badge-warning', 'in_progress' => 'badge-info', 'completed' => 'badge-success'];
                        $pLabels = ['pending' => 'Pendiente', 'in_progress' => 'En Progreso', 'completed' => 'Finalizado'];
                    @endphp
                    <span class="badge {{ $pStatuses[$procedure->status] ?? 'badge-gray' }}">{{ $pLabels[$procedure->status] ?? $procedure->status }}</span>
                </td>
            </tr>
            <tr>
                <td class="label">Prioridad:</td>
                <td class="value">
                    @php
                        $prioColors = ['low' => 'badge-gray', 'medium' => 'badge-info', 'high' => 'badge-danger'];
                        $prioLabels = ['low' => 'Baja', 'medium' => 'Media', 'high' => 'Alta'];
                    @endphp
                    <span class="badge {{ $prioColors[$procedure->priority] ?? 'badge-gray' }}">{{ $prioLabels[$procedure->priority] ?? $procedure->priority }}</span>
                </td>
                <td class="label">Fecha Inicio:</td>
                <td class="value">{{ $procedure->starting_date ? $procedure->starting_date->format('d/m/Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Fecha Límite:</td>
                <td class="value" style="color: #991b1b; font-weight: bold;">{{ $procedure->limit_date ? $procedure->limit_date->format('d/m/Y') : 'Sin límite' }}</td>
                <td class="label">Última Act.:</td>
                <td class="value">{{ $procedure->last_update ? $procedure->last_update->format('d/m/Y') : 'N/A' }}</td>
            </tr>
        </table>
    </div>

    @php
        $totalPaid = $procedure->payments->where('payment_status', \App\Enums\PaymentStatus::Paid)->sum('amount');
        $totalPending = $procedure->payments->whereIn('payment_status', [\App\Enums\PaymentStatus::Pending, \App\Enums\PaymentStatus::Partial])->sum('amount');
        $totalCost = $procedure->payments->sum('amount');
    @endphp

    @if($totalCost > 0)
    <div class="section">
        <div class="section-title">Resumen de Pagos del Trámite</div>
        <div class="summary-box">
            <div class="summary-item">
                <span class="summary-label">Costo del Trámite</span>
                <span class="summary-value">${{ number_format($totalCost, 2) }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Monto Pagado</span>
                <span class="summary-value" style="color: #166534;">${{ number_format($totalPaid, 2) }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Pendiente</span>
                <span class="summary-value" style="color: #991b1b;">${{ number_format($totalPending, 2) }}</span>
            </div>
        </div>
    </div>
    @endif

    @if($procedure->payments->count() > 0)
    <div class="section">
        <div class="section-title">Desglose de Cuotas y Pagos</div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Vencimiento</th>
                        <th>Monto</th>
                        <th>Método</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($procedure->payments->sortBy('due_date') as $payment)
                    <tr>
                        <td>{{ $payment->concept }}</td>
                        <td>{{ $payment->due_date ? $payment->due_date->format('d/m/Y') : '-' }}</td>
                        <td style="font-weight: bold;">${{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->payment_method }}</td>
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
