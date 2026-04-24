<x-app-layout>
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50">

        {{-- Sidebar --}}
        @include('pages.sidebar.admin')

        {{-- Main Content --}}
        <main class="flex-1 space-y-6 transition-all duration-300" :class="sidebarOpen ? 'ml-64' : 'ml-0'">

            {{-- Header --}}
            @include('layouts.navigation')

            {{-- 📝 FORM BALASAN LAPORAN HASIL KEGIATAN --}}
            <form method="POST" action="{{ route('superadmin.balasanlaporankegiatan.store', $laporankegiatans->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="bg-white rounded-xl shadow p-6 mb-4">
                    <h1 class="text-2xl font-medium bg-gradient-to-r from-[#922B80] to-[#5B2C89] bg-clip-text text-transparent leading-tight">FORMULIR BALASAN LAPORAN HASIL KEGIATAN PENGEMBANGAN KOMPETENSI ASN</h1>
                    <p class="text-sm text-blue-600">
                        Silahkan lengkapi data balasan laporan hasil kegiatan pada form ini dan pastikan data balasan laporan hasil kegiatan yang diisikan telah sesuai sebelum dicetak.
                    </p>
                </div>

                {{-- ========================================================= --}}
                {{-- ======== BAGIAN 1: BUAT BALASAN LAPORAN KEGIATAN ======== --}}
                {{-- ========================================================= --}}
                <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-bold text-blue-600 mb-4">Preview Data Utama Kegiatan</h2>

                    <!-- 🔻 DIVIDER -->
                    <div class="my-4 border-t-2 border-gray-200"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Nama Kegiatan --}}
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nama Kegiatan</label>
                            <div class="relative">
                                <input type="text"
                                    value="{{ $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->nama_kegiatan ?? '' }}"
                                    class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-gray-100 focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Sub Unit Kerja --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Sub Unit Kerja</label>
                            <div class="relative">
                                <input type="text"
                                    value="{{ $subunitkerjas ?? '' }}"
                                    class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-gray-100 focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" readonly>
                                <input type="hidden" name="subunitkerja_id" value="{{ $subunitkerja_id ?? '' }}">
                            </div>
                        </div>

                        {{-- Cara Pelatihan --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Cara Pelatihan</label>
                            <div class="relative">
                                <input type="text"
                                    value="{{ $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->carapelatihans->cara_pelatihan ?? '' }}"
                                    class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-gray-100 focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" readonly>
                            </div>
                        </div>

                        {{-- Tanggal Pelaksanaan Kegiatan --}}
                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Kegiatan</label>
                            <div class="relative">
                                <input type="text"
                                    value="{{ $laporankegiatans->tanggalmulai_kegiatan && $laporankegiatans->tanggalselesai_kegiatan
                            ? \Carbon\Carbon::parse($laporankegiatans->tanggalmulai_kegiatan)->format('d F Y') . ' s/d ' .
                            \Carbon\Carbon::parse($laporankegiatans->tanggalselesai_kegiatan)->format('d F Y') : '-'}}"
                                    class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-gray-100 focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" readonly>
                                @error('tanggalpelaksanaan_kegiatan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Lama Kegiatan Terlaksana  --}}
                        @php
                        $lamaHari = '-';
                        if($laporankegiatans->tanggalmulai_kegiatan && $laporankegiatans->tanggalselesai_kegiatan)
                        {
                        $start = \Carbon\Carbon::parse($laporankegiatans->tanggalmulai_kegiatan);
                        $end = \Carbon\Carbon::parse($laporankegiatans->tanggalselesai_kegiatan);
                        $lamaHari = $start->diffInDays($end) + 1;
                        }
                        @endphp

                        <div>
                            <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Lama Kegiatan Terlaksana</label>
                            <div class="relative">
                                <input type="text"
                                    value="{{ $lamaHari != '-' ? $lamaHari.' hari' : '-' }}"
                                    class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-gray-100 focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ============================================================= --}}
                {{-- ======== BAGIAN 2: LENGKAPI BALASAN LAPORAN KEGIATAN ======== --}}
                {{-- ============================================================= --}}
                <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                    <h2 class="text-lg font-bold text-blue-600 mb-4">Lengkapi Balasan Laporan Kegiatan</h2>

                    <!-- 🔻 DIVIDER -->
                    <div class="my-4 border-t-2 border-gray-200"></div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Nomor Sertifikat Kegiatan  --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Nomor Sertifikat Kegiatan</label>
                        <input type="text" name="nomorsertifikat_kegiatan" value="{{ $sertifikats->nomorsertifikat_kegiatan ?? '-' }}" class="block w-full text-sm text-gray-700 
                                  border border-[#E0E7FF] rounded-lg cursor-pointer
                                  bg-gray-100 focus:ring-2 focus:ring-[#A5B4FC] 
                                  focus:outline-none p-2" readonly>
                        <input type="hidden" name="sertifikat_id" value="{{ $sertifikats->id ?? '' }}">
                    </div>

                    {{-- Capaian JP Kegiatan  --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Capaian JP Kegiatan</label>
                        <input type="text" name="totalcapaianjp_kegiatan" value="{{ old('totalcapaianjp_kegiatan') }}"
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-gray-20 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                        @error('totalcapaianjp_kegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tanggal Keluar Sertifikat  --}}
                    <div>
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Tanggal Sertifikat Kegiatan Dikeluarkan</label>
                        <input type="date" name="tanggalkeluarsertifikat_kegiatan" value="{{ old('tanggalkeluarsertifikat_kegiatan') }}"
                            class="block w-full text-sm text-gray-700 border border-[#E0E7FF] rounded-lg cursor-pointer bg-gray-20 focus:ring-2 focus:ring-[#A5B4FC] focus:outline-none p-2" required>
                        @error('tanggalkeluarsertifikat_kegiatan')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- =============================================================-==== --}}
                    {{-- ======== BAGIAN 3: CANVAS DRAG AND DROP ELEMEN SERTIFIKAT ======== --}}
                    {{-- ================================================================== --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-[#5A5A5A] mb-2">Canvas Desain Sertifikat Kegiatan OPD</label>

                        {{-- Ukuran Canvas Desain Srertifikat  --}}
                        <div id="designArea" class="relative border rounded bg-gray-100 mx-auto"></div>
                        <input type="hidden" name="fieldstemplatesertifikat_kegiatan" id="fieldstemplatesertifikat_kegiatan">

                        {{-- Elemen Drag and Drop  --}}
                        <div class="mt-4 p-3 border rounded bg-gray-50">
                            <p class="font-semibold mb-2">Elemen yang tersedia:</p>
                            <div class="flex gap-3 flex-wrap">
                                <div class="placeholder-item bg-blue-600 text-white rounded cursor-move"
                                    draggable="true" data-type="nama_peserta">Nama Peserta Kegiatan</div>

                                <div class="placeholder-item bg-blue-600 text-white rounded cursor-move"
                                    draggable="true" data-type="nip_peserta">NIP Peserta Kegiatan</div>

                                <div class="placeholder-item bg-blue-600 text-white rounded cursor-move"
                                    draggable="true" data-type="nomorsertifikatpeserta_kegiatan">Nomor Sertifikat Kegiatan Peserta</div>

                                <div class="placeholder-item bg-blue-600 text-white rounded cursor-move"
                                    draggable="true" data-type="totalcapaianjp_kegiatan">Jumlah Capaian JP Kegiatan</div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                {{-- =========================================== --}}
                {{-- ========== BAGIAN 3: TOMBOL AKSI ========== --}}
                {{-- =========================================== --}}
                <div class="mt-6 flex justify-end gap-3">
                    <button type="submit"
                        class="w-2/12 text-center py-2.5 bg-[#FFA41B] text-white px-6 rounded-lg text-sm hover:bg-[#ff9600] transition font-semibold">
                        Kirim Balasan
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
        const designArea = document.getElementById("designArea");
        let selectedElement = null;

        /* =====================================
        |   SAMPLE TEXT AGAR TERLIHAT REAL     |
        ===================================== */
        function getSampleText(type) {
            switch (type) {
                case "nama_peserta":
                    return "BUDI SANTOSO";
                case "nip_peserta":
                    return "198712312020011001";
                case "jabatan_peserta":
                    return "Analis Kepegawaian";
                case "nomorsertifikatpeserta_kegiatan":
                    return "18/BKPSDM/005/II/2026";
                case "totalcapaianjp_kegiatan":
                    return "32 (Tiga Puluh Dua)";
                default:
                    return type;
            }
        }

        /* ============================
        |   DRAG ELEMEN DARI LIST     |
        ============================ */
        document.querySelectorAll(".placeholder-item").forEach(item => {
            item.addEventListener("dragstart", e => {
                e.dataTransfer.setData("placeholder", e.target.dataset.type);
            });
        });

        /* ============================
        |   DROP ELEMEN KE CANVAS     |
        ============================ */
        designArea.addEventListener("dragover", e => e.preventDefault());

        designArea.addEventListener("drop", e => {
            e.preventDefault();

            const type = e.dataTransfer.getData("placeholder");
            if (!type) return;

            const rect = designArea.getBoundingClientRect();

            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const el = createPlaceholder(type);
            designArea.appendChild(el);

            // anchor tengah biar presisi
            const offsetX = el.offsetWidth / 2;
            const offsetY = el.offsetHeight / 2;

            const finalX = x - offsetX;
            const finalY = y - offsetY;

            el.style.left = finalX + "px";
            el.style.top = finalY + "px";

            saveMetadata();
        });

        // Fungsi untuk mengatur ukuran elemen drag and drop
        function getDefaultFontSize(type) {
            switch (type) {
                case "nama_peserta":
                    return 36;
                case "nip_peserta":
                    return 24;
                case "nomorsertifikatpeserta_kegiatan":
                    return 18;
                case "totalcapaianjp_kegiatan":
                    return 18;
                default:
                    return 20;
            }
        }

        /* ================================
        |   BUAT ELEMEN DRAG AND DROP     |
        ================================ */
        function createPlaceholder(type) {
            const el = document.createElement("div");
            el.className = "absolute cursor-move select-none";
            el.dataset.type = type;

            el.style.fontFamily = "'Times New Roman', serif";
            el.style.fontSize = getDefaultFontSize(type) + "px";
            el.style.fontWeight = "bold";
            el.style.color = "#000000";
            el.style.textAlign = "center";
            el.style.lineHeight = "1";
            el.style.whiteSpace = "nowrap";

            el.textContent = getSampleText(type);

            el.addEventListener("click", () => {
                selectedElement = el;
            });

            makeDraggable(el);
            return el;
        }

        /* ============================
        |   DRAG KE CANVAS DESAIN     |  
        ============================ */
        function makeDraggable(el) {
            el.addEventListener("mousedown", e => {

                let offsetX = e.clientX - el.getBoundingClientRect().left;
                let offsetY = e.clientY - el.getBoundingClientRect().top;

                function onMove(e2) {
                    const rect = designArea.getBoundingClientRect();

                    const x = e2.clientX - offsetX - rect.left;
                    const y = e2.clientY - offsetY - rect.top;

                    el.style.left = x + "px";
                    el.style.top = y + "px";
                }

                document.addEventListener("mousemove", onMove);

                document.addEventListener("mouseup", () => {
                    document.removeEventListener("mousemove", onMove);
                    saveMetadata();
                }, {
                    once: true
                });
            });
        }

        /* =====================================
        |   SIMPAN FIELDS DALAM PERSEN (%)     |
        ===================================== */
        function saveMetadata() {

            const result = [];
            const parentRect = designArea.getBoundingClientRect();

            designArea.querySelectorAll("[data-type]").forEach(el => {

                const elRect = el.getBoundingClientRect();

                const left = elRect.left - parentRect.left;
                const top = elRect.top - parentRect.top;

                const xPercent = (left / parentRect.width) * 100;
                const yPercent = (top / parentRect.height) * 100;

                result.push({
                    type: el.dataset.type,
                    x_percent: xPercent,
                    y_percent: yPercent,
                    font_size: parseInt(el.style.fontSize),
                    font_color: el.style.color,
                    font_weight: el.style.fontWeight,
                    text_align: el.style.textAlign
                });
            });

            document.getElementById("fieldstemplatesertifikat_kegiatan").value =
                JSON.stringify(result);
        }

        /* =========================================
        |    LOAD BACKGROUND SERTIFIKAT TEMPLATE   |
        ========================================= */
        document.addEventListener("DOMContentLoaded", function() {

            const templatePath = "{{ $laporankegiatans->sertifikats->templatesertifikat_kegiatan ?? '' }}";

            if (templatePath !== "") {

                const url = "{{ asset('storage') }}/" + templatePath;
                const img = new Image();
                img.src = url;

                img.onload = function() {

                    const containerWidth = designArea.parentElement.offsetWidth;

                    const ratio = img.height / img.width;

                    designArea.style.width = containerWidth + "px";
                    designArea.style.height = (containerWidth * ratio) + "px";

                    designArea.style.backgroundImage = `url('${url}')`;
                    designArea.style.backgroundSize = "100% 100%";
                    designArea.style.backgroundRepeat = "no-repeat";

                    loadExisting();
                };
            }
        });

        /* ========================================
        |   LOAD DATA LAMA TEMPLATE SERTIFIKAT    |
        ======================================== */
        function loadExisting() {

            let data = @json($sertifikats->fieldstemplatesertifikat_kegiatan ?? []);

            if (typeof data === "string") {
                try {
                    data = JSON.parse(data);
                } catch {
                    data = [];
                }
            }

            if (!Array.isArray(data)) return;

            data.forEach(f => {
                const el = createPlaceholder(f.type);

                const x = (f.x_percent / 100) * designArea.offsetWidth;
                const y = (f.y_percent / 100) * designArea.offsetHeight;

                el.style.left = x + "px";
                el.style.top = y + "px";

                el.style.fontSize = (f.font_size ?? 42) + "px";
                el.style.color = f.font_color ?? "#000000";
                el.style.fontWeight = f.font_weight ?? "bold";
                el.style.textAlign = f.text_align ?? "center";

                designArea.appendChild(el);
            });

            saveMetadata();
        }

        document.querySelector("form").addEventListener("submit", saveMetadata);
    </script>

</x-app-layout>