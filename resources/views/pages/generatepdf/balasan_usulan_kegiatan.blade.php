<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Surat Balasan Pengajuan dan KAK Usulan Kegiatan</title>
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
            /* bukan block */
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

        /* ====================== PEMBATAS HALAMAN AGAR TTD TIDAK TERPISAH ====================== */
        .page-break {
            page-break-after: always;
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
                    <td>{{ $identitas->nomor_surat?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Sifat</td>
                    <td class="colon">:</td>
                    <td>{{ $identitas->sifat_surat?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Lampiran</td>
                    <td class="colon">:</td>
                    <td>{{ $identitas->lampiran_surat?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Perihal</td>
                    <td class="colon">:</td>
                    <td>{{ $identitas->perihal_surat?? '' }}</td>
                </tr>
            </table>
        </div>

        <div class="meta-right">
            <p>Surakarta,
                {{
                    ($identitas->tanggal_surat ?? '')
                    ? \Carbon\Carbon::parse(
                        $identitas->tanggal_surat
                        ?? ''
                    )->translatedFormat('d F Y')
                    : ''
                }}
            </p>
        </div>
    </div>

    <div class="tujuan">
        <p>Yth.</p>
        <p>{{ $ttdPengusul?->jabatanpenanggungjawab_opd ?? '-' }}</p>
        <p>Kota Surakarta</p>
        <p><strong>di SURAKARTA</strong></p>
    </div>

    {{-- =================== ISI SURAT =================== --}}
    <div class="content">
        <p class="indent">Menindaklanjuti surat {{ $ttdPengusul?->jabatanpenanggungjawab_opd ?? '-' }} Kota Surakarta nomor
            <strong>{{ $usulankegiatans->inputusulankegiatans->kirimusulankegiatans?->identitassurats?->nomor_surat ?? '-' }}</strong> tanggal {{ \Carbon\Carbon::parse($usulankegiatans->inputusulankegiatans->kirimusulankegiatans?->identitassurats?->tanggal_surat)->translatedFormat('d F Y') ?? '-' }} 
            perihal {{ $usulankegiatans->inputusulankegiatans->kirimusulankegiatans?->identitassurats?->perihal_surat ?? '-' }}, bersama ini kami sampaikan hal-hal berikut:
        </p>

        <ol>
            <li>Kerangka Acuan Kerja (KAK) Kegiatan Pengembangan Kompetensi dalam bentuk {{ $usulankegiatans->inputusulankegiatans->nama_kegiatan ?? '-' }} yang diajukan sudah sesuai dengan ketentuan Pengembangan Kompetensi dalam bentuk {{ $usulankegiatans->carapelatihans->cara_pelatihan ?? '-' }}.</li>
            <li>Kegiatan Pengembangan Kompetensi tersebut direkomendasikan untuk dilaksanakan sesuai dengan aturan yang berlaku, dengan berpedoman pada Petunjuk Teknis Nomor B/KP 04.00/1340/ Tahun 2025 Tentang Pedoman Pengembangan Kompetensi bagi Aparatur Sipil Negara di Lingkungan Pemerintah Kota Surakarta.</li>
            <li>Setelah Kegiatan Pengembangan Kompetensi selesai dilaksanakan, unit kerja penyelenggara <strong>wajib</strong> mengirimkan laporan pelaksanaan kepada BKPSDM Kota Surakarta melalui website SIKOMPETEN</li>
            <li>Laporan Pelaksanaan Pengembangan Kompetensi akan diverifikasi. Apabila laporan dinyatakan sesuai, maka akan diberikan Nomor Register Sertifikat sebagai pengesahan Kegiatan Pengembangan Kompetensi, yang selanjutnya akan disampaikan oleh BKPSDM kepada unit kerja penyelenggara.</li>
        </ol>

        <p class="indent">
            Demikian atas kerjasamanya disampaikan terima kasih.
        </p>
    </div>

    <div class="ttd">
        <p><strong>{{ $ttd?->jabatanpenanggungjawab_opd ?? 'Kepala Organisasi Perangkat Daerah' }}</strong></p>
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

        <p><strong>{{ $ttd?->namakepala_opd ?? 'dr. Retno Widyastuti, M.Kes' }}</strong></p>
        <p><strong>{{ $ttd?->pangkatpenanggungjawab_opd ?? 'ASN Golongan III/C' }}</strong></p>
        <p>NIP. {{ $ttd?->nipkepala_opd ?? '197912182006041006' }}</p>
    </div>
</body>

</html>