<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat dan Laporan Hasil Kegiatan</title>
    <style>
        @page {
            margin: 40px 50px;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.15;
            color: #000;
        }

        /* ====================== KOP SURAT ====================== */
        .kop-container {
            display: table;
            width: 100%;
            margin-bottom: 2px;
            /* jarak ke garis bawah */
        }

        .kop-logo,
        .kop-text {
            display: table-cell;
            vertical-align: middle;
        }

        .kop-logo {
            width: 100px;
            height: auto;
            padding-left: 15px;
            padding-right: 5px;
            /* jarak kiri-kanan logo */
        }

        .kop-text {
            text-align: center;
            padding: 0;
            margin: 0;
            line-height: 1.1;
        }

        .kop-text h1 {
            font-size: 18pt;
            margin: 0;
            font-weight: bolder;
        }

        .kop-text h2 {
            font-size: 14pt;
            margin: 0;
            font-weight: bold;
        }

        .kop-text p {
            font-size: 10pt;
            margin: 1px 0;
            /* biar antarbaris rapat */
            text-align: center;
        }

        .kop-line {
            border-bottom: 3px solid black;
            margin-top: 2px;
            /* jarak ke logo */
        }

        .kop-line::after {
            content: "";
            display: block;
            border-bottom: 1px solid black;
            margin-top: 3px;
        }

        /* ====================== BAGIAN SURAT ====================== */
        .meta-section {
            width: 100%;
            font-size: 12pt;
            margin-top: 10px;
        }

        .meta-table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12pt;
            margin-left: 5px;
        }

        .meta-table td {
            padding: 2px 4px;
            vertical-align: top;
            border: none;
        }

        .meta-table .label {
            width: 80px;
            /* atur sesuai panjang teks */
        }

        .meta-table .colon {
            width: 10px;
            text-align: center;
        }

        .meta-left {
            padding-left: 10px;
            float: left;
            width: 70%;
        }

        .meta-right {
            float: right;
            text-align: left;
            width: 35%;
        }

        .meta-left p,
        .meta-right p {
            margin: 4px 0;
            line-height: 1.2;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        p {
            margin: 4px 0;
            text-align: justify;
            padding-left: 20px;
            padding-right: 20px;
        }

        .tujuan {
            margin-top: 25px;
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .content {
            margin-top: 10px;
            padding-right: 10px;
            text-align: justify;
            line-height: 1.5;
        }

        p.indent {
            text-indent: 30px;
        }

        .ttd {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            /* ⬅️ ini yang bikin ke kanan */
            width: 50%;
            /* batasi lebar area tanda tangan */
            margin-left: auto;
            margin-top: 30px;
            padding-right: 10px;
            /* atur jarak dari tepi kanan */
            line-height: 1.3;
        }

        .ttd p {
            margin: 2px 0;
            text-align: left;
            font-size: 12pt;
        }

        .ttd img {
            display: inline-block;
            /* bukan block */
            height: 100px;
            margin: 0;
            align-items: flex-end;
            /* dorong ke kanan */
            margin-left: auto;
            /* ini kunci biar ke kanan */
            position: relative;
            left: 5%;
            /* ⬅️ tambahkan ini */
        }

        /* ====================== PEMBATAS HALAMAN ====================== */
        .page-break {
            page-break-after: always;
        }

        /* ====================== BAGIAN KAK ====================== */
        .kak-section {
            margin-top: 10px;
            font-size: 12pt;
            line-height: 1.4;
        }

        .kak-section .kak-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            line-height: 1.1;
            margin-top: 10px;
        }

        .kak-section .kak-title h3 {
            font-size: 14pt;
            margin: 0;
            font-weight: bold;
        }

        .kak-section .section-title {
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 16px;
            margin-bottom: 6px;
            text-align: justify;
            padding-left: 20px;
            padding-right: 20px;
        }

        .kak-section .subsection-title {
            font-weight: bold;
            margin-top: 8px;
            margin-bottom: 2px;
            margin-left: 40px;
        }

        .kak-section p {
            margin: 4px 0;
            text-align: justify;
            padding-left: 40px;
            padding-right: 40px;
        }

        .kak-section p.indent {
            text-indent: 30px;
            margin-top: 0;
            margin-bottom: 8px;
            padding-left: 40px;
            padding-right: 40px;
            text-align: justify;
        }

        .kak-section ol,
        .kak-section ul {
            margin: 4px 0 4px 40px;
            padding-left: 20px;
            padding-right: 40px;
            line-height: 1.4;
        }

        .kak-section ol li,
        .kak-section ul li {
            text-align: justify;
            margin-bottom: 3px;
        }

        .kak-section ol ol {
            margin-left: 25px;
            list-style-type: decimal;
        }

        .kak-section table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .kak-section th,
        .kak-section td {
            border: 1px solid black;
            padding: 6px;
            font-size: 11pt;
            border: none;
        }

        .kak-section th {
            text-align: center;
        }

        .kak-section .ttd {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            /* ⬅️ ini yang bikin ke kanan */
            width: 50%;
            /* batasi lebar area tanda tangan */
            margin-left: auto;
            margin-top: 30px;
            padding-right: 10px;
            /* atur jarak dari tepi kanan */
            line-height: 1.3;
        }

        .kak-section .ttd p {
            margin: 2px 0;
            text-align: left;
            font-size: 12pt;
        }

        .kak-section .ttd img {
            display: inline-block;
            /* bukan block */
            height: 100px;
            margin: 0;
            align-items: flex-end;
            /* dorong ke kanan */
            margin-left: auto;
            /* ini kunci biar ke kanan */
            position: relative;
            left: 5%;
            /* ⬅️ tambahkan ini */
        }

        .kak-section .table {
            width: 60%;
            border-collapse: collapse;
            margin-top: 6px;
            padding-left: 40px;
            padding-right: 40px;
        }

        .kak-maksud-tujuan {
            margin-left: 15px;
            padding-left: 20px;
            padding-right: 0;
        }

        .kak-maksud-tujuan ol {
            list-style-type: decimal;
            margin-left: 25px;
            padding-left: 0;
        }

        .kak-maksud-tujuan li {
            text-align: justify;
            margin-bottom: 6px;
        }

        .kak-maksud-tujuan p.indent {
            text-indent: 30px;
            margin: 0px 0 0px 0;
            padding-left: 0;
            padding-right: 0;
        }

        .kak-narasumber-peserta {
            margin-left: 15px;
            padding-left: 20px;
            padding-right: 0;
        }

        .kak-narasumber-peserta ol {
            list-style-type: decimal;
            margin-left: 25px;
            padding-left: 0;
        }

        .kak-narasumber-peserta li {
            text-align: justify;
            margin-bottom: 6px;
        }

        .kak-narasumber-peserta p.indent {
            text-indent: 30px;
            margin: 0px 0 0px 0;
            padding-left: 0;
            padding-right: 0;
        }

        .susunan-acara {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            table-layout: auto;
            font-size: 10.5pt;
            margin-top: 8px;
        }

        .susunan-acara th,
        .susunan-acara td {
            border: 0.7px solid #000;
            padding: 2.5px 3.5px;
            word-wrap: break-word;
            vertical-align: middle;
            line-height: 1.2;
        }

        .susunan-acara th {
            font-weight: bold;
            text-align: center;
            background-color: #fdfdfd;
            font-size: 10.5pt;
            padding: 3px 4px;
        }

        .susunan-acara td {
            text-align: left;
            font-size: 10.3pt;
        }

        /* Kolom angka */
        .susunan-acara td:nth-child(n+6) {
            text-align: right;
        }

        /* Judul Grup (Belanja Bahan Habis Pakai, dsb) */
        .susunan-acara tr.group-row td {
            font-weight: bold;
            text-align: left;
            padding: 4px 5px;
            background-color: #f7f7f7;
            border: 0.7px solid #000;
            font-size: 10.7pt;
            word-spacing: 2px;
            text-transform: capitalize;
        }

        /* Kolom Nomor agar kecil dan proporsional */
        .susunan-acara td:first-child {
            text-align: center;
            width: 30px;
            font-size: 9.5pt;
        }

        /* Agar teks kata panjang seperti “Belanja Operasional Lainnya” tidak nempel */
        .susunan-acara td,
        .susunan-acara th {
            white-space: normal;
            overflow-wrap: break-word;
        }

        /* Kolom nomor kecil & center */
        .susunan-acara .td-nomor {
            text-align: center;
            width: 22px;
            /* sebelumnya 30px, sekarang lebih rapat */
            font-size: 9pt;
            /* sedikit lebih kecil */
            padding: 1px 2px;
            /* padding diperkecil */
            vertical-align: middle;
            white-space: nowrap;
            /* biar angka nggak turun ke bawah */
        }

        /* Kolom isi umum */
        .susunan-acara .td-isi {
            text-align: left;
            padding: 3px 4px;
            font-size: 10.3pt;
            line-height: 1.2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            font-size: 11pt;
        }

        th {
            text-align: center;
        }
    </style>
</head>

<body>
    @php
    $user = $user ?? Auth::user();
    @endphp

    {{-- ====================== SURAT PERMOHONAN ====================== --}}
    <div class="kop-container">
        @if($kop_path && file_exists($kop_path))
        <img src="{{ $kop_path }}" class="kop-logo" alt="Logo Pemerintah Kota Surakarta">
        @endif

        <div class="kop-text">
            <h2>PEMERINTAH KOTA SURAKARTA</h2>
            <h1>BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA</h1>
            <p>Jalan Jenderal Sudirman No. 2 Telp. (0271) 632202 Website dinkes.surakarta.go.id</p>
            <p>Email: dinkes@surakarta.go.id</p>
            <p><strong>SURAKARTA</strong></p>
            <p><strong>57111</strong></p>
        </div>
    </div>

    <div class="kop-line"></div>

    <div class="meta-section clearfix">
        <div class="meta-left">
            <table class="meta-table">
                <tr>
                    <td class="label">Nomor</td>
                    <td class="colon">:</td>
                    <td>{{ $laporankegiatans->identitassurats->nomor_surat ?? '....' }}</td>
                </tr>
                <tr>
                    <td class="label">Sifat</td>
                    <td class="colon">:</td>
                    <td>{{ $laporankegiatans->sifat_surat ?? 'Biasa' }}</td>
                </tr>
                <tr>
                    <td class="label">Lampiran</td>
                    <td class="colon">:</td>
                    <td>{{ $laporankegiatans->identitassurats->lampiran_surat ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td class="colon">:</td>
                    <td><strong>{{ $laporankegiatans->identitassurats->perihal_surat ?? 'Permohonan Rekomendasi Kegiatan Pengembangan Kompetensi' }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="meta-right">
            <p>Surakarta,
                {{ $laporankegiatans->identitassurats->tanggal_surat
                    ? \Carbon\Carbon::parse($laporankegiatans->identitassurats->tanggal_surat)->translatedFormat('d F Y')
                    : '-' }}
            </p>
        </div>
    </div>

    <div class="tujuan">
        <p>Yth.</p>
        <p>Kepala Badan Kepegawaian dan Pengembangan SDM</p>
        <p>Kota Surakarta</p>
        <p><strong>di SURAKARTA</strong></p>
    </div>

    <div class="content">
        <p class="indent">
            Dalam rangka penyelenggaraan kegiatan "{{ $laporankegiatans->usulankegiatans->nama_kegiatan ?? 'Workshop Deteksi dan Intervensi Dini Perkembangan pada Anak dengan Disabilitas untuk Tenaga Kesehatan' }} yang dilaksanakan pada hari {{ $laporankegiatans->tanggalpelaksanaan_kegiatan ?? '18 September 2025' }} di {{ $laporankegiatans->lokasi_kegiatan ?? 'Hotel Alila' }}. Sehubungan dengan hal tersebut, kami mengajukan permohonan penerbitan nomor register guna pembuatan Sertifikat {{ $laporankegiatans->nama_kegiatan ?? 'Workshop Deteksi dan Intervensi Dini Perkembangan pada Anak dengan Disabilitas untuk Tenaga Kesehatan' }}.
        </p>
    </div>

    <div class="ttd">
        <p><strong>Kepala {{ $user->subunitkerjas->sub_unitkerja }}</strong></p>
        <p><strong>Kota Surakarta</strong></p>

        @php
        // 🔍 Langkah 1: ambil dari controller dulu
        $finalPath = $ttd_path ?? null;

        // 🔍 Langkah 2: fallback dari session
        if (empty($finalPath) && session()->has('tandatangan_pjkegiatan')) {
        $finalPath = storage_path('app/public/' . session('tandatangan_pjkegiatan'));
        }

        // 🔍 Langkah 3: fallback ke kemungkinan lokasi lain
        if (empty($finalPath) || !file_exists($finalPath)) {
        // Coba cek apakah filenya ada di storage/izin/tandatangan_pjkegiatan
        $possiblePath = storage_path('app/public/izin/tandatangan_pjkegiatan');
        if (is_dir($possiblePath)) {
        foreach (glob($possiblePath . '/*.png') as $file) {
        $finalPath = $file; // ambil file pertama
        break;
        }
        }
        }
        @endphp

        @if(!empty($finalPath) && file_exists($finalPath))
        @php
        $imageData = base64_encode(file_get_contents($finalPath));
        @endphp
        <img src="data:image/png;base64,{{ $imageData }}"
            alt="Tanda Tangan"
            style="height:90px; margin-top:5px; margin-right:0; display:inline-block;">
        @else
        <p style="color:red; font-size:10pt;">[TTD tidak ditemukan di path {{ $finalPath ?? 'N/A' }}]</p>
        @endif


        <p><strong>{{ $laporankegiatans->nama_pejabat ?? 'dr. Retno Widyastuti, M.Kes' }}</strong></p>
        <p>NIP. {{ $laporankegiatans->nip_pejabat ?? '19791218 200604 1 006' }}</p>
    </div>

    <div class="page-break"></div>

    {{-- ====================== LAPORAN HASIL KEGIATAN ====================== --}}
    <div class="kop-container">
        @if($kop_path && file_exists($kop_path))
        <img src="{{ $kop_path }}" class="kop-logo" alt="Logo Pemerintah Kota Surakarta">
        @endif

        <div class="kop-text">
            <h2>PEMERINTAH KOTA SURAKARTA</h2>
            <h1>BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA</h1>
            <p>Jalan Jenderal Sudirman No. 2 Telp. (0271) 632202 Website dinkes.surakarta.go.id</p>
            <p>Email: dinkes@surakarta.go.id</p>
            <p><strong>SURAKARTA</strong></p>
            <p><strong>57111</strong></p>
        </div>
    </div>

    <div class="kop-line"></div>

    <div class="kak-section">
        <div class="kak-title">
            <h3>LAPORAN HASIL PELAKSANAAN</h3>
            <h3>{{ $laporankegiatans->usulankegiatans->nama_kegiatan ?? '-' }}<br></h3>
            <h3>TAHUN ANGGARAN 2025<br></h3>
        </div>

        @php
        $letterIndex = 0; // mulai dari A
        function getLetter($i) {
        $alphabet = range('A', 'Z');
        return $alphabet[$i] ?? ('Z' . ($i - 25)); // fallback kalau lewat Z
        }
        @endphp


        <p class="section-title">{{ getLetter($letterIndex++) }}. LATAR BELAKANG</p>
        <p class="indent">
            @if(!empty($laporankegiatans->latarbelakang_laporan))
            {!! nl2br(e($laporankegiatans->latarbelakang_laporan)) !!}
            @else
            Lima tahun pertama kehidupan anak merupakan masa krusial atau golden period sekaligus masa kritis...
            @endif
        </p>

        <p class="section-title">{{ getLetter($letterIndex++) }}. DASAR HUKUM</p>
        <ol>
            @if(!empty($laporankegiatans->dasarhukum_laporan))
            <li>{!! nl2br(e($laporankegiatans->dasarhukum_laporan)) !!}</li>
            @else
            <li>Undang-Undang Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara</li>
            <li>Peraturan Menteri Kesehatan Nomor 66 Tahun 2014 tentang Pemantauan Perkembangan Anak</li>
            @endif
        </ol>

        <p class="section-title">{{ getLetter($letterIndex++) }}. MAKSUD DAN TUJUAN</p>
        <div class="kak-maksud-tujuan">
            <ol type="1">
                <li>MAKSUD
                    <p class="indent">
                        {!! nl2br(e($laporankegiatans->maksud_laporan ??
                        'Kegiatan ini dilaksanakan untuk meningkatkan kemampuan pegawai di bidangnya.')) !!}
                    </p>
                </li>
                <li>TUJUAN
                    <ol type="1">
                        <li>Meningkatkan kemampuan teknis tenaga kesehatan.</li>
                        <li>Memperkuat kapasitas pelayanan kesehatan masyarakat.</li>
                    </ol>
                </li>
            </ol>
        </div>

        <p class="section-title">{{ getLetter($letterIndex++) }}. RUANG LINGKUP</p>
        <ol type="1">
            @if(!empty($laporankegiatans->ruanglingkup_laporan))
            <li>{!! nl2br(e($laporankegiatans->ruanglingkup_laporan)) !!}</li>
            @else
            <li>Peningkatan kemampuan tenaga kesehatan dalam deteksi dini tumbuh kembang anak.</li>
            <li>Peningkatan kualitas layanan kesehatan anak di wilayah kerja Dinas Kesehatan Kota Surakarta.</li>
            @endif
        </ol>

        <p class="section-title">{{ getLetter($letterIndex++) }}. RINCIAN KEGIATAN PENGEMBANGAN KOMPETENSI</p>
        <p class="indent">
            @if(!empty($laporankegiatans->detaillaporankegiatans?->rincian_laporan))
            {!! nl2br(e($laporankegiatans->detaillaporankegiatans?->rincian_laporan)) !!}
            @else
            Lima tahun pertama kehidupan anak merupakan masa krusial atau golden period sekaligus masa kritis...
            @endif
        </p>

        <p class="section-title">{{ getLetter($letterIndex++) }}. OUTPUT HASIL KEGIATAN PENGEMBANGAN KOMPETENSI</p>
        <ol type="1">
            @if(!empty($laporankegiatans->detaillaporankegiatans?->outputkegiatan_laporan))
            <li>{!! nl2br(e($laporankegiatans->detaillaporankegiatans?->outputkegiatan_laporan)) !!}</li>
            @else
            <li>Peningkatan kemampuan tenaga kesehatan dalam deteksi dini tumbuh kembang anak.</li>
            <li>Peningkatan kualitas layanan kesehatan anak di wilayah kerja Dinas Kesehatan Kota Surakarta.</li>
            @endif
        </ol>

        <p class="section-title">{{ getLetter($letterIndex++) }}. PELAKSANAAN KEGIATAN PENGEMBANGAN KOMPETENSI</p>
        <div class="kak-narasumber-peserta">
            <ol type="1">
                <li>NAMA KEGIATAN
                    <p class="indent">
                        {{ $laporankegiatans->usulankegiatans->nama_kegiatan ?? '-' }}
                    </p>
                </li>
                <li>METODE KEGIATAN
                    <p class="indent">
                        {{ $laporankegiatans->metodepelatihans->metode_pelatihan ?? 'Klasikal' }}
                    </p>
                </li>
                <li>NARASUMBER KEGIATAN
                    <p class="indent">
                    <ol type="1">
                        @if(!empty($laporankegiatans->narasumber_laporan))
                        <li>{!! nl2br(e($laporankegiatans->narasumber_laporan)) !!}</li>
                        @else
                        <li>Peningkatan kemampuan tenaga kesehatan dalam deteksi dini tumbuh kembang anak.</li>
                        <li>Peningkatan kualitas layanan kesehatan anak di wilayah kerja Dinas Kesehatan Kota Surakarta.</li>
                        @endif
                    </ol>
                    </p>
                </li>
                <li>PELAKSANAAN KEGIATAN
                    <p class="indent">
                    <table class="table">
                        <tr>
                            <td class="label">Hari, Tanggal</td>
                            <td class="colon">:</td>
                            <td>@if($laporankegiatans->usulankegiatans->tanggalpelaksanaan_kegiatan)
                                {{ \Carbon\Carbon::parse($laporankegiatans->usulankegiatans->tanggalpelaksanaan_kegiatan)->translatedFormat('d F Y') }}
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Waktu Pelaksanaan</td>
                            <td class="colon">:</td>
                            <td>@if($laporankegiatans->waktupelaksanaan_laporan)
                                {{ \Carbon\Carbon::parse($laporankegiatans->waktupelaksanaan_laporan)->translatedFormat('d F Y') }}
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="label">Tempat Pelaksanaan</td>
                            <td class="colon">:</td>
                            <td>{{ $laporankegiatans->usulankegiatans->lokasi_kegiatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Organisasi Penyelenggara</td>
                            <td class="colon">:</td>
                            <td>{{ $laporankegiatans->usulankegiatans->lokasi_kegiatan ?? '-' }}</td>
                        </tr>
                    </table>
                    </p>
                </li>
            </ol>
        </div>

        {{-- ====================== ATRIBUT KHUSUS DINAMIS ====================== --}}
        @php
            $hasAtribut = !empty($atribut_khusus) && count(array_filter($atribut_khusus)) > 0;
        @endphp

        @if($hasAtribut)
        @foreach($atribut_khusus as $key => $value)
        @php
        // Huruf urutan (L, M, N, O, ...)
        $letterAbjad = getLetter($letterIndex++);

        // ambil label dari config atribut_khusus (kalau ada)
            $config = config('atribut_khusus');
            $label = null;
            foreach ($config as $item) {
                if (isset($item['fields'][$key]['label'])) {
                    $label = $item['fields'][$key]['label'];
                    break;
                }
            }

            // fallback kalau label gak ditemukan → buat dari key
            if (!$label) {
                $label = preg_replace('/([a-z])([A-Z])/', '$1 $2', $key);
                $label = str_replace('_', ' ', $label);
                $label = ucwords(strtolower($label));
            }

        // Tambahkan spasi sebelum huruf besar & ubah underscore jadi spasi
        /*$subjudul = strtoupper(
            trim(
            preg_replace(
            ['/([a-z])([A-Z])/', '/_/'], // cari huruf kecil diikuti besar, & underscore
            ['$1 $2', ' '], // sisipkan spasi
            $key
            )
        ));*/

            // Deteksi apakah nilai adalah URL
            $isUrl = filter_var($value, FILTER_VALIDATE_URL);
        @endphp

        <p class="section-title">{{ $letterAbjad }}. {{ strtoupper($label) }}</p>
        <p class="indent">
            @if(is_array($value))
            {{ implode(', ', $value) }}
            @elseif($isUrl)
            <a href="{{ $value }}" target="_blank">{{ $value }}</a>
            @else
            {{ $value ?? '-' }}
            @endif
        </p>

        @endforeach
        @endif

        {{-- ==================================================================== --}}

        <p class="section-title">{{ getLetter($letterIndex++) }}. LINK UNDANGAN KEGIATAN</p>
        <p class="indent">
            @if(!empty($laporankegiatans->detaillaporankegiatans?->undangan_laporan))
            {!! nl2br(e($laporankegiatans->detaillaporankegiatans?->undangan_laporan)) !!}
            @else
            Lima tahun pertama kehidupan anak merupakan masa krusial atau golden period sekaligus masa kritis...
            @endif
        </p>

        <p class="section-title">{{ getLetter($letterIndex++) }}. LINK MATERI KEGIATAN</p>
        <p class="indent">
            @if(!empty($laporankegiatans->detaillaporankegiatans?->materi_laporan))
            {!! nl2br(e($laporankegiatans->detaillaporankegiatans?->materi_laporan)) !!}
            @else
            Lima tahun pertama kehidupan anak merupakan masa krusial atau golden period sekaligus masa kritis...
            @endif
        </p>

        <p class="section-title">{{ getLetter($letterIndex++) }}. LINK DAFTAR HADIR KEGIATAN</p>
        <p class="indent">
            @if(!empty($laporankegiatans->detaillaporankegiatans?->daftarhadir_laporan))
            {!! nl2br(e($laporankegiatans->detaillaporankegiatans?->daftarhadir_laporan)) !!}
            @else
            Lima tahun pertama kehidupan anak merupakan masa krusial atau golden period sekaligus masa kritis...
            @endif
        </p>
        <p class="section-title">{{ getLetter($letterIndex++) }}. LINK DOKUMENTASI KEGIATAN</p>
        <p class="indent">
            @if(!empty($laporankegiatans->detaillaporankegiatans?->dokumentasi_laporan))
            {!! nl2br(e($laporankegiatans->detaillaporankegiatans?->dokumentasi_laporan)) !!}
            @else
            Lima tahun pertama kehidupan anak merupakan masa krusial atau golden period sekaligus masa kritis...
            @endif
        </p>

        <p class="section-title">{{ getLetter($letterIndex++) }}. RUNDOWN KEGIATAN PENGEMBANGAN KOMPETENSI</p>
        @if(!empty($rundown_laporan) && count($rundown_laporan) > 1)
        <table class="susunan-acara">
            @foreach($rundown_laporan as $r => $row)
            @php
            // Bersihkan semua sel dari spasi tak terlihat dan format Excel
            $row = array_map(function($cell) {
            if (is_array($cell)) $cell = implode(', ', array_filter($cell));
            $cell = preg_replace('/[\x00-\x1F\x7F]/u', '', (string)$cell); // hapus karakter kontrol
            $cell = trim(str_replace([' ', "\t", "\n", "\r"], '', $cell)); // hapus spasi non-breaking, tab, newline
            return $cell === '' ? null : $cell;
            }, $row);

            // Cek apakah semua kolom benar-benar kosong
            $hasData = false;
            foreach ($row as $v) {
            if (!empty($v) && !preg_match('/^\d+\.?$/', $v)) { // bukan cuma nomor urut
            $hasData = true;
            break;
            }
            }
            if (!$hasData) continue; // lewati baris kosong sepenuhnya

            // Deteksi header grup seperti "Belanja Operasional Lainnya"
            $isGroupHeader = count(array_filter($row)) === 1 && !empty($row[0]);
            @endphp

            {{-- Judul grup --}}
            @if($isGroupHeader)
            <tr class="group-row">
                <td colspan="{{ count($rundown_laporan[0]) }}">
                    {{ ucwords(preg_replace(['/([a-z])([A-Z])/', '/([a-zA-Z])\(/'], '$1 $2', $row[0])) }}
                </td>
            </tr>

            {{-- Header tabel --}}
            @elseif($r === 0)
            <thead>
                <tr>
                    @foreach($row as $cell)
                    <th>
                        {{ ucwords(
        preg_replace(
            ['/([a-z])([A-Z])/', '/([a-zA-Z])\(/'], 
            ['$1 $2', '$1 ('], 
            $cell
        )
    ) }}
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>

                {{-- Data biasa --}}
                @else
                <tr>
                    @foreach($row as $i => $cell)
                    @php
                    // Kasih spasi antar huruf besar, lalu rapihin whitespace ganda
                    $cleanCell = ucwords(preg_replace(['/([a-z])([A-Z])/', '/([a-zA-Z])\(/'], '$1 $2', trim($cell)));
                    $cleanCell = preg_replace('/\s+/', ' ', $cleanCell);

                    // Nomor kolom (kolom pertama) diperkecil
                    $isNumberCol = $i === 0 && is_numeric(str_replace('.', '', $cleanCell));
                    @endphp

                    <td class="{{ $isNumberCol ? 'td-nomor' : 'td-isi' }}">
                        {{ $cleanCell }}
                    </td>
                    @endforeach
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        @else
        <p class="indent">Terlampir dalam jadwal kegiatan.</p>
        @endif

        <p class="section-title">{{ getLetter($letterIndex++) }}. PESERTA KEGIATAN PENGEMBANGAN KOMPETENSI</p>
        @if(!empty($peserta_laporan) && count($peserta_laporan) > 1)
        <table class="susunan-acara">
            @foreach($peserta_laporan as $r => $row)
            @php
            // Bersihkan semua sel dari spasi tak terlihat dan format Excel
            $row = array_map(function($cell) {
            if (is_array($cell)) $cell = implode(', ', array_filter($cell));
            $cell = preg_replace('/[\x00-\x1F\x7F]/u', '', (string)$cell); // hapus karakter kontrol
            $cell = trim(str_replace([' ', "\t", "\n", "\r"], '', $cell)); // hapus spasi non-breaking, tab, newline
            return $cell === '' ? null : $cell;
            }, $row);

            // Cek apakah semua kolom benar-benar kosong
            $hasData = false;
            foreach ($row as $v) {
            if (!empty($v) && !preg_match('/^\d+\.?$/', $v)) { // bukan cuma nomor urut
            $hasData = true;
            break;
            }
            }
            if (!$hasData) continue; // lewati baris kosong sepenuhnya

            // Deteksi header grup seperti "Belanja Operasional Lainnya"
            $isGroupHeader = count(array_filter($row)) === 1 && !empty($row[0]);
            @endphp

            {{-- Judul grup --}}
            @if($isGroupHeader)
            <tr class="group-row">
                <td colspan="{{ count($peserta_laporan[0]) }}">
                    {{ ucwords(preg_replace(['/([a-z])([A-Z])/', '/([a-zA-Z])\(/'], '$1 $2', $row[0])) }}
                </td>
            </tr>

            {{-- Header tabel --}}
            @elseif($r === 0)
            <thead>
                <tr>
                    @foreach($row as $cell)
                    <th>
                        {{ ucwords(
        preg_replace(
            ['/([a-z])([A-Z])/', '/([a-zA-Z])\(/'], 
            ['$1 $2', '$1 ('], 
            $cell
        )
    ) }}
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>

                {{-- Data biasa --}}
                @else
                <tr>
                    @foreach($row as $i => $cell)
                    @php
                    // Kasih spasi antar huruf besar, lalu rapihin whitespace ganda
                    $cleanCell = ucwords(preg_replace(['/([a-z])([A-Z])/', '/([a-zA-Z])\(/'], '$1 $2', trim($cell)));
                    $cleanCell = preg_replace('/\s+/', ' ', $cleanCell);

                    // Nomor kolom (kolom pertama) diperkecil
                    $isNumberCol = $i === 0 && is_numeric(str_replace('.', '', $cleanCell));
                    @endphp

                    <td class="{{ $isNumberCol ? 'td-nomor' : 'td-isi' }}">
                        {{ $cleanCell }}
                    </td>
                    @endforeach
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        @else
        <p class="indent">Terlampir dalam jadwal kegiatan.</p>
        @endif

        <p class="section-title">{{ getLetter($letterIndex++) }}. PENUTUP</p>
        <p class="indent">
            Demikian Laporan Kegiatan {{ $laporankegiatans->usulankegiatans->nama_kegiatan ?? '-' }} ini disusun untuk dipergunakan sebagaimana mestinya.
        </p>
    </div>

    <div class="ttd">
        <p><strong>Kepala {{ $user->subunitkerjas->sub_unitkerja }}</strong></p>
        <p><strong>Kota Surakarta</strong></p>

        @php
        // 🔍 Langkah 1: ambil dari controller dulu
        $finalPath = $ttd_path ?? null;

        // 🔍 Langkah 2: fallback dari session
        if (empty($finalPath) && session()->has('tandatangan_pjkegiatan')) {
        $finalPath = storage_path('app/public/' . session('tandatangan_pjkegiatan'));
        }

        // 🔍 Langkah 3: fallback ke kemungkinan lokasi lain
        if (empty($finalPath) || !file_exists($finalPath)) {
        // Coba cek apakah filenya ada di storage/izin/tandatangan_pjkegiatan
        $possiblePath = storage_path('app/public/izin/tandatangan_pjkegiatan');
        if (is_dir($possiblePath)) {
        foreach (glob($possiblePath . '/*.png') as $file) {
        $finalPath = $file; // ambil file pertama
        break;
        }
        }
        }
        @endphp

        @if(!empty($finalPath) && file_exists($finalPath))
        @php
        $imageData = base64_encode(file_get_contents($finalPath));
        @endphp
        <img src="data:image/png;base64,{{ $imageData }}"
            alt="Tanda Tangan"
            style="height:90px; margin-top:5px; margin-right:0; display:inline-block;">
        @else
        <p style="color:red; font-size:10pt;">[TTD tidak ditemukan di path {{ $finalPath ?? 'N/A' }}]</p>
        @endif


        <p><strong>{{ $laporankegiatans->nama_pejabat ?? 'dr. Retno Widyastuti, M.Kes' }}</strong></p>
        <p>NIP. {{ $laporankegiatans->nip_pejabat ?? '19791218 200604 1 006' }}</p>
    </div>

    {{-- ====================== LAMPIRAN DOKUMENTASI HASIL KEGIATAN ====================== --}}
    @if(!empty($gambardokumentasi_laporan))
    <div class="page-break"></div>

    <h3 style="text-align:center; margin-top:10px;">
        LAMPIRAN<br>DOKUMENTASI KEGIATAN
    </h3>

    @foreach(array_chunk($gambardokumentasi_laporan, 2) as $pair)
    {{-- Satu halaman berisi dua gambar vertikal --}}
    <div style="width:100%; text-align:center; margin:0 auto;" {{ !$loop->last ? 'page-break-after: always;' : '' }}>
        @foreach($pair as $imgData)
        @if($imgData)
        <div style="margin:20px auto; page-break-inside: avoid;">
            <img src="{{ $imgData }}"
                style="width:50%; height:auto; border:1px solid #555; padding:4px;">
            <p style="font-size:11pt; margin-top:5px;">Dokumentasi Kegiatan</p>
        </div>
        @else
        <p style="color:red; text-align:center;">File tidak ditemukan</p>
        @endif
        @endforeach
    </div>
    @endforeach
    @else
    <p style="text-align:center; color:gray;">Tidak ada dokumentasi kegiatan.</p>
    @endif
</body>

</html>