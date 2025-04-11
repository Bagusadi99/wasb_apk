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
