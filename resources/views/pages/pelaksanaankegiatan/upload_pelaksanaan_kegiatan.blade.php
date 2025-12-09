<x-app-layout>

    <div class="bg-[#F5F6FA] p-6 sm:p-10 max-w-5xl mx-auto">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-[#2B3674] mb-4">
            <span>Surakarta, Indonesia</span>
            <span>•</span>
            <span>{{ date('d F Y') }}</span>
        </div>

        {{-- Judul --}}
        <div class="bg-white rounded-xl shadow p-6 mb-10">
            <h1 class="text-2xl font-semibold text-[#2B3674]">
                FORM UPLOAD BUKTI PELAKSANAAN KEGIATAN
            </h1>
            <p class="text-sm text-gray-500 max-w-2xl">
                Silakan lengkapi informasi pelaksanaan kegiatan dan unggah bukti dokumentasinya.
            </p>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.pelaksanaankegiatan.store', $usulankegiatans->id) }}" 
              method="POST" enctype="multipart/form-data">

            @csrf

            <div class="bg-white rounded-xl shadow p-6 mb-10">
                <h2 class="text-lg font-semibold text-[#2B3674] mb-1">Data Pelaksanaan</h2>
                <p class="text-gray-500 text-sm mb-6">Informasi pelaksanaan kegiatan.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    {{-- Nama Kegiatan --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Nama Kegiatan</label>
                        <input
                            type="text"
                            name="nama_kegiatan"
                            value="{{ $usulankegiatans->nama_kegiatan }}"
                            readonly
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100">
                    </div>

                    {{-- Lokasi --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Lokasi Kegiatan</label>
                        <input
                            type="text"
                            name="lokasi_kegiatan"
                            value="{{ $usulankegiatans->lokasi_kegiatan }}"
                            readonly
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100">
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <label class="text-sm font-medium text-gray-700">Tanggal Kegiatan</label>
                        <input
                            type="text"
                            name="tanggalpelaksanaan_kegiatan"
                            value="{{ $usulankegiatans->tanggalpelaksanaan_kegiatan }}"
                            readonly
                            class="mt-2 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-100">
                    </div>

                    {{-- Upload Bukti --}}
                    <div class="sm:col-span-2">
                        <label class="text-sm font-medium text-gray-700">
                            Unggah Bukti Pelaksanaan (JPG, PNG, JPEG)
                        </label>

                        <label class="mt-2 border border-gray-300 rounded-lg px-3 py-6 
                                      flex flex-col items-center text-sm text-gray-500 cursor-pointer
                                      hover:bg-gray-50 transition">
                            <i class="fa-solid fa-upload text-2xl mb-2"></i>
                            Klik untuk upload atau drag & drop
                            <input 
                                type="file" 
                                id="buktipelaksanaan_kegiatanFiles"
                                name="buktipelaksanaan_kegiatan[]"
                                class="hidden"
                                accept=".jpg,.png,.jpeg"
                                multiple 
                                required>
                        </label>

                        {{-- Daftar file --}}
                        <ul id="fileList" class="mt-2 list-disc list-inside text-gray-700"></ul>

                        @error('buktipelaksanaan_kegiatan')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between mt-10">
                <a href="{{ url('/admin/usulankegiatan/listusulankegiatan') }}"
                   class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i>Batal
                </a>

                <button type="submit" name="statususulan_kegiatan" value="in_progress"
                        class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-sm hover:bg-[#ff9600] transition">
                    Kirim <i class="fa-solid fa-arrow-right ml-2"></i>
                </button>
            </div>

        </form>

    </div>

    {{-- Script Tampilan File --}}
    <script>
        const fileInput = document.getElementById('buktipelaksanaan_kegiatanFiles');
        const fileList = document.getElementById('fileList');

        fileInput.addEventListener('change', function() {
            fileList.innerHTML = '';

            for (let i = 0; i < this.files.length; i++) {
                const li = document.createElement('li');
                li.textContent = `${i + 1}. ${this.files[i].name}`;
                fileList.appendChild(li);
            }
        });
    </script>

</x-app-layout>
