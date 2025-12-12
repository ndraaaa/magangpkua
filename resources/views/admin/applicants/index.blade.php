<x-app-layout>
    <x-slot name="header">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Pelamar') }}
        </h2>
        
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full md:w-auto">
            
            <form method="GET" action="{{ route('admin.applicants.index') }}" class="relative w-full sm:w-auto">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    <input type="hidden" name="direction" value="{{ request('direction') }}">
                @endif

                <div class="flex items-center w-full">
                    <input type="text" 
                           id="searchInput" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari..." 
                           class="w-full sm:w-64 rounded-l-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    
                    <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 h-[38px] mt-[1px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
            </form>

            <a href="{{ route('admin.applicants.export') }}" class="justify-center inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 h-[38px] w-full sm:w-auto">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Excel
            </a>
        </div>
    </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div id="data-container" class="transition-opacity duration-200">
                    @include('admin.applicants._list')
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('data-container');
            const searchInput = document.getElementById('searchInput');
            let timeout = null;

            function fetchData(url) {
                container.style.opacity = '0.5';
                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.text())
                .then(html => {
                    container.innerHTML = html;
                    container.style.opacity = '1';
                    window.history.pushState(null, '', url);
                });
            }

            searchInput.addEventListener('input', function () {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', this.value);
                    url.searchParams.set('page', 1);
                    fetchData(url);
                }, 500);
            });

            container.addEventListener('click', function (e) {
                const link = e.target.closest('.pagination a') || e.target.closest('a.ajax-link');
                if (link) {
                    e.preventDefault();
                    fetchData(link.href);
                }
            });

            window.addEventListener('popstate', () => fetchData(window.location.href));
        });
    </script>
</x-app-layout>