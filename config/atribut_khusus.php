<?php

return [
    5 => [
        'cara_pelatihan' => 'Bimbingan Teknis',
        'fields' => [
            'Linkkonfirmasipeserta_bimtek' => [
                'label' => 'Link Konfirmasi Peserta',
                'type' => 'url',
                'rules' => 'nullable|url',
            ],
            'Linksurveykepuasan_bimtek' => [
                'label' => 'Link Survey Kepuasan',
                'type' => 'url',
                'rules' => 'nullable|url',
            ],
        ],
    ],

    18 => [
        'cara_pelatihan' => 'Workshop',
        'fields' => [
            'Temakegiatan_workshop' => [
                'label' => 'Tema Kegiatan',
                'type' => 'text',
                'rules' => 'nullable|string',
            ],
            'Detailpembiayaan_workshop' => [
                'label' => 'Detail Pembiayaan',
                'type' => 'textarea',
                'rules' => 'nullable|string',
            ],
        ],
    ],

    19 => [
        'cara_pelatihan' => 'Seminar',
        'fields' => [
            'Targetkegiatan_seminar' => [
                'label' => 'Target Kegiatan',
                'type' => 'textarea',
                'rules' => 'nullable|string',
            ],
            'Detailpembiayaan_seminar' => [
                'label' => 'Detail Pembiayaan',
                'type' => 'textarea',
                'rules' => 'nullable|string',
            ],
            'Timelinekegiatan_seminar' => [
                'label' => 'Timeline Kegiatan',
                'type' => 'textarea',
                'rules' => 'nullable|string',
            ],
            'Temakegiatan_seminar' => [
                'label' => 'Tema Kegiatan',
                'type' => 'text',
                'rules' => 'nullable|string',
            ],
        ],
    ],

    20 => [
        'cara_pelatihan' => 'Sosialisasi',
        'fields' => [
            'Bentukkegiatan_sosialisasi' => [
                'label' => 'Bentuk Kegiatan',
                'type' => 'text',
                'rules' => 'nullable|string',
            ],
            'Judulsubkegiatan_sosialisasi' => [
                'label' => 'Judul Sub Kegiatan',
                'type' => 'text',
                'rules' => 'nullable|string',
            ],
            'Uraiansubkegiatan_sosialisasi' => [
                'label' => 'Uraian Sub Kegiatan',
                'type' => 'textarea',
                'rules' => 'nullable|string',
            ],
        ],
    ],
];
