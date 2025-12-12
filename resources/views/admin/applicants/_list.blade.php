<div class="flex overflow-x-auto whitespace-nowrap gap-2 mb-4 pb-2 scrollbar-hide">
    @php
    $getFilterLink = function($status) {
    $params = request()->all();
    if ($status === null) { unset($params['status']); } else { $params['status'] = $status; }
    $params['page'] = 1;
    return route('admin.applicants.index', $params);
    };
    $currentStatus = request('status');
    $c = $counts ?? ['all'=>0, 'pending'=>0, 'accepted'=>0, 'rejected'=>0];
    @endphp

    <a href="{{ $getFilterLink(null) }}" class="ajax-link px-4 py-2 rounded-full text-sm font-medium border {{ !$currentStatus ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300' }}">
        Semua <span class="ml-1 text-xs opacity-75">({{ $c['all'] }})</span>
    </a>
    <a href="{{ $getFilterLink('pending') }}" class="ajax-link px-4 py-2 rounded-full text-sm font-medium border {{ $currentStatus === 'pending' ? 'bg-yellow-500 text-white border-yellow-500' : 'bg-white text-gray-700 border-gray-300' }}">
        Menunggu <span class="ml-1 text-xs opacity-75">({{ $c['pending'] }})</span>
    </a>
    <a href="{{ $getFilterLink('accepted') }}" class="ajax-link px-4 py-2 rounded-full text-sm font-medium border {{ $currentStatus === 'accepted' ? 'bg-green-600 text-white border-green-600' : 'bg-white text-gray-700 border-gray-300' }}">
        Diterima <span class="ml-1 text-xs opacity-75">({{ $c['accepted'] }})</span>
    </a>
    <a href="{{ $getFilterLink('rejected') }}" class="ajax-link px-4 py-2 rounded-full text-sm font-medium border {{ $currentStatus === 'rejected' ? 'bg-red-600 text-white border-red-600' : 'bg-white text-gray-700 border-gray-300' }}">
        Ditolak <span class="ml-1 text-xs opacity-75">({{ $c['rejected'] }})</span>
    </a>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 hidden md:table">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                @php
                $getSortLink = function($col) {
                $params = request()->all();
                $params['sort'] = $col;
                $params['direction'] = request('direction') === 'asc' ? 'desc' : 'asc';
                unset($params['page']);
                return route('admin.applicants.index', $params);
                };
                $renderArrow = function($col) {
                return (request('sort', 'created_at') === $col) ? (request('direction', 'desc') === 'asc' ? '↑' : '↓') : '';
                };
                @endphp

                @foreach(['nama_lengkap'=>'Nama', 'institusi'=>'Institusi', 'stase'=>'Stase', 'created_at'=>'Tgl Daftar', 'status'=>'Status'] as $col => $label)
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                    <a href="{{ $getSortLink($col) }}" class="ajax-link flex items-center text-gray-500 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white group">
                        {{ $label }} <span class="ml-1">{{ $renderArrow($col) }}</span>
                    </a>
                </th>
                @endforeach
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($applicants as $item)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->nama_lengkap }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $item->nik }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    {{ Str::limit($item->institusi, 20) }} <br> <span class="text-xs">{{ $item->jurusan }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">{{ $item->stase }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $item->created_at->format('d/m/y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($item->status == 'pending') <span class="px-2 text-xs font-bold rounded bg-yellow-100 text-yellow-800">Pending</span>
                    @elseif($item->status == 'accepted') <span class="px-2 text-xs font-bold rounded bg-green-100 text-green-800">Diterima</span>
                    @else <span class="px-2 text-xs font-bold rounded bg-red-100 text-red-800">Ditolak</span> @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('admin.applicants.show', $item->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 font-bold">Review</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-10 text-center text-gray-500">Data tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TAMPILAN MOBILE (CARD VIEW) --}}
    <div class="block md:hidden space-y-4">
        @forelse($applicants as $item)
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow border border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $item->nama_lengkap }}</h3>
                    <p class="text-xs text-gray-500">{{ $item->institusi }}</p>
                </div>
                <div>
                    @if($item->status == 'pending') <span class="px-2 py-1 text-xs font-bold rounded bg-yellow-100 text-yellow-800">Pending</span>
                    @elseif($item->status == 'accepted') <span class="px-2 py-1 text-xs font-bold rounded bg-green-100 text-green-800">Diterima</span>
                    @else <span class="px-2 py-1 text-xs font-bold rounded bg-red-100 text-red-800">Ditolak</span> @endif
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 dark:text-gray-300 mb-4">
                <div><span class="block text-xs text-gray-400">Stase:</span> {{ $item->stase }}</div>
                <div><span class="block text-xs text-gray-400">Daftar:</span> {{ $item->created_at->format('d M Y') }}</div>
            </div>
            <div class="flex justify-end gap-3 border-t pt-3 border-gray-100 dark:border-gray-700">
                <form action="{{ route('admin.applicants.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 text-sm font-medium">Hapus</button>
                </form>
                <a href="{{ route('admin.applicants.show', $item->id) }}" class="text-white bg-indigo-600 px-4 py-1.5 rounded text-sm font-medium">Review</a>
            </div>
        </div>
        @empty
        <div class="text-center py-10 text-gray-500">Tidak ada data.</div>
        @endforelse
    </div>

    <div class="mt-4 px-4 py-2">
        <div id="pagination-wrapper">
            {{ $applicants->appends(request()->query())->links() }}
        </div>
    </div>
</div>