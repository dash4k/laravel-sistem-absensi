<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rekapan Harian Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-row items-center">
                        <h2 class="font-bold text-md">Shift {{ $now->translatedFormat('l, d F Y') }}</h2>
                        <form action="{{ route('admin.dashboard') }}" method="get">
                            <input name="date" type="date" class="only-icon-date-input w-10 h-10 flex flex-row items-center justify-center border-0 bg-transparent focus:outline-none focus:ring-0 focus:border-0 rounded cursor-pointer" onchange="this.form.submit()"/>
                        </form>
                    </div>
                    <div class="w-full h-auto p-2 mt-4 flex flex-col lg:flex-row justify-between items-center gap-10">
                        <div class="">
                            <table class="table-fixed w-full text-center text-sm break-words">
                                <thead class="bg-blue-600 text-white font-black">
                                    <tr>
                                        <th class="border px-4 py-2 w-2/4">Nama Pegawai</th>
                                        <th class="border px-4 py-2">Shift</th>
                                        <th class="border px-4 py-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($sortedUsers as $pegawai)
                                        @php
                                            $shift = $todayShifts->firstWhere('user_id', $pegawai->id);
                                            $absensi = $todayAbsensis->firstWhere('shift_id', $shift->id ?? null);
                                        @endphp
                                        <tr class="text-xs lg:text-sm">
                                            <td class="border px-4 py-2">{{ $pegawai->name }}</td>
                                            <td class="border px-4 py-2 capitalize">{{ $shift?->shift_type ?? 'Belum Diatur' }}</td>
                                            <td class="border px-4 py-2">
                                                @if ($shift)
                                                    @if ($absensi)
                                                        <a href="{{ route('admin.absensi', $shift->id) }}">
                                                            @switch($absensi->status)
                                                                @case('on_duty')
                                                                    <span class="bg-green-200 dark:bg-green-800 font-black p-1 rounded-md hover:bg-green-600 hover:text-white transition-all duration-150">On Duty</span>
                                                                    @break
                                                                @case('off_duty')
                                                                    <span class="bg-red-200 dark:bg-red-800 font-black p-1 rounded-md hover:bg-red-600 hover:text-white transition-all duration-150">Off Duty</span>
                                                                    @break
                                                                @case('istirahat')
                                                                    <span class="bg-yellow-200 dark:bg-yellow-800 font-black p-1 rounded-md hover:bg-yellow-600 hover:text-white transition-all duration-150">Istirahat</span>
                                                                    @break
                                                            @endswitch
                                                        </a>
                                                    @elseif ($shift->shift_type == 'izin')
                                                        <a href="{{ route('admin.absensi', $shift->id) }}"> 
                                                            <span class="bg-blue-200 dark:bg-blue-800 font-black p-1 rounded-md hover:bg-blue-600 hover:text-white transition-all duration-150 px-5">Izin</span>
                                                        </a>
                                                    @else
                                                        <span class="bg-gray-800 dark:bg-gray-200 dark:text-black font-black p-1 rounded-md hover:bg-gray-600 hover:text-white transition-all duration-150">Belum Absen</span>
                                                    @endif
                                                @else
                                                    <span class="bg-gray-400 font-black p-1 text-white rounded-md">Belum Absen</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="border px-4 py-2" colspan="3">Tidak ada data pegawai</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div> 
                        @php
                            $userTotal = $sortedUsers->count();
                        @endphp
                        @if ($userTotal > 0)
                            <div class="lg:w-1/4 w-full dark:bg-gray-300 p-5">
                                <div class="w-auto grow">
                                    <canvas id="pegawaiChart"></canvas>
                                </div>
                            </div>   
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                window.renderPegawaiChart([{{ $onDuty }}, {{ $offDuty }}, {{ $istirahat }}, {{ $noAbsen }}, {{ $izin }}]);
            });
        </script>
    @endpush
</x-app-layout>