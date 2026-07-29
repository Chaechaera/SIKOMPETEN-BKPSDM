<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Pengajuan dan KAK Usulan Kegiatan</title>
    <style>
        @page {
            margin: 1cm 2cm 1cm 2cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            line-height: 1.15;
            color: #000;
        }

        /* ====================== BAGIAN KOP SURAT ====================== */
        .kop-container {
            display: table;
            width: 100%;
            margin-bottom: 2px;
        }

        .kop-gambar-full {
            width: 100%;
            max-height: 150px;
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
            text-align: center;
        }

        .kop-line {
            border-bottom: 3px solid black;
            margin-top: 2px;
        }

        .kop-line::after {
            content: "";
            display: block;
            border-bottom: 1px solid black;
            margin-top: 3px;
        }

        /* ====================== BAGIAN IDENTITAS SURAT ====================== */
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

        /* ====================== BAGIAN SURAT USULAN ====================== */

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
            text-indent: 30px;
            margin-top: 8px;
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .ttd {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            width: 50%;
            margin-left: auto;
            margin-top: 30px;
            padding-right: 10px;
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
            height: 100px;
            margin: 0;
            align-items: flex-end;
            margin-left: auto;
            position: relative;
            left: 5%;
        }

        .ttd-wrapper {
            position: relative;
            width: 75%;
            height: 300px;
            margin-top: 5px;
            margin-bottom: -180px;
        }

        .stempel-layer {
            position: absolute;
            left: 30%;
            top: 15px;
            transform: translateX(-10%) scale(2);
            transform-origin: center;
            opacity: 0.6;
            z-index: 2;
            mix-blend-mode: multiply;
        }

        .ttd-layer {
            position: absolute;
            left: 40%;
            top: -90px;
            transform: translateX(5%);
            width: 100%;
            z-index: 1;
        }

        .ttd-layer-no-stempel {
            position: absolute;
            left: 40%;
            top: 10px;
            transform: translateX(5%);
            width: 100%;
            z-index: 1;
        }

        /* ====================== PEMBATAS HALAMAN AGAR TTD TIDAK TERPISAH ====================== */
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
            width: 50%;
            margin-left: auto;
            margin-top: 30px;
            padding-right: 10px;
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
            height: 100px;
            margin: 0;
            align-items: flex-end;
            margin-left: auto;
            position: relative;
            left: 5%;
        }

        .kak-section .ttd-wrapper {
            position: relative;
            width: 75%;
            height: 300px;
            margin-top: 5px;
        }

        .kak-section .stempel-layer {
            position: absolute;
            left: 30%;
            top: 15px;
            transform: translateX(-10%) scale(2);
            transform-origin: center;
            opacity: 0.6;
            z-index: 2;
            mix-blend-mode: multiply;
        }

        .kak-section .ttd-layer {
            position: absolute;
            left: 40%;
            top: -90px;
            transform: translateX(5%);
            width: 100%;
            z-index: 1;
        }

        .kak-section .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            padding-left: 40px;
            padding-right: 40px;
        }

        .kak-section .table .td {
            padding: 2px 4px;
            vertical-align: top;
            border: none;
        }

        .kak-section .table .label {
            width: 160px;
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
            text-indent: 30px;
            margin: 0px 0 0px 0;
            padding-left: 0;
            padding-right: 0;
        }

        .susunan-acara-wrapper {
            display: block;
        }

        .susunan-acara {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            font-size: 10.5pt;
            margin-top: 8px;
            page-break-inside: auto;
            break-inside: auto;
        }

        .susunan-acara thead,
        .susunan-acara tbody,
        .susunan-acara tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .susunan-acara th,
        .susunan-acara td {
            border: 0.5px solid #000 !important;
            padding: 4px 6px;
            vertical-align: middle;
            line-height: 1.25;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: normal;
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
            overflow-wrap: anywhere;
        }

        .susunan-acara tr.group-row td {
            font-weight: bold;
            text-align: left;
            padding: 4px 5px;
            background-color: #f7f7f7;
            border: 0.7px solid #000 !important;
            font-size: 10.7pt;
            word-spacing: 2px;
            text-transform: capitalize;
        }

        .susunan-acara .td-isi {
            text-align: left;
            padding: 3px 4px;
            font-size: 10.3pt;
            line-height: 1.2;
        }

        .th-hari,
        .td-hari {
            width: 25%;
            text-align: center !important;
            vertical-align: middle;
        }

        .th-waktu,
        .td-waktu {
            width: 20%;
            text-align: center !important;
            vertical-align: middle;
        }

        .th-agenda,
        .td-agenda {
            width: 60%;
            text-align: left;
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
        @if($usulankegiatans->detailusulankegiatans->jeniskop_usulankegiatan === 'kop_text')
        @if($kop_path && file_exists($kop_path))
        <img src="{{ $kop_path }}" class="kop-logo" alt="Logo Pemerintah Kota Surakarta">
        @endif
        @endif

        {{-- ================= KOP GAMBAR ================= --}}
        @if($usulankegiatans->detailusulankegiatans->jeniskop_usulankegiatan === 'kop_gambar')
        @if(!empty($kop?->gambarkop_opd) && file_exists(storage_path('app/public/' . $kop->gambarkop_opd)))
        <img src="{{ storage_path('app/public/' . $kop->gambarkop_opd) }}" class="kop-gambar-full" alt="Logo OPD">
        @endif

        {{-- ================= KOP TEXT ================= --}}
        @elseif($usulankegiatans->detailusulankegiatans->jeniskop_usulankegiatan === 'kop_text')

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
                    <td>
                        {{ $identitas->nomor_surat ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Sifat</td>
                    <td class="colon">:</td>
                    <td>{{ $identitas->sifat_surat ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Lampiran</td>
                    <td class="colon">:</td>
                    <td>{{ $identitas->lampiran_surat ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td class="colon">:</td>
                    <td>
                        <strong>
                            {{ $identitas->perihal_surat ?? '' }}
                        </strong>
                    </td>
                </tr>
            </table>
        </div>

        <div class="meta-right">
            <p>Surakarta,
                {{ $identitas->tanggal_surat
    ? \Carbon\Carbon::parse($identitas->tanggal_surat)->translatedFormat('d F Y')
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
            Guna meningkatkan kompetensi sumber daya manusia di lingkungan
            {{ $usulankegiatans?->subunitkerjas?->sub_unitkerja ?? '-' }} Kota Surakarta serta unit,
            {{ $usulankegiatans?->subunitkerjas?->sub_unitkerja ?? '-' }} Kota Surakarta akan menyelenggarakan kegiatan pengembangan
            kompetensi
            "{{ $usulankegiatans->inputusulankegiatans->nama_kegiatan ?? 'Workshop Deteksi dan Intervensi Dini Perkembangan pada Anak dengan Disabilitas untuk Tenaga Kesehatan' }}".
            Sehubungan dengan hal tersebut, bersama ini kami sampaikan permohonan rekomendasi pelaksanaan kegiatan
            "{{ $usulankegiatans->inputusulankegiatans->nama_kegiatan ?? 'Workshop Deteksi dan Intervensi Dini Perkembangan pada Anak dengan Disabilitas untuk Tenaga Kesehatan' }}"
            dengan Kerangka Acuan Kegiatan (KAK) sebagaimana terlampir.
        </p>
        <p class="indent">
            Demikian atas perhatian dan kerja samanya disampaikan terima kasih.
        </p>
    </div>

    <div class="ttd">
        <p><strong>{{ $ttd?->jabatanpenanggungjawab_opd ?? 'Kepala Organisasi Perangkat Daerah' }}</strong></p>
        <p><strong>Kota Surakarta</strong></p>

        <div class="ttd-wrapper">

            @php
            $hasStempel = $showStempel
            && !empty($stempel?->gambarstempel_opd)
            && file_exists(storage_path('app/public/' . $stempel->gambarstempel_opd));
            @endphp

            {{-- ===== STAMPEL ===== --}}
            @if($showStempel && !empty($stempel?->gambarstempel_opd) &&
            file_exists(storage_path('app/public/' . $stempel->gambarstempel_opd)))
            <img src="{{ storage_path('app/public/' . $stempel->gambarstempel_opd) }}"
                class="stempel-layer"
                alt="Stempel OPD">
            @endif

            {{-- ===== TTD ===== --}}
            @if($showTtd && !empty($ttd?->gambarttd_opd))
            <img
                src="{{ storage_path('app/public/' . $ttd->gambarttd_opd) }}"
                class="{{ $hasStempel ? 'ttd-layer' : 'ttd-layer-no-stempel' }}"
                alt="TTD OPD">
            @endif

        </div>

        <p><strong>{{ $ttd?->namakepala_opd ?? 'dr. Retno Widyastuti, M.Kes' }}</strong></p>
        @if ($showJabatan && $ttd?->jabatanpenanggungjawab_opd)
        <p><strong>{{ $ttd?->jabatanpenanggungjawab_opd ?? 'ASN Golongan III/C' }}</strong></p>
        @endif
        @if ($showNIP && $ttd?->nipkepala_opd)
        <p>NIP. <strong>{{ $ttd?->nipkepala_opd ?? '197912182006041006' }}</strong></p>
        @endif
    </div>

    <div class="page-break"></div>

    {{-- ====================== KERANGKA ACUAN KERJA (KAK) ====================== --}}
    <div class="kop-container">
        @if($usulankegiatans->detailusulankegiatans->jeniskop_usulankegiatan === 'kop_text')
        @if($kop_path && file_exists($kop_path))
        <img src="{{ $kop_path }}" class="kop-logo" alt="Logo Pemerintah Kota Surakarta">
        @endif
        @endif

        {{-- ================= KOP GAMBAR ================= --}}
        @if($usulankegiatans->detailusulankegiatans->jeniskop_usulankegiatan === 'kop_gambar')
        @if(!empty($kop?->gambarkop_opd) && file_exists(storage_path('app/public/' . $kop->gambarkop_opd)))
        <img src="{{ storage_path('app/public/' . $kop->gambarkop_opd) }}" class="kop-gambar-full" alt="Logo OPD">
        @endif

        {{-- ================= KOP TEXT ================= --}}
        @elseif($usulankegiatans->detailusulankegiatans->jeniskop_usulankegiatan === 'kop_text')

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
            <h3>KERANGKA ACUAN KERJA (KAK)</h3>
            <h3>KEGIATAN PENGEMBANGAN KOMPETENSI<br></h3>
            <h3>TAHUN ANGGARAN {{ \Carbon\Carbon::now()->year }}<br></h3>
        </div>

        @php
        $letterIndex = 0; // mulai dari A
        function getLetter($i) {
        $alphabet = range('A', 'Z');
        return $alphabet[$i] ?? ('Z' . ($i - 25));
        } // fallback kalau lewat Z
        @endphp

        <p class="section-title">{{ getLetter($letterIndex++) }}. NAMA KEGIATAN PENGEMBANGAN KOMPETENSI</p>
        <p>{{ $usulankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }}</p>

        <p class="section-title">{{ getLetter($letterIndex++) }}. LATAR BELAKANG</p>
        @php
        $latarbelakang = trim($usulankegiatans->detailusulankegiatans->latarbelakang_kegiatan ?? '');
        $blocks = preg_split("/\r\n|\r|\n/", $latarbelakang); // pisah tiap paragraf kosong
        @endphp

        @if(!empty($latarbelakang))
        @foreach($blocks as $block)
        <p class="indent">{!! nl2br(e(trim($block))) !!}</p>
        @endforeach
        @else
        <p class="indent">
            Kegiatan ini dilaksanakan untuk meningkatkan kemampuan pegawai di bidangnya.
        </p>
        @endif

        <p class="section-title">{{ getLetter($letterIndex++) }}. DASAR HUKUM</p>
        @php
        $dasarhukum = trim($usulankegiatans->detailusulankegiatans->dasarhukum_kegiatan ?? '');
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

        <p class="section-title">{{ getLetter($letterIndex++) }}. URAIAN KEGIATAN</p>
        @php
        $uraian = trim($usulankegiatans->detailusulankegiatans->uraian_kegiatan ?? '');
        $blocks = preg_split("/\r\n|\r|\n/", $uraian); // split per paragraf / blok
        @endphp
        @if(!empty($uraian))
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

        <p class="section-title">{{ getLetter($letterIndex++) }}. MAKSUD DAN TUJUAN</p>
        <div class="kak-maksud-tujuan">
            <ol type="1">
                <li>MAKSUD
                    @php
                    $maksud = trim($usulankegiatans->detailusulankegiatans->maksud_kegiatan ?? '');
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
                    $tujuan = trim($usulankegiatans->detailusulankegiatans->tujuan_kegiatan ?? '');
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

        <p class="section-title">{{ getLetter($letterIndex++) }}. HASIL LANGSUNG YANG DIHARAPKAN</p>
        @php
        $hasillangsung = trim($usulankegiatans->detailusulankegiatans->hasillangsung_kegiatan ?? '');
        $blocks = preg_split("/\r\n|\r|\n/", $hasillangsung); // split per paragraf / blok
        @endphp
        @if(!empty($hasillangsung))
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

        <p class="section-title">{{ getLetter($letterIndex++) }}. HASIL JANGKA MENENGAH YANG DIHARAPKAN</p>
        @php
        $hasilmenengah = trim($usulankegiatans->detailusulankegiatans->hasilmenengah_kegiatan ?? '');
        $blocks = preg_split("/\r\n|\r|\n/", $hasilmenengah);
        @endphp
        @if(!empty($hasilmenengah))
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

        <p class="section-title">{{ getLetter($letterIndex++) }}. HASIL JANGKA PANJANG YANG DIHARAPKAN</p>
        @php
        $hasilpanjang = trim($usulankegiatans->detailusulankegiatans->hasilpanjang_kegiatan ?? '');
        $blocks = preg_split("/\r\n|\r|\n/", $hasilpanjang); // split per paragraf / blok
        @endphp
        @if(!empty($hasilpanjang))
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

        <p class="section-title">{{ getLetter($letterIndex++) }}. NARASUMBER DAN SASARAN PESERTA</p>
        <div class="kak-narasumber-peserta">
            <ol type="1">
                <li>NARASUMBER
                    @php
                    $narasumber = trim($usulankegiatans->detailusulankegiatans->narasumber_kegiatan ?? '');
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
                <li>SASARAN PESERTA
                    <p class="indent">
                        Sasaran peserta yang mengikuti kegiatan ini merupakan orang yang berasal dari ruang lingkup
                        {{ $usulankegiatans?->subunitkerjas?->sub_unitkerja }} di Kota Surakarta yang mana meliputi: <br>
                        {!! nl2br(e($usulankegiatans->detailusulankegiatans->sasaranpeserta_kegiatan ?? 'Peserta berasal dari tenaga kesehatan puskesmas, sebanyak 50 orang.')) !!}
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
        <p class="indent">Berikut terlampir dalam rancangan susunan acara untuk kegiatan pengembangan komptensi yang akan dilaksanakan:</p>
        @if(!empty($jadwalpelaksanaan_kegiatan) && count($jadwalpelaksanaan_kegiatan) > 1)
        <div class="susunan-acara-wrapper">
            <table class="susunan-acara">
                @foreach($jadwalpelaksanaan_kegiatan as $r => $row)
                @php
                // Bersihkan semua sel dari spasi tak terlihat dan format Excel
                /*$row = array_map(function ($cell) {
                if (is_array($cell))
                $cell = implode(', ', array_filter($cell));
                $cell = preg_replace('/[\x00-\x1F\x7F]/u', '', (string) $cell); // hapus karakter kontrol
                $cell = trim(str_replace([' ', "\t", "\n", "\r"], '', $cell)); // hapus spasi non-breaking, tab, newline
                return $cell === '' ? null : $cell;
                }, $row);*/
                $row = array_map(function ($cell) {

                if (is_array($cell)) {
                $cell = implode(', ', array_filter($cell));
                }

                $cell = preg_replace('/[\x00-\x1F\x7F]/u', '', (string) $cell);

                // jangan hapus spasi
                $cell = trim($cell);

                // rapikan spasi ganda
                $cell = preg_replace('/\s+/', ' ', $cell);

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
                    <td colspan="{{ count($jadwalpelaksanaan_kegiatan[0]) }}">
                        {{ ucwords(preg_replace(['/([a-z])([A-Z])/', '/([a-zA-Z])\(/'], '$1 $2', $row[0])) }}
                    </td>
                </tr>

                {{-- Header tabel --}}
                @elseif($r === 0)
                <thead>
                    <tr>
                        @for($i = 0; $i < 3; $i++)
                            <th>
                            {{ ucwords(
                    preg_replace(
                        ['/([a-z])([A-Z])/', '/([a-zA-Z])\(/'],
                        ['$1 $2', '$1 ('],
                        $row[$i]
                    )
                ) }}
                            </th>
                            @endfor
                    </tr>
                </thead>
                <tbody>

                    {{-- Data biasa --}}
                    @else
                    <tr>

                        {{-- Kolom Hari / Tanggal --}}
                        @if(($row['_rowspan'] ?? 0) > 0)

                        <td rowspan="{{ $row['_rowspan'] }}" class="td-hari">
                            {{ $row[0] }}
                        </td>

                        @elseif(!empty($row[0]))

                        <td class="td-hari">
                            {{ $row[0] }}
                        </td>

                        @endif

                        {{-- Waktu --}}
                        <td class="td-waktu">
                            {{ $row[1] }}
                        </td>

                        {{-- Agenda --}}
                        <td class="td-agenda">
                            {{ $row[2] }}
                        </td>

                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="indent">Terlampir dalam jadwal kegiatan.</p>
        @endif

        <p class="section-title">{{ getLetter($letterIndex++) }}. PENUTUP</p>
        <p class="indent">
            {{ $usulankegiatans->detailusulankegiatans->penutup_kegiatan ?? 'Demikian Kerangka Acuan Kerja ini dibuat untuk digunakan sebagai pedoman pelaksanaan kegiatan.' }}
        </p>
    </div>

    <div class="ttd">
        <p><strong>{{ $ttd?->jabatanpenanggungjawab_opd ?? 'Kepala Organisasi Perangkat Daerah' }}</strong></p>
        <p><strong>Kota Surakarta</strong></p>

        <div class="ttd-wrapper">

            @php
            $hasStempel = $showStempel
            && !empty($stempel?->gambarstempel_opd)
            && file_exists(storage_path('app/public/' . $stempel->gambarstempel_opd));
            @endphp

            {{-- ===== STAMPEL ===== --}}
            @if($showStempel && !empty($stempel?->gambarstempel_opd) &&
            file_exists(storage_path('app/public/' . $stempel->gambarstempel_opd)))
            <img src="{{ storage_path('app/public/' . $stempel->gambarstempel_opd) }}"
                class="stempel-layer"
                alt="Stempel OPD">
            @endif

            {{-- ===== TTD ===== --}}
            @if($showTtd && !empty($ttd?->gambarttd_opd))
            <img
                src="{{ storage_path('app/public/' . $ttd->gambarttd_opd) }}"
                class="{{ $hasStempel ? 'ttd-layer' : 'ttd-layer-no-stempel' }}"
                alt="TTD OPD">
            @endif

        </div>

        <p><strong>{{ $ttd?->namakepala_opd ?? 'dr. Retno Widyastuti, M.Kes' }}</strong></p>
        @if ($showJabatan && $ttd?->jabatanpenanggungjawab_opd)
        <p><strong>{{ $ttd?->jabatanpenanggungjawab_opd ?? 'ASN Golongan III/C' }}</strong></p>
        @endif
        @if ($showNIP && $ttd?->nipkepala_opd)
        <p>NIP. <strong>{{ $ttd?->nipkepala_opd ?? '197912182006041006' }}</strong></p>
        @endif
    </div>
</body>

</html>