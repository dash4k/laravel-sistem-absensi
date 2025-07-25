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
                                <th class="border px-4 py-2">Jam Kerja</th>
                                <th class="border px-4 py-2">Waktu Masuk</th>
                                <th class="border px-4 py-2">Waktu Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-xs lg:text-sm">
                                <td class="border px-4 py-2 break-words capitalize">{{ ucfirst($shift->user->name) }}</td>
                                <td class="border px-4 py-2 break-words">{{ ucfirst($shift->shift_type) }}</td>
                                <td class="border px-4 py-2 break-words">
                                    @if ($shift->shift_type === 'pagi')
                                        08:00 - 16:00
                                    @elseif ($shift->shift_type === 'sore')
                                        16:00 - 22:00
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="border px-4 py-2 break-words">{{ $shift->start_time->format('H:i:s') }}</td>
                                <td class="border px-4 py-2 break-words">
                                    @if ($shift->end_time)
                                        {{ $shift->end_time->format('H:i:s') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                </tr>
                        </tbody>
                    </table>

                    <h2 class="mt-8 font-bold text-md">Absensi {{ $shift->date->translatedFormat('l, d F Y') }}</h2>
                    <table class="table-fixed w-full text-center text-sm break-words">
                        <thead class="bg-blue-600 text-white font-black">
                            <tr>
                                <th class="border px-4 py-2">Waktu</th>
                                <th class="border px-4 py-2">Lokasi</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Bukti</th>
                                <th class="border px-4 py-2">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($absensis as $absensi)
                                <tr class="text-xs lg:text-sm">
                                    <td class="border px-4 py-2 break-words capitalize">{{ $absensi->time }}</td>
                                    <td class="border px-4 py-2 break-words">
                                        <a href="https://www.google.com/maps?q={{ $absensi->latitude }},{{ $absensi->longitude }}" class="text-blue-600 dark:text-blue-300 hover:cursor-pointer capitalize">{{ $absensi->lokasi }}</a>    
                                    </td>
                                    <td class="border px-4 py-2 break-words capitalize">
                                        @switch($absensi->status)
                                            @case('on_duty')
                                                <span class="bg-green-200 dark:bg-green-800 font-black p-1 rounded-md">On Duty</span>
                                                @break
                                            @case('off_duty')
                                                <span class="bg-red-200 dark:bg-red-800 font-black p-1 rounded-md">Off Duty</span>
                                                @break
                                            @case('istirahat')
                                                <span class="bg-yellow-200 dark:bg-yellow-800 font-black p-1 rounded-md">Istirahat</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ asset('storage/' . $absensi->bukti) }}" target="_blank" class="text-blue-600 dark:text-blue-300 hover:underline"><i class="fa-solid fa-up-right-from-square"></i></a>
                                    </td>
                                    <td class="border px-4 py-2 text-start break-words">
                                        <div class="max-h-[100px] overflow-y-auto">
                                            {{ $absensi->keterangan }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border px-4 py-2 text-center">
                                        Tidak ada data absensi untuk hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>