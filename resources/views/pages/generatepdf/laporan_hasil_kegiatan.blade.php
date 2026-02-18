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

        .kop-gambar-full {
            width: 100%;
            /* full lebar surat */
            max-height: 150px;
            /* proporsional */
            display: block;
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
            text-align: justify;
            /* biar teks rata kiri-kanan */
            text-indent: 30px;
            /* ini kunci: jarak baris pertama menjorok */
            margin-top: 8px;
            margin-bottom: 8px;
            line-height: 1.5;
            /* biar nyaman dibaca */
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
            page-break-inside: avoid;
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

        .ttd-wrapper {
            position: relative;
            width: 75%;
            /* perbesar area gabungan */
            height: 300px;
            /* tinggi total */
            margin-top: 5px;
            margin-bottom: -180px;
        }

        /* === STEMPEL === */
        .stempel-layer {
            position: absolute;
            left: 30%;
            /* pusatkan horizontal */
            top: 15px;
            /* geser naik biar nyentuh tulisan atas */
            transform: translateX(-10%) scale(2);
            /* perbesar proporsional (lebar & tinggi) */
            transform-origin: center;
            opacity: 0.6;
            /* tetap transparan */
            z-index: 1;
            mix-blend-mode: multiply;
        }

        /* === TTD === */
        .ttd-layer {
            position: absolute;
            left: 40%;
            top: -90px;
            /* geser ke bawah biar nempel pas di atas stempel */
            transform: translateX(5%);
            width: 100%;
            /* sedikit lebih kecil dari stempel */
            z-index: 1;
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
            text-indent: 20px;
            margin-top: 0;
            margin-bottom: 8px;
            padding-left: 40px;
            padding-right: 40px;
            text-align: justify;
        }

        .kak-section p.indent-link {
            text-indent: 20px;
            margin-top: 0;
            margin-bottom: 8px;
            padding-left: 20px;
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
            page-break-inside: avoid;
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

        .kak-section .ttd-wrapper {
            position: relative;
            width: 75%;
            /* perbesar area gabungan */
            height: 300px;
            /* tinggi total */
            margin-top: 5px;
        }

        /* === STEMPEL === */
        .kak-section .stempel-layer {
            position: absolute;
            left: 30%;
            /* pusatkan horizontal */
            top: 15px;
            /* geser naik biar nyentuh tulisan atas */
            transform: translateX(-10%) scale(2);
            /* perbesar proporsional (lebar & tinggi) */
            transform-origin: center;
            opacity: 0.6;
            /* tetap transparan */
            z-index: 1;
            mix-blend-mode: multiply;
        }

        /* === TTD === */
        .kak-section .ttd-layer {
            position: absolute;
            left: 40%;
            top: -90px;
            /* geser ke bawah biar nempel pas di atas stempel */
            transform: translateX(5%);
            width: 100%;
            /* sedikit lebih kecil dari stempel */
            z-index: 1;
        }

        .kak-section .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            padding-left: 0px;
            padding-right: 40px;
        }

        .kak-section .table .td {
            padding: 2px 4px;
            vertical-align: top;
            border: none;
        }

        .kak-section .table .label {
            width: 160px;
            /* atur sesuai panjang teks */
        }

        .kak-section .table .colon {
            width: 10px;
            text-align: center;
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
            text-indent: 0;
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
        @if($laporankegiatans->detaillaporankegiatans->jeniskop_laporankegiatan === 'kop_text')
        @if($kop_path && file_exists($kop_path))
        <img src="{{ $kop_path }}" class="kop-logo" alt="Logo Pemerintah Kota Surakarta">
        @endif
        @endif

        {{-- ================= KOP GAMBAR ================= --}}
        @if($laporankegiatans->detaillaporankegiatans->jeniskop_laporankegiatan === 'kop_gambar')
        @if(!empty($kop?->gambarkop_opd) && file_exists(storage_path('app/public/' . $kop->gambarkop_opd)))
        <img src="{{ storage_path('app/public/' . $kop->gambarkop_opd) }}" class="kop-gambar-full" alt="Logo OPD">
        @endif

        {{-- ================= KOP TEXT ================= --}}
        @elseif($laporankegiatans->detaillaporankegiatans->jeniskop_laporankegiatan === 'kop_text')

        <div class="kop-text">
            <h2>PEMERINTAH KOTA SURAKARTA</h2>
            <h1>{{ strtoupper($kop->nama_opd) }}</h1>
            <p> {{ $kop->lokasi_opd }}
                @if($kop->telepon_opd)
                Telp. {{ $kop->telepon_opd }}
                @endif
                @if($kop->faxmile_opd)
                Fax. {{ $kop->faxmile_opd }}
                @endif
            </p>
            <p>Website {{ $kop->website_opd }}
                @if($kop->email_opd)
                Email: {{ $kop->email_opd }}
                @endif
            </p>
            <p><strong>SURAKARTA</strong></p>
            <p><strong>{{ $kop->kodepos_opd }}</strong></p>
        </div>
        @endif
    </div>

    <div class="kop-line"></div>

    <div class="meta-section clearfix">
        <div class="meta-left">
            <table class="meta-table">
                <tr>
                    <td class="label">Nomor</td>
                    <td class="colon">:</td>
                    <td>{{ $laporankegiatans->identitassurats?->nomor_surat ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Sifat</td>
                    <td class="colon">:</td>
                    <td>{{ $laporankegiatans->identitassurats?->sifat_surat ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Lampiran</td>
                    <td class="colon">:</td>
                    <td>{{ $laporankegiatans->identitassurats?->lampiran_surat ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td class="colon">:</td>
                    <td><strong>{{ $laporankegiatans->identitassurats?->perihal_surat ?? '' }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="meta-right">
            <p>Surakarta,
                {{ $laporankegiatans->identitassurats?->tanggal_surat
    ? \Carbon\Carbon::parse($laporankegiatans->identitassurats?->tanggal_surat)->translatedFormat('d F Y')
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
            Dalam rangka penyelenggaraan kegiatan
            "{{ $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? 'Workshop Deteksi dan Intervensi Dini Perkembangan pada Anak dengan Disabilitas untuk Tenaga Kesehatan' }}"
            yang dilaksanakan pada hari
            {{ \Carbon\Carbon::parse($laporankegiatans->tanggalmulai_kegiatan)->translatedFormat('l, d F Y') ?? 'Kamis, 5 Februari 2025' }}
            s/d
            {{ \Carbon\Carbon::parse($laporankegiatans->tanggalselesai_kegiatan)->translatedFormat('l, d F Y') ?? 'Sabtu, 7 Februari 2025' }}
            di {{ $laporankegiatans->lokasi_kegiatan ?? 'Hotel Alila' }}.
            Sehubungan dengan hal tersebut, kami mengajukan permohonan penerbitan nomor register guna pembuatan
            Sertifikat
            {{ $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? 'Workshop Deteksi dan Intervensi Dini Perkembangan pada Anak dengan Disabilitas untuk Tenaga Kesehatan' }}.
        </p>
    </div>

    <div class="ttd">
        <p><strong>Kepala {{ $user->subunitkerjas?->sub_unitkerja ?? '-' }}</strong></p>
        <p><strong>Kota Surakarta</strong></p>

        <div class="ttd-wrapper">

            {{-- ===== STAMPEL ===== --}}
            @if(!empty($stempel?->gambarstempel_opd) && file_exists(storage_path('app/public/' . $stempel->gambarstempel_opd)))
            <img src="{{ storage_path('app/public/' . $stempel->gambarstempel_opd) }}" class="stempel-layer"
                alt="Stempel OPD">
            @endif

            {{-- ===== TTD ===== --}}
            @if(!empty($ttd?->gambarttd_opd) && file_exists(storage_path('app/public/' . $ttd->gambarttd_opd)))
            <img src="{{ storage_path('app/public/' . $ttd->gambarttd_opd) }}" class="ttd-layer" alt="TTD OPD">
            @endif

        </div>

        <p><strong>{{ $usulankegiatans->nama_pejabat ?? 'dr. Retno Widyastuti, M.Kes' }}</strong></p>
        <p>NIP. {{ $usulankegiatans->nip_pejabat ?? '19791218 200604 1 006' }}</p>
    </div>

    <div class="page-break"></div>

    {{-- ====================== LAPORAN HASIL KEGIATAN ====================== --}}
    <div class="kop-container">
        @if($laporankegiatans->detaillaporankegiatans->jeniskop_laporankegiatan === 'kop_text')
        @if($kop_path && file_exists($kop_path))
        <img src="{{ $kop_path }}" class="kop-logo" alt="Logo Pemerintah Kota Surakarta">
        @endif
        @endif

        {{-- ================= KOP GAMBAR ================= --}}
        @if($laporankegiatans->detaillaporankegiatans->jeniskop_laporankegiatan === 'kop_gambar')
        @if(!empty($kop?->gambarkop_opd) && file_exists(storage_path('app/public/' . $kop->gambarkop_opd)))
        <img src="{{ storage_path('app/public/' . $kop->gambarkop_opd) }}" class="kop-gambar-full" alt="Logo OPD">
        @endif

        {{-- ================= KOP TEXT ================= --}}
        @elseif($laporankegiatans->detaillaporankegiatans->jeniskop_laporankegiatan === 'kop_text')

        <div class="kop-text">
            <h2>PEMERINTAH KOTA SURAKARTA</h2>
            <h1>{{ strtoupper($kop->nama_opd) }}</h1>
            <p> {{ $kop->lokasi_opd }}
                @if($kop->telepon_opd)
                Telp. {{ $kop->telepon_opd }}
                @endif
                @if($kop->faxmile_opd)
                Fax. {{ $kop->faxmile_opd }}
                @endif
            </p>
            <p>Website {{ $kop->website_opd }}
                @if($kop->email_opd)
                Email: {{ $kop->email_opd }}
                @endif
            </p>
            <p><strong>SURAKARTA</strong></p>
            <p><strong>{{ $kop->kodepos_opd }}</strong></p>
        </div>
        @endif
    </div>

    <div class="kop-line"></div>

    <div class="kak-section">
        <div class="kak-title">
            <h3>LAPORAN HASIL PELAKSANAAN</h3>
            <h3>{{ mb_strtoupper($laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '-') }}<br></h3>
            <h3>TAHUN ANGGARAN {{ \Carbon\Carbon::now()->year }}<br></h3>
        </div>

        @php
        $letterIndex = 0; // mulai dari A
        function getLetter($i) {
        $alphabet = range('A', 'Z');
        return $alphabet[$i] ?? ('Z' . ($i - 25));
        } // fallback kalau lewat Z
        @endphp

        <p class="section-title">{{ getLetter($letterIndex++) }}. LATAR BELAKANG</p>
        @php
        $latarbelakang = trim($laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->detailusulankegiatans->latarbelakang_kegiatan ?? '');
        $blocks = preg_split("/\r\n|\r|\n/", $latarbelakang); // pisah tiap paragraf kosong
        @endphp

        @if(!empty($latarbelakang))
        @php $inList = false; @endphp
        @foreach($blocks as $block)
        @php
        $trimmed = trim($block);
        $isList = preg_match('/^\s*(\d+[\.\)]|[\-\•\*])/', $trimmed);
        @endphp
        @if($isList)
        @if(!$inList)
        @php $inList = true; @endphp
        <ol>
            @endif
            <li>{{ preg_replace('/^\s*(\d+[\.\)]|[\-\•\*])\s*/', '', $trimmed) }}</li>
            @else
            @if($inList)
        </ol>
        @php $inList = false; @endphp
        @endif
        <p class="indent">{!! nl2br(e($trimmed)) !!}</p>
        @endif
        @endforeach
        @if($inList)</ol>@endif
        @else
        <p class="indent">
            Kegiatan ini dilaksanakan untuk meningkatkan kemampuan pegawai di bidangnya.
        </p>
        @endif

        <p class="section-title">{{ getLetter($letterIndex++) }}. DASAR HUKUM</p>
        @php
        $dasarhukum = trim($laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->detailusulankegiatans->dasarhukum_kegiatan ?? '');
        @endphp

        @if(!empty($dasarhukum))
        @if(preg_match('/^\s*[\-\d\•\*]/m', $dasarhukum))
        {{-- Kalau diawali tanda list seperti "-" atau angka --}}
        <ol type="1">
            @foreach(preg_split('/\r\n|\r|\n/', $dasarhukum) as $line)
            @if(!empty(trim($line)))
            {{-- Hapus angka + titik di awal, juga tanda list lain --}}
            <li>{{ preg_replace('/^\s*\d+[\.\)]?\s*/', '', trim($line, "-•* ")) }}</li>
            @endif
            @endforeach
        </ol>
        @else
        <p class="indent">{!! nl2br(e($dasarhukum)) !!}</p>
        @endif
        @else
        {{-- Default kalau kosong --}}
        <ol type="1">
            <li>Undang-Undang Nomor 20 Tahun 2023 tentang Aparatur Sipil Negara</li>
            <li>Peraturan Menteri Kesehatan Nomor 66 Tahun 2014 tentang Pemantauan Perkembangan Anak</li>
        </ol>
        @endif

        <p class="section-title">{{ getLetter($letterIndex++) }}. MAKSUD DAN TUJUAN</p>
        <div class="kak-maksud-tujuan">
            <ol type="1">
                <li>MAKSUD
                    @php
                    $maksud = trim($laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->detailusulankegiatans->maksud_kegiatan ?? '');
                    $blocks = preg_split("/\r\n|\r|\n/", $maksud); // pisah tiap paragraf kosong
                    @endphp

                    @if(!empty($maksud))
                    @foreach($blocks as $block)
                    <p class="indent">{!! nl2br(e(trim($block))) !!}</p>
                    @endforeach
                    @else
                    <p class="indent">
                        Kegiatan ini dilaksanakan untuk meningkatkan kemampuan pegawai di bidangnya.
                    </p>
                    @endif
                </li>
                <li>TUJUAN
                    @php
                    $tujuan = trim($laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->detailusulankegiatans->tujuan_kegiatan ?? '');
                    @endphp

                    @if(!empty($tujuan))
                    @if(preg_match('/^\s*[\-\d\•\*]/m', $tujuan))
                    {{-- Kalau diawali tanda list seperti "-" atau angka --}}
                    <ol type="1">
                        @foreach(preg_split('/\r\n|\r|\n/', $tujuan) as $line)
                        @if(!empty(trim($line)))
                        {{-- Hapus angka + titik di awal, juga tanda list lain --}}
                        <li>{{ preg_replace('/^\s*\d+[\.\)]?\s*/', '', trim($line, "-•* ")) }}</li>
                        @endif
                        @endforeach
                    </ol>
                    @else
                    <p class="indent">{!! nl2br(e($tujuan)) !!}</p>
                    @endif
                    @else
                    {{-- Default kalau kosong --}}
                    <ol type="1">
                        <li>Meningkatkan kualitas pelaksanaan kegiatan dan kompetensi peserta.</li>
                        <li>Peningkatan kualitas layanan kesehatan anak di wilayah kerja Dinas Kesehatan Kota Surakarta.</li>
                    </ol>
                    @endif
                </li>
            </ol>
        </div>

        <p class="section-title">{{ getLetter($letterIndex++) }}. RINCIAN KEGIATAN PENGEMBANGAN KOMPETENSI</p>
        @php
        $rincian = trim($laporankegiatans->detaillaporankegiatans?->rincian_laporan ?? '');
        $blocks = preg_split("/\r\n|\r|\n/", $rincian); // split per paragraf / blok
        @endphp
        @if(!empty($rincian))
        @php $inList = false; @endphp
        @foreach($blocks as $block)
        @php
        $trimmed = trim($block);
        $isList = preg_match('/^\s*(\d+[\.\)]|[\-\•\*])/', $trimmed);
        @endphp
        @if($isList)
        @if(!$inList)
        @php $inList = true; @endphp
        <ol>
            @endif
            <li>{{ preg_replace('/^\s*(\d+[\.\)]|[\-\•\*])\s*/', '', $trimmed) }}</li>
            @else
            @if($inList)
        </ol>
        @php $inList = false; @endphp
        @endif
        <p class="indent">{!! nl2br(e($trimmed)) !!}</p>
        @endif
        @endforeach
        @if($inList)</ol>@endif
        @else
        <p class="indent">
            Kegiatan ini dilaksanakan dengan metode tatap muka yang terdiri dari sesi penyampaian materi,
            diskusi, dan simulasi praktik...
        </p>
        @endif

        <p class="section-title">{{ getLetter($letterIndex++) }}. OUTPUT HASIL KEGIATAN PENGEMBANGAN KOMPETENSI</p>
        @php
        $outputhasil = trim($laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->detailusulankegiatans->detailhasil_kegiatan ?? '');
        $blocks = preg_split("/\r\n|\r|\n/", $outputhasil); // split per paragraf / blok
        @endphp
        @if(!empty($outputhasil))
        @php $inList = false; @endphp
        @foreach($blocks as $block)
        @php
        $trimmed = trim($block);
        $isList = preg_match('/^\s*(\d+[\.\)]|[\-\•\*])/', $trimmed);
        @endphp
        @if($isList)
        @if(!$inList)
        @php $inList = true; @endphp
        <ol>
            @endif
            <li>{{ preg_replace('/^\s*(\d+[\.\)]|[\-\•\*])\s*/', '', $trimmed) }}</li>
            @else
            @if($inList)
        </ol>
        @php $inList = false; @endphp
        @endif
        <p class="indent">{!! nl2br(e($trimmed)) !!}</p>
        @endif
        @endforeach
        @if($inList)</ol>@endif
        @else
        <p class="indent">
            Kegiatan ini dilaksanakan dengan metode tatap muka yang terdiri dari sesi penyampaian materi,
            diskusi, dan simulasi praktik...
        </p>
        @endif

        <p class="section-title">{{ getLetter($letterIndex++) }}. PELAKSANAAN KEGIATAN PENGEMBANGAN KOMPETENSI</p>
        <div class="kak-narasumber-peserta">
            <ol type="1">
                <li>NAMA KEGIATAN
                    <p class="indent">
                        {{ $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}
                    </p>
                </li>
                <li>METODE KEGIATAN
                    <p class="indent">
                        Metode yang digunakan adalah {{ $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->detailusulankegiatans->metodepelatihans->metode_pelatihan ?? 'Klasikal' }}
                    </p>
                </li>
                <li>NARASUMBER
                    @php
                    $narasumber = trim($laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->detailusulankegiatans->narasumber_kegiatan ?? '');
                    @endphp

                    @if(!empty($narasumber))
                    @if(preg_match('/^\s*[\-\d\•\*]/m', $narasumber))
                    {{-- Kalau diawali tanda list seperti "-" atau angka --}}
                    <ol type="1">
                        @foreach(preg_split('/\r\n|\r|\n/', $narasumber) as $line)
                        @if(!empty(trim($line)))
                        {{-- Hapus angka + titik di awal, juga tanda list lain --}}
                        <li>{{ preg_replace('/^\s*\d+[\.\)]?\s*/', '', trim($line, "-•* ")) }}</li>
                        @endif
                        @endforeach
                    </ol>
                    @else
                    <p class="indent">{!! nl2br(e($narasumber)) !!}</p>
                    @endif
                    @else
                    {{-- Default kalau kosong --}}
                    <ol type="1">
                        <li>Peningkatan kemampuan tenaga kesehatan dalam deteksi dini tumbuh kembang anak.</li>
                        <li>Peningkatan kualitas layanan kesehatan anak di wilayah kerja Dinas Kesehatan Kota Surakarta.</li>
                    </ol>
                    @endif
                </li>
                <li>PELAKSANAAN KEGIATAN
                    <div>
                        <table class="table">
                            <tr>
                                <td class="label">Tanggal Pelaksanaan</td>
                                <td class="colon">:</td>
                                <td>@if($laporankegiatans->tanggalmulai_kegiatan)
                                    {{ \Carbon\Carbon::parse($laporankegiatans->tanggalmulai_kegiatan)->translatedFormat('d F Y') }}
                                    @else
                                    -
                                    @endif
                                    s/d
                                    @if($laporankegiatans->tanggalselesai_kegiatan)
                                    {{ \Carbon\Carbon::parse($laporankegiatans->tanggalselesai_kegiatan)->translatedFormat('d F Y') }}
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Waktu Pelaksanaan</td>
                                <td class="colon">:</td>
                                <td>@if($laporankegiatans->waktumulai_kegiatan)
                                    {{ \Carbon\Carbon::parse($laporankegiatans->waktumulai_kegiatan)->format('H:i') }}
                                    @else
                                    -
                                    @endif
                                    s/d
                                    @if($laporankegiatans->waktuselesai_kegiatan)
                                    {{ \Carbon\Carbon::parse($laporankegiatans->waktuselesai_kegiatan)->format('H:i') }}
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Tempat Pelaksanaan</td>
                                <td class="colon">:</td>
                                <td>{{ $laporankegiatans->lokasi_kegiatan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Alokasi Anggaran</td>
                                <td class="colon">:</td>
                                <td>{{ $format_anggaran ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Organisasi Penyelenggara</td>
                                <td class="colon">:</td>
                                <td>{{ $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->detailusulankegiatans->penyelenggara_kegiatan ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
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

        @php
        if (is_array($value)) {
        $valueText = implode(', ', $value);
        } else {
        $valueText = trim($value ?? '');
        }

        $blocks = preg_split("/\r\n|\r|\n/", $valueText);
        @endphp

        @if(!empty($valueText))

        @php $inList = false; @endphp

        @foreach($blocks as $block)

        @php
        $trimmed = trim($block);

        $isList = preg_match('/^\s*(\d+[\.\)]|[\-\•\*])/', $trimmed);
        $isUrl = filter_var($trimmed, FILTER_VALIDATE_URL);
        @endphp

        {{-- ========= LIST ========= --}}
        @if($isList)

        @if(!$inList)
        @php $inList = true; @endphp
        <ol>
            @endif

            <li>
                {{ preg_replace('/^\s*(\d+[\.\)]|[\-\•\*])\s*/', '', $trimmed) }}
            </li>

            {{-- ========= NON LIST ========= --}}
            @else

            @if($inList)
        </ol>
        @php $inList = false; @endphp
        @endif

        <p>
            @if($isUrl)
            <a href="{{ $trimmed }}" target="_blank">{{ $trimmed }}</a>
            @else
            {!! nl2br(e($trimmed)) !!}
            @endif
        </p>

        @endif

        @endforeach

        @if($inList)</ol>@endif

        @else
        <p class="indent">-</p>
        @endif

        @endforeach
        @endif

        {{-- ==================================================================== --}}

        <p class="section-title">{{ getLetter($letterIndex++) }}. LINK UNDANGAN KEGIATAN</p>
        <p class="indent-link">{{ $laporankegiatans->detaillaporankegiatans?->linkundangan_laporan ?? '-' }}</p>

        <p class="section-title">{{ getLetter($letterIndex++) }}. LINK MATERI KEGIATAN</p>
        <p class="indent-link">{{ $laporankegiatans->detaillaporankegiatans?->linkmateri_laporan ?? '-'}}</p>

        <p class="section-title">{{ getLetter($letterIndex++) }}. LINK DAFTAR HADIR KEGIATAN</p>
        <p class="indent-link">{{ $laporankegiatans->detaillaporankegiatans?->linkdaftarhadir_laporan ?? '-' }}</p>

        <p class="section-title">{{ getLetter($letterIndex++) }}. LINK DOKUMENTASI KEGIATAN</p>
        <p class="indent-link">{{ $laporankegiatans->detaillaporankegiatans?->linkdokumentasi_laporan ?? '-'}}</p>

        <p class="section-title">{{ getLetter($letterIndex++) }}. RUNDOWN KEGIATAN PENGEMBANGAN KOMPETENSI</p>
        <p class="indent">Berikut terlampir rundown acara kegiatan pengembangan komptensi yang telah terlaksana:</p>
        @if(!empty($rundown_laporan) && count($rundown_laporan) > 1)
        <table class="susunan-acara">
            @foreach($rundown_laporan as $r => $row)
            @php
            // Bersihkan semua sel dari spasi tak terlihat dan format Excel
            $row = array_map(function ($cell) {
            if (is_array($cell))
            $cell = implode(', ', array_filter($cell));
            $cell = preg_replace('/[\x00-\x1F\x7F]/u', '', (string) $cell); // hapus karakter kontrol
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
            if (!$hasData)
            continue; // lewati baris kosong sepenuhnya

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
        <p class="indent">Berikut terlampir peserta yang mengikuti kegiatan pengembangan kompetensi yang telah terlaksana:</p>
        @if(!empty($peserta_laporan) && count($peserta_laporan) > 1)
        <table class="susunan-acara">
            @foreach($peserta_laporan as $r => $row)
            @php
            // Bersihkan semua sel dari spasi tak terlihat dan format Excel
            $row = array_map(function ($cell) {
            if (is_array($cell))
            $cell = implode(', ', array_filter($cell));
            $cell = preg_replace('/[\x00-\x1F\x7F]/u', '', (string) $cell); // hapus karakter kontrol
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
            if (!$hasData)
            continue; // lewati baris kosong sepenuhnya

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
            {{ $laporankegiatans->detaillaporankegiatans?->penutup_laporan ?? 'Demikian Laporan Kegiatan ini disusun untuk dipergunakan sebagaimana mestinya.' }}
        </p>

        <div class="ttd">
            <p><strong>Kepala {{ $user->subunitkerjas?->sub_unitkerja ?? '-' }}</strong></p>
            <p><strong>Kota Surakarta</strong></p>

            <div class="ttd-wrapper">

                {{-- ===== STAMPEL ===== --}}
                @if(!empty($stempel?->gambarstempel_opd) && file_exists(storage_path('app/public/' . $stempel->gambarstempel_opd)))
                <img src="{{ storage_path('app/public/' . $stempel->gambarstempel_opd) }}" class="stempel-layer"
                    alt="Stempel OPD">
                @endif

                {{-- ===== TTD ===== --}}
                @if(!empty($ttd?->gambarttd_opd) && file_exists(storage_path('app/public/' . $ttd->gambarttd_opd)))
                <img src="{{ storage_path('app/public/' . $ttd->gambarttd_opd) }}" class="ttd-layer" alt="TTD OPD">
                @endif

            </div>

            <p><strong>{{ $usulankegiatans->nama_pejabat ?? 'dr. Retno Widyastuti, M.Kes' }}</strong></p>
            <p>NIP. {{ $usulankegiatans->nip_pejabat ?? '19791218 200604 1 006' }}</p>
        </div>
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
            <img src="{{ $imgData }}" style="width:50%; height:auto; border:1px solid #555; padding:4px;">
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