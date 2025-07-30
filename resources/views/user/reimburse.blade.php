<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Reimbursement {{ Auth::user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="w-full flex justify-between">
                        <h2 class="font-bold text-md mt-8">Reimbursement {{ now()->translatedFormat('l, d F Y') }}</h2>
                        <a href="{{ route('reimburse.user.create') }}" class="px-2 py-1 bg-blue-600 text-white font-black mt-2 mb-4 rounded hover:bg-white hover:text-blue-600 border border-blue-600 transition-all duration-150">Tambah <i class="fa-solid fa-money-bills"></i></a>
                    </div>
                    <table class="table-fixed w-full text-center text-sm break-words">
                        <thead class="bg-blue-600 text-white font-black">
                            <tr>
                                <th class="border px-4 py-2">Tanggal</th>
                                <th class="border px-4 py-2">Jenis</th>
                                <th class="border px-4 py-2">Nominal</th>
                                <th class="border px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($today as $r)
                                <tr>
                                    <td class="border px-4 py-2 break-words capitalize">{{ $r->created_at->format('d-m-Y') }}</td>
                                    <td class="border px-4 py-2 break-words">
                                        @if ($r->type === 'bensin')
                                            <p class="bg-orange-300 text-black px-2 py-1 rounded" title="Bensin">
                                                <i class="fa-solid fa-gas-pump"></i>
                                            </p>
                                        @elseif ($r->type === 'makan')
                                            <p class="bg-lime-300 text-black px-2 py-1 rounded" title="Makan">
                                                <i class="fa-solid fa-utensils"></i>
                                            </p>
                                        @else
                                            <p class="bg-indigo-300 text-black px-2 py-1 rounded" title="Barang">
                                                <i class="fa-solid fa-box-open"></i>
                                            </p>
                                        @endif
                                    </td>
                                    <td class="border px-4 py-2 break-words">Rp. {{ number_format($r->nominal, 0, ',', '.') }}</td>
                                    <td class="border px-4 py-2 break-words">
                                        @if ($r->status)
                                            <p class="bg-green-300 text-black font-medium px-2 py-1 rounded" title="Barang">
                                                LUNAS <i class="fa-solid fa-circle-check font-thin"></i>
                                            </p>
                                        @else
                                            <p class="bg-red-300 text-black font-medium px-2 py-1 rounded" title="Barang">
                                                PENDING <i class="fa-solid fa-clock font-thin"></i>
                                            </p>
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

                    <livewire:reimburse-history-table />

                    <h2 class="font-bold text-md mt-8">Nominal Reimbursement</h2>
                    <table class="table-fixed w-full text-center text-sm break-words">
                        <thead class="bg-blue-600 text-white font-black">
                            <tr>
                                <th class="border px-4 py-2">Lunas</th>
                                <th class="border px-4 py-2">Pending</th>
                                <th class="border px-4 py-2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border px-4 py-2">
                                    <p class="bg-green-300 text-black px-2 py-1 rounded">
                                        Rp {{ number_format($completed, 0, ',', '.') }}
                                    </p>
                                </td>
                                <td class="border px-4 py-2">
                                    <p class="bg-red-300 text-black px-2 py-1 rounded">
                                        Rp {{ number_format($pending, 0, ',', '.') }}
                                    </p>
                                </td>
                                <td class="border px-4 py-2">
                                    <p class="bg-blue-300 text-black px-2 py-1 rounded">
                                        Rp {{ number_format(($completed + $pending), 0, ',', '.') }}
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        @if ($errors->any() || session('error'))
            <script>
                window.laravelErrors = [];

                @if ($errors->any())
                    window.laravelErrors = @json($errors->all());
                @endif

                @if (session('error'))
                    window.laravelErrors.push(@json(session('error')));
                @endif
            </script>
        @endif
        @if (session('success'))
            <script>
                window.laravelSuccess = @json(session('success'));
            </script>
        @endif
    @endpush
</x-app-layout>