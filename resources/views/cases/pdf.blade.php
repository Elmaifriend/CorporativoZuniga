@extends('layouts.pdf')

@section('title', 'Detalle de Expediente')

@section('content')
    <div class="section">
        <div class="section-title">Información General del Expediente</div>
        <table class="grid">
            <tr>
                <td class="label">Nombre del Caso:</td>
                <td class="value" style="font-weight: bold; font-size: 12pt;">{{ $clientCase->case_name }}</td>
                <td class="label">Expediente:</td>
                <td class="value">#{{ $clientCase->external_expedient_number }}</td>
            </tr>
            <tr>
                <td class="label">Cliente:</td>
                <td class="value">{{ $clientCase->client->full_name }}</td>
                <td class="label">Estatus:</td>
                <td class="value">
                    @php
                        $caseStatuses = ['Abierto' => 'badge-info', 'En Proceso' => 'badge-warning', 'Cerrado' => 'badge-success', 'Pausado' => 'badge-gray'];
                    @endphp
                    <span class="badge {{ $caseStatuses[$clientCase->status] ?? 'badge-gray' }}">{{ $clientCase->status }}</span>
                </td>
            </tr>
            <tr>
                <td class="label">Materia / Tipo:</td>
                <td class="value">{{ $clientCase->case_type }} / {{ $clientCase->case_sub_type }}</td>
                <td class="label">Abogado Resp.:</td>
                <td class="value">{{ $clientCase->responsable->name ?? 'No asignado' }}</td>
            </tr>
            <tr>
                <td class="label">Fecha Inicio:</td>
                <td class="value">{{ \Carbon\Carbon::parse($clientCase->start_date)->format('d/m/Y') }}</td>
                <td class="label">Cierre Estimado:</td>
                <td class="value">{{ \Carbon\Carbon::parse($clientCase->stimated_finish_date)->format('d/m/Y') }}</td>
            </tr>
            @if($clientCase->resume)
            <tr>
                <td class="label">Resumen:</td>
                <td class="value" colspan="3">{!! $clientCase->resume !!}</td>
            </tr>
            @endif
        </table>
    </div>

    @php
        $casePayments = $clientCase->payments;
        $procedurePayments = collect();
        foreach($clientCase->procedures as $proc) {
            $procedurePayments = $procedurePayments->concat($proc->payments);
        }
        
        $totalPaid = 0;
        $totalPending = 0;
        $allCaseRelatedPayments = $casePayments->concat($procedurePayments);
        
        foreach($allCaseRelatedPayments as $p) {
            if($p->payment_status === \App\Enums\PaymentStatus::Paid) $totalPaid += $p->amount;
            elseif($p->payment_status === \App\Enums\PaymentStatus::Pending || $p->payment_status === \App\Enums\PaymentStatus::Partial) $totalPending += $p->amount;
        }

        $globalTotal = (float)$clientCase->total_pricing;
        if ($clientCase->billing_mode !== 'by_case') {
            $globalTotal = $allCaseRelatedPayments->sum('amount');
        }
    @endphp

    <div class="section">
        <div class="section-title">Control Financiero ({{ $clientCase->billing_mode === 'by_case' ? 'Facturación Global' : 'Facturación por Trámites' }})</div>
        <div class="summary-box">
            <div class="summary-item">
                <span class="summary-label">Costo Total</span>
                <span class="summary-value">${{ number_format($globalTotal, 2) }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Total Pagado</span>
                <span class="summary-value" style="color: #166534;">${{ number_format($totalPaid, 2) }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Saldo Pendiente</span>
                <span class="summary-value" style="color: #991b1b;">${{ number_format($globalTotal - $totalPaid, 2) }}</span>
            </div>
        </div>
    </div>

    @if($clientCase->procedures->count() > 0)
    <div class="section">
        <div class="section-title">Trámites y Gestiones</div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Título del Trámite</th>
                        <th>Responsable</th>
                        <th>Estatus</th>
                        <th>Prioridad</th>
                        <th>Pagado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clientCase->procedures as $procedure)
                    <tr>
                        <td style="font-weight: bold;">{{ $procedure->title }}</td>
                        <td>{{ $procedure->responsable_employee }}</td>
                        <td>
                            @php
                                $pStatuses = ['pending' => 'badge-warning', 'in_progress' => 'badge-info', 'completed' => 'badge-success'];
                                $pLabels = ['pending' => 'Pendiente', 'in_progress' => 'En Progreso', 'completed' => 'Finalizado'];
                            @endphp
                            <span class="badge {{ $pStatuses[$procedure->status] ?? 'badge-gray' }}">{{ $pLabels[$procedure->status] ?? $procedure->status }}</span>
                        </td>
                        <td>
                            @php
                                $prioColors = ['low' => 'badge-gray', 'medium' => 'badge-info', 'high' => 'badge-danger'];
                                $prioLabels = ['low' => 'Baja', 'medium' => 'Media', 'high' => 'Alta'];
                            @endphp
                            <span class="badge {{ $prioColors[$procedure->priority] ?? 'badge-gray' }}">{{ $prioLabels[$procedure->priority] ?? $procedure->priority }}</span>
                        </td>
                        <td>
                            @php
                                $procPaid = $procedure->payments->where('payment_status', \App\Enums\PaymentStatus::Paid)->sum('amount');
                                $procTotal = $procedure->payments->sum('amount');
                            @endphp
                            ${{ number_format($procPaid, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if($allCaseRelatedPayments->count() > 0)
    <div class="section">
        <div class="section-title">Historial de Pagos y Plan de Cobro</div>
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
                    @foreach($allCaseRelatedPayments->sortBy('due_date') as $payment)
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
