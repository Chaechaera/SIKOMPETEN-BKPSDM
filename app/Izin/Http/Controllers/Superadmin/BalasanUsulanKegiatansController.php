<?php

namespace App\Izin\Http\Controllers\Superadmin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Identitassurats;
use App\Izin\Models\Izin_Inputusulankegiatans;
use App\Izin\Models\Izin_Kirimbalasanusulankegiatans;
use App\Izin\Models\Izin_Kopunitkerjas;
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use App\Izin\Models\Izin_Usulankegiatans;
use App\Izin\Services\IdentitasSuratsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BalasanUsulanKegiatansController extends Controller
{
    /**
     * Download Surat Balasan Pengajuan Usulan Kegiatan
     */
    public function downloadBalasan($id)
    {
        $usulan = Izin_Usulankegiatans::with([
            'inputusulankegiatans.kirimbalasanusulankegiatans'
        ])->findOrFail($id);

        $kirimBalasan = $usulan
            ->inputusulankegiatans
            ->kirimbalasanusulankegiatans;

        if (
            !$kirimBalasan ||
            !$kirimBalasan->filepdfgenerate_path ||
            !Storage::disk('public')->exists(
                $kirimBalasan->filepdfgenerate_path
            )
        ) {
            abort(404, 'Dokumen belum digenerate.');
        }

        return Storage::disk('public')->download(
            $kirimBalasan->filepdfgenerate_path,
            'Surat Balasan Pengajuan Usulan Kegiatan ' .
                $usulan->inputusulankegiatans->nama_kegiatan .
                '.pdf'
        );
    }

    public function createCetak($id)
    {
        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans.usulankegiatans'
        ])->findOrFail($id);

        $bulan = now()->month;
        $tahun = now()->year;

        $urutan = Izin_Identitassurats::count() + 1;
        $urutan = str_pad($urutan, 3, '0', STR_PAD_LEFT);

        $cara = optional(
            $usulankegiatans->inputusulankegiatans?->usulankegiatans
        )->carapelatihan_id ?? 0;

        $nomorSurat = "{$urutan}/BKPSDM/{$this->bulanRomawi($bulan)}/{$cara}/{$tahun}";

        return view(
            'pages.balasanusulankegiatan.cetak_balasan_usulan_kegiatan',
            compact('usulankegiatans', 'nomorSurat')
        );
    }


    /**
     * Tampilkan Form Kirim Balasan Pengajuan Usulan Kegiatan Final
     */
    public function create($id)
    {
        $usulankegiatan = Izin_Usulankegiatans::with([
            'inputusulankegiatans.kirimbalasanusulankegiatans.identitassurats'
        ])->findOrFail($id);

        return view(
            'pages.balasanusulankegiatan.kirim_balasan_usulan_kegiatan',
            compact('usulankegiatan')
        );
    }

    /**
     * Simpan File Balasan Usulan Kegiatan Final Serta Proses Generate Dokumen Balasan Usulan Kegiatan
     */
    public function storeCetak(Request $request, IdentitasSuratsService $identitassuratservice, $id)
    {
        $request->validate([
            'nomor_surat'    => 'required|string|max:30|unique:izin_identitassurats,nomor_surat',
            'tanggal_surat'  => 'required|date',
            'perihal_surat'  => 'required|string',
            'sifat_surat'    => 'required|string',
            'lampiran_surat' => 'nullable|string',
        ]);

        $user = Auth::user();

        DB::transaction(function () use (
            $request,
            $identitassuratservice,
            $user,
            &$path,
            &$usulan,
            $id
        ) {

            // Simpan Identitas Surat
            $identitas = $identitassuratservice->create(
                $request->only([
                    'nomor_surat',
                    'tanggal_surat',
                    'perihal_surat',
                    'sifat_surat',
                    'lampiran_surat',
                ])
            );

            // Ambil data usulan
            $usulan = Izin_Usulankegiatans::with([
                'inputusulankegiatans',
                'detailusulankegiatans'
            ])->findOrFail($id);

            // Simpan data kirim balasan
            $kirimBalasan = Izin_Kirimbalasanusulankegiatans::updateOrCreate(
                [
                    'inputusulankegiatan_id' => $usulan->inputusulankegiatans->id,
                ],
                [
                    'identitassurat_id' => $identitas->id,
                    'nipadmin_cetakbalasanusulankegiatan' => $user->nip,
                    'tanggalcetak_balasanusulankegiatan' => now(),
                ]
            );

            Izin_Inputusulankegiatans::where(
                'id',
                $usulan->inputusulankegiatans->id
            )->update([
                'kirimbalasanusulankegiatan_id' => $kirimBalasan->id,
            ]);

            /*
        |--------------------------------------------------------------------------
        | Kalau PDF sudah pernah dibuat, langsung download file lama
        |--------------------------------------------------------------------------
        */

            if (
                $kirimBalasan &&
                $kirimBalasan->filepdfgenerate_path &&
                Storage::disk('public')->exists($kirimBalasan->filepdfgenerate_path)
            ) {
                return Storage::disk('public')->download(
                    $kirimBalasan->filepdfgenerate_path,
                    'Surat Balasan Pengajuan Usulan Kegiatan ' .
                        $usulan->inputusulankegiatans->nama_kegiatan .
                        '.pdf'
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */

            $admin = User::where(
                'nip',
                $user->nip
            )->first();

            $kop = Izin_Kopunitkerjas::where(
                'subunitkerja_id',
                $admin->subunitkerja_id
            )->latest()->first();

            $ttd = Izin_Ttdunitkerjas::where(
                'subunitkerja_id',
                $admin->subunitkerja_id
            )->latest()->first();

            $stempel = Izin_Stempelunitkerjas::where(
                'subunitkerja_id',
                $admin->subunitkerja_id
            )->latest()->first();

            $ttdPengusul = Izin_Ttdunitkerjas::where(
                'subunitkerja_id',
                $usulan->subunitkerja_id
            )->latest()->first();

            // Ambil gambar logo surakarta sebagai kop surat dari asset
            $kop_path = public_path('build/assets/kop_surat.png'); // contoh nama file
            if (!file_exists($kop_path)) {
                $kop_path = null; // fallback kalau tidak ada file kop
            }

            // Ambil identitas surat
            $identitas = optional(
                optional($kirimBalasan)->identitassurats
            );

            // Ambil parameter untuk menampilkan ttd, stempel, NIP, dan jabatan
            $showTtd = $request->boolean('show_ttd');
            $showStempel = $request->boolean('show_stempel');
            $showNIP = $request->boolean('show_nip');
            $showJabatan = $request->boolean('show_jabatan');

            $pdf = PDF::loadView(
                'pages.generatepdf.balasan_usulan_kegiatan',
                [
                    'usulankegiatans' => $usulan,
                    'kop_path' => $kop_path,
                    'identitas' => $identitas,
                    'kop' => $kop,
                    'ttd' => $ttd,
                    'stempel' => $stempel,
                    'ttdPengusul' => $ttdPengusul,
                    'showTtd' => $showTtd,
                    'showStempel' => $showStempel,
                    'showNIP' => $showNIP,
                    'showJabatan' => $showJabatan,
                ]
            )->setPaper('A4', 'portrait');

            /*
        |--------------------------------------------------------------------------
        | Simpan PDF
        |--------------------------------------------------------------------------
        */

            $folder = 'generated/balasan-usulan';

            Storage::disk('public')->makeDirectory($folder);

            $fileName = $id . '.pdf';

            $path = $folder . '/' . $fileName;

            Storage::disk('public')->put(
                $path,
                $pdf->output()
            );

            /*
        |--------------------------------------------------------------------------
        | Update path PDF
        |--------------------------------------------------------------------------
        */
            // Simpan lokasi file ke database
            if ($kirimBalasan) {
                $kirimBalasan->update([
                    'filepdfgenerate_path' => $path,
                ]);
            } else {
                $kirimBalasan = $usulan
                    ->inputusulankegiatans
                    ->cetakusulankegiatans()
                    ->create([
                        'filepdfgenerate_path' => $path,
                    ]);
            }

            $kirimBalasan->update([
                'filepdfgenerate_path' => $path,
            ]);
        });

        return Storage::disk('public')->download(
            $path,
            'Surat Balasan Pengajuan Usulan Kegiatan ' .
                $usulan->inputusulankegiatans->nama_kegiatan .
                '.pdf'
        );
    }

    public function storeFinal(Request $request, $id)
    {
        $request->validate([
            'filekirim_balasanusulankegiatan' =>
            'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $user = Auth::user();

        DB::transaction(function () use ($request, $user, $id) {

            $usulan = Izin_Usulankegiatans::with(
                'inputusulankegiatans.kirimbalasanusulankegiatans'
            )->findOrFail($id);

            $file = $request->file('filekirim_balasanusulankegiatan')
                ->storeAs(
                    'izin/filekirim_balasanusulankegiatan',
                    time() . '_' . $request->file('filekirim_balasanusulankegiatan')
                        ->getClientOriginalName(),
                    'public'
                );

            $usulan->inputusulankegiatans
                ->kirimbalasanusulankegiatans
                ->update([
                    'filekirim_balasanusulankegiatan' => $file,
                    'tanggalkirim_balasanusulankegiatan' => now(),
                    'nipadmin_kirimbalasanusulankegiatan' => $user->nip,
                ]);
        });

        return redirect()
            ->route('superadmin.usulankegiatan.pending')
            ->with('success', 'Balasan usulan kegiatan berhasil dikirim.');
    }

    public function preview(Request $request, $id)
    {
        $request->validate([
            'nomor_surat'   => 'required|string|max:30',
            'tanggal_surat' => 'required|date',
            'perihal_surat' => 'required|string',
            'sifat_surat'   => 'required|string',
            'lampiran_surat' => 'nullable|string',
        ]);

        // Ambil data usulan
        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'inputusulankegiatans.kirimusulankegiatans.identitassurats',
            'detailusulankegiatans'
        ])->findOrFail($id);

        // Data identitas surat dari form (belum disimpan)
        $identitassurat = (object) [
            'nomor_surat'   => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'perihal_surat' => $request->perihal_surat,
            'sifat_surat'   => $request->sifat_surat,
            'lampiran_surat' => $request->lampiran_surat,
        ];

        // Ambil data user login
        $user = Auth::user();

        $kop = Izin_Kopunitkerjas::where(
            'subunitkerja_id',
            $user->subunitkerja_id
        )->latest()->first();

        $ttd = Izin_Ttdunitkerjas::where(
            'subunitkerja_id',
            $user->subunitkerja_id
        )->latest()->first();

        $stempel = Izin_Stempelunitkerjas::where(
            'subunitkerja_id',
            $user->subunitkerja_id
        )->latest()->first();

        $ttdPengusul = Izin_Ttdunitkerjas::where(
            'subunitkerja_id',
            $usulankegiatans->subunitkerja_id
        )->latest()->first();

        $kop_path = public_path('build/assets/kop_surat.png');

        if (!file_exists($kop_path)) {
            $kop_path = null;
        }

        // Ambil parameter untuk menampilkan ttd, stempel, NIP, dan jabatan
        $showTtd = $request->boolean('show_ttd');
        $showStempel = $request->boolean('show_stempel');
        $showNIP = $request->boolean('show_nip');
        $showJabatan = $request->boolean('show_jabatan');

        $pdf = PDF::loadView(
            'pages.generatepdf.balasan_usulan_kegiatan',
            [
                'usulankegiatans' => $usulankegiatans,
                'identitassurat'  => $identitassurat,
                'kop_path'        => $kop_path,
                'kop'             => $kop,
                'ttd'             => $ttd,
                'stempel'         => $stempel,
                'ttdPengusul'     => $ttdPengusul,
                'isPreview'       => true,
                'showTtd' => $showTtd,
                'showStempel' => $showStempel,
                'showNIP' => $showNIP,
                'showJabatan' => $showJabatan,
            ]
        )->setPaper('A4', 'portrait');

        return $pdf->stream('Preview Surat Balasan.pdf');
    }

    private function bulanRomawi($bulan)
    {
        $romawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        return $romawi[(int)$bulan] ?? '-';
    }
}
