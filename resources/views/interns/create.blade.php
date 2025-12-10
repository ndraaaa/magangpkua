<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Lengkapi Biodata Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 transition-colors duration-200">
                
                {{-- Tampilkan Error Validasi --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-300 p-4 rounded-lg text-sm">
                        <p class="font-bold mb-2">Terjadi kesalahan input, mohon periksa kembali:</p>
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        {{-- Peringatan File --}}
                        <p class="mt-3 text-xs font-semibold italic text-red-500 dark:text-red-400">
                            *Catatan: Mohon pilih ulang kembali SEMUA file dokumen yang akan diupload.
                        </p>
                    </div>
                @endif

                <form action="{{ route('biodata.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">Data Pribadi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Pas Foto Resmi (4x6)</label>
                            <input type="file" name="pas_foto" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:outline-none">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG, Wajah terlihat jelas.</p>
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nama Lengkap</label>
                            {{-- LOGIC: Gunakan data old() jika ada error, jika tidak ada, gunakan data User Login --}}
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', Auth::user()->name) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">NIK (KTP)</label>
                            <input type="number" name="nik" value="{{ old('nik') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">No HP / WA</label>
                            <input type="text" name="nomor_hp" value="{{ old('nomor_hp') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Alamat</label>
                            <input type="text" name="alamat" value="{{ old('alamat') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700 mt-8">Data Akademik</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Asal Kampus / Sekolah</label>
                            <input type="text" name="institusi" value="{{ old('institusi') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">NIM / NISN</label>
                            <input type="text" name="nim" value="{{ old('nim') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Prodi / Jurusan</label>
                            <input type="text" name="jurusan" value="{{ old('jurusan') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Semester Saat Ini</label>
                            <input type="number" name="semester" value="{{ old('semester') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Stase / Bagian Magang</label>
                            <input type="text" name="stase" value="{{ old('stase') }}" placeholder="Contoh: IT Support / Humas" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Pembimbing Akademik (Nama & Gelar)</label>
                            <input type="text" name="pembimbing_akademik" value="{{ old('pembimbing_akademik') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Tanggal Berakhir</label>
                            <input type="date" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700 mt-8">Dokumen Kelengkapan</h3>
                    <p class="text-sm text-red-500 dark:text-red-400 mb-4 font-semibold">*Jika terjadi error, mohon upload ulang file dokumen di bawah ini.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Surat Lamaran (PDF)</label>
                            <input type="file" name="surat_lamaran" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Daftar Riwayat Hidup / CV (PDF)</label>
                            <input type="file" name="cv" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Ijazah Terakhir (PDF)</label>
                            <input type="file" name="ijazah" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Transkrip Nilai (PDF)</label>
                            <input type="file" name="transkrip" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Kartu Keluarga / KK (PDF/JPG)</label>
                            <input type="file" name="kk" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:outline-none">
                        </div>

                        <div class="col-span-1 md:col-span-2 bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Surat Ijin Bekerja (Wajib pakai Template)</label>
                            
                            <div class="flex items-center space-x-4 mb-3">
                                <a href="{{ asset('assets/template_surat_ijin.docx') }}" download class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Download Template
                                </a>
                                <span class="text-sm text-gray-500 dark:text-gray-400">Download, isi, lalu upload kembali di bawah ini.</span>
                            </div>

                            <input type="file" name="surat_ijin" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:outline-none">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform transition hover:scale-105">
                            Simpan & Kirim Biodata
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>