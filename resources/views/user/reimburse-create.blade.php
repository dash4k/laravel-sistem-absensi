<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Reimburse {{ now()->translatedFormat('l, d F Y') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="w-full flex justify-between items-end mb-2">
                        <h2 class="font-bold text-md">Buat Reimburse Baru</h2>
                        <select id="formType" class="flex justify-start border pr-8 py-3 w-fit rounded-md bg-white dark:bg-gray-700 dark:text-white h-auto">
                            <option value="bensin">Bensin</option>
                            <option value="makan">Makan</option>
                            <option value="barang">Barang</option>
                        </select>
                    </div>
                    <form id="bensinForm" action="{{ route('reimburse.user.bensin') }}" method="post" enctype="multipart/form-data" class="border p-4 rounded-md bg-white dark:bg-gray-800 mt-1">
                        @csrf
                        <div class="mb-4">
                            <label for="kilometer" class="block text-sm font-medium">Jumlah Kilometer</label>
                            <div class="w-full flex flex-row gap-0">
                                <input type="number" name="kilometer" id="kilometer" required class="mt-1 border-r-0 block w-full border-gray-300 rounded-md rounded-r-none shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                <label for="kilometer" class="border border-gray-300 px-2 mt-1 text-center items-center flex rounded-md rounded-l-none"> Km</label>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="nominal" class="block text-sm font-medium">Jumlah Nominal</label>
                            <div class="w-full flex flex-row gap-0">
                                <label for="nominal" class="border border-gray-300 px-2 mt-1 text-center items-center flex rounded-md rounded-r-none">Rp. </label>
                                <input type="number" name="nominal" id="nominal" required class="mt-1 border-l-0 block w-full border-gray-300 rounded-md rounded-l-none shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="keterangan" class="block text-sm font-medium">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                        </div>
                        <div class="mt-4">
                            <label for="notaBensin" class="block text-md font-medium">Nota</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="notaBensin" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG or JPG (MAX. 20MB)</p>
                                    </div>
                                    <input id="notaBensin" name="nota" type="file" class="hidden" />
                                </label>
                            </div> 
                            <div id="notaBensinPreview" class="hidden flex items-center justify-center w-full mt-4 border-2 border-dashed border-gray-300 rounded-lg p-4">
                            </div>
                        </div>
                        <div class="flex flex-row justify-end mt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                Simpan Reimburse
                            </button>
                        </div>
                    </form>
                   
                    <form id="makanForm" action="{{ route('reimburse.user.makan') }}" method="post" enctype="multipart/form-data" class="border p-4 rounded-md bg-white dark:bg-gray-800 mt-1">
                        @csrf
                        <div class="mb-4">
                            <label for="nominal" class="block text-sm font-medium">Jumlah Nominal</label>
                            <div class="w-full flex flex-row gap-0">
                                <label for="nominal" class="border border-gray-300 px-2 mt-1 text-center items-center flex rounded-md rounded-r-none">Rp. </label>
                                <input type="number" name="nominal" id="nominal" required class="mt-1 border-l-0 block w-full border-gray-300 rounded-md rounded-l-none shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="keterangan" class="block text-sm font-medium">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                        </div>
                        <div class="mt-4">
                            <label for="notaMakan" class="block text-md font-medium">Nota</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="notaMakan" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG or JPG (MAX. 20MB)</p>
                                    </div>
                                    <input id="notaMakan" name="nota" type="file" class="hidden" />
                                </label>
                            </div> 
                            <div id="notaMakanPreview" class="hidden flex items-center justify-center w-full mt-4 border-2 border-dashed border-gray-300 rounded-lg p-4">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="buktiMakan" class="block text-md font-medium">Bukti</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="buktiMakan" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG or JPG (MAX. 20MB)</p>
                                    </div>
                                    <input id="buktiMakan" name="bukti" type="file" class="hidden" />
                                </label>
                            </div> 
                            <div id="buktiMakanPreview" class="hidden flex items-center justify-center w-full mt-4 border-2 border-dashed border-gray-300 rounded-lg p-4">
                            </div>
                        </div>
                        <div class="flex flex-row justify-end mt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                Simpan Reimburse
                            </button>
                        </div>
                    </form>
                    
                    <form id="barangForm" action="{{ route('reimburse.user.barang') }}" method="post" enctype="multipart/form-data" class="border p-4 rounded-md bg-white dark:bg-gray-800 mt-1">
                        @csrf
                        <div class="mb-4">
                            <label for="nominal" class="block text-sm font-medium">Jumlah Nominal</label>
                            <div class="w-full flex flex-row gap-0">
                                <label for="nominal" class="border border-gray-300 px-2 mt-1 text-center items-center flex rounded-md rounded-r-none">Rp. </label>
                                <input type="number" name="nominal" id="nominal" required class="mt-1 border-l-0 block w-full border-gray-300 rounded-md rounded-l-none shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="keterangan" class="block text-sm font-medium">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                        </div>
                        <div class="mt-4">
                            <label for="notaBarang" class="block text-md font-medium">Nota</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="notaBarang" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG or JPG (MAX. 20MB)</p>
                                    </div>
                                    <input id="notaBarang" name="nota" type="file" class="hidden" />
                                </label>
                            </div> 
                            <div id="notaBarangPreview" class="hidden flex items-center justify-center w-full mt-4 border-2 border-dashed border-gray-300 rounded-lg p-4">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label for="buktiBarang" class="block text-md font-medium">Bukti</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="buktiBarang" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG or JPG (MAX. 20MB)</p>
                                    </div>
                                    <input id="buktiBarang" name="bukti" type="file" class="hidden" />
                                </label>
                            </div> 
                            <div id="buktiBarangPreview" class="hidden flex items-center justify-center w-full mt-4 border-2 border-dashed border-gray-300 rounded-lg p-4">
                            </div>
                        </div>
                        <div class="flex flex-row justify-end mt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                                Simpan Reimburse
                            </button>
                        </div>
                    </form>
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