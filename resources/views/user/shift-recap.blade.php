<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Shift {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-bold text-md">Shift {{ now()->translatedFormat('l, d F Y') }}</h2>
                    @if ($todaysShift)
                        <table class="table-fixed w-full text-center text-sm break-words">
                            <thead class="bg-blue-600 text-white font-black">
                                <tr>
                                    <th class="border px-4 py-2">Nama</th>
                                    <th class="border px-4 py-2">Shift</th>
                                    <th class="border px-4 py-2">Jam Kerja</th>
                                    <th class="border px-4 py-2">Waktu Masuk</th>
                                    <th class="border px-4 py-2">Waktu Pulang</th>
                                    <th class="border px-4 py-2">Absensi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border px-4 py-2 break-words capitalize">{{ ucfirst(Auth::user()->name) }}</td>
                                    <td class="border px-4 py-2 break-words">{{ ucfirst($todaysShift->shift_type) }}</td>
                                    <td class="border px-4 py-2 break-words">
                                        @if ($todaysShift->shift_type === 'pagi')
                                            08:00 - 16:00
                                        @elseif ($todaysShift->shift_type === 'sore')
                                            16:00 - 22:00
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2 break-words">{{ $todaysShift->start_time->format('H:i:s') }}</td>
                                    <td class="border px-4 py-2 break-words">
                                        @if ($todaysShift->end_time)
                                            {{ $todaysShift->end_time->format('H:i:s') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('shift.show', $todaysShift->id) }}" class="editButton bg-yellow-300 text-black hover:text-yellow-300 hover:bg-black px-2 py-1 rounded hover:cursor-pointer transition-all duration-100" title="List Absensi"><i class="fa-solid fa-square-arrow-up-right"></i></a>
                                    </td>
                                    </tr>
                            </tbody>
                        </table>
                    @else
                        <div class="w-full flex flex-col gap-5 justify-center items-center mt-4">
                            <p class="text-center text-gray-500">Anda belum membuat shift untuk hari ini.</p>
                            <a href="{{ route('shift.index') }}" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                Atur Shift
                            </a>
                        </div>
                    @endif

                    <h2 class="font-bold text-md mt-8">Riwayat Shift</h2>
                    <table class="table-fixed w-full text-center text-sm break-words">
                        <thead class="bg-blue-600 text-white font-black">
                            <tr>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">Shift</th>
                                <th class="border px-4 py-2">Jam Kerja</th>
                                <th class="border px-4 py-2">Waktu Masuk</th>
                                <th class="border px-4 py-2">Waktu Pulang</th>
                                <th class="border px-4 py-2">Absensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shifts as $shift)
                                <tr>
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
                                    <td class="border px-4 py-2">
                                        <a href="{{ route('shift.show', $shift->id) }}" class="editButton bg-yellow-300 text-black hover:text-yellow-300 hover:bg-black px-2 py-1 rounded hover:cursor-pointer transition-all duration-100" title="List Absensi"><i class="fa-solid fa-square-arrow-up-right"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border px-4 py-2 text-center">
                                        Tidak ada data riwayat shift terkini.
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