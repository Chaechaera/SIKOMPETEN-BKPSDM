<div class="p-6" x-data="{ open: true }">
    
    <div 
        x-show="open"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        x-transition>
        
        <div 
            @click.away="open = false" 
            class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">

            <button 
                @click="open = false"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                ✕
            </button>

            <h3 class="text-lg font-semibold mb-4">
                Review Laporan: {{ $laporankegiatans->inputlaporankegiatans->inputusulankegiatans->usulankegiatans->nama_kegiatan }}
            </h3>

            <form method="POST" 
                  action="{{ route('superadmin.laporankegiatan.reviewUpload', $laporankegiatans->id) }}">
                @csrf
                <div class="mb-4">
                    <label for="catatan_verifikasilaporankegiatan" class="font-semibold">Catatan Review (Opsional)</label>
                    <textarea 
                        name="catatan_verifikasilaporankegiatan" 
                        id="catatan_verifikasilaporankegiatan" 
                        class="border rounded w-full mt-2 p-2"
                        placeholder="Tulis catatan review..."></textarea>
                </div>

                <div class="flex gap-2 justify-end">
                    <button 
                        type="submit" 
                        name="actionlaporan_kegiatan" 
                        value="accepted" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Setujui
                    </button>
                    <button 
                        type="submit" 
                        name="actionlaporan_kegiatan" 
                        value="rejected" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
