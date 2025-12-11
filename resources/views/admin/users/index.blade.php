<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar Admin') }}
            </h2>
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-lg shadow-sm">
                + Tambah Admin
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan Error/Sukses --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Form Pencarian (REALTIME) --}}
                <div class="mb-4 flex justify-end">
                    <form method="GET" action="{{ route('admin.users.index') }}" onsubmit="return false;"> {{-- Prevent Default Submit --}}
                        <input type="text" 
                               id="searchInput" {{-- ID UNTUK JS --}}
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari nama atau email..." 
                               autocomplete="off"
                               class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm w-64">
                    </form>
                </div>

                {{-- Tabel Admin --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Dibuat</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        
                        {{-- ID UNTUK JS --}}
                        <tbody id="tableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            {{-- Panggil Partial View --}}
                            @include('admin.users._table_body')
                        </tbody>
                    </table>
                </div>

                {{-- Pagination (Akan reload page jika diklik, tapi search tetap jalan) --}}
                <div class="mt-4">
                    {{ $admins->appends(['search' => request('search')])->links() }}
                </div>

            </div>
        </div>
    </div>

    {{-- SCRIPT SEARCH REALTIME --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('tableBody');
            let timeout = null;

            searchInput.addEventListener('input', function () {
                const keyword = this.value;

                // Debounce 500ms
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    // Update URL agar saat direfresh, pencarian tidak hilang
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', keyword);
                    url.searchParams.set('page', 1); // Reset ke page 1
                    window.history.pushState(null, '', url);
                    
                    // Fetch AJAX
                    fetch(url, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(response => response.text())
                    .then(html => {
                        tableBody.innerHTML = html;
                    })
                    .catch(error => console.error('Error:', error));
                    
                }, 500);
            });
        });
    </script>
</x-app-layout>