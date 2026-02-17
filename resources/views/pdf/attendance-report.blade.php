<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #10b981;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #10b981;
            margin: 0 0 5px 0;
            font-size: 24px;
        }

        .header p {
            margin: 0;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background: #f3f4f6;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }

        .status-hadir {
            color: #10b981;
            font-weight: bold;
        }

        .status-izin {
            color: #3b82f6;
            font-weight: bold;
        }

        .status-sakit {
            color: #f59e0b;
            font-weight: bold;
        }

        .status-alpha {
            color: #ef4444;
            font-weight: bold;
        }

        .summary {
            margin-bottom: 20px;
        }

        .summary td {
            text-align: center;
            padding: 10px;
            border-radius: 8px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>{{ $date }}</p>
    </div>

    <table class="summary">
        <tr>
            <td style="background: #d1fae5; color: #065f46;">
                <strong>Hadir</strong><br>{{ $totalHadir }}
            </td>
            <td style="background: #dbeafe; color: #1e40af;">
                <strong>Izin</strong><br>{{ $totalIzin }}
            </td>
            <td style="background: #fef3c7; color: #92400e;">
                <strong>Sakit</strong><br>{{ $totalSakit }}
            </td>
            <td style="background: #fee2e2; color: #991b1b;">
                <strong>Alpha</strong><br>{{ $totalAlpha }}
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Santri</th>
                <th>Status</th>
                <th>Waktu Hadir</th>
                <th>Poin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $index => $att)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $att->santri->name ?? '-' }}</td>
                <td class="status-{{ $att->status }}">{{ ucfirst($att->status) }}</td>
                <td>{{ $att->check_in_time ?? '-' }}</td>
                <td>+{{ $att->points_gained }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Digenerate pada {{ $generatedAt }} | SITARA - TPA Ramadan</p>
    </div>
</body>

</html>