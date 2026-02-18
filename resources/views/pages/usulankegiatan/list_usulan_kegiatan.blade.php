<x-app-layout>
    @php $unfinished = $usulankegiatans->where('statususulan_kegiatan', '!=', 'finish')->count() > 0; @endphp

    <div class="p-6 space-y-6">

        <!-- Judul Halaman -->
        <h1 class="text-2xl font-bold mb-4">Daftar Pengajuan Usulan Kegiatan Pengembangan Kompetensi ASN</h1>

        <!-- Bagian Progress Stepper -->
        <div class="bg-gray-50 p-4 rounded-xl shadow-sm border">
            <h2 class="text-lg font-semibold mb-3">Progress Pengajuan</h2>
            {{-- Komponen Stepper (bisa dijadikan partial blade include) --}}
            @include('components.proggres-stepper', ['processStatus' => $usulankegiatans[0]->process_status ?? null])
        </div>

        <!-- Tombol Aksi -->
        <div class="flex gap-3 mt-4">
            <a href="{{ route('admin.usulankegiatan.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Buat Usulan Baru
            </a>
        </div>

        <!-- Tabel Daftar Usulan -->
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-300 rounded-lg mt-4 text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-2 text-left w-10">No</th>
                        <!--<th class="p-2 text-left">Nomor Surat</th>
                        <th class="p-2 text-left">Perihal Surat</th>-->
                        <th class="p-2 text-left">Nama Kegiatan</th>
                        <th class="p-2 text-left">Tanggal Pelaksanaan Kegiatan</th>
                        <th class="p-2 text-left">Status Usulan Kegiatan</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($usulankegiatans as $u)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <!-- Nomor Otomatis -->
                        <td class="p-2 text-center">{{ $loop->iteration }}</td>

                        <!-- Nomor Surat 
                        <td class="p-2">{{ $u->identitassurats->nomor_surat ?? '-' }}</td>

                        Perihal Surat
                        <td class="p-2">{{ $u->identitassurats->perihal_surat ?? '-' }}</td>-->

                        <!-- Nama Kegiatan -->
                        <td class="p-2 font-medium">{{ $u->inputusulankegiatans->nama_kegiatan }}</td>

                        <!-- Tanggal Pelaksanaan Kegiatan -->
                        <td class="p-2">
                            {{
        $u->tanggalmulai_kegiatan && $u->tanggalselesai_kegiatan
        ? \Carbon\Carbon::parse($u->tanggalmulai_kegiatan)->format('d-m-Y') . ' s/d ' .
          \Carbon\Carbon::parse($u->tanggalselesai_kegiatan)->format('d-m-Y')
        : '-'
    }}
                        </td>

                        <!-- Status Usulan Kegiatan -->
                        <td class="p-2 capitalize font-semibold">
                            <span class="{{ $u->status_ui_class }}">
                                {{ str_replace('_', ' ', $u->status_ui) }}
                            </span>
                        </td>

                        <!-- Tombol Aksi -->
                        <td class="p-2 space-y-2 text-sm">

                            {{-- ===================== AKSI DOKUMEN ===================== --}}
                            <div class="border rounded p-2 bg-gray-50">
                                <p class="text-xs font-semibold text-gray-500 mb-1">📄 Dokumen</p>

                                <div class="flex flex-col gap-1">
                                    <a href="{{ route('admin.usulankegiatan.download', $u->id) }}"
                                        target="_blank"
                                        class="text-green-600 hover:underline">
                                        Lihat Surat Usulan
                                    </a>

                                    <a href="{{ route('admin.usulankegiatan.downloadBalasan', $u->id) }}"
                                        target="_blank"
                                        class="text-green-600 hover:underline">
                                        Lihat Surat Balasan Usulan
                                    </a>

                                    <a href="{{ route('admin.pelaksanaankegiatan.show', $u->id) }}"
                                        target="_blank"
                                        class="text-green-600 hover:underline">
                                        Lihat Pelaksanaan Kegiatan
                                    </a>

                                    <a href="{{ route('admin.laporankegiatan.download', $u->id) }}"
                                        target="_blank"
                                        class="text-green-600 hover:underline">
                                        Lihat Laporan
                                    </a>

                                    <a href="{{ route('admin.balasanlaporankegiatan.download', $u->id) }}"
                                        target="_blank"
                                        class="text-green-600 hover:underline">
                                        Lihat Surat Balasan
                                    </a>

                                    <a href="{{ route('admin.sertifikat.download', $u->id) }}"
                                        target="_blank"
                                        class="text-green-600 hover:underline">
                                        Download Sertifikat
                                    </a>
                                </div>
                            </div>

                            {{-- ===================== AKSI PROSES ===================== --}}
                            <div class="border rounded p-2 bg-gray-50">
                                <p class="text-xs font-semibold text-gray-500 mb-1">📌 Process</p>

                                <div class="flex flex-col gap-1">

                                    {{-- Update Pelaksanaan --}}
                                    @if($u->status_ui === 'accepted')
                                    <a href="{{ route('admin.pelaksanaankegiatan.create', $u->id) }}"
                                        class="text-blue-700 hover:underline font-medium">
                                        ▶ Update Pelaksanaan Kegiatan
                                    </a>
                                    @else
                                    <span class="text-gray-400 italic cursor-not-allowed">
                                        ▶ Update Pelaksanaan Kegiatan
                                    </span>
                                    @endif

                                    {{-- Update Laporan --}}
                                    @if($u->status_ui === 'in_progress')
                                    <a href="{{ route('admin.laporankegiatan.create', $u->id) }}"
                                        class="text-purple-700 hover:underline font-medium">
                                        ▶ Update Laporan Hasil Kegiatan
                                    </a>
                                    @else
                                    <span class="text-gray-400 italic cursor-not-allowed">
                                        ▶ Update Laporan Hasil Kegiatan
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- ===================== AKSI ADMINISTRATIF ===================== --}}
                            <div class="border rounded p-2 bg-white">
                                <p class="text-xs font-semibold text-gray-500 mb-1">🛠 Administratif</p>

                                <div class="flex flex-wrap gap-2">
                                    {{-- EDIT --}}
                                    @if(in_array($u->status_ui, ['draft', 'rejected']))
                                    <a href="{{ route('admin.usulankegiatan.edit', $u->id) }}"
                                        class="text-indigo-600 hover:underline">
                                        Edit
                                    </a>
                                    @elseif(
                                    //$u->status_ui === 'accepted' &&
                                    $u->inputlaporankegiatans?->laporankegiatans?->canEditLaporan()
                                    //isset($u->inputlaporankegiatans) &&
                                    //isset($u->inputlaporankegiatans?->laporankegiatans?->canEditLaporan())
                                    //&& in_array($u->inputlaporankegiatans?->laporankegiatans->status_laporan_ui, ['completed', 'rejected'])
                                    )
                                    <a href="{{ route('admin.laporankegiatan.edit', $u->id) }}"
                                        class="text-indigo-600 hover:underline">
                                        Edit
                                    </a>
                                    @else
                                    <span class="text-gray-400 italic">Edit</span>
                                    @endif

                                    {{-- CETAK --}}
                                    @if(
                                    in_array($u->status_ui, ['draft', 'rejected']) &&
                                    is_null($u->cetakusulankegiatans)
                                    )
                                    <form method="POST"
                                        action="{{ route('admin.usulankegiatan.cetak', $u->id) }}"
                                        onsubmit="return confirm('Yakin cetak? Status akan berubah ke pending.')">
                                        @csrf
                                        <button type="submit"
                                            class="text-indigo-600 hover:underline">
                                            Cetak
                                        </button>
                                    </form>
                                    @elseif (
                                    isset($u->inputlaporankegiatans) &&
                                    isset($u->inputlaporankegiatans->laporankegiatans) &&
                                    in_array(
                                    $u->inputlaporankegiatans->laporankegiatans->status_laporan_ui,
                                    ['completed', 'rejected']
                                    ) &&
                                    is_null($u->inputlaporankegiatans->laporankegiatans->cetakusulankegiatans)
                                    )
                                    <form method="POST"
                                        action="{{ route('admin.laporankegiatan.cetak', $u->id) }}"
                                        onsubmit="return confirm('Yakin cetak? Status akan berubah ke pending.')">
                                        @csrf
                                        <button type="submit"
                                            class="text-indigo-600 hover:underline">
                                            Cetak
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-gray-400 italic">Cetak</span>
                                    @endif

                                    {{-- KIRIM --}}
                                    @if($u->isPendingUsulan())
                                    <a href="{{ route('admin.usulankegiatan.kirim', $u->id) }}"
                                        class="text-indigo-600 hover:underline">
                                        Kirim
                                    </a>
                                    @elseif($u->isPendingLaporan())
                                    <a href="{{ route('admin.laporankegiatan.kirim', $u->id) }}"
                                        class="text-indigo-600 hover:underline">
                                        Kirim
                                    </a>
                                    @else
                                    <span class="text-gray-400 italic">Kirim</span>
                                    @endif


                                    {{-- HAPUS --}}
                                    <form action="{{ route('admin.usulankegiatan.destroy', $u->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin hapus usulan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:underline">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 p-4">
                            Tidak ada data usulan kegiatan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>