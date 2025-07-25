<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Shift {{ $shift->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-bold text-md">Shift {{ $shift->date->translatedFormat('l, d F Y') }}</h2>
                    <table class="table-fixed w-full text-center text-sm break-words">
                        <thead class="bg-blue-600 text-white font-black">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">Shift</th>
                                <th class="border px-4 py-2">Waktu Izin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-xs lg:text-sm">
                                <td class="border px-4 py-2 break-words capitalize">{{ ucfirst($shift->user->name) }}</td>
                                <td class="border px-4 py-2 break-words">{{ ucfirst($shift->shift_type) }}</td>
                                <td class="border px-4 py-2 break-words">{{ $shift->start_time->format('H:i:s') }}</td>
                                </tr>
                        </tbody>
                    </table>

                    <h3 class="font-medium text-sm mt-4">Keterangan Izin</h3>
                    <div class="border px-4 py-2 break-words w-full h-auto">
                        {{ $shift->keterangan }}
                    </div>

                    <h3 class="font-medium text-sm mt-4">Bukti Izin</h3>
                    <div class="border px-4 py-2 break-words w-full h-auto">
                        <img src="{{ asset('storage/' . $shift->bukti) }}" alt="Bukti Izin" class="w-fit h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>