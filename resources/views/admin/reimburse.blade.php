<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reimburse Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="w-full h-auto p-2 mt-4 flex flex-col justify-between items-center gap-10">
                        <div class="">
                            <h2 class="font-medium text-md">Reimburse Pegawai</h2>
                            <table class="table-fixed w-full text-center text-sm break-words">
                                <thead class="bg-blue-600 text-white font-black">
                                    <tr>
                                        <th class="border px-4 py-2">Nama Pegawai</th>
                                        <th class="border px-4 py-2">Tagihan Pending</th>
                                        <th class="border px-4 py-2">Tagihan Lunas</th>
                                        <th class="border px-4 py-2">Total Reimburse</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($usersTotals as $u)
                                        <tr class="text-xs lg:text-sm">
                                            <td class="border px-4 py-2 capitalize">{{ $u['user_name'] }}</td>
                                            <td class="border px-4 py-2">
                                                <a href="{{ route('admin.reimburse.pending', $u['user_id']) }}">
                                                    <p class="bg-red-300 text-black hover:bg-red-700 hover:text-white px-2 py-1 rounded transition-colors duration-150">
                                                        Rp. {{ number_format($u['pending'], 0, ',', '.') }}
                                                    </p>
                                                </a>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <a href="{{ route('admin.reimburse.lunas', $u['user_id']) }}">
                                                    <p class="bg-green-300 text-black hover:bg-green-700 hover:text-white px-2 py-1 rounded transition-colors duration-150">
                                                        Rp. {{ number_format($u['lunas'], 0, ',', '.') }}
                                                    </p>
                                                </a>
                                            </td>
                                            <td class="border px-4 py-2">
                                                <a href="{{ route('admin.reimburse.total', $u['user_id']) }}">
                                                    <p class="bg-blue-300 text-black hover:bg-blue-700 hover:text-white px-2 py-1 rounded transition-colors duration-150">
                                                        Rp. {{ number_format(($u['lunas'] + $u['pending']), 0, ',', '.') }}
                                                    </p>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="border px-4 py-2" colspan="4">Tidak ada data pegawai</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="">
                            <h2 class="font-medium text-md">Reimburse Pending</h2>
                            <table class="table-fixed w-full text-center text-sm break-words">
                            <thead class="bg-blue-600 text-white font-black">
                                <tr>
                                    <th class="border px-4 py-2">Tanggal</th>
                                    <th class="border px-4 py-2">Nama</th>
                                    <th class="border px-4 py-2">Nominal</th>
                                    <th class="border px-4 py-2">Jenis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pendings as $r)
                                    <tr>
                                        <td class="border px-4 py-2 break-words capitalize">{{ $r->created_at->format('d-m-Y') }}</td>
                                        <td class="border px-4 py-2 break-words capitalize">{{ optional(optional($r->shift)->user)->name }}</td>
                                        <td class="border px-4 py-2 break-words">Rp. {{ number_format($r->nominal, 0, ',', '.') }}</td>
                                        <td class="border px-4 py-2 break-words">
                                            @if ($r->type === 'bensin')
                                                <a href="{{ route('admin.reimburse.bensin', $r->id) }}">
                                                    <p class="bg-orange-300 hover:bg-orange-700 text-black hover:text-white px-2 py-1 rounded transition-colors duration-150" title="Bensin">
                                                        <i class="fa-solid fa-gas-pump"></i>
                                                    </p>
                                                </a>
                                            @elseif ($r->type === 'makan')
                                                <a href="{{ route('admin.reimburse.makan', $r->id) }}">
                                                    <p class="bg-lime-300 hover:bg-lime-700 text-black hover:text-white px-2 py-1 rounded transition-colors duration-150" title="Makan">
                                                        <i class="fa-solid fa-utensils"></i>
                                                    </p>
                                                </a>
                                            @else
                                                <a href="{{ route('admin.reimburse.barang', $r->id) }}">
                                                    <p class="bg-indigo-300 hover:bg-indigo-700 text-black hover:text-white px-2 py-1 rounded transition-colors duration-150" title="Barang">
                                                        <i class="fa-solid fa-box-open"></i>
                                                    </p>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="border px-4 py-2 text-center">
                                            Tidak ada data riwayat reimbursement terkini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>