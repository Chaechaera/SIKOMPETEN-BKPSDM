<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
        @page { margin: 0; }

        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .bg-img {
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
            z-index: 3;
        }
    </style>
</head>

<body>

    {{-- BACKGROUND GAMBAR TEMPLATE SERTIFIKAT --}}
    <img src="data:image/png;base64,{{ $backgroundBase64 }}" class="bg-img">

    @php
        $fields = $fieldstemplatesertifikat_kegiatan ?? [];
    @endphp

    @if(is_array($fields) && count($fields))
        @foreach($fields as $f)
            @php
                $x  = (int)($f['x'] ?? 0);
                $y  = (int)($f['y'] ?? 0);
                $fs = (int)($f['font_size'] ?? 14);
                $fc = $f['font_color'] ?? '#000';
                $type = $f['type'] ?? '';
            @endphp

            <div class="field"
                 style="
                    left: {{ $x }}px;
                    top:  {{ $y }}px;
                    font-size: {{ $fs }}px;
                    color: {{ $fc }};
                 ">

                @switch($type)
                    @case('nama_peserta')
                        {{ $peserta->nama_peserta ?? '-' }}
                        @break

                    @case('nip_peserta')
                        {{ $peserta->nip_peserta ?? '' }}
                        @break

                    @case('jabatan_peserta')
                        {{ $peserta->jabatan_peserta ?? '' }}
                        @break

                    @case('nomorsertifikatpeserta_kegiatan')
                        {{ $peserta->nomorsertifikatpeserta_kegiatan ?? ($sertifikat->nomorsertifikat_kegiatan ?? '') }}
                        @break

                    @case('totalcapaianjp_kegiatan')
                        {{ isset($sertifikat->totalcapaianjp_kegiatan) ? $sertifikat->totalcapaianjp_kegiatan.' JP' : '' }}
                        @break

                    @default
                        {{-- kosong --}}
                @endswitch
            </div>

        @endforeach
    @endif

</body>
</html>
