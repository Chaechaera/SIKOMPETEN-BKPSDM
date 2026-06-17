<section id="alurProses" class="py-20 px-8 bg-biruCerah/20">
    <h2 class="text-center text-3xl text-biruNavy font-bold mb-12">
        Alur Proses <span class="text-hijauToska">SIKOMPETEN</span>
    </h2>

    <div class="grid md:grid-cols-5 gap-7 max-w-7xl mx-auto">
        <!-- Steps Array -->
        @php
        $steps = [
        ['1','Pengajuan Usulan','OPD mengajukan usulan kegiatan Pengembangan Kompetensi ASN secara online'],
        ['2','Verifikasi BKPSDM','BKPSDM melakukan verifikasi usulan kegiatan Pengembangan Kompetensi ASN'],
        ['3','Pelaksanaan Kegiatan','Kegiatan Pengembangan Kompetensi ASN yang disetujui dilaksanakan sesuai jadwal'],
        ['4','Pelaporan Kegiatan','OPD melaporkan hasil kegiatan Pengembangan Kompetensi ASN secara online'],
        ['5','Sertifikat Digital','BKPSDM melakukan proses verifikasi pelaporan kegiatan dan menerbitkan sertifikat digital'],
        ];
        @endphp

        <!-- Steps Cards -->
        @foreach($steps as $s)
        <div class="group bg-white hover:bg-biruCerah/40 rounded-xl shadow-md p-6 text-center transition-all duration-300 hover:-translate-y-2 hover:shadow-xl cursor-pointer">
            <!-- Circle Number -->
            <div
                class="w-16 h-16 mx-auto mb-5 rounded-full
                       bg-hijauToska
                       flex items-center justify-center
                       text-white text-3xl font-bold
                       transition-all duration-300
                       group-hover:scale-110 group-hover:shadow-lg group-hover:bg-biruLangit">
                {{ $s[0] }}
            </div>

            <!-- Title -->
            <p class=" font-bold text-lg mb-2 text-biruNavy transition-colors duration-300">
                {{ $s[1] }}
            </p>

            <!-- Description -->
            <p class="text-abuabuSedang font-normal text-sm leading-relaxed transition-colors duration-300 group-hover:text-biruMariana">
                {{ $s[2] }}
            </p>

        </div>
        @endforeach
    </div>
</section>