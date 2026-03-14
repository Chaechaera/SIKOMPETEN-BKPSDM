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
        $request->validate([
            'filelaporan_pesertakegiatan' => 'required|mimes:pdf,doc,docx|max:5120',
        ]);

        $user = Auth::user();
        $sertifikat = Izin_Sertifikats::findOrFail($sertifikat_id);

        $peserta = $sertifikat->pesertakegiatans()
    ->where('nip_nik_peserta', $user->nip)
    ->first();

        if (!$peserta) {
            return redirect()->back()->with('error', 'Anda bukan peserta kegiatan ini.');
        }

        // Upload file kirim pengajuan usulan kegiatan final
            if ($request->hasFile('filelaporan_pesertakegiatan')) {
                $laporanpesertakegiatans = $request->file('filelaporan_pesertakegiatan')
                    ->storeAs(
                        'izin/filelaporan_pesertakegiatan',
                        time() . '_' . $request->file('filelaporan_pesertakegiatan')->getClientOriginalName(),
                        'public'
                    );
            }

        Izin_LaporanPesertakegiatans::updateOrCreate(
            [
                'pesertakegiatan_id' => $peserta->id,
                'sertifikat_id'      => $sertifikat_id,
            ],
            [
                'filelaporan_pesertakegiatan' => $laporanpesertakegiatans,
                'statuslaporan_pesertakegiatan' => 'pending',
                'uploaded_at' => now(),
            ]
        );

        return redirect()->route('user.sertifikat')
    ->with('success', 'Laporan peserta berhasil diunggah!');
    }
}
