@props(['title', 'path'])

<li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
    <div class="w-0 flex-1 flex items-center">
        <svg class="flex-shrink-0 h-5 w-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
        </svg>
        <span class="ml-2 flex-1 w-0 truncate dark:text-gray-200"> {{ $title }} </span>
    </div>
    <div class="ml-4 flex-shrink-0">
        <a href="{{ asset('storage/' . $path) }}" target="_blank" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
            Lihat / Download
        </a>
    </div>
</li>