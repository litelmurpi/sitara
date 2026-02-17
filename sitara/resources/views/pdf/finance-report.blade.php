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

        .summary {
            display: flex;
            margin-bottom: 20px;
        }

        .summary-box {
            flex: 1;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            margin: 0 5px;
        }

        .income {
            background: #d1fae5;
            color: #065f46;
        }

        .expense {
            background: #fee2e2;
            color: #991b1b;
        }

        .balance {
            background: #e0e7ff;
            color: #3730a3;
        }

        .summary-box h3 {
            margin: 0;
            font-size: 11px;
            text-transform: uppercase;
        }

        .summary-box p {
            margin: 5px 0 0 0;
            font-size: 18px;
            font-weight: bold;
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

        .type-income {
            color: #10b981;
        }

        .type-expense {
            color: #ef4444;
        }

        .amount {
            text-align: right;
            font-weight: bold;
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
        <p>Periode: {{ $startDate }} - {{ $endDate }}</p>
    </div>

    <table>
        <tr>
            <td style="background: #d1fae5; text-align: center; width: 33%; border-radius: 8px;">
                <strong style="font-size: 10px; color: #065f46;">PEMASUKAN</strong><br>
                <span style="font-size: 16px; font-weight: bold; color: #065f46;">Rp {{ number_format($totalIncome, 0, ',', '.') }}</span>
            </td>
            <td style="background: #fee2e2; text-align: center; width: 33%; border-radius: 8px;">
                <strong style="font-size: 10px; color: #991b1b;">PENGELUARAN</strong><br>
                <span style="font-size: 16px; font-weight: bold; color: #991b1b;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</span>
            </td>
            <td style="background: #e0e7ff; text-align: center; width: 33%; border-radius: 8px;">
                <strong style="font-size: 10px; color: #3730a3;">SALDO</strong><br>
                <span style="font-size: 16px; font-weight: bold; color: #3730a3;">Rp {{ number_format($balance, 0, ',', '.') }}</span>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Kategori</th>
                <th>Tipe</th>
                <th class="amount">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($finances as $finance)
            <tr>
                <td>{{ $finance->date->format('d/m/Y') }}</td>
                <td>{{ $finance->description }}</td>
                <td>{{ ucfirst($finance->category) }}</td>
                <td class="{{ $finance->type === 'income' ? 'type-income' : 'type-expense' }}">
                    {{ $finance->type === 'income' ? 'Masuk' : 'Keluar' }}
                </td>
                <td class="amount {{ $finance->type === 'income' ? 'type-income' : 'type-expense' }}">
                    Rp {{ number_format($finance->amount, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Digenerate pada {{ $generatedAt }} | SITARA - TPA Ramadan</p>
    </div>
</body>

</html>