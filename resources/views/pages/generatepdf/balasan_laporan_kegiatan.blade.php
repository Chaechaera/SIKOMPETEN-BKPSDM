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
            margin-top: 4px;
            margin-bottom: 4px;
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
            margin-top: 15px;
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

        .ttd-wrapper {
            position: relative;
            width: 75%;
            /* perbesar area gabungan */
            height: 75%;
            /* tinggi total */
            margin-top: 5px;
            margin-bottom: -60px;
        }

        /* === STEMPEL === */
        .stempel-layer {
            position: absolute;
            left: 30%;
            /* pusatkan horizontal */
            top: 10px;
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
            <p>Jl. Jenderal Sudirman No. 2 Telp. (0271) 642020 Fax. (0271) 638088</p>
            <p>Website: bkpsdm.surakarta.go.id Email: bkpsdm@surakarta.go.id</p>
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
                    <td>{{ $balasanlaporankegiatans->laporankegiatans?->identitassurats?->nomor_surat ?? '' }}</td>                </tr>
                <tr>
                    <td class="label">Sifat</td>
                    <td class="colon">:</td>
                    <td>{{ $balasanlaporankegiatans->laporankegiatans?->identitassurats?->sifat_surat ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Lampiran</td>
                    <td class="colon">:</td>
                    <td>{{ $balasanlaporankegiatans->laporankegiatans?->identitassurats?->lampiran_surat ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td class="colon">:</td>
                    <td><strong>{{ $balasanlaporankegiatans->laporankegiatans?->identitassurats?->perihal_surat ?? '' }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="meta-right">
            <p>Surakarta,
                {{ $balasanlaporankegiatans->laporankegiatans?->identitassurats?->tanggal_surat
                    ? \Carbon\Carbon::parse($balasanlaporankegiatans->laporankegiatans?->identitassurats?->tanggal_surat)->translatedFormat('d F Y')
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

    {{-- =================== ISI SURAT =================== --}}
        <div class="content">
        <p class="indent">Menindaklanjuti surat Kepala {{ $user->subunitkerjas->sub_unitkerja }} Kota Surakarta Nomor:
            <strong>{{ $balasanlaporankegiatans->laporankegiatans->inputlaporankegiatans->kirimlaporankegiatans?->identitassurats?->nomor_surat ?? '-' }}</strong> tanggal {{ \Carbon\Carbon::parse ($balasanlaporankegiatans->laporankegiatans->inputlaporankegiatans->kirimlaporankegiatans?->identitassurats?->tanggal_surat)->translatedFormat('d F Y') ?? '-' }} 
            perihal {{ $balasanlaporankegiatans->laporankegiatans->inputlaporankegiatans->kirimlaporankegiatans?->identitassurats?->perihal_surat ?? '-' }} yang telah dikirimkan kepada BKPSDM
            Kota Surakarta melalui tautan
            <a href="#">https://bit.ly/uploadlaporanbangkom2025</a>, bersama ini kami sampaikan hal-hal berikut:</p>

        <ol>
            <li>Kegiatan {{ $balasanlaporankegiatans->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }} sudah sesuai dengan ketentuan Pengembangan Kompetensi dan ditetapkan nomor register sertifikat
                yaitu:
                <strong>{{ $balasanlaporankegiatans->laporankegiatans->sertifikats->nomorsertifikat_kegiatan ?? '-' }}</strong> dengan tanggal sertifikat {{ \Carbon\Carbon::parse($balasanlaporankegiatans->laporankegiatans->sertifikats->tanggalkeluarsertifikat_kegiatan)->translatedFormat('d F Y') ?? '-' }}.
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
        <p><strong>Kepala {{ $user->subunitkerjas?->sub_unitkerja ?? '-' }}</strong></p>
        <p><strong>Kota Surakarta</strong></p>

        <div class="ttd-wrapper">

            {{-- ===== STAMPEL ===== --}}
            @if(!empty($stempel?->gambarstempel_opd) && file_exists(storage_path('app/public/' . $stempel->gambarstempel_opd)))
            <img src="{{ storage_path('app/public/' . $stempel->gambarstempel_opd) }}" class="stempel-layer" alt="Stempel OPD">
            @endif

            {{-- ===== TTD ===== --}}
            @if(!empty($ttd?->gambarttd_opd) && file_exists(storage_path('app/public/' . $ttd->gambarttd_opd)))
            <img src="{{ storage_path('app/public/' . $ttd->gambarttd_opd) }}" class="ttd-layer" alt="TTD OPD">
            @endif

        </div>

        <p><strong>{{ $usulankegiatans->nama_pejabat ?? 'dr. Retno Widyastuti, M.Kes' }}</strong></p>
        <p>NIP. {{ $usulankegiatans->nip_pejabat ?? '19791218 200604 1 006' }}</p>
    </div>
</body>

</html>