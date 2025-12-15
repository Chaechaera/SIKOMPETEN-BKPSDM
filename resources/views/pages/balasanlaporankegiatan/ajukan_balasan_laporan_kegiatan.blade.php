<x-app-layout>

    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">
            Buat Balasan Laporan Kegiatan Pengembangan Kompetensi ASN
        </h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form method="POST" action="{{ route('superadmin.balasanlaporankegiatan.store', $laporankegiatans->id) }}" enctype="multipart/form-data">
                @csrf

                {{-- ===================================================== --}}
                {{-- BAGIAN 1: IDENTITAS SURAT --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Identitas Surat</h2>

                     <div class="mb-4">
                        <label class="block font-medium">Nomor Surat</label>
                        <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                            class="border rounded w-full p-2" placeholder="Masukkan nomor surat">
                        @error('nomor_surat')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Tanggal Surat</label>
                        <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}"
                            class="border rounded w-full p-2">
                        @error('tanggal_surat')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Perihal Surat</label>
                        <input type="text" name="perihal_surat" value="{{ old('perihal_surat') }}"
                            class="border rounded w-full p-2" placeholder="Masukkan perihal">
                        @error('perihal_surat')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Lampiran Surat</label>
                        <input type="text" name="lampiran_surat" value="1 Bendel" class="border rounded w-full p-2 bg-gray-100" readonly>
                    </div>
                </div>

                {{-- ===================================================== --}}
                {{-- BAGIAN 2: INFORMASI SURAT LAPORAN KEGIATAN --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Informasi Surat Laporan Kegiatan</h2>

                    <div class="mb-4">
                        <label class="block font-medium">Nomor Surat Laporan</label>
                        <input type="text" name="nomor_surat_laporan" value="{{ $laporankegiatans->identitassurats->nomor_surat ?? '-' }}" class="border p-2 w-full" readonly>
                        @error('nomor_surat_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Tanggal Surat Laporan</label>
                        <input type="text" name="tanggal_surat_laporan" value="{{ $laporankegiatans->identitassurats->tanggal_surat ?? '-' }}" class="border p-2 w-full" readonly>
                        @error('tanggal_surat_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Perihal Surat Laporan</label>
                        <input type="text" name="perihal_surat_laporan" value="{{ $laporankegiatans->identitassurats->perihal_surat ?? '-' }}" class="border p-2 w-full" readonly>
                        @error('perihal_surat_laporan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                </div>

                {{-- ===================================================== --}}
                {{-- BAGIAN 3: BALASAN LAPORAN KEGIATAN --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-semibold mb-4">Balasan Laporan Kegiatan</h2>

                    <div class="mb-4">
                            <label class="block font-medium">Sub Unit Kerja Pengajuan Kegiatan</label>
                            <input type="text" value="{{ $subunitkerjas ?? '' }}" class="border p-2 w-full bg-gray-100" readonly>
                            <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium">Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" value="{{ $laporankegiatans->usulankegiatans->nama_kegiatan ?? '-' }}" class="border p-2 w-full" readonly>
                            @error('nama_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium">Cara Pelatihan Kegiatan</label>
                            <input type="text" name="cara_pelatihan" value="{{ $laporankegiatans->usulankegiatans->carapelatihans->cara_pelatihan ?? '-' }}" class="border p-2 w-full" readonly>
                            @error('cara_pelatihan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium">Tanggal Pelaksanaan Kegiatan</label>
                            <input type="text" name="tanggalpelaksanaan_kegiatan" value="{{ $laporankegiatans->usulankegiatans->tanggalpelaksanaan_kegiatan ?? '-' }}" class="border p-2 w-full" readonly>
                            @error('tanggalpelaksanaan_kegiatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-medium">Lama Kegiatan</label>
                            <input type="text" id="lama_kegiatan" name="lama_kegiatan" value="1 hari"
                                class="border p-2 w-full bg-gray-100" readonly>
                        </div>
                </div>

                {{-- ===================================================== --}}
                {{-- BAGIAN 4: CAPAIAN JP DAN SERTIFIKAT --}}
                {{-- ===================================================== --}}
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4">Lengkapi Balasan Laporan Kegiatan</h2>

                    <div class="p-4 border rounded">

                        <h3 class="font-semibold mb-3">Detail Kegiatan</h3>

                        <div class="mt-4">
                                <label class="block font-medium">Nomor Sertifikat Kegiatan</label>
                                <input type="text" name="nomorsertifikat_kegiatan" value="{{ $sertifikats->nomorsertifikat_kegiatan ?? '-' }}" class="border p-2 w-full" readonly>
                                <input type="hidden" name="sertifikat_id" value="{{ $sertifikats->id ?? '' }}">
                            </div>

                            <div class="mt-4">
                                <label class="block font-medium">Capaian JP Kegiatan</label>
                                <input type="text" name="totalcapaianjp_kegiatan" value="{{ old('totalcapaianjp_kegiatan') }}"
                                    class="border p-2 w-full">
                                @error('totalcapaianjp_kegiatan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block font-medium">Tanggal Sertifikat Kegiatan</label>
                                <input type="date" name="tanggalkeluarsertifikat_kegiatan" value="{{ old('tanggalkeluarsertifikat_kegiatan') }}"
                                    class="border p-2 w-full" required>
                                @error('tanggalkeluarsertifikat_kegiatan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        {{-- ====================== --}}
                        {{-- DRAG AREA --}}
                        {{-- ====================== --}}
                        <div class="mt-6">
                            <label class="block font-medium mb-2">Desain Placeholder Sertifikat</label>

                            <div id="designArea"
                                 class="relative w-full h-[500px] border rounded bg-gray-100 flex items-center justify-center text-gray-500">
                            </div>

                            <input type="hidden" name="fieldstemplatesertifikat_kegiatan"
                                   id="fieldstemplatesertifikat_kegiatan">

                            <div class="mt-4 p-3 border rounded bg-gray-50">
                                <p class="font-semibold mb-2">Placeholder yang tersedia:</p>

                                <div class="flex gap-3 flex-wrap">
                                    <div class="placeholder-item px-3 py-2 bg-blue-600 text-white rounded cursor-move"
                                         draggable="true" data-type="nama_peserta">Nama Peserta</div>

                                    <div class="placeholder-item px-3 py-2 bg-blue-600 text-white rounded cursor-move"
                                         draggable="true" data-type="nip_peserta">NIP Peserta</div>

                                    <div class="placeholder-item px-3 py-2 bg-blue-600 text-white rounded cursor-move"
                                         draggable="true" data-type="jabatan_peserta">Jabatan</div>

                                    <div class="placeholder-item px-3 py-2 bg-blue-600 text-white rounded cursor-move"
                                         draggable="true" data-type="nomorsertifikatpeserta_kegiatan">Nomor Sertifikat</div>

                                    <div class="placeholder-item px-3 py-2 bg-blue-600 text-white rounded cursor-move"
                                         draggable="true" data-type="totalcapaianjp_kegiatan">Jumlah JP</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="submit" name="statususulan_kegiatan" value="draft"
                                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                                Simpan Draft
                            </button>

                            <button type="submit" name="statususulan_kegiatan" value="pending"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                Kirim Usulan
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <!--<script>
        // === Hitung Lama Kegiatan ===
        /**const tglMulai = document.getElementById('tanggal_mulai');
        const tglSelesai = document.getElementById('tanggal_selesai');
        const tglPelaksanaan = document.getElementById('tanggalpelaksanaan_kegiatan');
        const lama = document.getElementById('lama_kegiatan');

        function hitungLama() {
            if (tglMulai.value && tglSelesai.value) {
                const start = new Date(tglMulai.value);
                const end = new Date(tglSelesai.value);
                const diff = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
                lama.value = diff > 0 ? diff + ' hari' : '';
            }
        }

        tglMulai.addEventListener('change', hitungLama);
        tglSelesai.addEventListener('change', hitungLama);**/
    </script>-->

{{-- ============================================================= --}}
{{-- SCRIPT DRAG N DROP --}}
{{-- ============================================================= --}}
<script>
const designArea = document.getElementById("designArea");
let bgImage = null;
let scaleX = 1, scaleY = 1;

/* ----------------------------------------------------- */
/* DRAGSTART (ambil tipe placeholder)                    */
/* ----------------------------------------------------- */
document.querySelectorAll(".placeholder-item").forEach(item => {
    item.addEventListener("dragstart", e => {
        e.dataTransfer.setData("placeholder", e.target.dataset.type);
    });
});

/* ----------------------------------------------------- */
/* DROP KE CANVAS                                        */
/* ----------------------------------------------------- */
designArea.addEventListener("dragover", e => e.preventDefault());

designArea.addEventListener("drop", e => {
    e.preventDefault();

    const type = e.dataTransfer.getData("placeholder");
    if (!type) return;

    const rect = designArea.getBoundingClientRect();

    // posisi DISPLAY (yang kamu lihat)
    const x_display = e.clientX - rect.left;
    const y_display = e.clientY - rect.top;

    // simpan posisi real (koordinat asli PNG)
    const x_real = x_display * scaleX;
    const y_real = y_display * scaleY;

    const el = createPlaceholderElement(type, x_real, y_real);
    designArea.appendChild(el);
    saveMetadata();
});

/* ----------------------------------------------------- */
/* BUAT ELEMENT (pakai posisi REAL lalu konversi)        */
/* ----------------------------------------------------- */
function createPlaceholderElement(type, x_real, y_real) {
    const el = document.createElement("div");
    el.className = "absolute px-2 py-1 bg-black text-white text-xs rounded cursor-move select-none";
    el.dataset.type = type;
    el.dataset.x_real = x_real;
    el.dataset.y_real = y_real;

    // tampilkan di layar (konversi posisi real → display)
    el.style.left = (x_real / scaleX) + "px";
    el.style.top = (y_real / scaleY) + "px";
    el.textContent = type;

    makeDraggable(el);
    return el;
}

/* ----------------------------------------------------- */
/* DRAG DI DALAM CANVAS                                  */
/* ----------------------------------------------------- */
function makeDraggable(el) {
    el.addEventListener("mousedown", e => {

        let offsetX = e.clientX - el.getBoundingClientRect().left;
        let offsetY = e.clientY - el.getBoundingClientRect().top;

        function onMove(e2) {
            const rect = designArea.getBoundingClientRect();

            const x_display = e2.clientX - offsetX - rect.left;
            const y_display = e2.clientY - offsetY - rect.top;

            el.style.left = x_display + "px";
            el.style.top = y_display + "px";

            // update posisi REAL
            el.dataset.x_real = x_display * scaleX;
            el.dataset.y_real = y_display * scaleY;
        }

        document.addEventListener("mousemove", onMove);

        document.addEventListener("mouseup", () => {
            document.removeEventListener("mousemove", onMove);
            saveMetadata();
        }, { once: true });
    });
}

/* ----------------------------------------------------- */
/* SIMPAN METADATA KE INPUT HIDDEN                        */
/* ----------------------------------------------------- */
function saveMetadata() {
    const result = [];

    designArea.querySelectorAll("[data-type]").forEach(el => {
        result.push({
            type: el.dataset.type,
            x: Math.round(el.dataset.x_real),
            y: Math.round(el.dataset.y_real),
            font_size: 18,
            font_color: "#000000"
        });
    });

    document.getElementById("fieldstemplatesertifikat_kegiatan").value =
        JSON.stringify(result);
}

/* ----------------------------------------------------- */
/* LOAD TEMPLATE GAMBAR                                   */
/* ----------------------------------------------------- */
document.addEventListener("DOMContentLoaded", function () {

    const templatePath = "{{ $laporankegiatans->detaillaporankegiatans->templatesertifikat_kegiatan ?? '' }}";

    if (templatePath !== "") {
        const url = "{{ asset('storage') }}/" + templatePath;
        const img = new Image();
        img.src = url;

        img.onload = function () {
            bgImage = img;

            const containerWidth = designArea.parentElement.offsetWidth;
            const ratio = img.width / img.height;

            designArea.style.width = containerWidth + "px";
            designArea.style.height = (containerWidth / ratio) + "px";

            scaleX = img.width / designArea.offsetWidth;
            scaleY = img.height / designArea.offsetHeight;

            designArea.style.backgroundImage = `url('${url}')`;
            designArea.style.backgroundSize = "100% 100%";
            designArea.style.backgroundRepeat = "no-repeat";

            loadExisting();
        };
    }
});

/* ----------------------------------------------------- */
/* LOAD DATA LAMA                                         */
/* ----------------------------------------------------- */
function loadExisting() {
    let data = @json($sertifikats->fieldstemplatesertifikat_kegiatan ?? []);

    if (typeof data === "string") {
        try { data = JSON.parse(data); } catch { data = []; }
    }
    if (!Array.isArray(data)) return;

    data.forEach(f => {
        const el = createPlaceholderElement(f.type, f.x, f.y);
        designArea.appendChild(el);
    });

    saveMetadata();
}

document.querySelector("form").addEventListener("submit", saveMetadata);
</script>

</x-app-layout>
