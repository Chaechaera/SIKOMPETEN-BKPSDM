<section class="text-center py-16 px-6">
    <div class="max-w-7xl mx-auto">

        <h2 class="text-3xl font-bold text-biruNavy">
            Mengapa Memilih <span class="text-hijauToska">SIKOMPETEN?</span>
        </h2>

        <div class="grid md:grid-cols-3 gap-8 mt-12">
            <!-- Fitur Array -->
            @php
            $features = [
            ['icon'=>'file-text','title'=>'Pengajuan Digital','desc'=>'Seluruh proses pengajuan usulan dan pelaporan kegiatan dilakukan secara online, sehingga lebih praktis, terdokumentasi, dan mudah','bg'=>'bg-biruLangit'],
            ['icon'=>'calendar','title'=>'Monitoring Real-time','desc'=>'Memantau perkembangan kegiatan secara langsung melalui dashboard yang informatif dan selalu diperbarui secara real-time','bg'=>'bg-hijauToska'],
            ['icon'=>'users','title'=>'Verifikasi Cepat','desc'=>'Proses verifikasi lebih efisien, terstruktur, dan transparan untuk seluruh proses pengajuan, verifikasi, dan pelaporan di dalam sistem','bg'=>'bg-biruTelurAsin'],
            ['icon'=>'shield','title'=>'Sistem Terpercaya','desc'=>'Dirancang dengan standar keamanan yang baik untuk menjaga integritas dan kerahasiaan data pengembangan kompetensi ASN','bg'=>'bg-biruLangit'],
            ['icon'=>'clock','title'=>'Efisiensi Waktu','desc'=>'Otomatisasi proses administrasi membantu memangkas waktu layanan dan meningkatkan produktivitas pengelolaan data kegiatan','bg'=>'bg-hijauToska'],
            ['icon'=>'award','title'=>'Sertifikat Digital','desc'=>'Penerbitan sertifikat dilakukan secara digital, cepat, dan mudah diakses sebagai bukti sah terlaksananya kegiatan Pengembangan Kompetensi ASN','bg'=>'bg-biruTelurAsin'],
            ];
            @endphp

            <!-- Fitur Cards -->
            @foreach($features as $f)
            <div class="group bg-white hover:bg-secondary-gradient rounded-3xl shadow-lg p-8 text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
                <!-- Icon Circle -->
                <div class="w-16 h-16 mx-auto mb-5 rounded-full {{ $f['bg'] }} flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:shadow-lg group-hover:bg-white/30">
                    <i data-lucide="{{ $f['icon'] }}" class="w-8 h-8 text-white transition-all duration-300 group-hover:text-black"></i>
                </div>

                <!-- Title -->
                <h3 class="font-bold text-lg mb-2 text-biruNavy transition-colors duration-300 group-hover:text-white/70">
                    {{ $f['title'] }}
                </h3>

                <!-- Description -->
                <p class="text-abuabuSedang font-normal text-sm leading-relaxed transition-colors duration-300 group-hover:text-white">
                    {{ $f['desc'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
</section>