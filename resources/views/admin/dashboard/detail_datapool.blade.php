<div
    {{--Maps --}}
    data-latitude="{{ $data->latitude }}" 
    data-longitude="{{ $data->longitude }}">
    
    <h5>{{ $data->nama_pool }}</h5>
    <p><strong>Pengawas:</strong> {{ $data->pekerja->nama_pekerja }}</p>
    <p><strong>Shift:</strong> {{ $data->shift->shift_nama }}</p>
    <p><strong>Koridor:</strong> {{$data->koridor->koridor_nama}}</p>
    <p><strong>Pool:</strong> {{$data->pool->pool_nama}}</p>
    <p><strong>Waktu:</strong> {{ $data->tanggal_waktu_pool }}</p>

    <!-- Container untuk peta -->
    <p><strong>Lokasi:</strong> {{$data->lokasi_pool}}</p>
    <div id="mini-map"></div>
    <hr>
    <p style="margin-bottom: 0px"><strong>Bukti Kebersihan Lantai:</strong></p>
    <div class="image-container">
        <img src="{{ asset('storage/' . $data->bukti_kebersihan_lantai_pool) }}" alt="Bukti Kebersihan">
    </div>
    <p style="margin-bottom: 0px"><strong>Bukti Kebersihan Kaca:</strong></p>
    <div class="image-container">
        <img src="{{ asset('storage/' . $data->bukti_kebersihan_kaca_pool) }}" alt="Bukti Kebersihan">
    </div>
    <p style="margin-bottom: 0px"><strong>Bukti Kebersihan Sampah:</strong></p>
    <div class="image-container">
        <img src="{{ asset('storage/' . $data->bukti_kebersihan_sampah_pool) }}" alt="Bukti Kebersihan">
    </div>
    <p style="margin-bottom: 0px"><strong>Bukti Kondisi Pool:</strong></p>
    <div class="image-container">
        <img src="{{ asset('storage/' . $data->bukti_kondisi_pool) }}" alt="Bukti Kebersihan">
    </div>
    <hr>
    <p><strong>Kendala Pool:</strong></p>
    <ul>
        @forelse ($kendala as $item)
            <li>
                @if ($item->kendalaPool)
                    {{ $item->kendalaPool->kendala_pool}}
                @else
                    Kendala tidak ada
                @endif
            </li>
        @empty
            <li>Kendala tidak ada</li>
        @endforelse
        
    </ul>
    <p style="margin-bottom: 0px"><strong>Bukti Kendala Pool:</strong></p>
    <div class="image-container">
        @if ($data->bukti_kendala_pool)
            <img src="{{ asset('storage/' . $data->bukti_kendala_pool) }}" alt="Bukti Kendala">
        @else
            Kendala tidak ada
        @endif
        
    </div>
</div>