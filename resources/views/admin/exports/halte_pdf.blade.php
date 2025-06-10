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
            font-size: 14px;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
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
            max-width: 100px;
            max-height: 70px;
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
                    <img src="{{ public_path('template/dist/assets/compiled/png/logotransjatim.png') }}" alt="Logo">
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
                <th style="width: 5%;">No</th>
                <th style="width: 40%;">Nama Petugas</th>
                <th>Shift</th>
                <th>Koridor</th>
                <th style="width: 5%;">Halte</th>
                <th style="width: 15%;">Tanggal & Waktu</th>
                <th style="width: 20%;">Kebersihan Lantai</th>
                <th style="width: 20%;">Kebersihan Kaca</th>
                <th style="width: 20%;">Kebersihan Sampah</th>
                <th style="width: 20%;">Kebersihan Halte</th>
                <th style="width: 20%;">Kendala</th>
                <th style="width: 20%;">Bukti Kendala</th>

            </tr>
        </thead>
        <tbody>
            @if(is_countable($laporan_halte) && count($laporan_halte) > 0)
                @foreach($laporan_halte as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->pekerja->nama_pekerja }}</td>
                        <td>{{ $item->shift->shift_nama }}</td>
                        <td>{{ $item->koridor->koridor_nama }}</td>
                        <td>{{ $item->halte->halte_nama }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->tanggal_waktu_halte)) }}</td>
                        <td class="image-cell">
                            @if($item->bukti_kebersihan_lantai_halte)
                                <img src="{{ public_path('storage/' . $item->bukti_kebersihan_lantai_halte) }}" alt="Foto Lantai ">
                            @else
                                [Tidak ada bukti]
                            @endif
                        </td>
                        <td class="image-cell">
                            @if($item->bukti_kebersihan_kaca_halte)
                                <img src="{{ public_path('storage/' . $item->bukti_kebersihan_kaca_halte) }}" alt="Foto Lantai ">
                            @else
                                [Tidak ada bukti]
                            @endif
                        </td>
                        <td class="image-cell">
                            @if($item->bukti_kebersihan_sampah_halte)
                                <img src="{{ public_path('storage/' . $item->bukti_kebersihan_sampah_halte) }}" alt=" Foto Sampah ">
                            @else
                                [Tidak ada bukti]
                            @endif
                        </td>
                        <td class="image-cell">
                            @if($item->bukti_kondisi_halte)
                                <img src="{{ public_path('storage/' . $item->bukti_kondisi_halte) }}" alt="Foto Halte ">
                            @else
                                [Tidak ada bukti]
                            @endif
                        </td>

                        <td class="image-cell">
                            @if($item->bukti_kendala_halte)
                                <img src="{{ public_path('storage/' . $item->bukti_kendaala_halte) }}" alt="Foto Kendala ">
                            @else
                                [Tidak ada bukti]
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data yang tersedia</td>
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