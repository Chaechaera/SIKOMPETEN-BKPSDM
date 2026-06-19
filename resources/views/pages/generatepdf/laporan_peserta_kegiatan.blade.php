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

        /* ====================== COVER ====================== */

        .cover-page {
            text-align: center;
            margin-top: 80px;
        }

        .cover-title {
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
            margin: 0 0 10px 0;
            line-height: 1.3;
        }

        .cover-judul-kegiatan {
            width: 85%;
            margin: 0 auto;
            font-size: 16pt;
            font-weight: bold;
            line-height: 1.2;
            text-align: center;
        }

        .cover-logo {
            width: 160px;
            height: auto;
            margin-top: 60px;
            margin-bottom: 40px;
        }

        .cover-identitas {
            margin: 0 auto;
            border-collapse: collapse;
            width: auto;
            font-size: 12pt;
        }

        .cover-identitas td {
            border: none !important;
            padding: 3px 8px;
            font-size: 12pt;
            text-align: left;
        }

        .cover-identitas .label {
            width: 120px;
        }

        .cover-identitas .colon {
            width: 10px;
            text-align: center;
        }

        .cover-footer {
            margin-top: 80px;
        }

        .cover-footer h2 {
            margin: 0 0 10px 0;
            font-size: 16pt;
            font-weight: bold;
            text-align: center;
        }

        /* ====================== PEMBATAS HALAMAN ====================== */
        .page-break {
            page-break-after: always;
        }

        /* ====================== BAGIAN LAPORAN PESERTA ====================== */
        p {
            margin: 4px 0;
            text-align: justify;
            padding-left: 20px;
            padding-right: 20px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            position: center;
        }

        .table td {
            padding: 2px 4px;
            vertical-align: top;
            border: none;
        }

        .table .label {
            width: 100px;
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
    {{-- ====================== COVER LAPORAN PESERTA ====================== --}}
    <div class="cover-page">

        <h2 class="cover-title">
            LAPORAN PESERTA
        </h2>

        <h2 class="cover-title">
            KEGIATAN PENGEMBANGAN KOMPETENSI ASN
        </h2>

        <h2 class="cover-judul-kegiatan">
            {{ strtoupper($laporanpesertakegiatans->sertifikats->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '-') }}
        </h2>

        @if($kop_path && file_exists($kop_path))
        <img src="{{ $kop_path }}" class="cover-logo" alt="Logo">
        @endif

        <table class="cover-identitas">
            <tr>
                <td class="label">Nama Peserta</td>
                <td class="colon">:</td>
                <td>{{ $laporanpesertakegiatans->pesertakegiatans->nama_peserta ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">NIP/NIK Peserta</td>
                <td class="colon">:</td>
                <td>{{ $laporanpesertakegiatans->pesertakegiatans->nip_nik_peserta ?? '-' }}</td>
            </tr>
        </table>

        <div class="cover-footer">
            <h2>
                {{ strtoupper($laporanpesertakegiatans->pesertakegiatans->subunitkerjas->sub_unitkerja ?? '-') }}
            </h2>

            <h2>
                PEMERINTAH KOTA SURAKARTA
            </h2>

            <h2>
                {{ date('Y') }}
            </h2>
        </div>

    </div>

    <div class="page-break"></div>

    {{-- ====================== LAPORAN PESERTA HASIL KEGIATAN ====================== --}}
    <div class="kak-section">
        <div class="kak-title">
            <h3>LAPORAN KEIKUTSERTAAN PESERTA KEGIATAN</h3>
            <h3>{{ mb_strtoupper($laporanpesertakegiatans->sertifikats->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '-') }}<br></h3>
        </div>

        @php
        $letterIndex = 0; // mulai dari A
        function getLetter($i) {
        $alphabet = range('A', 'Z');
        return $alphabet[$i] ?? ('Z' . ($i - 25));
        } // fallback kalau lewat Z
        @endphp

        <p class="section-title">{{ getLetter($letterIndex++) }}. TUJUAN PARTISIPASI KEGIATAN</p>
        @php
        $tujuanpartisipasi = trim($laporanpesertakegiatans->tujuanpeserta_kegiatan ?? '');
        $blocks = preg_split("/\r\n|\r|\n/", $tujuanpartisipasi); // pisah tiap paragraf kosong
        @endphp

        @if(!empty($tujuanpartisipasi))
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

        <p class="section-title">{{ getLetter($letterIndex++) }}. URAIAN PARTISIPASI KEGIATAN</p>
        @php
        $uraianpartisipasi = trim($laporanpesertakegiatans->uraianpeserta_kegiatan ?? '');
        $blocks = preg_split("/\r\n|\r|\n/", $uraianpartisipasi); // pisah tiap paragraf kosong
        @endphp

        @if(!empty($uraianpartisipasi))
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

        <p class="section-title">{{ getLetter($letterIndex++) }}. RANGKUMAN SESI KEGIATAN</p>
        @php
        $rangkumansesi = trim($laporanpesertakegiatans->rangkumanpeserta_kegiatan ?? '');
        $blocks = preg_split("/\r\n|\r|\n/", $rangkumansesi); // pisah tiap paragraf kosong
        @endphp

        @if(!empty($rangkumansesi))
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

        <p class="section-title">{{ getLetter($letterIndex++) }}. KESIMPULAN PARTISIPASI KEGIATAN</p>
        @php
        $kesimpulanpartisipasi = trim($laporanpesertakegiatans->kesimpulanpeserta_kegiatan ?? '');
        $blocks = preg_split("/\r\n|\r|\n/", $kesimpulanpartisipasi); // pisah tiap paragraf kosong
        @endphp

        @if(!empty($kesimpulanpartisipasi))
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

        {{-- ====================== LAMPIRAN DOKUMENTASI HASIL KEGIATAN ====================== --}}
        @if(!empty($dokumentasipeserta_kegiatan))
        <div class="page-break"></div>

        <h3 style="text-align:center; margin-top:10px;">
            LAMPIRAN DOKUMENTASI<br>KEIKUTSERTAAN PESERTA KEGIATAN
        </h3>

        @foreach(array_chunk($dokumentasipeserta_kegiatan, 2) as $pair)
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