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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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

        .rank-1 {
            background: #fef3c7;
        }

        .rank-2 {
            background: #f3f4f6;
        }

        .rank-3 {
            background: #fed7aa;
        }

        .points {
            font-weight: bold;
            color: #10b981;
            text-align: right;
        }

        .rank {
            font-weight: bold;
            text-align: center;
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
        <p>Top 50 Santri dengan Poin Tertinggi</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">Rank</th>
                <th>Nama Santri</th>
                <th style="width: 100px; text-align: right;">Total Poin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($santris as $index => $santri)
            <tr class="{{ $index < 3 ? 'rank-' . ($index + 1) : '' }}">
                <td class="rank">{{ $index + 1 }}</td>
                <td>{{ $santri->name }}</td>
                <td class="points">{{ number_format($santri->total_points, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Digenerate pada {{ $generatedAt }} | SITARA - TPA Ramadan</p>
    </div>
</body>

</html>