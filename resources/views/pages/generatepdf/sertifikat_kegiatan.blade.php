<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sertifikat {{ $peserta->nama_peserta ?? '' }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", serif;
            position: relative;
        }

        .bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .field {
            position: absolute;
            white-space: nowrap;
            z-index: 5;
            line-height: 1;
        }
    </style>
</head>

<body>

    {{-- Gambar background sertifikat --}}
    <!--<img src="{{ $backgroundPath }}" class="bg">-->
    <img src="data:{{ $backgroundMime }};base64,{{ $backgroundBase64 }}" class="bg">

    @php
    $fields = $fieldstemplatesertifikat_kegiatan ?? [];
    @endphp

    @if(is_array($fields))
    @foreach($fields as $f)
    @php
    /* =========================
   BASE DATA
========================= */
$x = $f['x_percent'] ?? 0;
$y = $f['y_percent'] ?? 0;
$type = $f['type'] ?? '';

$fs = $f['font_size'] ?? 42;
$fc = $f['font_color'] ?? '#000';
$fw = $f['font_weight'] ?? 'normal';
$ta = $f['text_align'] ?? 'center';

/* =========================
   TEXT REAL (Untuk Auto Offset)
========================= */

$text = '';

switch($type){
    case 'nama_peserta':
        $text = $peserta->nama_peserta ?? '';
    break;

    case 'nip_peserta':
        $text = $peserta->nip_nik_peserta ?? '';
    break;

    case 'jabatan_peserta':
        $text = $peserta->jabatan_peserta ?? '';
    break;

    case 'nomorsertifikatpeserta_kegiatan':
        $text = $peserta->nomorsertifikatpeserta_kegiatan ?? ($sertifikat->nomorsertifikat_kegiatan ?? '');
    break;

    case 'totalcapaianjp_kegiatan':
        $text = isset($sertifikat->balasanlaporankegiatans->totalcapaianjp_kegiatan)
            ? $sertifikat->balasanlaporankegiatans->totalcapaianjp_kegiatan
            : '';
    break;
}

$textLength = strlen($text);

/* =========================
   AUTO OFFSET ENGINE
========================= */

/*
Ide:
Font besar → geser dikit
Text panjang → geser dikit
*/

$autoOffsetX = ($textLength * $fs) / 900;
$autoOffsetY = ($fs / 140);

/* =========================
   MANUAL OFFSET (Fine Tune)
========================= */

$offsetMap = [
    'nama_peserta' => ['x'=>10.8,'y'=>-0.70],
    'nip_peserta' => ['x'=>3.32,'y'=>-1.7],
    'nomorsertifikatpeserta_kegiatan' => ['x'=>-0.5,'y'=>0.4],
    'totalcapaianjp_kegiatan' => ['x'=>-0.8,'y'=>0.35],
];

$manualX = $offsetMap[$type]['x'] ?? 0;
$manualY = $offsetMap[$type]['y'] ?? 0;

/* =========================
   FINAL POSITION
========================= */

$left = ($x + $autoOffsetX + $manualX) . '%';
$top  = ($y - $autoOffsetY + $manualY) . '%';

@endphp


<div class="field"
style="
left:{{ $left }};
top:{{ $top }};
font-size:{{ $fs }}px;
color:{{ $fc }};
font-weight:{{ $fw }};
text-align:{{ $ta }};
">

@switch($type)
@case('nama_peserta')
{{ $peserta->nama_peserta ?? '-' }}
@break

@case('nip_peserta')
{{ $peserta->nip_nik_peserta ?? '' }}
@break

@case('jabatan_peserta')
{{ $peserta->jabatan_peserta ?? '' }}
@break

@case('nomorsertifikatpeserta_kegiatan')
{{ $peserta->nomorsertifikatpeserta_kegiatan ?? ($sertifikat->nomorsertifikat_kegiatan ?? '') }}
@break

@case('totalcapaianjp_kegiatan')
{{ $totalcapaianjp_text ?? '' }}
@break

{{--@case('totalcapaianjp_kegiatan')
{{ isset($sertifikat->balasanlaporankegiatans->totalcapaianjp_kegiatan) ? $sertifikat->balasanlaporankegiatans->totalcapaianjp_kegiatan : '' }}
@break--}}
@endswitch

</div>

@endforeach
@endif

</body>

</html>