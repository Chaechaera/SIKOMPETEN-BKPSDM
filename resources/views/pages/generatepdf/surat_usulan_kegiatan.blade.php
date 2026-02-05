<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pengajuan dan KAK Usulan Kegiatan</title>
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
            width: 100%;
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

        .table td {
            padding: 2px 4px;
            vertical-align: top;
            border: none;
        }

        .table .label {
            width: 150px;
            /* atur sesuai panjang teks */
        }

        .table .colon {
            width: 10px;
            text-align: center;
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
                    <td>{{ $usulankegiatans->identitassurats?->nomor_surat ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Sifat</td>
                    <td class="colon">:</td>
                    <td>{{ $usulankegiatans->identitassurats?->sifat_surat ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Lampiran</td>
                    <td class="colon">:</td>
                    <td>{{ $usulankegiatans->identitassurats?->lampiran_surat ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td class="colon">:</td>
                    <td><strong>{{ $usulankegiatans->identitassurats?->perihal_surat ?? '' }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="meta-right">
            <p>Surakarta,
                {{ $usulankegiatans->identitassurats?->tanggal_surat
                    ? \Carbon\Carbon::parse($usulankegiatans->identitassurats?->tanggal_surat)->translatedFormat('d F Y')
                    : '' }}
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
            Guna meningkatkan kompetensi sumber daya manusia di lingkungan {{ $user->subunitkerjas?->sub_unitkerja ?? '-' }} Kota Surakarta serta unit, {{ $user->subunitkerjas?->sub_unitkerja ?? '-' }} Kota Surakarta akan menyelenggarakan kegiatan pengembangan kompetensi
            "{{ $usulankegiatans->inputusulankegiatans->nama_kegiatan ?? 'Workshop Deteksi dan Intervensi Dini Perkembangan pada Anak dengan Disabilitas untuk Tenaga Kesehatan' }}". Sehubungan dengan hal tersebut, bersama ini kami sampaikan permohonan rekomendasi pelaksanaan kegiatan "{{ $usulankegiatans->inputusulankegiatans->nama_kegiatan ?? 'Workshop Deteksi dan Intervensi Dini Perkembangan pada Anak dengan Disabilitas untuk Tenaga Kesehatan' }}" dengan Kerangka Acuan Kegiatan (KAK) sebagaimana terlampir.
        </p>
        <p class="indent">
            Demikian atas perhatian dan kerja samanya disampaikan terima kasih.
        </p>
    </div>

    <div class="ttd">
        <p><strong>Kepala {{ $user->subunitkerjas?->sub_unitkerja ?? '-' }}</strong></p>
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


        <p><strong>{{ $usulankegiatans->nama_pejabat ?? 'dr. Retno Widyastuti, M.Kes' }}</strong></p>
        <p>NIP. {{ $usulankegiatans->nip_pejabat ?? '19791218 200604 1 006' }}</p>
    </div>

    <div class="page-break"></div>

    {{-- ====================== KERANGKA ACUAN KERJA (KAK) ====================== --}}
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
            <h3>KERANGKA ACUAN KERJA (KAK)</h3>
            <h3>KEGIATAN PENGEMBANGAN KOMPETENSI<br></h3>
            <h3>TAHUN ANGGARAN {{ \Carbon\Carbon::now()->year }}<br></h3>
        </div>

        @php
        $letterIndex = 0; // mulai dari A
        function getLetter($i) {
            $alphabet = range('A', 'Z');
            return $alphabet[$i] ?? ('Z' . ($i - 25));} // fallback kalau lewat Z
        @endphp

        <p class="section-title">{{ getLetter($letterIndex++) }}. NAMA KEGIATAN PENGEMBANGAN KOMPETENSI</p>
        <p>{{ $usulankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}</p>

        <p class="section-title">{{ getLetter($letterIndex++) }}. LATAR BELAKANG</p>
        <p class="indent">
            @if(!empty($usulankegiatans->detailusulankegiatans->latarbelakang_kegiatan))
            {!! nl2br(e($usulankegiatans->detailusulankegiatans->latarbelakang_kegiatan)) !!}
            @else
            Lima tahun pertama kehidupan anak merupakan masa krusial atau golden period sekaligus masa kritis...
            @endif
        </p>

        <p class="section-title">{{ getLetter($letterIndex++) }}. DASAR HUKUM</p>
        <ol>
            @if(!empty($usulankegiatans->detailusulankegiatans->dasarhukum_kegiatan))
            <li>{!! nl2br(e($usulankegiatans->detailusulankegiatans->dasarhukum_kegiatan)) !!}</li>
            @else
            <li>Undang-Undang Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara</li>
            <li>Peraturan Menteri Kesehatan Nomor 66 Tahun 2014 tentang Pemantauan Perkembangan Anak</li>
            @endif
        </ol>

        <p class="section-title">{{ getLetter($letterIndex++) }}. URAIAN KEGIATAN</p>
        @php
        $uraian = trim($usulankegiatans->detailusulankegiatans->uraian_kegiatan ?? '');
        @endphp

        @if(!empty($uraian))
        @if(preg_match('/^\s*[\-\d\•\*]/m', $uraian))
        {{-- Kalau diawali tanda list seperti "-" atau angka --}}
        <ol>
            @foreach(preg_split('/\r\n|\r|\n/', $uraian) as $line)
            @if(!empty(trim($line)))
            <li>{{ trim($line, "-•* ") }}</li>
            @endif
            @endforeach
        </ol>
        @else
        <p class="indent">{!! nl2br(e($uraian)) !!}</p>
        @endif
        @else
        <p class="indent">
            Kegiatan ini dilaksanakan dengan metode tatap muka yang terdiri dari sesi penyampaian materi,
            diskusi, dan simulasi praktik...
        </p>
        @endif

        <p class="section-title">{{ getLetter($letterIndex++) }}. MAKSUD DAN TUJUAN</p>
        <div class="kak-maksud-tujuan">
            <ol type="1">
                <li>MAKSUD
                    <p class="indent">
                        {!! nl2br(e($usulankegiatans->detailusulankegiatans->maksud_kegiatan ??
                        'Kegiatan ini dilaksanakan untuk meningkatkan kemampuan pegawai di bidangnya.')) !!}
                    </p>
                </li>
                <li>TUJUAN
                    <ol type="1">
                        <li>{!! nl2br(e($usulankegiatans->detailusulankegiatans->tujuan_kegiatan ??
                            'Meningkatkan kualitas pelaksanaan kegiatan dan kompetensi peserta.')) !!}</li>
                    </ol>
                </li>
            </ol>
        </div>

        <p class="section-title">{{ getLetter($letterIndex++) }}. HASIL LANGSUNG YANG DIHARAPKAN</p>
        @php
        $hasillangsung = trim($usulankegiatans->detailusulankegiatans->hasillangsung_kegiatan ?? '');
        @endphp

        @if(!empty($hasillangsung))
        @if(preg_match('/^\s*[\-\d\•\*]/m', $hasillangsung))
        {{-- Kalau diawali tanda list seperti "-" atau angka --}}
        <ol>
            @foreach(preg_split('/\r\n|\r|\n/', $hasillangsung) as $line)
            @if(!empty(trim($line)))
            <li>{{ trim($line, "-•* ") }}</li>
            @endif
            @endforeach
        </ol>
        @else
        <p class="indent">{!! nl2br(e($hasillangsung)) !!}</p>
        @endif
        @else
        <p class="indent">
            Kegiatan ini dilaksanakan dengan metode tatap muka yang terdiri dari sesi penyampaian materi,
            diskusi, dan simulasi praktik...
        </p>
        @endif

        <p class="section-title">{{ getLetter($letterIndex++) }}. HASIL JANGKA MENENGAH YANG DIHARAPKAN</p>
        @php
        $hasilmenengah = trim($usulankegiatans->detailusulankegiatans->hasilmenengah_kegiatan ?? '');
        @endphp

        @if(!empty($hasilmenengah))
        @if(preg_match('/^\s*[\-\d\•\*]/m', $hasilmenengah))
        {{-- Kalau diawali tanda list seperti "-" atau angka --}}
        <ol>
            @foreach(preg_split('/\r\n|\r|\n/', $hasilmenengah) as $line)
            @if(!empty(trim($line)))
            <li>{{ trim($line, "-•* ") }}</li>
            @endif
            @endforeach
        </ol>
        @else
        <p class="indent">{!! nl2br(e($hasilmenengah)) !!}</p>
        @endif
        @else
        <p class="indent">
            Kegiatan ini dilaksanakan dengan metode tatap muka yang terdiri dari sesi penyampaian materi,
            diskusi, dan simulasi praktik...
        </p>
        @endif

        <p class="section-title">{{ getLetter($letterIndex++) }}. HASIL JANGKA PANJANG YANG DIHARAPKAN</p>
        @php
        $hasilpanjang = trim($usulankegiatans->detailusulankegiatans->hasilpanjang_kegiatan ?? '');
        @endphp

        @if(!empty($hasilpanjang))
        @if(preg_match('/^\s*[\-\d\•\*]/m', $hasilpanjang))
        {{-- Kalau diawali tanda list seperti "-" atau angka --}}
        <ol>
            @foreach(preg_split('/\r\n|\r|\n/', $hasilpanjang) as $line)
            @if(!empty(trim($line)))
            <li>{{ trim($line, "-•* ") }}</li>
            @endif
            @endforeach
        </ol>
        @else
        <p class="indent">{!! nl2br(e($hasilpanjang)) !!}</p>
        @endif
        @else
        <p class="indent">
            Kegiatan ini dilaksanakan dengan metode tatap muka yang terdiri dari sesi penyampaian materi,
            diskusi, dan simulasi praktik...
        </p>
        @endif

        <p class="section-title">{{ getLetter($letterIndex++) }}. NARASUMBER DAN SASARAN PESERTA</p>
        <div class="kak-narasumber-peserta">
            <ol type="1">
                <li>NARASUMBER
                    <p class="indent">
                    <ol type="1">
                        @if(!empty($usulankegiatans->detailusulankegiatans->narasumber_kegiatan))
                        <li>{!! nl2br(e($usulankegiatans->detailusulankegiatans->narasumber_kegiatan)) !!}</li>
                        @else
                        <li>Peningkatan kemampuan tenaga kesehatan dalam deteksi dini tumbuh kembang anak.</li>
                        <li>Peningkatan kualitas layanan kesehatan anak di wilayah kerja Dinas Kesehatan Kota Surakarta.</li>
                        @endif
                    </ol>
                    </p>
                </li>
                <li>SASARAN PESERTA
                    <p class="indent">
                        Sasaran peserta yang mengikuti kegiatan ini merupakan orang yang berasal dari ruang lingkup {{ $user->subunitkerjas->sub_unitkerja }} di Kota Surakarta yang mana meliputi {!! nl2br(e($usulankegiatans->detailusulankegiatans->sasaranpeserta_kegiatan ?? 'Peserta berasal dari tenaga kesehatan puskesmas, sebanyak 50 orang.')) !!}
                    </p>
                </li>
            </ol>
        </div>

        <p class="section-title">{{ getLetter($letterIndex++) }}. WAKTU DAN TEMPAT</p>
        <table class="table">
            <tr>
                <td class="label">Tanggal Pelaksanaan</td>
                <td class="colon">:</td>
                <td>@if($usulankegiatans->tanggalmulai_kegiatan)
                    {{ \Carbon\Carbon::parse($usulankegiatans->tanggalmulai_kegiatan)->translatedFormat('d F Y') }}
                    @else
                    -
                    @endif
                    s/d
                    @if($usulankegiatans->tanggalselesai_kegiatan)
                    {{ \Carbon\Carbon::parse($usulankegiatans->tanggalselesai_kegiatan)->translatedFormat('d F Y') }}
                    @else
                    -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Waktu Pelaksanaan</td>
                <td class="colon">:</td>
                <td>@if($usulankegiatans->waktumulai_kegiatan)
                    {{ \Carbon\Carbon::parse($usulankegiatans->waktumulai_kegiatan)->format('H:i') }}
                    @else
                    -
                    @endif
                    s/d
                    @if($usulankegiatans->waktuselesai_kegiatan)
                    {{ \Carbon\Carbon::parse($usulankegiatans->waktuselesai_kegiatan)->format('H:i') }}
                    @else
                    -
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Tempat Pelaksanaan</td>
                <td class="colon">:</td>
                <td>{{ $usulankegiatans->lokasi_kegiatan ?? '-' }}</td>
            </tr>
        </table>

        <p class="section-title">{{ getLetter($letterIndex++) }}. METODE PELAKSANAAN</p>
        <p>
            Kegiatan {{ $usulankegiatans->inputusulankegiatans->nama_kegiatan }} dilaksanakan dengan metode
            {{ $usulankegiatans->detailusulankegiatans?->metodepelatihans->metode_pelatihan ?? 'Ceramah, diskusi, simulasi, dan tanya jawab.' }}
        </p>

        <p class="section-title">{{ getLetter($letterIndex++) }}. SUSUNAN ACARA</p>
        @if(!empty($jadwalpelaksanaan_kegiatan) && count($jadwalpelaksanaan_kegiatan) > 1)
        <table class="susunan-acara">
            @foreach($jadwalpelaksanaan_kegiatan as $r => $row)
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
                <td colspan="{{ count($jadwalpelaksanaan_kegiatan[0]) }}">
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
            {{ $usulankegiatans->detailusulankegiatans->penutup_kegiatan ?? 'Demikian Kerangka Acuan Kerja ini dibuat untuk digunakan sebagai pedoman pelaksanaan kegiatan.' }}
        </p>
    </div>

    <div class="ttd">
        <p><strong>Kepala {{ $user->subunitkerjas?->sub_unitkerja ?? '-' }}</strong></p>
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


        <p><strong>{{ $usulankegiatans->nama_pejabat ?? 'dr. Retno Widyastuti, M.Kes' }}</strong></p>
        <p>NIP. {{ $usulankegiatans->nip_pejabat ?? '19791218 200604 1 006' }}</p>
    </div>
</body>

</html>