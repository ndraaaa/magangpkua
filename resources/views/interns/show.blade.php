<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Biodata Saya') }}
            </h2>
            <a href="{{ route('biodata.edit') }}"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg shadow-sm transition">
                Edit Biodata
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div
                class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg mb-6 p-6 transition-colors duration-200">
                <div class="md:flex items-start space-x-0 md:space-x-6">
                    <div class="flex-shrink-0 mb-4 md:mb-0">
                        @if ($profile->pas_foto_path)
                            <img class="w-32 h-40 object-cover rounded-lg border-4 border-gray-100 dark:border-gray-700 shadow-sm"
                                src="{{ asset('storage/' . $profile->pas_foto_path) }}" alt="Pas Foto">
                        @else
                            <div
                                class="w-32 h-40 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-500">
                                No Photo
                            </div>
                        @endif
                    </div>

                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    {{ $profile->nama_lengkap }}</h1>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $profile->nim }} |
                                    {{ $profile->jurusan }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $profile->institusi }}</p>
                            </div>

                            <div>
                                @if ($profile->status === 'pending')
                                    <span
                                        class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 border border-yellow-200 dark:border-yellow-800">
                                        Menunggu Review
                                    </span>
                                @elseif($profile->status === 'accepted')
                                    <span
                                        class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 border border-green-200 dark:border-green-800">
                                        Diterima Magang
                                    </span>
                                @elseif($profile->status === 'rejected')
                                    <span
                                        class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 border border-red-200 dark:border-red-800">
                                        Maaf, Belum Diterima
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                {{ $profile->nomor_hp }}
                            </div>
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ Str::limit($profile->alamat, 40) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg transition-colors duration-200">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">Detail Informasi</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Data lengkap pribadi dan
                        akademik.</p>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700">
                    <dl>
                        <div
                            class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 transition-colors duration-200">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">NIK (KTP)</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                {{ $profile->nik }}</dd>
                        </div>

                        <div
                            class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 transition-colors duration-200">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Alamat Lengkap</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                {{ $profile->alamat }}</dd>
                        </div>

                        <div
                            class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 transition-colors duration-200">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Semester / Stase</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                Semester {{ $profile->semester }} - Bagian: {{ $profile->stase }}
                            </dd>
                        </div>

                        <div
                            class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 transition-colors duration-200">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Periode Magang</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                {{ \Carbon\Carbon::parse($profile->tanggal_mulai)->format('d F Y') }}
                                <span class="mx-2 text-gray-400">s/d</span>
                                {{ \Carbon\Carbon::parse($profile->tanggal_berakhir)->format('d F Y') }}
                            </dd>
                        </div>

                        <div
                            class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 transition-colors duration-200">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Pembimbing Akademik</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                {{ $profile->pembimbing_akademik }}</dd>
                        </div>

                        <div
                            class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 transition-colors duration-200">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Dokumen Lampiran</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                <ul role="list"
                                    class="border border-gray-200 dark:border-gray-600 rounded-md divide-y divide-gray-200 dark:divide-gray-600">

                                    {{-- Component Item Dokumen (Looping Manual) --}}

                                    {{-- 1. Surat Lamaran --}}
                                    @if ($profile->doc_surat_lamaran_path)
                                        <x-document-list-item title="Surat Lamaran" :path="$profile->doc_surat_lamaran_path" />
                                    @endif

                                    {{-- 2. CV --}}
                                    @if ($profile->cv_path)
                                        <x-document-list-item title="Curriculum Vitae (CV)" :path="$profile->cv_path" />
                                    @endif

                                    {{-- 3. Ijazah --}}
                                    @if ($profile->doc_ijazah_path)
                                        <x-document-list-item title="Ijazah Terakhir" :path="$profile->doc_ijazah_path" />
                                    @endif

                                    {{-- 4. Transkrip --}}
                                    @if ($profile->transkrip_path)
                                        <x-document-list-item title="Transkrip Nilai" :path="$profile->transkrip_path" />
                                    @endif

                                    {{-- 5. KK --}}
                                    @if ($profile->doc_kk_path)
                                        <x-document-list-item title="Kartu Keluarga (KK)" :path="$profile->doc_kk_path" />
                                    @endif

                                    {{-- 6. Surat Ijin --}}
                                    @if ($profile->doc_surat_ijin_path)
                                        <x-document-list-item title="Surat Ijin Bekerja" :path="$profile->doc_surat_ijin_path" />
                                    @endif

                                </ul>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

{{-- DEFINISI KOMPONEN KECIL (Bisa dipisah ke file komponen, tapi ditaruh disini biar praktis copy-paste) --}}
@verbatim
    <?php
    // Trick Blade component inline (agar tidak perlu buat file baru untuk list item)
    // Jika error, hapus blok ini dan copy HTML list item manual
    ?>
@endverbatim
