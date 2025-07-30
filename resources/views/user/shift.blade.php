<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Shift {{ now()->translatedFormat('l, d F Y') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($shift)
                        <table class="table-fixed w-full text-center text-sm break-words">
                            <thead class="bg-blue-600 text-white font-black">
                                <tr>
                                    <th class="border px-4 py-2">Nama</th>
                                    <th class="border px-4 py-2">Shift</th>
                                    <th class="border px-4 py-2">Jam Kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border px-4 py-2 break-words capitalize">{{ ucfirst(Auth::user()->name) }}</td>
                                    <td class="border px-4 py-2 break-words">{{ ucfirst($shift->shift_type) }}</td>
                                    <td class="border px-4 py-2 break-words">
                                        @if ($shift->shift_type === 'pagi')
                                            08:00 - 16:00
                                        @elseif ($shift->shift_type === 'sore')
                                            16:00 - 00:00
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-8 flex flex-row gap-0">
                            <h3 class="font-bold text-md inline text-white bg-blue-600 p-2">Status</h3>
                            <p class="text-md inline border w-full h-full p-2 text-center">
                                @if ($shift->end_time)
                                    Shift ini telah selesai pada {{ $shift->end_time->translatedFormat('H:i') }}.
                                @else
                                    Shift ini masih berlangsung.        
                                @endif
                            </p>
                        </div>
                    @else
                        <form action="{{ route('shift.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <table class="table-fixed w-full text-center text-sm break-words">
                                <thead class="bg-blue-600 text-white font-black">
                                    <tr>
                                        <th class="border px-4 py-2">Nama</th>
                                        <th class="border px-4 py-2">Shift</th>
                                        <th class="border px-4 py-2">Jam Kerja</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border px-4 py-2 break-words capitalize">{{ Auth::user()->name }}</td>
                                        <td class="border px-4 py-2 break-words">
                                            <select id="shift_type" name="shift_type" class="border p-2 py-3 w-full rounded-md bg-white dark:bg-gray-700 dark:text-white h-auto">
                                            <option value="pagi">Pagi</option>
                                            <option value="sore">Sore</option>
                                            <option value="izin">Izin</option>
                                            </select>
                                        </td>
                                        <td class="border px-4 py-2 break-words"><span id="jamKerja"></span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-4">
                                <div id="keteranganContainer">
                                    <label for="keterangan">Keterangan Izin</label>
                                    <input type="text" name="keterangan" id="keterangan" placeholder="Tulis keterangan izin Anda di sini..." class="border p-2 w-full rounded-md bg-white dark:bg-gray-700 dark:text-white h-auto">
                                </div>
                                <div id="buktiContainer" class="mt-4">
                                    <label for="keterangan" class="">Bukti Izin</label>
                                    <div class="flex items-center justify-center w-full">
                                        <label for="bukti" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">PNG or JPG (MAX. 20MB)</p>
                                            </div>
                                            <input id="bukti" name="bukti" type="file" class="hidden" />
                                        </label>
                                    </div> 
                                    <div id="previewContainer" class="hidden flex items-center justify-center w-full mt-4 border-2 border-dashed border-gray-300 rounded-lg p-4">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 flex flex-row justify-end">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold py-2 px-4 rounded">
                                    Simpan Shift
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const shift = document.getElementById('shift_type');
            const ket = document.getElementById('keteranganContainer');
            const bukti = document.getElementById('buktiContainer');

            if (shift && ket) {
                const show = () => {
                    ket.classList.toggle('hidden', shift.value !== 'izin');
                    bukti.classList.toggle('hidden', shift.value !== 'izin');
                    if (shift.value !== 'izin') ket.value = '';
                    if (shift.value !== 'izin') bukti.value = '';
                };
                show();
                shift.addEventListener('change', show);
            }

            if (shift && jamKerja) {
                const updateJamKerja = () => {
                    switch (shift.value) {
                        case 'pagi':
                            jamKerja.textContent = '08:00 - 16:00';
                            break;
                        case 'sore':
                            jamKerja.textContent = '16:00 - 22:00';
                            break;
                        case 'izin':
                            jamKerja.textContent = '-';
                            break;
                        default:
                            jamKerja.textContent = '08:00 - 16:00';
                    }
                };
                updateJamKerja();
                shift.addEventListener('change', updateJamKerja);
            }

            const fileInput = document.getElementById('bukti');
            const previewContainer = document.getElementById('previewContainer');

            if (fileInput && previewContainer) {
                fileInput.addEventListener('change', function (event) {
                    const file = event.target.files[0];
                    previewContainer.innerHTML = ''; // clear previous

                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = "Preview";
                            img.className = "max-w-xs rounded-lg shadow-md";
                            previewContainer.appendChild(img);
                        };

                        reader.readAsDataURL(file);
                        previewContainer.classList.remove('hidden');
                    } else {
                        previewContainer.innerHTML = '<p class="text-red-500">File bukan gambar yang valid.</p>';
                    }
                });
            }
        });
    </script>
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