<div
    {{--Maps --}}
    data-latitude="{{ $data->latitude }}" 
    data-longitude="{{ $data->longitude }}">
    
    <h5>{{ $data->nama_halte }}</h5>
    <p><strong>Pengawas:</strong> {{ $data->pekerja->nama_pekerja }}</p>
    <p><strong>Shift:</strong> {{ $data->shift->shift_nama }}</p>
    <p><strong>Koridor:</strong> {{$data->koridor->koridor_nama}}</p>
    <p><strong>Halte:</strong> {{$data->halte->halte_nama}}</p>
    <p><strong>Waktu:</strong> {{ $data->tanggal_waktu_halte }}</p>

    <!-- Container untuk peta -->
    <p><strong>Lokasi:</strong></p>
    <div id="mini-map"></div>
    <hr>
    <p style="margin-bottom: 0px"><strong>Bukti Kebersihan Lantai:</strong></p>
    <div class="image-container">
        <img src="{{ asset('storage/' . $data->bukti_kebersihan_lantai_halte) }}" alt="Bukti Kebersihan">
    </div>
    <p style="margin-bottom: 0px"><strong>Bukti Kebersihan Kaca:</strong></p>
    <div class="image-container">
        <img src="{{ asset('storage/' . $data->bukti_kebersihan_kaca_halte) }}" alt="Bukti Kebersihan">
    </div>
    <p style="margin-bottom: 0px"><strong>Bukti Kebersihan Sampah:</strong></p>
    <div class="image-container">
        <img src="{{ asset('storage/' . $data->bukti_kebersihan_sampah_halte) }}" alt="Bukti Kebersihan">
    </div>
    <p style="margin-bottom: 0px"><strong>Bukti Kondisi Halte:</strong></p>
    <div class="image-container">
        <img src="{{ asset('storage/' . $data->bukti_kondisi_halte) }}" alt="Bukti Kebersihan">
    </div>
    <hr>
    <p><strong>Kendala Halte:</strong> {{$data->kendala_halte}}</p>
    <p style="margin-bottom: 0px"><strong>Bukti Kendala Halte:</strong></p>
    <div class="image-container">
        <img src="{{ asset('storage/' . $data->bukti_kendala_halte) }}" alt="Bukti Kebersihan">
    </div>
</div>