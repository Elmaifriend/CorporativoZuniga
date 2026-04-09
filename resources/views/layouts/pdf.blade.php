<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 1cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #2d3748;
            line-height: 1.5;
            font-size: 11pt;
            margin: 0;
            padding: 0;
        }
        .header {
            border-bottom: 2px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header table {
            width: 100%;
            border: none;
        }
        .header h1 {
            margin: 0;
            color: #1e40af;
            font-size: 24pt;
            text-transform: uppercase;
        }
        .header .subtitle {
            font-size: 10pt;
            color: #64748b;
            margin-top: 5px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            color: #1e40af;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        .grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .grid td {
            padding: 8px 5px;
            vertical-align: top;
            border-bottom: 1px solid #f1f5f9;
        }
        .label {
            font-weight: bold;
            color: #475569;
            width: 30%;
            font-size: 10pt;
        }
        .value {
            color: #1e293b;
            width: 70%;
        }
        .table-container {
            width: 100%;
            margin-top: 10px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
        }
        table.data-table th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: bold;
            text-align: left;
            padding: 10px 8px;
            border-bottom: 2px solid #e2e8f0;
            font-size: 9pt;
            text-transform: uppercase;
        }
        table.data-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10pt;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-success { background-color: #dcfce7; color: #166534; }
        .badge-warning { background-color: #fef9c3; color: #854d0e; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
        .badge-info { background-color: #e0f2fe; color: #075985; }
        .badge-gray { background-color: #f1f5f9; color: #475569; }

        .summary-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .summary-item {
            display: inline-block;
            width: 32%;
            text-align: center;
        }
        .summary-label {
            display: block;
            font-size: 9pt;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .summary-value {
            display: block;
            font-size: 14pt;
            font-weight: bold;
            color: #1e293b;
        }
        .text-right { text-align: right; }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 8pt;
            color: #94a3b8;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td>
                    <h1>@yield('title', 'Expediente Legal')</h1>
                    <div class="subtitle">Corporativo Zúñiga - Sistema de Gestión Legal</div>
                </td>
                <td class="text-right">
                    <div style="font-size: 10pt; color: #64748b;">
                        Fecha de Emisión: {{ date('d/m/Y H:i') }}<br>
                        Generado por: {{ auth()->user()->name ?? 'Sistema' }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    @yield('content')

    <div class="footer">
        Este documento es para uso informativo. Corporativo Zúñiga &copy; {{ date('Y') }} - Página <span class="pagenum"></span>
    </div>
</body>
</html>
