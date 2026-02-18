<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Detailusulankegiatans;
use App\Izin\Models\Izin_Inputusulankegiatans;
use App\Izin\Models\Izin_Kopunitkerjas;
use App\Izin\Models\Izin_RefCarapelatihans;
use App\Izin\Models\Izin_RefMetodepelatihans;
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use App\Izin\Models\Izin_Usulankegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\PDF;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UsulanKegiatansController extends Controller
{
    /**
     * Tampilkan Daftar Usulan Kegiatan yang Telah Diajukan
     */
    public function index()
    {
        // Eager load relasi dari model
        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'inputusulankegiatans.pelaksanaankegiatans',
            'cetakusulankegiatans',
            'verifikasiusulankegiatanterakhir',
            'inputlaporankegiatans',
            'inputlaporankegiatans.laporankegiatans'
        ])->orderBy('created_at', 'desc')->get();

        // Redirect ke halaman daftar pengajuan usulan kegiatan
        return view('pages.usulankegiatan.list_usulan_kegiatan', compact('usulankegiatans'));
    }

    /**
     * Tampilkan Form Ajukan Nama Usulan Kegiatan Pengembangan Kompetensi ASN
     */
    public function create()
    {
        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Redirect ke halaman ajukan pengajuan usulan kegiatan
        return view('pages.usulankegiatan.ajukan_usulan_kegiatan', [
            'unitkerjas' => $user->subunitkerjas?->unitkerjas?->unitkerja,
            'subunitkerjas' => $user->subunitkerjas->sub_unitkerja ?? null,
            'dibuat_oleh' => $user->nama,
            'carapelatihans' => Izin_RefCarapelatihans::select('id', 'cara_pelatihan')->get(),
            'metodepelatihans' => Izin_RefMetodepelatihans::select('id', 'metode_pelatihan')->get(),
        ]);
    }

    /**
     * Simpan Data Awal Pada Form Ajukan Nama Usulan Kegiatan Pengembangan Kompetensi ASN
     */
    public function storeAwal(Request $request)
    {
        // Validasi request
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255'
        ]);

        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Simpan data awal usulankegiatan
        $usulan = Izin_Usulankegiatans::create([
            'nama_kegiatan' => $request->nama_kegiatan,
            'dibuat_oleh' => $user->id,
            'subunitkerja_id' => $user->subunitkerja_id,
            'unitkerja_id' => $user->subunitkerjas->unitkerja_id,
            'statususulan_kegiatan' => 'draft'
        ]);

        // Simpan data inputusulankegiatan
        Izin_Inputusulankegiatans::create([
            'usulankegiatan_id' => $usulan->id,
            'nama_kegiatan' => $request->nama_kegiatan,
            'pjunitkerja_id' => $user->id
        ]);

        // Redirect ke halaman edit usulan kegiatan
        return redirect()->route('admin.usulankegiatan.edit', $usulan->id)->with('success', 'Silakan lengkapi data usulan kegiatan.');
    }

    /**
     * Tampilkan Form Edit Ajukan Usulan Kegiatan Pengembangan Kompetensi ASN
     */
    public function edit($id)
    {
        // Eager load relasi dari model
        $usulan = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'inputusulankegiatans.kopunitkerjas',
            'detailusulankegiatans'
        ])->findOrFail($id);

        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Ambil kopunitkerja terakhir user yang sedang login saat ini
        $kopunitkerja_user = Izin_Kopunitkerjas::where('subunitkerja_id', $user->subunitkerja_id)->latest()->first();
        $kopunitkerja_id = $usulan->inputusulankegiatans?->kopunitkerja_id ?? $kopunitkerja_user?->id ?? null;
        
        // Verifikasi bahwa status usulankegiatan tidak sama dengan draft
        if ($usulan->statususulan_kegiatan !== 'draft') {
            abort(403, 'Usulan sudah tidak dapat diubah.');
        }

        // Pastikan detailusulankegiatan selalu ada
        $detail = $usulan->detailusulankegiatans ?? new Izin_Detailusulankegiatans();

        // Redirect ke halaman lengkapi pengajuan usulan kegiatan
        return view('pages.usulankegiatan.lengkapi_usulan_kegiatan', [
            'usulan' => $usulan,
            'detail' => $detail,
            'subunitkerjas' => $usulan->subunitkerjas->sub_unitkerja,
            'unitkerjas' => $usulan->subunitkerjas->unitkerjas->unitkerja,
            'nama_kegiatan' => $usulan->inputusulankegiatans->nama_kegiatan,
            'carapelatihans' => Izin_RefCarapelatihans::all(),
            'metodepelatihans' => Izin_RefMetodepelatihans::all(),
            'kopunitkerja_id' => $kopunitkerja_id,
        ]);
    }

    /**
     * Update Data Pada Form Edit Ajukan Usulan Kegiatan Pengembangan Kompetensi ASN
     */
    public function update(Request $request, $id)
    {
        // Temukan usulankegiatan berdasarkan id
        $usulankegiatans = Izin_Usulankegiatans::findOrFail($id);

        // Verifikasi bahwa status usulankegiatan tidak sama dengan draft
        if ($usulankegiatans->statususulan_kegiatan !== 'draft') {
            abort(403);
        }

        // Update data usulankegiatan
        $usulankegiatans->update([
            'lokasi_kegiatan' => $request->lokasi_kegiatan,
            'carapelatihan_id' => $request->carapelatihan_id,
            'tanggalmulai_kegiatan' => $request->tanggalmulai_kegiatan,
            'tanggalselesai_kegiatan' => $request->tanggalselesai_kegiatan,
            'waktumulai_kegiatan' => $request->waktumulai_kegiatan,
            'waktuselesai_kegiatan' => $request->waktuselesai_kegiatan,
        ]);

        // Merge request berdasarkan id usulankegiatan
        $request->merge([
            'usulankegiatan_id' => $usulankegiatans->id
        ]);

        // Lanjutkan proses store ke controller detailusulankegiatan
        return app(DetailUsulanKegiatansController::class)->store($request);
    }

    /**
     * Download Surat dan KAK Pengajuan Usulan Kegiatan Pengembangan Kompetensi ASN
     */
    public function download($id)
    {
        // Ambil user yang sedang login saat ini
        $user = Auth::user();

        // Eager load relasi dari model dan temukan usulankegiatan berdasarkan id
        $usulankegiatans = Izin_Usulankegiatans::with([
            'inputusulankegiatans',
            'inputusulankegiatans.kopunitkerjas',
            'detailusulankegiatans'
        ])->findOrFail($id);

        // Ambil kop,ttd, dan stempel dari inputusulankegiatan pertama (1 unitkerja dianggap telah mengupload sekali)
        $kop = $usulankegiatans->inputusulankegiatans->first()?->kopunitkerjas ?? null;
        $ttd = Izin_Ttdunitkerjas::where('unitkerja_id', $user->subunitkerjas->unitkerja_id)->first();
        $stempel = Izin_Stempelunitkerjas::where('unitkerja_id', $user->subunitkerjas->unitkerja_id)->first();

        // Ambil gambar logo surakarta sebagai kop surat dari asset
        $kop_path = public_path('build/assets/kop_surat.png'); // contoh nama file
        if (!file_exists($kop_path)) {
            $kop_path = null; // fallback kalau tidak ada file kop
        }

        // Baca file excel jadwal kegiatan kalau ada
        $jadwalpelaksanaan_kegiatan = [];
        if ($usulankegiatans->detailusulankegiatans?->jadwalpelaksanaan_kegiatan) {
            $path = storage_path('app/public/' . $usulankegiatans->detailusulankegiatans->jadwalpelaksanaan_kegiatan);
            if (file_exists($path)) {
                try {
                    $spreadsheet = IOFactory::load($path);
                    $sheet = $spreadsheet->getActiveSheet();
                    // Ambil semua baris, termasuk yang kosong
                    $jadwalpelaksanaan_kegiatan = [];
                    foreach ($sheet->toArray(null, true, true, true) as $row) {
                        $values = array_values($row);
                        $jadwalpelaksanaan_kegiatan[] = $values;
                    }
                } catch (\Exception $e) {
                    $jadwalpelaksanaan_kegiatan = [];
                }
            }
        }

        // Load view PDF
        $pdf = PDF::loadView('pages.generatepdf.surat_usulan_kegiatan', [
            'usulankegiatans' => $usulankegiatans,
            'jadwalpelaksanaan_kegiatan' => $jadwalpelaksanaan_kegiatan,
            'kop_path' => $kop_path,
            'kop' => $kop,
            'ttd' => $ttd,
            'stempel' => $stempel,
            'user'   => $user,
        ])->setPaper('A4', 'portrait');

        // Redirect dan simpan file PDF
        return $pdf->stream('KAK dan Surat Pengajuan Usulan Kegiatan ' . $usulankegiatans->inputusulankegiatans->nama_kegiatan . '.pdf');
    }
}
