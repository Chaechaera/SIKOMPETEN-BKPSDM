<x-app-layout>
    <x-slot name="title">
        Unggah Template Sertifikat
    </x-slot>

    {{-- Step Progress --}}
    @include('components.step-progress', ['currentStep' => 8])

    <div
        class="max-w-5xl mx-auto px-6 py-8 text-[#2B3674]"
        x-data="{
            mode: 'pilih',
            selectedTemplate: null,
            uploadedFile: null
        }"
    >

        <div class="bg-white shadow-sm sm:rounded-xl p-8 border-2 border-gray-300">

            {{-- ICON --}}
            <div class="flex justify-center mb-4">
                <div class="w-20 h-20 rounded-full bg-orange-100 flex items-center justify-center">
                    <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2
                                 M7 10l5-5m0 0l5 5m-5-5v12"/>
                    </svg>
                </div>
            </div>

            {{-- TITLE --}}
            <h2 class="text-center text-xl font-semibold mb-1">
                Unggah Template Sertifikat
            </h2>
            <p class="text-center text-sm text-gray-500 mb-8">
                Pilih template yang tersedia atau unggah template baru
            </p>

            {{-- MODE --}}
            <div class="flex justify-center gap-6 mb-8">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" value="pilih" x-model="mode"
                           @click="uploadedFile = null">
                    <span class="text-sm font-medium">Pilih Template</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" value="upload" x-model="mode"
                           @click="selectedTemplate = null">
                    <span class="text-sm font-medium">Upload Template</span>
                </label>
            </div>

            {{-- ================= PILIH TEMPLATE ================= --}}
            <div x-show="mode === 'pilih'" x-transition>

                <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-100">
                    <p class="font-semibold text-sm mb-3">
                        Template Sertifikat Tersedia
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- TEMPLATE 1 --}}
                        <label
                            class="relative border rounded-lg p-4 bg-white cursor-pointer transition
                                   hover:ring-2 hover:ring-orange-300"
                            :class="selectedTemplate === 1
                                ? 'border-orange-500 ring-2 ring-orange-400'
                                : 'border-gray-200'"
                        >
                            <input type="radio" name="template_id" class="hidden"
                                   @click="selectedTemplate = 1">

                            <div x-show="selectedTemplate === 1"
                                 class="absolute top-3 right-3 bg-orange-500 text-white rounded-full p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>

                            <p class="font-semibold text-gray-800">
                                Template Bangkom Umum
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                Untuk pengembangan kompetensi umum
                            </p>
                        </label>

                        {{-- TEMPLATE 2 --}}
                        <label
                            class="relative border rounded-lg p-4 bg-white cursor-pointer transition
                                   hover:ring-2 hover:ring-orange-300"
                            :class="selectedTemplate === 2
                                ? 'border-orange-500 ring-2 ring-orange-400'
                                : 'border-gray-200'"
                        >
                            <input type="radio" name="template_id" class="hidden"
                                   @click="selectedTemplate = 2">

                            <div x-show="selectedTemplate === 2"
                                 class="absolute top-3 right-3 bg-orange-500 text-white rounded-full p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>

                            <p class="font-semibold text-gray-800">
                                Template Pelatihan Teknis
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                Untuk pelatihan teknis ASN
                            </p>
                        </label>

                    </div>
                </div>
            </div>

            {{-- ================= UPLOAD TEMPLATE ================= --}}
            <div x-show="mode === 'upload'" x-transition>

                {{-- Panduan --}}
                <div class="mb-6 p-4 rounded-xl bg-blue-50 border border-blue-100">
                    <p class="font-semibold text-sm mb-2">
                        Panduan Template
                    </p>
                    <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                        <li>Format: PDF, DOCX, PNG, JPG</li>
                        <li>Maksimal ukuran 5MB</li>
                        <li>Gunakan placeholder data</li>
                    </ul>
                </div>

                {{-- Upload File (MODEL KLASIK) --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-2">
                        Upload Template Sertifikat
                    </label>

                    <div class="border-2 border-gray-300 rounded-lg p-3 bg-white">
                        <input
                            type="file"
                            name="template_file"
                            accept=".pdf,.docx,.png,.jpg,.jpeg"
                            @change="uploadedFile = $event.target.files[0]"
                            class="w-full text-sm
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-lg file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-gray-100 file:text-gray-700
                                   hover:file:bg-gray-200"
                        >
                    </div>

                    <p class="text-xs text-gray-400 mt-2">
                        Upload template sertifikat (maks. 5MB)
                    </p>

                    <p x-show="uploadedFile" class="text-xs text-green-600 mt-1">
                        File dipilih: <span x-text="uploadedFile.name"></span>
                    </p>
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-medium mb-2">
                        Keterangan (Opsional)
                    </label>
                    <textarea
                        rows="3"
                        class="w-full rounded-lg border-gray-300 text-sm
                               focus:ring-orange-500 focus:border-orange-500"
                        placeholder="Catatan template sertifikat"
                    ></textarea>
                </div>
            </div>

            {{-- BUTTON SIMPAN --}}
            <button
                type="button"
                class="w-full flex items-center justify-center gap-2
                       bg-orange-600 hover:bg-orange-700
                       text-white font-medium py-3 rounded-lg transition mt-6"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2
                             M7 10l5-5m0 0l5 5m-5-5v12"/>
                </svg>
                Simpan Template
            </button>

            {{-- FOOTER --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-10">

                <div class="text-sm text-gray-500">
                    Step <span class="font-semibold text-[#2B3674]">8</span> dari
                    <span class="font-semibold text-[#2B3674]">9</span>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('izinpengembangan.unggah-peserta') }}"
                       class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-200 transition">
                        Kembali
                    </a>

                    <button type="button"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-sm">
                        Simpan Draft
                    </button>

                    <a href="{{ route('izinpengembangan.download-sertifikat') }}"
                       class="bg-[#FFA41B] text-white px-6 py-2 rounded-lg text-sm hover:bg-[#ff9600] transition">
                        Selanjutnya
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
