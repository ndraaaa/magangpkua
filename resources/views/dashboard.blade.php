<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div x-data="{ isProfileInfoModal: false }">
                        <div class="p-5 mb-6 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
                            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">
                                        Personal Information
                                    </h4>

                                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
                                        <div>
                                            <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">First Name</p>
                                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">Musharof</p>
                                        </div>

                                        <div>
                                            <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">Last Name</p>
                                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">Chowdhury</p>
                                        </div>

                                        <div>
                                            <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">Email address</p>
                                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">randomuser@pimjo.com</p>
                                        </div>

                                        <div>
                                            <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">Phone</p>
                                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">+09 363 398 46</p>
                                        </div>

                                        <div>
                                            <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">Bio</p>
                                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">Team Manager</p>
                                        </div>
                                    </div>
                                </div>

                                <button class="edit-button" @click="isProfileInfoModal = true">
                                    <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.0911 2.78206C14.2125 1.90338 12.7878 1.90338 11.9092 2.78206L4.57524 10.116C4.26682 10.4244 4.0547 10.8158 3.96468 11.2426L3.31231 14.3352C3.25997 14.5833 3.33653 14.841 3.51583 15.0203C3.69512 15.1996 3.95286 15.2761 4.20096 15.2238L7.29355 14.5714C7.72031 14.4814 8.11172 14.2693 8.42013 13.9609L15.7541 6.62695C16.6327 5.74827 16.6327 4.32365 15.7541 3.44497L15.0911 2.78206Z" />
                                    </svg>
                                    Edit
                                </button>
                            </div>
                        </div>

                        {{-- Modal --}}
                        <div x-show="isProfileInfoModal"
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4 backdrop-blur-sm"
                            x-transition>
                            <div class="relative w-full max-w-[700px] rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11"
                                @click.away="isProfileInfoModal = false">

                                {{-- Close button --}}
                                <button @click="isProfileInfoModal = false"
                                    class="absolute right-5 top-5 flex h-11 w-11 items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
                                    ✕
                                </button>

                                <div class="px-2 pr-14">
                                    <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">
                                        Edit Personal Information
                                    </h4>
                                    <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                                        Update your details to keep your profile up-to-date.
                                    </p>
                                </div>

                                <form class="flex flex-col">
                                    <div class="h-[458px] overflow-y-auto p-2">
                                        {{-- Form fields --}}

                                        <h5 class="mb-5 text-lg font-medium text-gray-800 dark:text-white/90">
                                            Social Links
                                        </h5>

                                        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                                            <div>
                                                <label class="text-sm font-medium text-gray-700 dark:text-gray-400">Facebook</label>
                                                <input type="text" value="https://www.facebook.com/PimjoHQ"
                                                    class="input-theme" />
                                            </div>

                                            <div>
                                                <label class="text-sm font-medium text-gray-700 dark:text-gray-400">X.com</label>
                                                <input type="text" value="https://x.com/PimjoHQ"
                                                    class="input-theme" />
                                            </div>

                                            <div>
                                                <label class="text-sm font-medium text-gray-700 dark:text-gray-400">LinkedIn</label>
                                                <input type="text" value="https://www.linkedin.com/company/pimjo/"
                                                    class="input-theme" />
                                            </div>

                                            <div>
                                                <label class="text-sm font-medium text-gray-700 dark:text-gray-400">Instagram</label>
                                                <input type="text" value="https://instagram.com/PimjoHQ"
                                                    class="input-theme" />
                                            </div>
                                        </div>

                                        <div class="mt-7">
                                            <h5 class="mb-5 text-lg font-medium text-gray-800 dark:text-white/90">
                                                Personal Information
                                            </h5>

                                            <div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                                                <div>
                                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-400">First Name</label>
                                                    <input type="text" value="Musharof" class="input-theme" />
                                                </div>

                                                <div>
                                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-400">Last Name</label>
                                                    <input type="text" value="Chowdhury" class="input-theme" />
                                                </div>

                                                <div>
                                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-400">Email</label>
                                                    <input type="text" value="emirhanboruch55@gmail.com" class="input-theme" />
                                                </div>

                                                <div>
                                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-400">Phone</label>
                                                    <input type="text" value="+09 363 398 46" class="input-theme" />
                                                </div>

                                                <div class="col-span-2">
                                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-400">Bio</label>
                                                    <input type="text" value="Team Manager" class="input-theme" />
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="flex items-center gap-3 mt-6 lg:justify-end">
                                        <button type="button" @click="isProfileInfoModal = false"
                                            class="btn-secondary">Close</button>

                                        <button type="button"
                                            @click="alert('Profile saved!'); isProfileInfoModal = false"
                                            class="btn-primary">
                                            Save Changes
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="p-5 border border-gray-200 rounded-2xl dark:border-gray-800 lg:p-6">
                            <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-6">Address
                                    </h4>

                                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-7 2xl:gap-x-32">
                                        <div>
                                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                                Country</p>
                                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">United
                                                States</p>
                                        </div>

                                        <div>
                                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                                City/State</p>
                                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">Phoenix,
                                                United States</p>
                                        </div>

                                        <div>
                                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                                Postal Code</p>
                                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">ERT 2489</p>
                                        </div>

                                        <div>
                                            <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">TAX
                                                ID</p>
                                            <p class="text-sm font-medium text-gray-800 dark:text-white/90">AS4568384
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <button onclick="openAddressModal()"
                                    class="flex w-full items-center justify-center gap-2 rounded-full border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 lg:inline-flex lg:w-auto">
                                    <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18">
                                        <path d="M15.0911 2.78206C14.2125 1.90338 12.7878..." />
                                    </svg>
                                    Edit
                                </button>
                            </div>
                        </div>

                        <!-- MODAL -->
                        <div id="addressModal" style="display:none;">
                            <div
                                class="no-scrollbar relative w-full max-w-[700px] overflow-y-auto rounded-3xl bg-white p-4 dark:bg-gray-900 lg:p-11">
                                <button onclick="closeAddressModal()"
                                    class="absolute right-5 top-5 h-11 w-11 flex items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 dark:bg-gray-700">
                                    ✕
                                </button>

                                <div class="px-2 pr-14">
                                    <h4 class="mb-2 text-2xl font-semibold text-gray-800 dark:text-white/90">Edit
                                        Address</h4>
                                    <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">Update your details to keep
                                        your profile up-to-date.</p>
                                </div>

                                <form class="flex flex-col">
                                    <div class="px-2 overflow-y-auto custom-scrollbar">
                                        <div class="grid grid-cols-1 gap-x-6 gap-y-5 lg:grid-cols-2">

                                            <div>
                                                <label
                                                    class="mb-1.5 block text-sm font-medium text-gray-700">Country</label>
                                                <input type="text" value="United States"
                                                    class="h-11 w-full rounded-lg border border-gray-300 px-4" />
                                            </div>

                                            <div>
                                                <label
                                                    class="mb-1.5 block text-sm font-medium text-gray-700">City/State</label>
                                                <input type="text" value="Phoenix, Arizona, United States"
                                                    class="h-11 w-full rounded-lg border border-gray-300 px-4" />
                                            </div>

                                            <div>
                                                <label class="mb-1.5 block text-sm font-medium text-gray-700">Postal
                                                    Code</label>
                                                <input type="text" value="ERT 2489"
                                                    class="h-11 w-full rounded-lg border border-gray-300 px-4" />
                                            </div>

                                            <div>
                                                <label class="mb-1.5 block text-sm font-medium text-gray-700">TAX
                                                    ID</label>
                                                <input type="text" value="AS4568384"
                                                    class="h-11 w-full rounded-lg border border-gray-300 px-4" />
                                            </div>

                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 mt-6 lg:justify-end">
                                        <button type="button" onclick="closeAddressModal()"
                                            class="rounded-lg border px-4 py-2.5">
                                            Close
                                        </button>

                                        <button type="button" onclick="saveProfile()"
                                            class="rounded-lg bg-blue-600 px-4 py-2.5 text-white">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .input-theme {
        @apply h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs 
        dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-gray-400;
    }

    .btn-primary {
        @apply flex w-full justify-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 sm:w-auto;
    }

    .btn-secondary {
        @apply flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 
        dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 sm:w-auto;
    }
</style>
<script>
    function openAddressModal() {
        document.getElementById("addressModal").style.display = "block";
    }

    function closeAddressModal() {
        document.getElementById("addressModal").style.display = "none";
    }

    function saveProfile() {
        console.log("Profile saved");
        closeAddressModal();
    }
</script>
