@forelse($applicants as $item)
    <tr>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->nama_lengkap }}</div>
            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $item->nik }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $item->institusi }}</td>

        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 font-medium">
            {{ $item->stase }}
        </td>

        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $item->jurusan }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
            {{ $item->created_at->format('d M Y') }}</td>
        <td class="px-6 py-4 whitespace-nowrap">
            @if ($item->status == 'pending')
                <span
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
            @elseif($item->status == 'accepted')
                <span
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Diterima</span>
            @else
                <span
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
            @endif
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.applicants.show', $item->id) }}"
                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 font-bold">
                    Review
                </a>

                <form action="{{ route('admin.applicants.destroy', $item->id) }}" method="POST"
                    onsubmit="return confirm('PERINGATAN: Menghapus data ini akan menghapus AKUN USER dan BIODATA secara permanen. Lanjutkan?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 hover:underline">
                        Hapus
                    </button>
                </form>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
            <div class="flex flex-col items-center justify-center">
                <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-base font-medium">Data tidak ditemukan.</p>
            </div>
        </td>
    </tr>
@endforelse
