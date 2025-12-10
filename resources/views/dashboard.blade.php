<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ================= TAMPILAN ADMIN ================= --}}
            @if(Auth::user()->role === 'admin')
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Total Pelamar</div>
                        <div class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $data['total_pelamar'] }}</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Menunggu Review</div>
                        <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $data['pending'] }}</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Diterima</div>
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $data['diterima'] }}</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                        <div class="text-gray-500 dark:text-gray-400 text-sm">Ditolak</div>
                        <div class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $data['ditolak'] }}</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">5 Pendaftar Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kampus</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jurusan</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Daftar</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($data['terbaru'] as $item)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $item->nama_lengkap }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $item->institusi }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $item->jurusan }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $item->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm">
                                        @if($item->status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                        @elseif($item->status == 'accepted')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Diterima</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada pendaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>


            {{-- ================= TAMPILAN PEMAGANG ================= --}}
            @else
                
                {{-- KONDISI 1: BELUM ISI BIODATA --}}
                @if(!$profile)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">Halo, {{ Auth::user()->name }}!</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Anda belum melengkapi biodata magang. Silakan lengkapi untuk melanjutkan proses pendaftaran.</p>
                        
                        <a href="{{ route('biodata.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg transform transition hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Isi Biodata Sekarang
                        </a>
                    </div>
                
                {{-- KONDISI 2: SUDAH ISI (TAMPILKAN STATUS) --}}
                @else
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Status Lamaran Anda</h3>
                        
                        {{-- STATUS PENDING --}}
                        @if($profile->status == 'pending')
                            <div class="bg-yellow-50 dark:bg-yellow-900/30 border-l-4 border-yellow-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700 dark:text-yellow-200">
                                            Biodata Anda berhasil dikirim dan sedang <strong>menunggu review</strong> oleh Admin/HRD. Mohon cek berkala.
                                        </p>
                                    </div>
                                </div>
                            </div>

                        {{-- STATUS DITERIMA --}}
                        @elseif($profile->status == 'accepted')
                            <div class="bg-green-50 dark:bg-green-900/30 border-l-4 border-green-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800 dark:text-green-200">Selamat! Lamaran Diterima</h3>
                                        <div class="mt-2 text-sm text-green-700 dark:text-green-300">
                                            <p>Anda telah diterima untuk magang. Silakan hubungi admin atau datang ke kantor pada tanggal {{ \Carbon\Carbon::parse($profile->tanggal_mulai)->format('d F Y') }}.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        {{-- STATUS DITOLAK --}}
                        @elseif($profile->status == 'rejected')
                            <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700 dark:text-red-200">
                                            Mohon maaf, lamaran magang Anda belum dapat kami terima saat ini.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-6">
                            <a href="{{ route('biodata.show') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 font-medium">
                                &rarr; Lihat Detail Biodata Saya
                            </a>
                        </div>
                    </div>
                @endif

            @endif

        </div>
    </div>
</x-app-layout>