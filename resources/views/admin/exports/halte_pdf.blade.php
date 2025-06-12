<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 2px solid #4A8939;
            margin-bottom: 20px;
        }
        .header img {
            max-height: 70px;
            /* Adjust max-height if needed */
        }
        .header h1 {
            color: #4A8939;
            margin: 5px 0;
            font-size: 24px;
            text-align: center;
        }
        .header h2 {
            color: #666;
            margin: 5px 0;
            font-size: 16px;
            font-weight: normal;
            text-align: center;
        }
        .company-info {
            font-size: 12px;
            color: #666;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #4A8939;
            color: white;
            font-weight: bold;
            text-align: left;
            padding: 8px;
            font-size: 11px; /* Slightly smaller font for more columns */
        }
        td {
            border: 1px solid #ddd;
            padding: 5px; /* Reduced padding for more compact cells */
            font-size: 10px; /* Smaller font for table content */
            vertical-align: middle;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 1px solid #ddd;
            padding: 10px 0;
            font-size: 10px;
            text-align: center;
            color: #666;
        }
        .page-number:after {
            content: counter(page);
        }
        .image-cell {
            text-align: center;
        }
        .image-cell img {
            max-width: 80px; /* Reduced max-width for images */
            max-height: 60px; /* Reduced max-height for images */
            height: auto; /* Maintain aspect ratio */
            display: block; /* Ensures image is centered */
            margin: 0 auto; /* Centers the image horizontally */
        }
        .timestamp {
            font-size: 10px;
            text-align: right;
            margin-bottom: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <table style="border: none; margin: 0;">
            <tr style="background: none; border: none;">
                <td style="width: 20%; border: none; text-align: center; vertical-align: middle;">
                    <img src="{{ $logo_base64 }}" alt="Logo Trans Jawa Timur">
                </td>
                <td style="width: 80%; border: none; text-align: center; vertical-align: middle;">
                    <h1>{{ $title }}</h1>
                    <h2>{{ $subtitle }}</h2>
                    <div class="company-info">
                        {{ $company['name'] }} | {{ $company['address'] }} | {{ $company['phone'] }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="timestamp">
        Dicetak pada: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i:s') }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 12%;">Nama Petugas</th>
                <th style="width: 8%;">Shift</th>
                <th style="width: 8%;">Koridor</th>
                <th style="width: 8%;">Halte</th>
                <th style="width: 12%;">Tanggal & Waktu</th>
                <th style="width: 10%;">Lantai</th>
                <th style="width: 10%;">Kaca</th>
                <th style="width: 10%;">Sampah</th>
                <th style="width: 10%;">Kondisi</th>
                <th style="width: 10%;">Kendala</th> <th style="width: 10%;">Bukti Kendala</th> </tr>
        </thead>
        <tbody>
            @if(is_countable($laporan_halte) && count($laporan_halte) > 0)
                @foreach($laporan_halte as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->pekerja->nama_pekerja ?? '-' }}</td>
                        <td>{{ $item->shift->shift_nama ?? '-' }}</td>
                        <td>{{ $item->koridor->koridor_nama ?? '-' }}</td>
                        <td>{{ $item->halte->halte_nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_waktu_halte)->format('d/m/Y H:i') }}</td>
                        <td class="image-cell">
                            @if($item->bukti_kebersihan_lantai_halte_base64)
                
                                <img src="{{ $item->bukti_kebersihan_lantai_halte_base64 }}" alt="Foto Lantai">
                            @else
                                [Tidak ada bukti]
                            @endif
                        </td>
                        <td class="image-cell">
                            @if($item->bukti_kebersihan_kaca_halte_base64)
                                <img src="{{ $item->bukti_kebersihan_kaca_halte_base64 }}" alt="Foto Kaca">
                            @else
                                [Tidak ada bukti]
                            @endif
                        </td>
                        <td class="image-cell">
                            @if($item->bukti_kebersihan_sampah_halte_base64)
                                <img src="{{ $item->bukti_kebersihan_sampah_halte_base64 }}" alt="Foto Sampah">
                            @else
                                [Tidak ada bukti]
                            @endif
                        </td>
                        <td class="image-cell">
                            @if($item->bukti_kondisi_halte_base64)
                                <img src="{{ $item->bukti_kondisi_halte_base64 }}" alt="Foto Kondisi Halte">
                            @else
                                [Tidak ada bukti]
                            @endif
                        </td>
                        <td>
                            @forelse($item->kendalaHaltes as $kendala)
                                {{ $kendala->kendala_halte }}@if(!$loop->last), @endif
                            @empty
                                Tidak ada kendala
                            @endforelse
                        </td>
                        <td class="image-cell">
                            @if($item->bukti_kendala_halte_base64)
                                <img src="{{ $item->bukti_kendala_halte_base64 }}" alt="Bukti Kendala">
                            @else
                                [Tidak ada bukti]
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="12" style="text-align: center;">Tidak ada data yang tersedia</td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="footer">
        <div>Trans Jawa Timur &copy; {{ date('Y') }}. All rights reserved.</div>
        <div class="page-number">Halaman </div>
    </div>
</body>
</html>