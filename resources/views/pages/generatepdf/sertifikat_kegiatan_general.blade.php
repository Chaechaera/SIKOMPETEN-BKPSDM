<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sertifikat</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto+Slab:wght@100..900&display=swap');

        @page {
            size: A4 landscape;
            margin: 0;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            /*height: 100%;
    width: 100%;*/
            font-family: "Roboto Slab", sans-serif;
            text-align: center;
        }

        .container {
            position: relative;
            min-width: 100%;
            min-height: 90%;
            /*box-sizing: border-box;
            border: 3px solid #000;*/
            padding: 20px;

            display: flex;
            flex-direction: column;

            overflow: hidden;
            /* 🔥 penting biar gak nembus halaman
            page-break-inside: avoid;
            break-inside: avoid;*/
        }

        .content {
            /*flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
             🔥 vertical center */
            /*align-items: center;
             🔥 horizontal center */
            text-align: center;
            margin-top: 20px;
        }

        /*body {
    display: flex;
    align-items: stretch;
    font-family: "Roboto Slab", serif;
            margin: 0;
            text-align: center;
}

.container {
border: 3px solid #000;
            padding: 10px;    
            position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}*/

        /*body {
            font-family: "Roboto Slab", serif;
            margin: 0;
            text-align: center;
            height: 100%;
        }

        .container {
            border: 3px solid #000;
            padding: 20px;
            position: relative;
            width: 100%;
            page-break-inside: avoid;

            box-sizing: border-box;
        }*/

        .kop {
            text-align: center;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
        }

        .judul {
            font-size: 20px;
            font-weight: bold;
            margin-top: 50px;
        }

        .subjudul {
            font-size: 16px;
            font-weight: 600;
        }

        .sertifikat {
            font-family: "Great Vibes", cursive;
            font-size: 65px;
            color: #BF8F00;
            margin: -4px 0;
        }

        .nomor {
            margin-bottom: 8px;
            font-size: 16px;
        }

        .nama {
            font: "Playfair Display", bold;
            font-size: 26px;
            font-weight: bold;
            margin: 2px 0;
        }

        .nip {
            font: "Playfair Display", bold;
            font-size: 22px;
        }

        .isi {
            font-size: 12px;
            width: 80%;
            margin: 10px auto;
            line-height: 1.5;
        }

        .bottom {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .footer {
            position: absolute;
            left: 50px;
            bottom: 40px;

            width: 600px;
            font-size: 10px;
            text-align: left;
            /*width: 300px;
            font-size: 10px;
            text-align: left;
            margin-left: 20px;*/
        }

        .ttd {
            position: absolute;
            width: 300px;
            right: 50px;
            bottom: 40px;
            width: 300px;
            text-align: left;
            /*display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
            margin-top: 8px;
            margin-right: 20px;
             ⬅️ ini yang bikin ke kanan 
            width: 50%;*/
            /* batasi lebar area tanda tangan 
            margin-left: auto;*/
            /*margin-top: 30px;
            padding-right: 10px;*/
            /* atur jarak dari tepi kanan 
            line-height: 1.3;
            page-break-inside: avoid;*/
        }

        .ttd p {
            margin: 1px 0;
            font-size: 10pt;
        }

        .ttd img {
            display: inline-block;
            height: 50px;
            margin: 0;
            align-items: flex-end;
            margin-left: auto;
            position: relative;
            left: 5%;
        }

        .ttd-wrapper {
            position: relative;
            width: 200px;
            /* perbesar area gabungan */
            height: 80px;
            /* tinggi total 
            margin-top: 5px;
            margin-bottom: -180px;*/
        }

        /* === STEMPEL === */
        .stempel-layer {
            position: absolute;
            left: 50%;
            /* pusatkan horizontal */
            top: 20px;
            /* geser naik biar nyentuh tulisan atas */
            transform: translateX(-50%) scale(2.3);
            /* perbesar proporsional (lebar & tinggi) */
            transform-origin: center;
            opacity: 0.6;
            /* tetap transparan */
            z-index: 2;
            mix-blend-mode: multiply;
        }

        /* === TTD === */
        .ttd-layer {
            position: absolute;
            left: 50%;
            top: 30px;
            /* geser ke bawah biar nempel pas di atas stempel */
            transform: translateX(-50%) scale(1.5);
            width: 100px;
            /*sedikit lebih kecil dari stempel */
            z-index: 1;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="content">
            {{-- LOGO --}}
            @if($kop_path && file_exists($kop_path))
            <img src="{{ $kop_path }}" class="logo" alt="Logo Pemerintah Kota Surakarta">
            @endif

            {{-- KOP --}}
            <div class="kop">
                <div class="judul">PEMERINTAH KOTA SURAKARTA</div>
                <div class="subjudul">{{ $peserta->detaillaporankegiatans->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->subunitkerjas->sub_unitkerja ?? 'NAMA PERANGKAT DAERAH' }}</div>
            </div>

            {{-- JUDUL --}}
            <div class="sertifikat">Sertifikat</div>

            {{-- NOMOR --}}
            <div class="nomor">
                Nomor: {{ $peserta->nomorsertifikatpeserta_kegiatan ?? '.........................' }}
            </div>

            {{-- PENERIMA --}}
            <div>Diberikan kepada :</div>

            <div class="nama">
                {{ $peserta->nama_peserta ?? '{Nama}' }}
            </div>

            <div class="nip">
                {{ $peserta->nip_nik_peserta ?? '{NIP}' }}
            </div>

            {{-- DESKRIPSI --}}
            <div class="isi">
                Atas partisipasinya sebagai
                <b>Peserta</b>
                dalam acara
                <b>{{ $peserta->detaillaporankegiatans->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? 'Nama Kegiatan' }}</b>
                yang diselenggarakan oleh
                <b>{{ $peserta->detaillaporankegiatans->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->detailusulankegiatans->penyelenggara_kegiatan ?? 'Instansi' }}</b>
                Tahun <b>{{ $peserta->detaillaporankegiatans->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->tanggalmulai_kegiatan ? \Carbon\Carbon::parse($peserta->detaillaporankegiatans->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->tanggalmulai_kegiatan)->format('Y') : '2026' }}</b>
                selama <b>{{ $totalcapaianjp_text ?? '' }}</b> Jam Pelajaran.
            </div>
        </div>

        <div class="bottom">
            {{-- FOOTER --}}
            <div class="footer">
                Dokumen ini telah disahkan oleh Badan Kepegawaian dan Pengembangan
                Sumber Daya Manusia Kota Surakarta.
            </div>

            {{-- TTD --}}
            <div class="ttd">
                <p>Surakarta, {{ $peserta->sertifikats->tanggalkeluarsertifikat_kegiatan ? \Carbon\Carbon::parse($peserta->sertifikats->tanggalkeluarsertifikat_kegiatan)->format('d F Y') : now()->format('d F Y') }} <br></p>
                <p>Kepala {{ $peserta->detaillaporankegiatans->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->subunitkerjas->sub_unitkerja ?? 'Perangkat Daerah' }}</p>

                <div class="ttd-wrapper">

                    {{-- ===== STAMPEL ===== --}}
                    @if(!empty($stempel?->gambarstempel_opd) && file_exists(storage_path('app/public/' . $stempel->gambarstempel_opd)))
                    <img src="data:image/png;base64,{{ $stempelBase64 }}" class="stempel-layer">
                    @endif

                    {{-- ===== TTD ===== --}}
                    @if(!empty($ttd?->gambarttd_opd) && file_exists(storage_path('app/public/' . $ttd->gambarttd_opd)))
                    <img src="data:image/png;base64,{{ $ttdBase64 }}" class="ttd-layer">
                    @endif

                </div>

                <p>{{ $peserta->detaillaporankegiatans->laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->subunitkerjas->ttdunitkerjas->first()->namakepala_opd ?? 'NAMA TANPA GELAR' }}</p>
            </div>
        </div>
    </div>

</body>

</html>