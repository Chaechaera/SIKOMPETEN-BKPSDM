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
                    <td>{{ $balasanlaporankegiatans->identitassurats->nomor_surat ?? '....' }}</td>
                </tr>
                <tr>
                    <td class="label">Sifat</td>
                    <td class="colon">:</td>
                    <td>{{ $balasanlaporankegiatans->sifat_surat ?? 'Biasa' }}</td>
                </tr>
                <tr>
                    <td class="label">Lampiran</td>
                    <td class="colon">:</td>
                    <td>{{ $balasanlaporankegiatans->identitassurats->lampiran_surat ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td class="colon">:</td>
                    <td><strong>{{ $balasanlaporankegiatans->identitassurats->perihal_surat ?? 'Permohonan Rekomendasi Kegiatan Pengembangan Kompetensi' }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="meta-right">
            <p>Surakarta,
                {{ $balasanlaporankegiatans->identitassurats->tanggal_surat
                    ? \Carbon\Carbon::parse($balasanlaporankegiatans->identitassurats->tanggal_surat)->translatedFormat('d F Y')
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

    {{-- =================== ISI SURAT =================== --}}
        <div class="content">
        <p class="indent">Menindaklanjuti surat Kepala {{ $user->subunitkerjas->sub_unitkerja }} Kota Surakarta Nomor:
            <strong>{{ $balasanlaporankegiatans->laporankegiatans->identitassurats->nomor_surat ?? '-' }}</strong> tanggal {{ $balasanlaporankegiatans->laporankegiatans->identitassurats->tanggal_surat ?? '-' }} perihal {{ $balasanlaporankegiatans->laporankegiatans->identitassurats->perihal_surat ?? '-' }} yang telah dikirimkan kepada BKPSDM
            Kota Surakarta melalui tautan
            <a href="#">https://bit.ly/uploadlaporanbangkom2025</a>, bersama ini kami sampaikan hal-hal berikut:</p>

        <ol>
            <li>Kegiatan {{ $balasanlaporankegiatans->laporankegiatans->usulankegiatans->nama_kegiatan ?? '-' }} sudah sesuai dengan ketentuan Pengembangan Kompetensi dan ditetapkan nomor register sertifikat
                yaitu:
                <strong>{{ $balasanlaporankegiatans->sertifikats->nomorsertifikat_kegiatan ?? '-' }}</strong> dengan tanggal sertifikat {{ $balasanlaporankegiatans->sertifikats->tanggalkeluarsertifikat_kegiatan ?? '-' }}.
            </li>
            <li>Nomor register sertifikat adalah nomor sertifikat yang tertulis pada sertifikat Pengembangan Kompetensi Workshop.</li>
            <li>Berdasarkan materi dan waktu pelaksanaan kegiatan yang dilaksanakan selama 3 hari penuh maka pengakuan
                Jam Pelajaran (JP) untuk kegiatan tersebut adalah <strong>{{ $balasanlaporankegiatans->totalcapaianjp_kegiatan ?? '-' }} Jam Pelajaran</strong> yang berlaku untuk peserta dan narasumber kegiatan.</li>
            <li>Apabila sertifikat sudah diterbitkan, maka Unit Kerja penyelenggara kegiatan wajib untuk mengunggah hasil
                sertifikat pada tautan
                <a href="#">https://bit.ly/uploadsertifikat_bangkom2025</a>.
            </li>
        </ol>

        <p class="indent">
            Demikian atas kerjasamanya disampaikan terima kasih.
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


        <p><strong>{{ $usulankegiatans->nama_pejabat ?? 'dr. Retno Widyastuti, M.Kes' }}</strong></p>
        <p>NIP. {{ $usulankegiatans->nip_pejabat ?? '19791218 200604 1 006' }}</p>
    </div>
</body>

</html>