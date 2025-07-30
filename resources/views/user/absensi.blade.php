<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Absensi {{ now()->translatedFormat('l, d F Y') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-bold text-md">Absensi Terakhir</h2>
                    <table class="table-fixed w-full text-center text-sm break-words">
                        <thead class="bg-blue-600 text-white font-black">
                            <tr>
                                <th class="border px-4 py-2">Waktu</th>
                                <th class="border px-4 py-2">Lokasi</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Bukti</th>
                                <th class="border px-4 py-2 max-w-[200px]">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($absensi)
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
                            @else
                                @if (Auth::user()->role == 'user' && Auth::user()->todaysShift()->shift_type == 'izin')
                                    <tr>
                                        <td colspan="5" class="border px-4 py-2 text-center">
                                            Tidak ada absensi untuk hari ini. Anda sedang izin.
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="5" class="border px-4 py-2 text-center">
                                            Tidak ada data absensi untuk hari ini.
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        </tbody>
                    </table>
                </div>
                @if (($absensi && $absensi->status !== 'off_duty') || !$absensi && (Auth::user()->role == 'user' && Auth::user()->todaysShift()->shift_type != 'izin'))
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="font-bold text-md">Buat Absensi Baru</h2>
                        <form action="{{ route('absensi.store') }}" method="post" enctype="multipart/form-data" class="border p-4 rounded-md bg-white dark:bg-gray-800 mt-1">
                            @csrf
                            <div class="mb-4">
                                <label for="lokasi" class="block text-sm font-medium">Lokasi</label>
                                <input type="text" name="lokasi" id="lokasi" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium">Status</label>
                                <select name="status" id="status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="on_duty">On Duty</option>
                                    <option value="off_duty">Off Duty</option>
                                    <option value="istirahat">Istirahat</option>
                                </select>
                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">
                            </div>
                            <div class="mb-4">
                                <label for="keterangan" class="block text-sm font-medium">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                            </div>
                            <div class="mt-4">
                                <label for="bukti" class="">Bukti Absensi</label>
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
                            <div class="flex flex-row justify-end mt-4">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                    Simpan Absensi
                                </button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                },
                function (error) {
                    console.warn('Geolocation error:', error.message);
                    alert('Tidak dapat mengambil lokasi. Pastikan izin lokasi diaktifkan.');
                }
            );
        } else {
            alert('Geolocation tidak didukung di browser ini.');
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