<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar Pelamar Magang') }}
            </h2>
            
            <div class="flex items-center gap-2">
                <form method="GET" action="{{ route('admin.applicants.index') }}" class="relative">
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                    @endif

                    <div class="flex items-center">
                        <input type="text" 
                                id="searchInput"
                                name="search" 
                                value="{{ request('search') }}" 
                                placeholder="Cari nama, stase, atau kampus..." 
                                class="w-64 rounded-l-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        
                        <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none transition ease-in-out duration-150 h-[38px] mt-[1px]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </div>
                </form>

                <a href="{{ route('admin.applicants.export') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none transition ease-in-out duration-150 h-[38px]">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                @php
                                    $getSortLink = function($col) {
                                        $params = request()->all();
                                        $params['sort'] = $col;
                                        $params['direction'] = request('direction') === 'asc' ? 'desc' : 'asc';
                                        return route('admin.applicants.index', $params);
                                    };
                                    
                                    $renderArrow = function($col) {
                                        if (request('sort', 'created_at') === $col) {
                                            return request('direction', 'desc') === 'asc' ? '↑' : '↓';
                                        }
                                        return '';
                                    };
                                @endphp

                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    <a href="{{ $getSortLink('nama_lengkap') }}" class="flex items-center text-gray-500 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white group">
                                        Nama Pelamar
                                        <span class="ml-1 text-gray-400 group-hover:text-gray-600">{{ $renderArrow('nama_lengkap') }}</span>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    <a href="{{ $getSortLink('institusi') }}" class="flex items-center text-gray-500 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white group">
                                        Institusi
                                        <span class="ml-1 text-gray-400 group-hover:text-gray-600">{{ $renderArrow('institusi') }}</span>
                                    </a>
                                </th>
                                
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    <a href="{{ $getSortLink('stase') }}" class="flex items-center text-gray-500 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white group">
                                        Stase
                                        <span class="ml-1 text-gray-400 group-hover:text-gray-600">{{ $renderArrow('stase') }}</span>
                                    </a>
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    <a href="{{ $getSortLink('jurusan') }}" class="flex items-center text-gray-500 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white group">
                                        Jurusan
                                        <span class="ml-1 text-gray-400 group-hover:text-gray-600">{{ $renderArrow('jurusan') }}</span>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    <a href="{{ $getSortLink('created_at') }}" class="flex items-center text-gray-500 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white group">
                                        Tgl Daftar
                                        <span class="ml-1 text-gray-400 group-hover:text-gray-600">{{ $renderArrow('created_at') }}</span>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                    <a href="{{ $getSortLink('status') }}" class="flex items-center text-gray-500 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white group">
                                        Status
                                        <span class="ml-1 text-gray-400 group-hover:text-gray-600">{{ $renderArrow('status') }}</span>
                                    </a>
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tableBody" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @include('admin.applicants._table_body')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('tableBody');
            let timeout = null;

            searchInput.addEventListener('input', function () {
                const keyword = this.value;

                clearTimeout(timeout);
                
                timeout = setTimeout(() => {
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', keyword);

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
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