@forelse($admins as $admin)
<tr>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm font-medium text-gray-900 dark:text-white">
            {{ $admin->name }}
            @if($admin->id === Auth::id())
            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Anda</span>
            @endif
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
        {{ $admin->email }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
        {{ $admin->created_at->format('d M Y') }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        @if($admin->id !== Auth::id())
        <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus Admin ini?');" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 hover:underline">
                Hapus
            </button>
        </form>
        @else
        <span class="text-gray-400 text-xs italic">Sedang Login</span>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
        Tidak ada data admin ditemukan.
    </td>
</tr>
@endforelse