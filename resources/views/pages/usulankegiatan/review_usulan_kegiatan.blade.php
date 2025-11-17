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

            <h3 class="text-md font-semibold text-gray-800 mb-3 text-center">
                Review Usulan: {{ $usulankegiatans->nama_kegiatan }}
            </h3>

            <form method="POST" 
                  action="{{ route('superadmin.usulankegiatan.reviewUpload', $usulankegiatans->id) }}">
                @csrf
                <div class="mb-4">
                    <label for="noteusulan_kegiatan" class="font-semibold">Catatan Review (Opsional)</label>
                    <textarea 
                        name="noteusulan_kegiatan" 
                        id="noteusulan_kegiatan" 
                        class="border rounded w-full mt-2 p-2"
                        placeholder="Tulis catatan review..."></textarea>
                </div>

                <div class="flex gap-2 justify-end">
                    <button 
                        type="submit" 
                        name="actionusulan_kegiatan" 
                        value="accepted" 
                        class="bg-green-100 hover:bg-green-200 text-green-700 font-medium px-6 py-2 rounded-lg transition">
                        Setujui
                    </button>
                    <button 
                        type="submit" 
                        name="actionusulan_kegiatan" 
                        value="rejected" 
                        class="bg-red-100 hover:bg-red-200 text-red-700 font-medium px-6 py-2 rounded-lg transition">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
