<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            size: 1123px 794px;
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 1123px;
            height: 794px;
            overflow: hidden;
            font-family: "Times New Roman", serif;
        }

        body {
            position: relative;
        }

        .certificate {
            position: relative;
            width: 1123px;
            height: 794px;
            overflow: hidden;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        .background {
            position: absolute;
            inset: 0;
            width: 1123px;
            height: 794px;
            z-index: 0;
        }

        .field {
            position: absolute;
            z-index: 5;
            white-space: nowrap;
            line-height: 1;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>

    <div class="certificate">

        {{-- Background --}}
        <img
            src="data:{{ $backgroundMime }};base64,{{ $backgroundBase64 }}"
            class="background">

        @php
        $fields = $fieldstemplatesertifikat_kegiatan ?? [];
        @endphp

        @foreach($fields as $f)

        @php

        $type = $f['type'] ?? '';

        /*
        ============================
        POSITION PERCENT
        ============================
        */

        $leftPx =
        (($f['x_percent'] ?? 0) / 100) * 1123;

        $topPx =
        (($f['y_percent'] ?? 0) / 100) * 794;

        $width =
        $f['width'] ?? 0;

        $height =
        $f['height'] ?? 0;

        /*
        ============================
        STYLE
        ============================
        */

        $fontSize = $f['font_size'] ?? 20;
        $fontColor = $f['font_color'] ?? '#000';
        $fontWeight = $f['font_weight'] ?? 'normal';
        $textAlign = $f['text_align'] ?? 'center';

        /*
        ============================
        VALUE
        ============================
        */

        $value = '';

        switch($type){

        case 'nama_peserta':
        $value = $peserta->nama_peserta ?? '';
        break;

        case 'nip_peserta':
        $value = $peserta->nip_nik_peserta ?? '';
        break;

        case 'jabatan_peserta':
        $value = $peserta->jabatan_peserta ?? '';
        break;

        case 'nomorsertifikatpeserta_kegiatan':
        $value =
        $peserta->nomorsertifikatpeserta_kegiatan
        ?? ($sertifikat->nomorsertifikat_kegiatan ?? '');
        break;

        case 'totalcapaianjp_kegiatan':
        $value = $totalcapaianjp_text ?? '';
        break;
        }

        @endphp

        <div
            class="field"
            style="
                left: {{ $leftPx }}px;
                top: {{ $topPx }}px;

                font-size: {{ $f['font_size'] ?? 20 }}px;
                color: {{ $f['font_color'] ?? '#000' }};
                font-weight: {{ $f['font_weight'] ?? 'normal' }};
                text-align: {{ $f['text_align'] ?? 'center' }};
            ">
            {{ $value }}
        </div>

        @endforeach

    </div>

</body>

</html>