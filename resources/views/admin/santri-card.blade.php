<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Santri - {{ $santri->name }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .card {
            width: 340px;
            height: 214px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            position: relative;
        }

        /* Front Card */
        .card-front {
            background: linear-gradient(135deg, #fcd9b6 0%, #fef3c7 50%, #fbbf24 100%);
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .card-front-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .logo {
            width: 40px;
            height: 40px;
            background: #0d9488;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo svg {
            width: 24px;
            height: 24px;
            color: white;
        }

        .org-name {
            font-weight: 700;
            font-size: 14px;
            color: #1f2937;
        }

        .org-subtitle {
            font-size: 10px;
            color: #6b7280;
        }

        .card-front-body {
            display: flex;
            gap: 15px;
            flex: 1;
        }

        .avatar {
            width: 70px;
            height: 70px;
            border-radius: 12px;
            background: #e5e7eb;
            overflow: hidden;
            border: 3px solid white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 24px;
            color: #6b7280;
            background: #e5e7eb;
        }

        .info {
            flex: 1;
        }

        .info-name {
            font-weight: 700;
            font-size: 16px;
            color: #1f2937;
            margin-bottom: 2px;
        }

        .info-class {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 10px;
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .info-row svg {
            width: 12px;
            height: 12px;
        }

        /* Back Card */
        .card-back {
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .qr-container {
            background: white;
            padding: 10px;
            border-radius: 12px;
            margin-bottom: 10px;
        }

        #qrcode {
            width: 100px;
            height: 100px;
        }

        .token-text {
            font-size: 10px;
            opacity: 0.8;
            margin-bottom: 10px;
        }

        .scan-instruction {
            font-size: 11px;
            font-weight: 500;
            text-align: center;
        }

        .ramadan-badge {
            position: absolute;
            bottom: 10px;
            right: 15px;
            font-size: 9px;
            opacity: 0.7;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .card-container {
                flex-direction: row;
                gap: 10px;
            }

            .card {
                box-shadow: none;
                border: 1px solid #e5e7eb;
            }

            .no-print {
                display: none;
            }
        }

        .print-btn {
            margin-top: 20px;
            padding: 12px 24px;
            background: #0d9488;
            color: white;
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .print-btn:hover {
            background: #0f766e;
        }
    </style>
</head>

<body>
    <div class="card-container">
        <!-- Front Card -->
        <div class="card card-front">
            <div class="card-front-header">
                <div class="logo">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <div class="org-name">SITARA</div>
                    <div class="org-subtitle">Sistem Informasi TPA Ramadan</div>
                </div>
            </div>
            <div class="card-front-body">
                <div class="avatar">
                    @if($santri->avatar)
                    <img src="{{ santri_image($santri->avatar) }}" alt="{{ $santri->name }}">
                    @else
                    <div class="avatar-placeholder">{{ substr($santri->name, 0, 1) }}</div>
                    @endif
                </div>
                <div class="info">
                    <div class="info-name">{{ $santri->name }}</div>
                    <div class="info-class">Santri TPA Ramadan {{ date('Y') }}</div>
                    <div class="info-row">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Wali: {{ $santri->parent_name }}</span>
                    </div>
                    <div class="info-row">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>{{ $santri->parent_phone }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Card -->
        <div class="card card-back">
            <div class="qr-container">
                <div id="qrcode"></div>
            </div>
            <div class="token-text">ID: {{ substr($santri->qr_token, 0, 8) }}</div>
            <div class="scan-instruction">Scan QR ini untuk absensi kehadiran</div>
            <div class="ramadan-badge">REIMAKE © {{ date('Y') }}</div>
        </div>

        <!-- Print Button -->
        <button class="print-btn no-print" onclick="window.print()">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Kartu
        </button>
    </div>

    <script>
        new QRCode(document.getElementById("qrcode"), {
            text: "{{ $santri->qr_token }}",
            width: 100,
            height: 100,
            colorDark: "#0d9488",
            colorLight: "#ffffff",
        });
    </script>
</body>

</html>