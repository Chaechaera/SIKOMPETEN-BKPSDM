<?php

namespace App\Izin\Http\Controllers\Admin;

use App\Izin\Http\Controllers\Controller;
use App\Izin\Models\Izin_Kopunitkerjas;
use App\Izin\Models\Izin_Stempelunitkerjas;
use App\Izin\Models\Izin_Ttdunitkerjas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class KopUnitKerjasController extends Controller
{
    /**
     * Tampilkan Form Upload Data Tambahan OPD
     */
    public function create()
    {
        // Ambil user yang login saat ini
        $user = Auth::user();

        // Redirect ke halaman upload data tambahan OPD
        return view('pages.upload_kop_ttd_surat', [
            'unitkerjas' => $user->subunitkerjas?->unitkerjas?->unitkerja,
            'subunitkerjas' => $user->subunitkerjas->singkatan ?? null,
            'unitkerja_id' => $user->subunitkerjas?->unitkerja_id,
            'subunitkerja_id' => $user->subunitkerja_id,
            'nama_opd' => $user->subunitkerjas->sub_unitkerja ?? null,
            'kopunitkerjas' => null,
            'ttdunitkerjas' => null,
            'stempelunitkerjas' => null
        ]);
    }

    /**
     * Simpan Data pada Form Upload Data Tambahan OPD
     */
    public function store(Request $request)
    {
        // Ambil user yang login saat ini
        $user = Auth::user();

        // Validasi request
        $request->validate([
            'gambarkop_opd' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'gambarttd_opd' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'gambarstempel_opd' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Buat driver image manager baru
        $manager = new ImageManager(new Driver());

        // Upload file gambar kop OPD
        $gambarkopopd_path = null;
        if ($request->hasFile('gambarkop_opd')) {
            $gambarkopopd_path = $request->file('gambarkop_opd')
                ->storeAs(
                    'izin/gambarkop_opd',
                    time() . '_' . $request->file('gambarkop_opd')->getClientOriginalName(),
                    'public'
                );
        }

        // Buat driver image manager baru
        $manager = new ImageManager(new Driver());

        // Upload file gambar ttd OPD
        $gambarttdopd_path = null;
        if ($request->hasFile('gambarttd_opd')) {
            $file = $request->file('gambarttd_opd');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = storage_path('app/public/izin/gambarttd_opd/' . $filename);
            if (!file_exists(dirname($path))) mkdir(dirname($path), 0755, true);

            // Simpan dulu gambar dalam versi normal
            $manager->read($file->getRealPath())->toPng()->save($path);

            // Hapus background putih pada gambar
            $this->removeWhiteBackground($path, $path);

            // Simpan path final gambar ttd
            $gambarttdopd_path = 'izin/gambarttd_opd/' . $filename;
        }

        // Upload file gambar stempel OPD
        $gambarstempelopd_path = null;
        if ($request->hasFile('gambarstempel_opd')) {
            $file = $request->file('gambarstempel_opd');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = storage_path('app/public/izin/gambarstempel_opd/' . $filename);
            if (!file_exists(dirname($path))) mkdir(dirname($path), 0755, true);

            // Simpan dulu gambar dalam versi normal
            $manager->read($file->getRealPath())->toPng()->save($path);

            // Hapus background putih pada gambar
            $this->removeWhiteBackground($path, $path);

            // Simpan path final gambar stempel
            $gambarstempelopd_path = 'izin/gambarstempel_opd/' . $filename;
        }

        // Simpan data kopunitkerja
        Izin_Kopunitkerjas::create([
            'unitkerja_id' => $user->subunitkerjas->unitkerja_id,
            'subunitkerja_id' => $user->subunitkerja_id,
            'nama_opd' => $request->nama_opd,
            'lokasi_opd' => $request->lokasi_opd,
            'telepon_opd' => $request->telepon_opd,
            'faxmile_opd' => $request->faxmile_opd,
            'website_opd' => $request->website_opd,
            'email_opd' => $request->email_opd,
            'kodepos_opd' => $request->kodepos_opd,
            'gambarkop_opd' => $gambarkopopd_path
        ]);

        // Simpan data ttdunitkerja
        Izin_Ttdunitkerjas::create([
            'unitkerja_id' => $user->subunitkerjas->unitkerja_id,
            'subunitkerja_id' => $user->subunitkerja_id,
            'gambarttd_opd' => $gambarttdopd_path
        ]);

        // Simpan data stempelunitkerja
        Izin_Stempelunitkerjas::create([
            'unitkerja_id' => $user->subunitkerjas->unitkerja_id,
            'subunitkerja_id' => $user->subunitkerja_id,
            'gambarstempel_opd' => $gambarstempelopd_path
        ]);

        // Redirect ke halaman dashboard admin
        return redirect()->route('admin.dashboard')
            ->with('success', 'Data KOP OPD berhasil disimpan');
    }

    /**
     * Tampilkan Form Edit Data Tambahan OPD
     */
    public function edit($id)
    {
        // Tampilkan data berdasarkan id kopunitkerja 
        $data = Izin_Kopunitkerjas::findOrFail($id);

        // Redirect ke halaman edit data tambahan OPD
        return view('izin.kopunitkerjas.edit', compact('data'));
    }

    /**
     * Simpan dan Update Data Tambahan OPD yang Diedit
     */
    public function update(Request $request, $id)
    {
        // Tampilkan data berdasarkan id kopunitkerja
        $data = Izin_Kopunitkerjas::findOrFail($id);

        // Validasi request
        $request->validate([
            'unitkerja_id' => 'required',
            'subunitkerja_id' => 'required',
            'nama_opd' => 'required',
            'lokasi_opd' => 'required',
            'telepon_opd' => 'nullable',
            'faxmile_opd' => 'nullable',
            'website_opd' => 'nullable',
            'email_opd' => 'nullable|email',
            'kodepos_opd' => 'nullable',
            'gambarkop_opd' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        // Update data request
        $updateData = [
            'nama_opd' => $request->nama_opd,
            'lokasi_opd' => $request->lokasi_opd,
            'telepon_opd' => $request->telepon_opd,
            'faxmile_opd' => $request->faxmile_opd,
            'website_opd' => $request->website_opd,
            'email_opd' => $request->email_opd,
            'kodepos_opd' => $request->kodepos_opd,
        ];

        // Update data gambar kop OPD
        if ($request->hasFile('gambarkop_opd')) {
            if ($data->gambarkop_opd) {
                Storage::disk('public')->delete($data->gambarkop_opd);
            }
            $updateData['gambarkop_opd'] = $request->file('gambarkop_opd')
                ->storeAs(
                    'izin/gambarkop_opd',
                    time() . '_' . $request->file('gambarkop_opd')->getClientOriginalName(),
                    'public'
                );
        }

        // Update seluruh data yang diedit
        $data->update($updateData);

        // Redirect ke halaman dashboard admin
        return redirect()->route('admin.dashboard')
            ->with('success', 'Data KOP OPD berhasil diupdate');
    }

    /**
     * Helper untuk Menghapus Background Pada Gambar
     */
    private function removeWhiteBackground($inputPath, $outputPath)
    {
        // Ambil data path gambar
        $image = imagecreatefromstring(file_get_contents($inputPath));
        imagealphablending($image, false);
        imagesavealpha($image, true);

        // Ambil ukuran gambar
        $width = imagesx($image);
        $height = imagesy($image);

        // Proses Pengecekan
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgb = imagecolorat($image, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                // threshold warna putih
                if ($r > 240 && $g > 240 && $b > 240) {
                    $alpha = imagecolorallocatealpha($image, 255, 255, 255, 127);
                    imagesetpixel($image, $x, $y, $alpha);
                }
            }
        }

        // Simpan data dalam file PNG
        imagepng($image, $outputPath);
        imagedestroy($image);
    }
}
