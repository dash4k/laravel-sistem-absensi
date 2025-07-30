<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Reimbursement Bensin
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-8">
                        <h3 class="font-bold text-sm">Detail Shift</h3>
                        <table class="table-fixed w-full text-center text-sm break-words">
                            <thead class="bg-blue-600 text-white font-black">
                                <tr>
                                    <th class="border px-4 py-2">Nama</th>
                                    <th class="border px-4 py-2">Shift</th>
                                    <th class="border px-4 py-2">Waktu Masuk</th>
                                    <th class="border px-4 py-2">Waktu Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border px-4 py-2 break-words capitalize">{{ $bensin->shift->user->name }}</td>
                                    <td class="border px-4 py-2 break-words">{{ ucfirst($bensin->shift->shift_type) }}</td>
                                    <td class="border px-4 py-2 break-words">{{ $bensin->shift->start_time->format('H:i:s') }}</td>
                                    <td class="border px-4 py-2 break-words">
                                        @if ($bensin->shift->end_time)
                                            {{ $bensin->shift->end_time->format('H:i:s') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mb-8">
                        <h3 class="font-bold text-sm">Detail Reimburse</h3>
                        <div class="flex flex-col justify-center items-start w-full mt-4">
                            <h4 class="font-medium text-sm">Jarak Tempuh</h4>
                            <p class="w-full border rounded-md p-2">{{ $bensin->kilometer }}</p>
                        </div>

                        <div class="flex flex-col justify-center items-start w-full mt-4">
                            <h4 class="font-medium text-sm">Nominal</h4>
                            <p class="w-full border rounded-md p-2 break-words">
                                Rp. {{ number_format($bensin->nominal, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="flex flex-col justify-center items-start w-full mt-4">
                            <h4 class="font-medium text-sm">Keterangan</h4>
                            <p class="w-full border rounded-md p-2 break-words">
                                {{ ucfirst($bensin->keterangan) }}
                            </p>
                        </div>

                        <div class="w-full mt-4 flex flex-col justify-center items-start">
                            <h4 class="font-medium text-sm">Nota</h4>
                            <div class="w-full border p-2">
                                <img src="{{ asset('storage/' . $bensin->nota) }}" alt="">
                            </div>
                        </div>

                        <div class="flex flex-col justify-center items-end w-full mt-4">
                            @if (!$bensin->status)
                                <form action="{{ route('admin.reimburse.bensin', $bensin->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="py-2 px-4 bg-blue-700 text-white font-bold hover:bg-blue-300 hover:text-black transition-colors duration-150">Tandai sebagai Lunas</button>
                                </form>
                            @endif
                        </div>
                    </div>
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