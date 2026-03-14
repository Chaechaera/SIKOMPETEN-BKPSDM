<section class="text-center py-16 px-6">
    <div class="max-w-7xl mx-auto">

        <h2 class="text-3xl font-bold">
            Mengapa Memilih <span class="text-[#1AB0B0]">SIKOMPETEN?</span>
        </h2>

        <div class="grid md:grid-cols-3 gap-8 mt-12">

            @php
            $features = [
            ['img'=>'Digital.png','title'=>'Pengajuan Digital','desc'=>'Seluruh proses pengajuan usulan dan pelaporan kegiatan dilakukan secara online, sehingga lebih praktis, terdokumentasi, dan mudah','bg'=>'bg-blue-100'],
            ['img'=>'Calendar.png','title'=>'Monitoring Real-time','desc'=>'Memantau perkembangan kegiatan secara langsung melalui dashboard yang informatif dan selalu diperbarui secara real-time','bg'=>'bg-teal-100'],
            ['img'=>'Users.png','title'=>'Verifikasi Cepat','desc'=>'Proses verifikasi lebih efisien, terstruktur, dan transparan untuk seluruh proses pengajuan, verifikasi, dan pelaporan di dalam sistem','bg'=>'bg-blue-100'],
            ['img'=>'Shield.png','title'=>'Sistem Terpercaya','desc'=>'Dirancang dengan standar keamanan yang baik untuk menjaga integritas dan kerahasiaan data pengembangan kompetensi ASN','bg'=>'bg-purple-100'],
            ['img'=>'Clock.png','title'=>'Efisiensi Waktu','desc'=>'Otomatisasi proses administrasi membantu memangkas waktu layanan dan meningkatkan produktivitas pengelolaan data kegiatan','bg'=>'bg-green-100'],
            ['img'=>'Award.png','title'=>'Sertifikat Digital','desc'=>'Penerbitan sertifikat dilakukan secara digital, cepat, dan mudah diakses sebagai bukti sah terlaksananya kegiatan Pengembangan Kompetensi ASN','bg'=>'bg-sky-100'],
            ];
            @endphp

            @foreach($features as $f)
            <div class="group bg-white hover:bg-gradient-to-br from-[#6fcae3] to-[#216e7f] rounded-3xl shadow-lg p-8 text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <div class="w-16 h-16 mx-auto mb-5 rounded-full {{ $f['bg'] }} flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg group-hover:bg-white/20">
                    <img src="{{ asset('images/'.$f['img']) }}" class="w-8 h-8 transition-all duration-300 group-hover:brightness-0 group-hover:invert">
                </div>
                <h3 class="font-bold text-lg mb-2 text-gray-800 transition-colors duration-300 group-hover:text-white">
                    {{ $f['title'] }}
                </h3>
                <p class="text-gray-600 text-sm leading-relaxed transition-colors duration-300 group-hover:text-white">
                    {{ $f['desc'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>