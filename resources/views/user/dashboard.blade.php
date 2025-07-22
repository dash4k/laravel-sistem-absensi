<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-bold text-md">Selamat Datang, {{ Auth::user()->name }}!</h2>
                    <h3 class="font-bold text-xs mt-4">Job {{ now()->translatedFormat('l, d F Y') }}</h3>
                    <table class="table-fixed w-full text-center text-sm break-words">
                        <thead class="bg-blue-600 text-white font-black">
                            <tr>
                                <th class="border px-4 py-2 w-3/4">Deskripsi</th>
                                <th class="border px-4 py-2 w-1/4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!Auth::user()->todaysShift())
                                <tr>
                                    <td class="border px-4 py-2 break-words capitalize">Anda belum membuat shift hari ini.</td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('shift.index') }}" class="text-blue-400 hover:underline"><i class="fa-solid fa-up-right-from-square"></i></a>
                                    </td>
                                </tr>
                            @elseif (!Auth::user()->clockOut())
                                <tr>
                                    <td class="border px-4 py-2 break-words">
                                        @if (!Auth::user()->todaysShift()->absensis)
                                            Anda belum melakukan absensi untuk shift hari ini.
                                        @else
                                            Anda belum melakukan absensi pulang untuk hari ini.
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('absensi.index') }}" class="text-blue-400 hover:underline"><i class="fa-solid fa-up-right-from-square"></i></a>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="2" class="border px-4 py-2 break-words capitalize">Anda sudah menyelesaikan semua job hari ini.</td> 
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>