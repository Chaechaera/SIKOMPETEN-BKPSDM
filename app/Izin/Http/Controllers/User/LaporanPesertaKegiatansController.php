<?php

namespace App\Izin\Http\Controllers\User;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Laporanpesertakegiatans;
use App\Izin\Models\Izin_Sertifikats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanPesertaKegiatansController extends Controller
{
    public function approve($id)
    {
        $laporan = Izin_LaporanPesertakegiatans::findOrFail($id);
        $laporan->update([
            'statuslaporan_pesertakegiatan' => 'approved'
        ]);

        return back()->with('success', 'Laporan disetujui');
    }

    public function create($sertifikat_id)
    {
        $user = Auth::user();

        $sertifikat = Izin_Sertifikats::with('pesertakegiatans')->findOrFail($sertifikat_id);

        $peserta = $sertifikat->pesertakegiatans()
            ->where('nip_nik_peserta', $user->nip)
            ->first();

        if (! $peserta) {
            return redirect()->back()->with('error', 'Anda bukan peserta kegiatan ini.');
        }

        $laporanpesertakegiatans = Izin_LaporanPesertakegiatans::where('pesertakegiatan_id', $peserta->id)
            ->where('sertifikat_id', $sertifikat_id)
            ->first();

        return view('pages.upload_laporanpeserta_kegiatan', compact('sertifikat', 'peserta', 'laporanpesertakegiatans'));
    }

    public function store(Request $request, $sertifikat_id)
    {
        $user = Auth::user();
        $sertifikat = Izin_Sertifikats::findOrFail($sertifikat_id);

        $peserta = $sertifikat->pesertakegiatans()
            ->where('nip_nik_peserta', $user->nip)
            ->first();

        if (!$peserta) {
            return redirect()->back()->with('error', 'Anda bukan peserta kegiatan ini.');
        }

        $laporanpesertakegiatans = $request->only([
            'uraianpeserta_kegiatan',
            'tujuanpeserta_kegiatan',
            'rangkumanpeserta_kegiatan',
            'kesimpulanpeserta_kegiatan',
        ]);

        // 🔥 Ambil data lama (kalau ada)
        $existing = Izin_LaporanPesertakegiatans::where('pesertakegiatan_id', $peserta->id)
            ->where('sertifikat_id', $sertifikat_id)
            ->first();

        // 🔥 Ambil gambar lama
        $path_dokumentasipeserta = $existing->dokumentasipeserta_kegiatan ?? [];

        // 🔥 Hapus gambar yang dicentang
        if ($request->has('hapus_gambar')) {
            foreach ($request->hapus_gambar as $index) {
                unset($path_dokumentasipeserta[$index]);
            }
            $path_dokumentasipeserta = array_values($path_dokumentasipeserta);
        }

        // 🔥 Tambah gambar baru
        if ($request->hasFile('dokumentasipeserta_kegiatan')) {
            foreach ($request->file('dokumentasipeserta_kegiatan') as $file) {
                $path_dokumentasipeserta[] = $file->store('izin/dokumentasipeserta_kegiatan', 'public');
            }
        }

        // 🔥 Tentukan status
        $status = $existing ? 'revisi' : 'pending';

        Izin_LaporanPesertakegiatans::updateOrCreate(
            [
                'pesertakegiatan_id' => $peserta->id,
                'sertifikat_id'      => $sertifikat_id,
            ],
            [
                'uraianpeserta_kegiatan' => $request->uraianpeserta_kegiatan,
                'tujuanpeserta_kegiatan' => $request->tujuanpeserta_kegiatan,
                'rangkumanpeserta_kegiatan' => $request->rangkumanpeserta_kegiatan,
                'kesimpulanpeserta_kegiatan' => $request->kesimpulanpeserta_kegiatan,
                'laporanpesertakegiatans' => $laporanpesertakegiatans,
                'dokumentasipeserta_kegiatan' => $path_dokumentasipeserta,
                'statuslaporan_pesertakegiatan' => $status,
                'uploaded_at' => now(),
            ]
        );

        return redirect()->route('user.sertifikat')
            ->with('success', 'Laporan peserta berhasil diunggah!');
    }
}
