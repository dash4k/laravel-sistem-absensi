<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Reimbursement Total {{ $pegawai->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @foreach ($shifts as $shift)
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="font-bold text-md mt-8">Reimbursement {{ $shift->date->translatedFormat('l, d F Y') }}</h3>
                        <table class="table-fixed w-full text-center text-sm break-words">
                            <thead class="bg-blue-600 text-white font-black">
                                <tr>
                                    <th class="border px-4 py-2">Nominal</th>
                                    <th class="border px-4 py-2">Jenis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($shift->reimbursements as $r)
                                    <tr>
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
                                        <td colspan="3" class="border px-4 py-2 text-center">
                                            Tidak ada data riwayat reimbursement terkini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endforeach

                {{ $shifts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>