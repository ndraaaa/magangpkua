<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Biodata Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 transition-colors duration-200">
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 dark:bg-red-900/50 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-300 p-4 rounded-lg text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM UPDATE --}}
                <form action="{{ route('biodata.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') {{-- WAJIB ADA UNTUK UPDATE --}}

                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700">Data Pribadi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Pas Foto (Biarkan kosong jika tidak ingin ganti)</label>
                            
                            {{-- Preview Foto Lama --}}
                            @if($profile->pas_foto_path)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $profile->pas_foto_path) }}" class="h-20 w-16 object-cover rounded border dark:border-gray-600">
                                </div>
                            @endif
                            
                            <input type="file" name="pas_foto" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $profile->nama_lengkap) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">NIK (KTP)</label>
                            <input type="number" name="nik" value="{{ old('nik', $profile->nik) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">No HP / WA</label>
                            <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $profile->nomor_hp) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Alamat Domisili</label>
                            <input type="text" name="alamat" value="{{ old('alamat', $profile->alamat) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700 mt-8">Data Akademik</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Asal Kampus / Sekolah</label>
                            <input type="text" name="institusi" value="{{ old('institusi', $profile->institusi) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">NIM / NISN</label>
                            <input type="text" name="nim" value="{{ old('nim', $profile->nim) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Prodi / Jurusan</label>
                            <input type="text" name="jurusan" value="{{ old('jurusan', $profile->jurusan) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Semester Saat Ini</label>
                            <input type="number" name="semester" value="{{ old('semester', $profile->semester) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Stase / Bagian Magang</label>
                            <input type="text" name="stase" value="{{ old('stase', $profile->stase) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Pembimbing Akademik</label>
                            <input type="text" name="pembimbing_akademik" value="{{ old('pembimbing_akademik', $profile->pembimbing_akademik) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $profile->tanggal_mulai) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Tanggal Berakhir</label>
                            <input type="date" name="tanggal_berakhir" value="{{ old('tanggal_berakhir', $profile->tanggal_berakhir) }}" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2 border-gray-200 dark:border-gray-700 mt-8">Dokumen Kelengkapan</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">*Upload file baru HANYA jika ingin mengganti dokumen yang lama.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        
                        {{-- COMPONENT INPUT FILE (Diulang untuk setiap file) --}}
                        {{-- Surat Lamaran --}}
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                Surat Lamaran 
                                @if($profile->doc_surat_lamaran_path) 
                                    <span class="text-green-600 text-xs font-normal">(Sudah ada, <a href="{{ asset('storage/'.$profile->doc_surat_lamaran_path) }}" target="_blank" class="underline">Lihat</a>)</span> 
                                @endif
                            </label>
                            <input type="file" name="surat_lamaran" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:outline-none">
                        </div>

                        {{-- CV --}}
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                Daftar Riwayat Hidup / CV
                                @if($profile->cv_path) 
                                    <span class="text-green-600 text-xs font-normal">(Sudah ada, <a href="{{ asset('storage/'.$profile->cv_path) }}" target="_blank" class="underline">Lihat</a>)</span> 
                                @endif
                            </label>
                            <input type="file" name="cv" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:outline-none">
                        </div>

                        {{-- Ijazah --}}
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                Ijazah Terakhir
                                @if($profile->doc_ijazah_path) 
                                    <span class="text-green-600 text-xs font-normal">(Sudah ada, <a href="{{ asset('storage/'.$profile->doc_ijazah_path) }}" target="_blank" class="underline">Lihat</a>)</span> 
                                @endif
                            </label>
                            <input type="file" name="ijazah" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:outline-none">
                        </div>

                        {{-- Transkrip --}}
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                Transkrip Nilai
                                @if($profile->transkrip_path) 
                                    <span class="text-green-600 text-xs font-normal">(Sudah ada, <a href="{{ asset('storage/'.$profile->transkrip_path) }}" target="_blank" class="underline">Lihat</a>)</span> 
                                @endif
                            </label>
                            <input type="file" name="transkrip" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:outline-none">
                        </div>

                        {{-- KK --}}
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                Kartu Keluarga (KK)
                                @if($profile->doc_kk_path) 
                                    <span class="text-green-600 text-xs font-normal">(Sudah ada, <a href="{{ asset('storage/'.$profile->doc_kk_path) }}" target="_blank" class="underline">Lihat</a>)</span> 
                                @endif
                            </label>
                            <input type="file" name="kk" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:outline-none">
                        </div>

                        {{-- Surat Ijin --}}
                        <div class="col-span-1 md:col-span-2">
                            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">
                                Surat Ijin Bekerja (Upload Ulang Template)
                                @if($profile->doc_surat_ijin_path) 
                                    <span class="text-green-600 text-xs font-normal">(Sudah ada, <a href="{{ asset('storage/'.$profile->doc_surat_ijin_path) }}" target="_blank" class="underline">Lihat</a>)</span> 
                                @endif
                            </label>
                            <input type="file" name="surat_ijin" class="block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 focus:outline-none">
                        </div>

                    </div>

                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('biodata.show') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transform transition hover:scale-105">
                            Update Biodata
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>