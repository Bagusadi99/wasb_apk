<!DOCTYPE html>
<html>
<head>
    <title>Laporan Halte</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h3>Laporan Data Halte</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Petugas</th>
                <th>Shift</th>
                <th>Tanggal & Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan_halte as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->pekerja->nama_pekerja }}</td>
                    <td>{{ $item->shift->shift_nama }}</td>
                    <td>{{ $item->tanggal_waktu_halte }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
