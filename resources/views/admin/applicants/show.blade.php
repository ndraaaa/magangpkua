<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Review Pelamar: ') . $profile->nama_lengkap }}
            </h2>
            <a href="{{ route('admin.applicants.index') }}"
                class="text-sm text-gray-600 dark:text-gray-400 hover:underline">&larr; Kembali ke Daftar</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- KOTAK AKSI / KEPUTUSAN ADMIN --}}
            <div
                class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg mb-6 p-6 border-l-4 border-indigo-500 transition-colors duration-200">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Keputusan Admin</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">Silakan cek berkas di bawah ini sebelum
                    memberikan keputusan.</p>

                <div class="flex flex-wrap gap-4">
                    <form action="{{ route('admin.applicants.update_status', $profile->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="accepted">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150 {{ $profile->status == 'accepted' ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Terima Magang
                        </button>
                    </form>

                    <form action="{{ route('admin.applicants.update_status', $profile->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150 {{ $profile->status == 'rejected' ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Tolak Lamaran
                        </button>
                    </form>

                    <form action="{{ route('admin.applicants.update_status', $profile->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="pending">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Reset Status
                        </button>
                    </form>
                </div>
            </div>

            {{-- DETAIL BIODATA LENGKAP --}}
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg transition-colors duration-200">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">Detail Biodata Lengkap
                    </h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">Informasi pribadi, akademik, dan
                        dokumen.</p>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700">
                    <dl>
                        <div
                            class="px-4 py-2 bg-gray-100 dark:bg-gray-900 font-bold text-gray-700 dark:text-gray-300 border-b dark:border-gray-700">
                            I. Data Pribadi
                        </div>

                        <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Pas Foto</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                @if ($profile->pas_foto_path)
                                    <a href="{{ asset('storage/' . $profile->pas_foto_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $profile->pas_foto_path) }}"
                                            class="h-32 w-24 object-cover rounded border border-gray-300 dark:border-gray-600 shadow-sm">
                                    </a>
                                @else
                                    <span class="text-red-500 italic">Tidak ada foto</span>
                                @endif
                            </dd>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Nama Lengkap</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                {{ $profile->nama_lengkap }}</dd>
                        </div>

                        <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">NIK (KTP)</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                {{ $profile->nik }}</dd>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Nomor HP / WA</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                {{ $profile->nomor_hp }}</dd>
                        </div>

                        <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Alamat Domisili</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                {{ $profile->alamat }}</dd>
                        </div>

                        <div
                            class="px-4 py-2 bg-gray-100 dark:bg-gray-900 font-bold text-gray-700 dark:text-gray-300 border-y dark:border-gray-700 mt-4">
                            II. Data Akademik
                        </div>

                        <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Institusi (Kampus/Sekolah)
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                {{ $profile->institusi }}</dd>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">NIM - Jurusan</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                {{ $profile->nim }} - {{ $profile->jurusan }}</dd>
                        </div>

                        <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Semester & Bagian</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                Semester: {{ $profile->semester }} <br>
                                Stase/Bagian: {{ $profile->stase }}
                            </dd>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Pembimbing Akademik</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                {{ $profile->pembimbing_akademik }}</dd>
                        </div>

                        <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Rencana Periode Magang</dt>
                            <dd
                                class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2 font-semibold">
                                {{ \Carbon\Carbon::parse($profile->tanggal_mulai)->format('d F Y') }}
                                <span class="mx-2 font-normal">s/d</span>
                                {{ \Carbon\Carbon::parse($profile->tanggal_berakhir)->format('d F Y') }}
                            </dd>
                        </div>

                        <div
                            class="px-4 py-2 bg-gray-100 dark:bg-gray-900 font-bold text-gray-700 dark:text-gray-300 border-y dark:border-gray-700 mt-4">
                            III. Dokumen Kelengkapan
                        </div>

                        <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">File Lampiran</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100 sm:mt-0 sm:col-span-2">
                                <ul
                                    class="border border-gray-200 dark:border-gray-600 rounded-md divide-y divide-gray-200 dark:divide-gray-600">

                                    @if ($profile->doc_surat_lamaran_path)
                                        <x-document-list-item title="Surat Lamaran" :path="$profile->doc_surat_lamaran_path" />
                                    @endif

                                    @if ($profile->cv_path)
                                        <x-document-list-item title="Curriculum Vitae (CV)" :path="$profile->cv_path" />
                                    @endif

                                    @if ($profile->doc_ijazah_path)
                                        <x-document-list-item title="Ijazah Terakhir" :path="$profile->doc_ijazah_path" />
                                    @endif

                                    @if ($profile->transkrip_path)
                                        <x-document-list-item title="Transkrip Nilai" :path="$profile->transkrip_path" />
                                    @endif

                                    @if ($profile->doc_kk_path)
                                        <x-document-list-item title="Kartu Keluarga (KK)" :path="$profile->doc_kk_path" />
                                    @endif

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
